@extends('layouts.admin')

@section('title', 'Moderasi Komentar - Meja Redaksi')
@section('page_title', 'Moderasi Komentar Pembaca')

@section('content')
<div class="space-y-6">

    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        @php
            $currentStatus = request('status', 'pending');
        @endphp
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
           class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center space-x-2 {{ $currentStatus === 'pending' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Menunggu Moderasi</span>
            <span class="px-1.5 py-0.2 rounded-full text-2xs {{ $currentStatus === 'pending' ? 'bg-amber-800 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['pending'] }}</span>
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
           class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center space-x-2 {{ $currentStatus === 'approved' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Disetujui</span>
            <span class="px-1.5 py-0.2 rounded-full text-2xs {{ $currentStatus === 'approved' ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['approved'] }}</span>
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'rejected']) }}"
           class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center space-x-2 {{ $currentStatus === 'rejected' ? 'bg-rose-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Ditolak</span>
            <span class="px-1.5 py-0.2 rounded-full text-2xs {{ $currentStatus === 'rejected' ? 'bg-rose-800 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['rejected'] }}</span>
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}"
           class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center space-x-2 {{ $currentStatus === 'spam' ? 'bg-slate-800 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Spam</span>
            <span class="px-1.5 py-0.2 rounded-full text-2xs {{ $currentStatus === 'spam' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['spam'] }}</span>
        </a>
    </div>

    <!-- Comments List -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <div class="divide-y divide-slate-100">
            @forelse($comments as $c)
                <div class="p-5 hover:bg-slate-50/70 transition flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div class="space-y-2 max-w-3xl">
                        <div class="flex items-center space-x-3 text-xs">
                            <span class="font-bold text-slate-900">{{ $c->name }}</span>
                            <span class="text-slate-400">&bull;</span>
                            <span class="text-slate-500 font-mono text-2xs">{{ $c->email }}</span>
                            <span class="text-slate-400">&bull;</span>
                            <span class="text-slate-400 text-2xs">{{ $c->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                        </div>

                        <p class="text-xs text-slate-700 leading-relaxed font-sans bg-slate-50/80 p-3 rounded-lg border border-slate-100">
                            {{ $c->content }}
                        </p>

                        <div class="flex items-center space-x-2 text-2xs text-slate-500">
                            <span>Pada artikel:</span>
                            @if($c->article)
                                <a href="{{ route('articles.show', $c->article->slug) }}" target="_blank" class="font-bold text-blue-950 hover:underline flex items-center">
                                    <span>{{ $c->article->title }}</span>
                                    <i data-lucide="external-link" class="w-3 h-3 ml-1"></i>
                                </a>
                            @else
                                <span class="italic text-slate-400">Artikel telah dihapus</span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-1.5 self-end md:self-center shrink-0">
                        @if($c->status !== 'approved')
                            <form action="{{ route('admin.comments.approve', $c) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-2xs font-bold transition flex items-center" title="Setujui dan tayangkan">
                                    <i data-lucide="check" class="w-3.5 h-3.5 mr-1"></i>
                                    <span>Setujui</span>
                                </button>
                            </form>
                        @endif

                        @if($c->status !== 'rejected')
                            <form action="{{ route('admin.comments.reject', $c) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded text-2xs font-bold transition flex items-center" title="Tolak komentar">
                                    <i data-lucide="x" class="w-3.5 h-3.5 mr-1"></i>
                                    <span>Tolak</span>
                                </button>
                            </form>
                        @endif

                        @if($c->status !== 'spam')
                            <form action="{{ route('admin.comments.spam', $c) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded text-2xs font-bold transition flex items-center" title="Tandai sebagai spam">
                                    <i data-lucide="alert-octagon" class="w-3.5 h-3.5 mr-1"></i>
                                    <span>Spam</span>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.comments.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus komentar ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded transition" title="Hapus permanen">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">
                    Tidak ada komentar dengan status "{{ $currentStatus }}".
                </div>
            @endforelse
        </div>

        @if($comments->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
