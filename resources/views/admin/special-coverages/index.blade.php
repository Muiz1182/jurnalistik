@extends('layouts.admin')

@section('title', 'Liputan Khusus - Meja Redaksi')
@section('page_title', 'Manajemen Liputan Khusus & Serial')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Daftar Serial Liputan Khusus</h2>
            <p class="text-xs text-slate-500">Kelola kurasi tematik yang menggabungkan beberapa artikel dalam satu fokus liputan.</p>
        </div>
        <a href="{{ route('admin.special-coverages.create') }}" class="bg-blue-950 hover:bg-blue-900 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-2xs flex items-center">
            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
            <span>Buat Liputan Khusus</span>
        </a>
    </div>

    <div class="space-y-4">
        @forelse($coverages as $coverage)
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start space-x-4">
                    @if($coverage->banner_image)
                        <img src="{{ $coverage->banner_image_url }}" alt="" class="w-20 h-14 rounded-lg object-cover shrink-0 bg-slate-100 border border-slate-200">
                    @endif
                    <div>
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-2xs font-bold uppercase px-2 py-0.5 rounded {{ $coverage->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $coverage->is_active ? 'Aktif Tayang' : 'Nonaktif' }}
                            </span>
                            <span class="text-xs text-slate-400">&bull;</span>
                            <span class="text-xs text-slate-500">{{ $coverage->articles_count }} artikel terhubung</span>
                        </div>
                        <h3 class="font-bold text-base text-slate-900">{{ $coverage->title }}</h3>
                        <p class="text-xs text-slate-600 mt-0.5 line-clamp-1">{{ $coverage->subtitle }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2 shrink-0">
                    <a href="{{ route('admin.special-coverages.edit', $coverage) }}" class="p-2 text-slate-600 hover:text-blue-900 rounded-lg hover:bg-slate-50 border border-slate-200" title="Kelola Artikel Serial">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('admin.special-coverages.destroy', $coverage) }}" method="POST" onsubmit="return confirm('Hapus serial liputan khusus ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-slate-50 border border-slate-200" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-xl border border-dashed border-slate-200 p-8">
                <p class="text-xs text-slate-400 italic">Belum ada serial liputan khusus yang dibuat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $coverages->links() }}
    </div>

</div>
@endsection
