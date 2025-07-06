<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Manuscript;
use App\Models\Book;
use App\Models\Author;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Admin;

class AdminController extends Controller
{
    public function login()
    {
        // Redirect if already logged in as admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if admin exists and is active
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            return back()->withErrors([
                'email' => 'No admin account found with this email address.',
            ])->onlyInput('email');
        }

        if (!$admin->is_active) {
            return back()->withErrors([
                'email' => 'This admin account has been deactivated.',
            ])->onlyInput('email');
        }

        // Attempt authentication with admin guard
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Update last login timestamp
            $admin->touch();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    public function dashboard()
    {
        $stats = [
            'manuscripts' => [
                'total' => Manuscript::count(),
                'pending' => Manuscript::pending()->count(),
                'under_review' => Manuscript::underReview()->count(),
                'approved' => Manuscript::approved()->count(),
                'rejected' => Manuscript::rejected()->count(),
                'published' => Manuscript::published()->count(),
            ],
            'books' => Book::count(),
            'authors' => Author::count(),
            'customers' => Customer::count(),
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'paid' => Order::where('status', 'paid')->count(),
                'failed' => Order::where('status', 'failed')->count(),
            ],
            'recent_orders' => Order::with('customer')
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Manuscript Management
    public function manuscripts(Request $request)
    {
        $query = Manuscript::with('author', 'reviewer');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by genre
        if ($request->has('genre') && $request->genre != '') {
            $query->where('genre', $request->genre);
        }

        // Search by title or author
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('author', function($authorQuery) use ($search) {
                      $authorQuery->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $manuscripts = $query->paginate(15)->withQueryString();

        // Get filter options
        $statuses = ['pending', 'under_review', 'approved', 'rejected', 'published'];
        $genres = Manuscript::distinct()->whereNotNull('genre')->pluck('genre')->unique()->sort();

        return view('admin.manuscripts.index', compact('manuscripts', 'statuses', 'genres'));
    }

    public function showManuscript($id)
    {
        $manuscript = Manuscript::with('author', 'reviewer')->findOrFail($id);

        // Get review history if needed (you might want to create a ManuscriptReview model for this)
        $reviewHistory = []; // Placeholder for review history

        return view('admin.manuscripts.show', compact('manuscript', 'reviewHistory'));
    }

    public function reviewManuscript(Request $request, $id)
    {
        $manuscript = Manuscript::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:approve,reject,request_changes',
            'admin_notes' => 'required|string|max:2000',
            'suggested_price' => 'nullable|numeric|min:0|max:99999.99',
        ]);

        $status = match($validated['action']) {
            'approve' => 'approved',
            'reject' => 'rejected',
            'request_changes' => 'under_review',
        };

        $updateData = [
            'status' => $status,
            'admin_notes' => $validated['admin_notes'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::guard('admin')->id(),
        ];

        if (isset($validated['suggested_price']) && $validated['action'] === 'approve') {
            $updateData['suggested_price'] = $validated['suggested_price'];
        }

        $manuscript->update($updateData);

        $message = match($validated['action']) {
            'approve' => 'Manuscript approved successfully!',
            'reject' => 'Manuscript rejected.',
            'request_changes' => 'Review feedback sent to author.',
        };

        return redirect()->route('admin.manuscripts.show', $manuscript->id)
            ->with('success', $message);
    }

    public function publishManuscript(Request $request, $id)
    {
        $manuscript = Manuscript::where('status', 'approved')->findOrFail($id);

        $validated = $request->validate([
            'book_price' => 'required|numeric|min:0|max:99999.99',
            'book_cover_link' => 'nullable|url|max:1024',
            'book_publisher' => 'nullable|string|max:255',
            'book_isbn_10' => 'nullable|string|max:20',
            'book_isbn_13' => 'nullable|string|max:20',
        ]);

        // Create book from manuscript
        $book = Book::create([
            'book_name' => $manuscript->title,
            'book_author' => $manuscript->author->name,
            'book_publisher' => $validated['book_publisher'] ?? 'IMS Publishing House',
            'book_price' => $validated['book_price'],
            'book_genre' => $manuscript->genre,
            'book_cover_link' => $validated['book_cover_link'] ?? ($manuscript->cover_image ? asset('storage/' . $manuscript->cover_image) : null),
            'book_pages' => $manuscript->pages,
            'book_isbn_10' => $validated['book_isbn_10'],
            'book_isbn_13' => $validated['book_isbn_13'],
            'book_publication_date' => now()->toDateString(),
        ]);

        // Update manuscript status
        $manuscript->update([
            'status' => 'published',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.manuscripts.show', $manuscript->id)
            ->with('success', "Manuscript published successfully as book: {$book->book_name}!");
    }

    public function bulkManuscriptAction(Request $request)
    {
        $validated = $request->validate([
            'manuscript_ids' => 'required|array',
            'manuscript_ids.*' => 'exists:manuscripts,id',
            'bulk_action' => 'required|in:approve,reject,under_review',
            'bulk_notes' => 'nullable|string|max:1000',
        ]);

        $manuscripts = Manuscript::whereIn('id', $validated['manuscript_ids'])->get();

        foreach ($manuscripts as $manuscript) {
            $manuscript->update([
                'status' => $validated['bulk_action'],
                'admin_notes' => $validated['bulk_notes'],
                'reviewed_at' => now(),
                'reviewed_by' => Auth::guard('admin')->id(),
            ]);
        }

        $count = count($validated['manuscript_ids']);
        $action = ucfirst(str_replace('_', ' ', $validated['bulk_action']));

        return back()->with('success', "{$count} manuscripts marked as {$action}.");
    }

    // Book Management
    public function books()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    public function createBookForm()
    {
        $genres = ['Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction', 'Fantasy', 'Biography', 'History', 'Self-Help', 'Business', 'Poetry', 'Children', 'Young Adult'];
        return view('admin.books.create', compact('genres'));
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'book_name' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'book_publisher' => 'required|string|max:255',
            'book_price' => 'required|numeric|min:0|max:99999.99',
            'book_genre' => 'required|string|max:100',
            'book_cover_link' => 'nullable|url|max:1024',
            'book_pages' => 'nullable|integer|min:1|max:10000',
            'book_isbn_10' => 'nullable|string|max:20',
            'book_isbn_13' => 'nullable|string|max:20',
            'book_publication_date' => 'nullable|date',
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book added successfully!');
    }

    public function editBookForm($id)
    {
        $book = Book::findOrFail($id);
        $genres = ['Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction', 'Fantasy', 'Biography', 'History', 'Self-Help', 'Business', 'Poetry', 'Children', 'Young Adult'];
        return view('admin.books.edit', compact('book', 'genres'));
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'book_name' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'book_publisher' => 'required|string|max:255',
            'book_price' => 'required|numeric|min:0|max:99999.99',
            'book_genre' => 'required|string|max:100',
            'book_cover_link' => 'nullable|url|max:1024',
            'book_pages' => 'nullable|integer|min:1|max:10000',
            'book_isbn_10' => 'nullable|string|max:20',
            'book_isbn_13' => 'nullable|string|max:20',
            'book_publication_date' => 'nullable|date',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }

    // Orders Management
    public function orders(Request $request)
    {
        $query = Order::with('customer');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get order statistics
        $statistics = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'failed' => Order::where('status', 'failed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount')
        ];

        return view('admin.orders.index', compact('orders', 'statistics'));
    }

    public function showOrder($id)
    {
        $order = Order::with('customer')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,confirmed,processing,completed,failed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'confirmed_by' => Auth::guard('admin')->id(),
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }

    public function confirmOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => 'confirmed',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'confirmed_by' => Auth::guard('admin')->id(),
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Order confirmed successfully!');
    }

    public function rejectOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $order->update([
            'status' => 'cancelled',
            'admin_notes' => $validated['admin_notes'],
            'confirmed_by' => Auth::guard('admin')->id(),
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Order rejected successfully!');
    }

    // Authors & Customers Management
    public function authors()
    {
        $authors = Author::withCount('manuscripts')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.authors.index', compact('authors'));
    }

    public function showAuthor($id)
    {
        $author = Author::with('manuscripts')->findOrFail($id);
        return view('admin.authors.show', compact('author'));
    }

    public function editAuthor($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.authors.edit', compact('author'));
    }

    public function updateAuthor(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors,email,' . $author->id,
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
            'bio' => 'nullable|string|max:2000',
            'website' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ]);

        $author->update($validated);

        return redirect()->route('admin.authors.show', $author->id)
            ->with('success', 'Author updated successfully!');
    }

    public function toggleAuthorStatus($id)
    {
        $author = Author::findOrFail($id);
        $author->update(['is_active' => !$author->is_active]);

        $status = $author->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Author {$status} successfully!");
    }

    public function deleteAuthor($id)
    {
        $author = Author::findOrFail($id);

        // Check if author has manuscripts
        if ($author->manuscripts()->count() > 0) {
            return back()->with('error', 'Cannot delete author with existing manuscripts!');
        }

        $author->delete();
        return redirect()->route('admin.authors')->with('success', 'Author deleted successfully!');
    }

    public function customers()
    {
        $customers = Customer::withCount('orders')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function showCustomer($id)
    {
        $customer = Customer::with('orders')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer->id)
            ->with('success', 'Customer updated successfully!');
    }

    public function toggleCustomerStatus($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['is_active' => !$customer->is_active]);

        $status = $customer->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Customer {$status} successfully!");
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete customer with existing orders!');
        }

        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully!');
    }
}
