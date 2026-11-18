@extends('layouts.admin')

@section('title', 'Manajemen Berita - Meja Redaksi')
@section('page_title', 'Manajemen Berita & Naskah')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center space-x-1.5 overflow-x-auto pb-1 text-xs font-semibold">
            <a href="{{ route('admin.articles.index') }}" 
               class="px-3 py-1.5 rounded-lg transition {{ !request('status') ? 'bg-blue-950 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Semua ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'draft' ? 'bg-blue-950 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Draf Saya ({{ $counts['draft'] }})
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'submitted']) }}" 
               class="px-3 py-1.5 rounded-lg transition flex items-center space-x-1 {{ request('status') === 'submitted' ? 'bg-amber-600 text-white font-bold shadow-xs' : 'bg-amber-50 text-amber-900 border border-amber-200 hover:bg-amber-100' }}">
                <span>Menunggu Kadiv</span>
                <span class="px-1.5 py-0.2 rounded-full text-2xs bg-amber-800 text-white">{{ $counts['submitted'] }}</span>
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'under_review']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'under_review' ? 'bg-blue-950 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Ditinjau ({{ $counts['under_review'] }})
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'revision_required']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'revision_required' ? 'bg-rose-900 text-white font-bold' : 'bg-white text-rose-800 border border-rose-200 hover:bg-rose-50' }}">
                Perlu Revisi ({{ $counts['revision_required'] }})
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'approved']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'approved' ? 'bg-blue-950 text-white font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Disetujui ({{ $counts['approved'] }})
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'published']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'published' ? 'bg-emerald-800 text-white font-bold' : 'bg-white text-emerald-800 border border-emerald-200 hover:bg-emerald-50' }}">
                Tayang ({{ $counts['published'] }})
            </a>
        </div>

        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm shrink-0">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tulis Berita Baru</span>
        </a>
    </div>

    <!-- Search & Filter Form -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau kata kunci..." class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-900">

            <select name="kategori" class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold py-2 rounded-lg transition">
                Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Articles Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs divide-y divide-slate-200">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Artikel & Kategori</th>
                        <th class="px-5 py-3.5">Penulis / Editor</th>
                        <th class="px-5 py-3.5">Status Alur</th>
                        <th class="px-5 py-3.5 text-center">Statistik</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50 transition">
                            <!-- Article Info -->
                            <td class="px-5 py-4 max-w-sm">
                                <div class="flex items-start space-x-3">
                                    @if($article->featured_image)
                                        <img src="{{ $article->featured_image_url }}" alt="" class="w-14 h-11 rounded object-cover shrink-0 bg-slate-100 border border-slate-200">
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="font-bold text-slate-900 hover:text-blue-900 line-clamp-1 text-sm">
                                            {{ $article->title }}
                                        </a>
                                        <div class="flex items-center space-x-2 text-2xs text-slate-400 mt-1">
                                            <span class="text-blue-900 font-semibold">{{ $article->category->name }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $article->created_at->locale('id')->isoFormat('D MMM Y') }}</span>
                                            @if($article->is_breaking)
                                                <span class="bg-red-100 text-red-700 font-bold px-1 rounded">Breaking</span>
                                            @endif
                                            @if($article->is_headline)
                                                <span class="bg-amber-100 text-amber-800 font-bold px-1 rounded">Headline</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Author & Editor -->
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $article->author->name }}</div>
                                @if($article->editor)
                                    <div class="text-2xs text-slate-400">Editor: {{ $article->editor->name }}</div>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="px-5 py-4">
                                @php
                                    $statusClasses = [
                                        'draft' => 'bg-slate-100 text-slate-700',
                                        'submitted' => 'bg-amber-100 text-amber-800',
                                        'under_review' => 'bg-blue-100 text-blue-800',
                                        'revision_required' => 'bg-rose-100 text-rose-800',
                                        'approved' => 'bg-indigo-100 text-indigo-800',
                                        'scheduled' => 'bg-purple-100 text-purple-800',
                                        'published' => 'bg-emerald-100 text-emerald-800',
                                        'archived' => 'bg-slate-200 text-slate-600',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full font-bold text-2xs uppercase tracking-wider {{ $statusClasses[$article->status] ?? 'bg-slate-100' }}">
                                    {{ str_replace('_', ' ', $article->status) }}
                                </span>
                            </td>

                            <!-- Stats -->
                            <td class="px-5 py-4 text-center">
                                <div class="font-bold text-slate-900">{{ number_format($article->views_count) }}</div>
                                <div class="text-2xs text-slate-400">pembaca</div>
                            </td>

                            <!-- Action Buttons -->
                            <!-- Action Buttons -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Quick workflow buttons --}}
                                    @if(auth()->user()->hasRole('editor') && in_array($article->status, ['draft', 'revision_required']) && $article->user_id === auth()->id())
                                        <form action="{{ route('admin.articles.submit', $article) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-2xs font-bold rounded-md bg-amber-600 hover:bg-amber-700 text-white shadow-2xs transition" title="Ajukan naskah kepada Kadiv">
                                                <i data-lucide="send" class="w-3 h-3"></i>
                                                <span>Kirim ke Kadiv</span>
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->isPemimpinRedaksi() && in_array($article->status, ['submitted', 'under_review']))
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-2xs font-bold rounded-md bg-blue-950 hover:bg-blue-900 text-white shadow-2xs transition" title="Tinjau & Putuskan Naskah">
                                            <i data-lucide="check-square" class="w-3 h-3 text-emerald-400"></i>
                                            <span>Tinjau & Putuskan</span>
                                        </a>
                                    @endif

                                    @if($article->status === 'published')
                                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-900 rounded hover:bg-slate-100" title="Buka di Website">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    @endif

                                    @if(auth()->user()->isPemimpinRedaksi() || ($article->user_id === auth()->id() && $article->status !== 'published'))
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="p-1.5 text-slate-600 hover:text-blue-900 rounded hover:bg-slate-100" title="Edit Naskah">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded hover:bg-red-50" title="Hapus Artikel">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-400 italic">
                                Belum ada artikel pada kriteria ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $articles->links() }}
        </div>
    </div>

</div>
@endsection
