<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Comment::with(['article', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        $comments = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'rejected' => Comment::where('status', 'rejected')->count(),
            'spam' => Comment::where('status', 'spam')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'counts'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update(['status' => 'approved']);
        ActivityLog::log('approve_comment', "Menyetujui komentar dari {$comment->name} pada artikel '{$comment->article->title}'.", $comment);

        return back()->with('success', 'Komentar berhasil disetujui dan kini tampil di website.');
    }

    public function reject(Comment $comment): RedirectResponse
    {
        $comment->update(['status' => 'rejected']);
        ActivityLog::log('reject_comment', "Menolak komentar dari {$comment->name}.", $comment);

        return back()->with('success', 'Komentar ditolak.');
    }

    public function markSpam(Comment $comment): RedirectResponse
    {
        $comment->update(['status' => 'spam']);
        ActivityLog::log('spam_comment', "Menandai komentar dari {$comment->name} sebagai spam.", $comment);

        return back()->with('success', 'Komentar ditandai sebagai spam.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();
        ActivityLog::log('delete_comment', "Menghapus komentar.");

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
