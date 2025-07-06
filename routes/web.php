<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Http\Request;

// Public routes with author access restriction
Route::middleware(['restrict.author.access'])->group(function () {
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
});

// Authentication Routes
Route::get('/login', function () {
    // Check if author is already logged in
    if (Auth::guard('author')->check()) {
        return redirect()->route('author.dashboard');
    }

    // Check if customer is already logged in
    if (Auth::guard('customer')->check()) {
        return redirect()->route('customer.dashboard');
    }

    // If no one is logged in, show login page
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
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
        ]);
    } else {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
            'address' => 'nullable|string',
        ]);
    }

    // Hash the password before storing in OTP data
    $validated['password'] = bcrypt($validated['password']);
    unset($validated['password_confirmation']);

    // Generate OTP and send email
    try {
        \App\Models\Otp::generateOtp($validated['email'], $userType, $validated);

        return redirect()->route('verify.otp.form', ['email' => $validated['email'], 'type' => $userType])
            ->with('success', 'Registration initiated! Please check your email for the verification code.');
    } catch (\Exception $e) {
        return back()->withErrors(['email' => 'Failed to send verification email. Please try again.'])->withInput();
    }
})->name('register.submit');

// OTP Verification Routes
Route::get('/verify-otp', function (Request $request) {
    $email = $request->get('email');
    $userType = $request->get('type');

    if (!$email || !$userType) {
        return redirect()->route('register')->with('error', 'Invalid verification request.');
    }

    return view('verify-otp', compact('email', 'userType'));
})->name('verify.otp.form');

Route::post('/verify-otp', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'otp_code' => 'required|string|size:6',
        'user_type' => 'required|in:customer,author'
    ]);

    $otp = \App\Models\Otp::verifyOtp($request->email, $request->otp_code);

    if (!$otp) {
        return back()->withErrors(['otp_code' => 'Invalid or expired verification code.'])->withInput();
    }

    // Create the user account based on type
    try {
        if ($otp->user_type === 'author') {
            \App\Models\Author::create($otp->registration_data);
        } else {
            \App\Models\Customer::create($otp->registration_data);
        }

        // Clean up the OTP record
        $otp->delete();

        return redirect()->route('login')->with('success', ucfirst($otp->user_type) . ' account created successfully! You can now log in.');
    } catch (\Exception $e) {
        return back()->withErrors(['email' => 'Failed to create account. Please try again.'])->withInput();
    }
})->name('verify.otp.submit');

// Resend OTP Route
Route::post('/resend-otp', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'user_type' => 'required|in:customer,author'
    ]);

    // Find the existing OTP record
    $existingOtp = \App\Models\Otp::where('email', $request->email)
        ->where('user_type', $request->user_type)
        ->where('is_verified', false)
        ->first();

    if (!$existingOtp) {
        return back()->withErrors(['email' => 'No pending verification found for this email.']);
    }

    try {
        // Generate new OTP with existing registration data
        \App\Models\Otp::generateOtp($request->email, $request->user_type, $existingOtp->registration_data);

        return back()->with('success', 'New verification code sent to your email!');
    } catch (\Exception $e) {
        return back()->withErrors(['email' => 'Failed to resend verification code. Please try again.']);
    }
})->name('resend.otp');

