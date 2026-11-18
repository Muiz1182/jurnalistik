<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article): RedirectResponse
    {
        if (!$article->allow_comments) {
            return back()->with('error', 'Komentar untuk artikel ini telah ditutup.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'content' => 'required|string|min:5|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Basic spam protection (honeypot or link limit check)
        if (substr_count($validated['content'], 'http://') + substr_count($validated['content'], 'https://') > 2) {
            return back()->with('error', 'Komentar terdeteksi memuat terlalu banyak tautan eksternal.');
        }

        // All comments require moderator review before publishing (per prompt requirement)
        Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => auth()->check() ? auth()->user()->name : strip_tags($validated['name']),
            'email' => auth()->check() ? auth()->user()->email : strip_tags($validated['email']),
            'content' => strip_tags($validated['content']),
            'status' => 'pending', // Moderated
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Komentar Anda telah terkirim dan menunggu moderasi redaksi sebelum ditampilkan.');
    }
}
