<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\EditorialAssignment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $query = EditorialAssignment::with(['reporter', 'assignedBy', 'article']);

        if (!$user->isPemimpinRedaksi()) {
            $query->where('reporter_id', $user->id);
        }

        $assignments = $query->latest()->paginate(15);
        $reporters = User::whereHas('role', fn($q) => $q->whereIn('slug', ['editor', 'reporter', 'fotografer']))->get();

        return view('admin.assignments.index', compact('assignments', 'reporters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isPemimpinRedaksi()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang dapat memberikan instruksi liputan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief' => 'required|string',
            'reporter_id' => 'required|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        $assignment = EditorialAssignment::create([
            'title' => $validated['title'],
            'brief' => $validated['brief'],
            'reporter_id' => $validated['reporter_id'],
            'assigned_by_id' => auth()->id(),
            'deadline' => $validated['deadline'] ?? null,
            'status' => 'assigned',
        ]);

        ActivityLog::log('create_assignment', "Memberikan penugasan liputan '{$assignment->title}' kepada {$assignment->reporter->name}.", $assignment);

        return back()->with('success', 'Penugasan liputan berhasil diberikan.');
    }

    public function updateStatus(Request $request, EditorialAssignment $assignment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:assigned,in_progress,submitted,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $assignment->update($validated);

        ActivityLog::log('update_assignment', "Memperbarui status penugasan '{$assignment->title}' menjadi [{$validated['status']}].", $assignment);

        return back()->with('success', 'Status penugasan berhasil diperbarui.');
    }

    public function destroy(EditorialAssignment $assignment): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isPemimpinRedaksi()) {
            abort(403, 'Hanya Kadiv atau Super Admin yang dapat menghapus penugasan liputan.');
        }

        $title = $assignment->title;
        $assignment->delete();

        ActivityLog::log('delete_assignment', "Menghapus penugasan liputan '{$title}'.");

        return back()->with('success', 'Penugasan liputan berhasil dihapus.');
    }
}
