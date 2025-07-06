<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Manuscript;

class AuthorDashboardController extends Controller
{
    public function dashboard()
    {
        $author = Auth::guard('author')->user();

        // Get all manuscripts for this author
        $manuscripts = Manuscript::where('author_id', $author->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total' => $manuscripts->count(),
            'pending' => $manuscripts->where('status', 'pending')->count(),
            'under_review' => $manuscripts->where('status', 'under_review')->count(),
            'approved' => $manuscripts->where('status', 'approved')->count(),
            'rejected' => $manuscripts->where('status', 'rejected')->count(),
            'published' => $manuscripts->where('status', 'published')->count(),
        ];

        // Get recent manuscripts (last 5)
        $recentManuscripts = $manuscripts->take(5);

        // Get manuscripts by status for quick actions
        $pendingManuscripts = $manuscripts->where('status', 'pending');
        $rejectedManuscripts = $manuscripts->where('status', 'rejected');

        // Get manuscripts with recent review updates (within last 7 days)
        $recentlyReviewedManuscripts = $manuscripts->filter(function($manuscript) {
            return $manuscript->reviewed_at &&
                   $manuscript->reviewed_at->isAfter(now()->subDays(7)) &&
                   in_array($manuscript->status, ['approved', 'rejected', 'under_review']);
        });

        // Get manuscripts that need author attention (rejected or changes requested)
        $manuscriptsNeedingAttention = $manuscripts->filter(function($manuscript) {
            return in_array($manuscript->status, ['rejected', 'under_review']) &&
                   $manuscript->admin_notes;
        });

        return view('author.dashboard', compact(
            'author',
            'manuscripts',
            'stats',
            'recentManuscripts',
            'pendingManuscripts',
            'rejectedManuscripts',
            'recentlyReviewedManuscripts',
            'manuscriptsNeedingAttention'
        ));
    }

    public function manuscripts()
    {
        $author = Auth::guard('author')->user();
        $manuscripts = Manuscript::where('author_id', $author->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.manuscripts', compact('manuscripts', 'author'));
    }

    public function showManuscript($id)
    {
        $author = Auth::guard('author')->user();
        $manuscript = Manuscript::where('id', $id)
            ->where('author_id', $author->id)
            ->firstOrFail();

        return view('author.manuscript-detail', compact('manuscript', 'author'));
    }

    public function createManuscriptForm()
    {
        $author = Auth::guard('author')->user();
        $genres = ['Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction', 'Fantasy', 'Biography', 'History', 'Self-Help', 'Business', 'Poetry', 'Children', 'Young Adult'];

        return view('author.create-manuscript', compact('author', 'genres'));
    }

    public function storeManuscript(Request $request)
    {
        $author = Auth::guard('author')->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'genre' => 'required|string|max:100',
            'pages' => 'nullable|integer|min:1|max:10000',
            'language' => 'required|string|max:50',
            'suggested_price' => 'nullable|numeric|min:0|max:99999.99',
            'manuscript_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        $manuscriptData = [
            'author_id' => $author->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'genre' => $validated['genre'],
            'pages' => $validated['pages'],
            'language' => $validated['language'],
            'suggested_price' => $validated['suggested_price'],
            'status' => 'pending',
            'submitted_at' => now(),
        ];

        // Handle file uploads
        if ($request->hasFile('manuscript_file')) {
            $manuscriptFile = $request->file('manuscript_file');
            $filename = time() . '_' . $manuscriptFile->getClientOriginalName();
            $manuscriptData['manuscript_file'] = $manuscriptFile->storeAs('manuscripts', $filename, 'public');
        }

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $filename = time() . '_cover_' . $coverImage->getClientOriginalName();
            $manuscriptData['cover_image'] = $coverImage->storeAs('covers', $filename, 'public');
        }

        $manuscript = Manuscript::create($manuscriptData);