// Logout Route
Route::post('/logout', function (Request $request) {
    Auth::guard('customer')->logout();
    Auth::guard('author')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Cart Routes - restricted from authors
Route::middleware(['restrict.author.access'])->group(function () {
    Route::get('/cart', function () {
        // Check if user is authenticated as customer
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $cartItems = \App\Models\Cart::getCartItems($customer->id);
            $cartTotal = \App\Models\Cart::getCartTotal($customer->id);
            $cartCount = \App\Models\Cart::getCartCount($customer->id);

            return view('cart', compact('cartItems', 'cartTotal', 'cartCount'));
        } else {
            // Guest user - show empty cart with login prompt
            return view('cart', [
                'cartItems' => collect(),
                'cartTotal' => 0,
                'cartCount' => 0,
                'isGuest' => true
            ]);
        }
    })->middleware('prevent.cross.access:customer')->name('cart.index');

    // Cart management routes (Customer only)
    Route::middleware(['auth:customer', 'prevent.cross.access:customer'])->group(function () {
        // Add to cart
        Route::post('/cart/add/{bookId}', function ($bookId) {
            $customer = Auth::guard('customer')->user();
            $book = \App\Models\Book::findOrFail($bookId);

            // Check if item already exists in cart
            $existingItem = \App\Models\Cart::where('customer_id', $customer->id)
                ->where('book_id', $bookId)
                ->first();

            if ($existingItem) {
                // Update quantity
                $existingItem->increment('quantity');
            } else {
                // Create new cart item
                \App\Models\Cart::create([
                    'customer_id' => $customer->id,
                    'book_id' => $bookId,
                    'quantity' => 1,
                    'price' => $book->book_price
                ]);
            }

            return back()->with('success', 'Book added to cart successfully!');
        })->name('cart.add');

        // Update cart quantity
        Route::patch('/cart/update/{cartId}', function (Request $request, $cartId) {
            $customer = Auth::guard('customer')->user();
            $cartItem = \App\Models\Cart::where('id', $cartId)
                ->where('customer_id', $customer->id)
                ->firstOrFail();

            $quantity = $request->validate(['quantity' => 'required|integer|min:1'])['quantity'];
            $cartItem->update(['quantity' => $quantity]);

            return back()->with('success', 'Cart updated successfully!');
        })->name('cart.update');

        // Remove from cart
        Route::delete('/cart/remove/{cartId}', function ($cartId) {
            $customer = Auth::guard('customer')->user();
            \App\Models\Cart::where('id', $cartId)
                ->where('customer_id', $customer->id)
                ->delete();

            return back()->with('success', 'Item removed from cart!');
        })->name('cart.remove');

        // Clear entire cart
        Route::delete('/cart/clear', function () {
            $customer = Auth::guard('customer')->user();
            \App\Models\Cart::where('customer_id', $customer->id)->delete();

            return back()->with('success', 'Cart cleared successfully!');
        })->name('cart.clear');

        // Checkout Route
        Route::post('/checkout', [App\Http\Controllers\SslCommerzPaymentController::class, 'checkout'])->name('checkout');
    });

    // Test route to debug cart clearing (remove after debugging)
    Route::get('/test-cart-clear', function () {
        if (!Auth::guard('customer')->check()) {
            return 'Please login first';
        }

        $customer = Auth::guard('customer')->user();
        $customerId = $customer->id;

        // Check current cart
        $cartItemsBefore = \App\Models\Cart::where('customer_id', $customerId)->count();

        // Try to clear cart
        $deletedRows = \App\Models\Cart::where('customer_id', $customerId)->delete();

        // Check after clearing
        $cartItemsAfter = \App\Models\Cart::where('customer_id', $customerId)->count();

        return "Customer ID: {$customerId}<br>Cart items before: {$cartItemsBefore}<br>Deleted rows: {$deletedRows}<br>Cart items after: {$cartItemsAfter}";
    })->middleware('auth:customer');

    // Customer Dashboard and Profile Routes
    Route::middleware(['auth:customer', 'prevent.cross.access:customer'])->group(function () {
        // Customer Dashboard
        Route::get('/customer-dashboard', function () {
            $customer = Auth::guard('customer')->user();
            return view('customer.dashboard', compact('customer'));
        })->name('customer.dashboard');

        // Customer Profile
        Route::get('/customer/profile', function () {
            $customer = Auth::guard('customer')->user();
            return view('customer.profile', compact('customer'));
        })->name('customer.profile');

        // Update Customer Profile
        Route::post('/customer/profile', function (Request $request) {
            $customer = Auth::guard('customer')->user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
                'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
                'address' => 'nullable|string|max:500',
            ]);

            $customer->update($validated);

            return back()->with('success', 'Profile updated successfully!');
        })->name('customer.profile.update');

        // Customer Orders
        Route::get('/customer/orders', function () {
            $customer = Auth::guard('customer')->user();
            $orders = \App\Models\Order::where('customer_id', $customer->id)
                ->orderBy('created_at', 'desc')
                ->get();
            return view('customer.orders', compact('customer', 'orders'));
        })->name('customer.orders');
    });
});

