<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\EditorialMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EditorialMemberController extends Controller
{
    public function index(): View
    {
        $members = EditorialMember::orderBy('order')->paginate(20);
        return view('admin.editorial-members.index', compact('members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'division' => 'required|string|max:100',
            'class_or_grade' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('editorial', 'public');
        }

        $member = EditorialMember::create([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'division' => $validated['division'],
            'class_or_grade' => $validated['class_or_grade'] ?? null,
            'photo' => $photoPath,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        ActivityLog::log('create_member', "Menambahkan anggota redaksi: {$member->name}.", $member);

        return back()->with('success', 'Anggota redaksi berhasil ditambahkan.');
    }

    public function update(Request $request, EditorialMember $editorialMember): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'division' => 'required|string|max:100',
            'class_or_grade' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($editorialMember->photo && !Str::startsWith($editorialMember->photo, 'http')) {
                Storage::disk('public')->delete($editorialMember->photo);
            }
            $editorialMember->photo = $request->file('photo')->store('editorial', 'public');
        }

        $editorialMember->update([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'division' => $validated['division'],
            'class_or_grade' => $validated['class_or_grade'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? $editorialMember->order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLog::log('update_member', "Memperbarui profil anggota redaksi {$editorialMember->name}.", $editorialMember);

        return back()->with('success', 'Data anggota redaksi berhasil diperbarui.');
    }

    public function destroy(EditorialMember $editorialMember): RedirectResponse
    {
        $name = $editorialMember->name;
        if ($editorialMember->photo && !Str::startsWith($editorialMember->photo, 'http')) {
            Storage::disk('public')->delete($editorialMember->photo);
        }
        $editorialMember->delete();

        ActivityLog::log('delete_member', "Menghapus anggota redaksi {$name}.");

        return back()->with('success', 'Anggota redaksi berhasil dihapus.');
    }
}