        return redirect()->route('author.manuscripts')->with('success', 'Manuscript submitted successfully! We will review it and get back to you soon.');
    }

    public function editManuscript($id)
    {
        $author = Auth::guard('author')->user();
        $manuscript = Manuscript::where('id', $id)
            ->where('author_id', $author->id)
            ->firstOrFail();

        // Only allow editing if manuscript is pending, rejected, or under review
        if (!in_array($manuscript->status, ['pending', 'rejected', 'under_review'])) {
            return redirect()->route('author.manuscripts')->with('error', 'You can only edit manuscripts that are pending, rejected, or under review.');
        }

        $genres = ['Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction', 'Fantasy', 'Biography', 'History', 'Self-Help', 'Business', 'Poetry', 'Children', 'Young Adult'];

        return view('author.edit-manuscript', compact('manuscript', 'author', 'genres'));
    }

    public function updateManuscript(Request $request, $id)
    {
        $author = Auth::guard('author')->user();
        $manuscript = Manuscript::where('id', $id)
            ->where('author_id', $author->id)
            ->firstOrFail();

        // Only allow updating if manuscript is pending, rejected, or under review
        if (!in_array($manuscript->status, ['pending', 'rejected', 'under_review'])) {
            return redirect()->route('author.manuscripts')->with('error', 'You can only edit manuscripts that are pending, rejected, or under review.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'genre' => 'required|string|max:100',
            'pages' => 'nullable|integer|min:1|max:10000',
            'language' => 'required|string|max:50',
            'suggested_price' => 'nullable|numeric|min:0|max:99999.99',
            'manuscript_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'genre' => $validated['genre'],
            'pages' => $validated['pages'],
            'language' => $validated['language'],
            'suggested_price' => $validated['suggested_price'],
            'status' => 'pending', // Reset to pending when updated
            'submitted_at' => now(),
        ];

        // Handle file uploads
        if ($request->hasFile('manuscript_file')) {
            // Delete old file if exists
            if ($manuscript->manuscript_file) {
                Storage::disk('public')->delete($manuscript->manuscript_file);
            }

            $manuscriptFile = $request->file('manuscript_file');
            $filename = time() . '_' . $manuscriptFile->getClientOriginalName();
            $updateData['manuscript_file'] = $manuscriptFile->storeAs('manuscripts', $filename, 'public');
        }

        if ($request->hasFile('cover_image')) {
            // Delete old file if exists
            if ($manuscript->cover_image) {
                Storage::disk('public')->delete($manuscript->cover_image);
            }

            $coverImage = $request->file('cover_image');
            $filename = time() . '_cover_' . $coverImage->getClientOriginalName();
            $updateData['cover_image'] = $coverImage->storeAs('covers', $filename, 'public');
        }

        $manuscript->update($updateData);

        return redirect()->route('author.manuscripts')->with('success', 'Manuscript updated successfully! We will review the changes.');
    }

    public function deleteManuscript($id)
    {
        $author = Auth::guard('author')->user();
        $manuscript = Manuscript::where('id', $id)
            ->where('author_id', $author->id)
            ->firstOrFail();

        // Only allow deletion if manuscript is pending or rejected
        if (!in_array($manuscript->status, ['pending', 'rejected'])) {
            return redirect()->route('author.manuscripts')->with('error', 'You can only delete manuscripts that are pending or rejected.');
        }

        // Delete associated files
        if ($manuscript->manuscript_file) {
            Storage::disk('public')->delete($manuscript->manuscript_file);
        }
        if ($manuscript->cover_image) {
            Storage::disk('public')->delete($manuscript->cover_image);
        }

        $manuscript->delete();

        return redirect()->route('author.manuscripts')->with('success', 'Manuscript deleted successfully.');
    }

    public function profile()
    {
        $author = Auth::guard('author')->user();
        return view('author.profile', compact('author'));
    }

    public function updateProfile(Request $request)
    {
        $author = Auth::guard('author')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:authors,email,' . $author->id,
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]{7,20}$/',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // If password change is requested, verify current password
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Current password is required to change password.']);
            }

            if (!Hash::check($request->current_password, $author->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $validated['password'] = bcrypt($validated['password']);
        } else {
            // Remove password fields if not changing password
            unset($validated['password'], $validated['current_password']);
        }

        // Remove confirmation field
        unset($validated['password_confirmation']);

        $author->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}