// Payment Routes (SSLCOMMERZ)
Route::post('/pay', [App\Http\Controllers\SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [App\Http\Controllers\SslCommerzPaymentController::class, 'payViaAjax']);

// Payment callback routes - both GET and POST to handle different gateway responses
Route::get('/payment/success', [App\Http\Controllers\SslCommerzPaymentController::class, 'success']);
Route::post('/payment/success', [App\Http\Controllers\SslCommerzPaymentController::class, 'success']);
Route::get('/payment/fail', [App\Http\Controllers\SslCommerzPaymentController::class, 'fail']);
Route::post('/payment/fail', [App\Http\Controllers\SslCommerzPaymentController::class, 'fail']);
Route::get('/payment/cancel', [App\Http\Controllers\SslCommerzPaymentController::class, 'cancel']);
Route::post('/payment/cancel', [App\Http\Controllers\SslCommerzPaymentController::class, 'cancel']);
Route::post('/payment/ipn', [App\Http\Controllers\SslCommerzPaymentController::class, 'ipn']);

// Author Dashboard Routes (Protected by author authentication)
Route::middleware(['auth:author'])->group(function () {
    // Author Dashboard - back to /author-dashboard
    Route::get('/author-dashboard', [App\Http\Controllers\AuthorDashboardController::class, 'dashboard'])->name('author.dashboard');

    // Author Profile - changed to /my-profile
    Route::get('/my-profile', [App\Http\Controllers\AuthorDashboardController::class, 'profile'])->name('author.profile');
    Route::post('/my-profile', [App\Http\Controllers\AuthorDashboardController::class, 'updateProfile'])->name('author.profile.update');

    // Manuscript Management - changed to /my-manuscripts
    Route::get('/my-manuscripts', [App\Http\Controllers\AuthorDashboardController::class, 'manuscripts'])->name('author.manuscripts');
    Route::get('/my-manuscripts/create', [App\Http\Controllers\AuthorDashboardController::class, 'createManuscriptForm'])->name('author.manuscripts.create');
    Route::post('/my-manuscripts', [App\Http\Controllers\AuthorDashboardController::class, 'storeManuscript'])->name('author.manuscripts.store');
    Route::get('/my-manuscripts/{id}', [App\Http\Controllers\AuthorDashboardController::class, 'showManuscript'])->name('author.manuscripts.show');
    Route::get('/my-manuscripts/{id}/edit', [App\Http\Controllers\AuthorDashboardController::class, 'editManuscript'])->name('author.manuscripts.edit');
    Route::put('/my-manuscripts/{id}', [App\Http\Controllers\AuthorDashboardController::class, 'updateManuscript'])->name('author.manuscripts.update');
    Route::delete('/my-manuscripts/{id}', [App\Http\Controllers\AuthorDashboardController::class, 'deleteManuscript'])->name('author.manuscripts.delete');
});

// Admin Routes
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.authenticate');

// Protected Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // Manuscript Management
    Route::get('/manuscripts', [App\Http\Controllers\AdminController::class, 'manuscripts'])->name('manuscripts.index');
    Route::get('/manuscripts/{id}', [App\Http\Controllers\AdminController::class, 'showManuscript'])->name('manuscripts.show');
    Route::post('/manuscripts/{id}/review', [App\Http\Controllers\AdminController::class, 'reviewManuscript'])->name('manuscripts.review');
    Route::patch('/manuscripts/{id}/status', [App\Http\Controllers\AdminController::class, 'updateManuscriptStatus'])->name('manuscripts.update-status');
    Route::post('/manuscripts/{id}/publish', [App\Http\Controllers\AdminController::class, 'publishManuscript'])->name('manuscripts.publish');
    Route::post('/manuscripts/bulk-action', [App\Http\Controllers\AdminController::class, 'bulkManuscriptAction'])->name('manuscripts.bulk-action');

    // Book Management
    Route::get('/books', [App\Http\Controllers\AdminController::class, 'books'])->name('books.index');
    Route::get('/books/create', [App\Http\Controllers\AdminController::class, 'createBookForm'])->name('books.create');
    Route::post('/books', [App\Http\Controllers\AdminController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{id}/edit', [App\Http\Controllers\AdminController::class, 'editBookForm'])->name('books.edit');
    Route::put('/books/{id}', [App\Http\Controllers\AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{id}', [App\Http\Controllers\AdminController::class, 'deleteBook'])->name('books.delete');

    // Orders Management
    Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{id}/status', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::post('/orders/{id}/confirm', [App\Http\Controllers\AdminController::class, 'confirmOrder'])->name('orders.confirm');
    Route::post('/orders/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectOrder'])->name('orders.reject');

    // User Management
    Route::get('/authors', [App\Http\Controllers\AdminController::class, 'authors'])->name('authors');
    Route::get('/authors/{id}', [App\Http\Controllers\AdminController::class, 'showAuthor'])->name('authors.show');
    Route::get('/authors/{id}/edit', [App\Http\Controllers\AdminController::class, 'editAuthor'])->name('authors.edit');
    Route::put('/authors/{id}', [App\Http\Controllers\AdminController::class, 'updateAuthor'])->name('authors.update');
    Route::post('/authors/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleAuthorStatus'])->name('authors.toggle-status');
    Route::delete('/authors/{id}', [App\Http\Controllers\AdminController::class, 'deleteAuthor'])->name('authors.delete');

    Route::get('/customers', [App\Http\Controllers\AdminController::class, 'customers'])->name('customers');
    Route::get('/customers/{id}', [App\Http\Controllers\AdminController::class, 'showCustomer'])->name('customers.show');
    Route::get('/customers/{id}/edit', [App\Http\Controllers\AdminController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/customers/{id}', [App\Http\Controllers\AdminController::class, 'updateCustomer'])->name('customers.update');
    Route::post('/customers/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleCustomerStatus'])->name('customers.toggle-status');
    Route::delete('/customers/{id}', [App\Http\Controllers\AdminController::class, 'deleteCustomer'])->name('customers.delete');

    // Logout
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
});

// Payment Gateway Routes
Route::prefix('payment')->name('payment.')->group(function () {
    // SSLCommerz callback routes
    Route::post('/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('success');
    Route::post('/fail', [App\Http\Controllers\PaymentController::class, 'fail'])->name('fail');
    Route::post('/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('cancel');
    Route::post('/ipn', [App\Http\Controllers\PaymentController::class, 'ipn'])->name('ipn');

    // Payment result pages
    Route::get('/success/{order}', [App\Http\Controllers\PaymentController::class, 'successPage'])->name('success.page');
    Route::get('/failed', [App\Http\Controllers\PaymentController::class, 'failedPage'])->name('failed.page');
    Route::get('/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelledPage'])->name('cancelled.page');

    // Payment status check API
    Route::get('/status/{transactionId}', [App\Http\Controllers\PaymentController::class, 'checkPaymentStatus'])->name('status.check');
});
