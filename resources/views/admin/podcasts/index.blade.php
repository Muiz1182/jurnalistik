@extends('layouts.admin')

@section('title', 'Podcast SPELAND - Meja Redaksi')
@section('page_title', 'Manajemen Podcast SPELAND')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Episode Podcast</h2>
            <p class="text-xs text-slate-500">Kelola episode gelar wicara podcast resmi SMP Negeri 9 Probolinggo.</p>
        </div>
        <a href="{{ route('admin.podcasts.create') }}" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Tambah Episode Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($podcasts as $podcast)
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-xs font-bold text-red-600 mb-2">
                        <span>EPISODE #{{ $podcast->episode_number }}</span>
                        <span class="text-slate-400 font-medium">{{ $podcast->duration ?: '~30 menit' }}</span>
                    </div>
                    <h3 class="font-bold text-base text-slate-900 leading-snug">{{ $podcast->title }}</h3>
                    <div class="mt-2 text-xs text-slate-600 space-y-0.5 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <p><strong>Host:</strong> {{ $podcast->host }}</p>
                        @if($podcast->guest)
                            <p><strong>Narasumber:</strong> {{ $podcast->guest }}</p>
                        @endif
                    </div>
                    @if($podcast->description)
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $podcast->description }}</p>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>{{ $podcast->published_at ? $podcast->published_at->locale('id')->isoFormat('D MMM Y') : '' }}</span>
                    <form action="{{ route('admin.podcasts.destroy', $podcast) }}" method="POST" onsubmit="return confirm('Hapus episode podcast ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                <p class="text-xs text-slate-400 italic">Belum ada episode podcast yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $podcasts->links() }}
    </div>

</div>
@endsection
