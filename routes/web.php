<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Illuminate\Http\Request;

Route::get('/', function () {
    $books = \App\Models\Book::orderByDesc('book_id')->limit(8)->get();
    $genres = \App\Models\Book::genres();
    $authors = \App\Models\Book::authors();
    return view('home', compact('books', 'genres', 'authors'));
});

Route::get('/books', function () {
    $books = Book::all();
    return view('books', ['books' => $books]);
});

Route::get('/book/{id}', function ($id) {
    $book = Book::findOrFail($id);
    return view('book', ['book' => $book]);
});

Route::get('/genres', function () {
    return view('genres');
});

Route::get('/authors', function () {
    $authors = \App\Models\Book::authors();
    return view('authors', ['authors' => $authors]);
});

Route::get('/publishers', function () {
    $publishers = \App\Models\Book::publishers();
    return view('publishers', ['publishers' => $publishers]);
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
    ]);

    \App\Models\ContactQuery::create($validated);

    return back()->with('success', 'Thank you for your message! We will get back to you soon.');
});

Route::get('/genre/{genre}', function ($genre) {
    $decodedGenre = urldecode($genre);
    $books = Book::where('book_genre', $decodedGenre)->get();
    return view('genre', ['books' => $books, 'genre' => $decodedGenre]);
});

Route::get('/author/{author}', function ($author) {
    $decodedAuthor = urldecode($author);
    $books = Book::where('book_author', $decodedAuthor)->get();
    return view('author', ['books' => $books, 'author' => $decodedAuthor]);
});

Route::get('/publisher/{publisher}', function ($publisher) {
    $decodedPublisher = urldecode($publisher);
    $books = Book::where('book_publisher', $decodedPublisher)->get();
    return view('publisher', ['books' => $books, 'publisher' => $decodedPublisher]);
});

Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    $author = $request->get('author');
    $genre = $request->get('genre');
    $sort = $request->get('sort', 'name'); // default sort by name

    $books = Book::query();

    // Search by book name or description
    if ($query) {
        $books->where(function($q) use ($query) {
            $q->where('book_name', 'LIKE', '%' . $query . '%')
              ->orWhere('book_author', 'LIKE', '%' . $query . '%');
        });
    }

    // Filter by author
    if ($author) {
        $books->where('book_author', 'LIKE', '%' . $author . '%');
    }

    // Filter by genre
    if ($genre) {
        $books->where('book_genre', $genre);
    }

    // Sort results
    switch ($sort) {
        case 'price_low':
            $books->orderBy('book_price', 'asc');
            break;
        case 'price_high':
            $books->orderBy('book_price', 'desc');
            break;
        case 'author':
            $books->orderBy('book_author', 'asc');
            break;
        default:
            $books->orderBy('book_name', 'asc');
    }

    $results = $books->get();
    $searchParams = compact('query', 'author', 'genre', 'sort');

    return view('search', [
        'books' => $results,
        'searchParams' => $searchParams,
        'totalResults' => $results->count()
    ]);
});

// Authentication Routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $userType = $request->input('user_type', 'customer');

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($userType === 'author') {
        $guard = 'author';
        $redirectTo = '/author-dashboard';
    } else {
        $guard = 'customer';
        $redirectTo = '/customer-dashboard';
    }

    if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended($redirectTo);
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.submit');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $userType = $request->input('user_type', 'customer');

    if ($userType === 'author') {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'website' => 'nullable|url',
            'phone' => 'nullable|string',
        ]);

        \App\Models\Author::create($validated);
        return redirect()->route('login')->with('success', 'Author account created successfully!');
    } else {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        \App\Models\Customer::create($validated);
        return redirect()->route('login')->with('success', 'Customer account created successfully!');
    }
})->name('register.submit');

Route::post('/logout', function (Request $request) {
    Auth::guard('customer')->logout();
    Auth::guard('author')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

