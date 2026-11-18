@extends('layouts.admin')

@section('title', 'Log Aktivitas Redaksi - Meja Redaksi')
@section('page_title', 'Audit & Catatan Aktivitas Sistem (Activity Log)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800">Catatan Audit & Riwayat Perubahan Redaksi</h2>
            <p class="text-xs text-slate-500">Merekam setiap tindakan penulisan, revisi, persetujuan naskah, moderasi, dan konfigurasi sistem.</p>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
        <table class="w-full text-left text-xs divide-y divide-slate-200">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3.5">Waktu</th>
                    <th class="px-5 py-3.5">Pengguna / Jurnalis</th>
                    <th class="px-5 py-3.5">Aksi</th>
                    <th class="px-5 py-3.5">Rincian Tindakan</th>
                    <th class="px-5 py-3.5 text-right font-mono">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5 text-slate-400 font-mono text-2xs whitespace-nowrap">
                            {{ $log->created_at->translatedFormat('d M Y, H:i:s') }}
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            @if($log->user)
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $log->user->avatar_url }}" alt="" class="w-6 h-6 rounded-full object-cover border border-slate-200">
                                    <span class="font-bold text-slate-900">{{ $log->user->name }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 italic">Sistem / Tamu</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            @php
                                $actionColors = [
                                    'create' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                    'update' => 'bg-blue-50 text-blue-800 border-blue-200',
                                    'approve' => 'bg-purple-50 text-purple-800 border-purple-200',
                                    'publish' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                    'delete' => 'bg-rose-50 text-rose-800 border-rose-200',
                                    'login' => 'bg-amber-50 text-amber-800 border-amber-200',
                                ];
                                $colorClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                foreach($actionColors as $k => $c) {
                                    if(str_contains($log->action, $k)) {
                                        $colorClass = $c;
                                        break;
                                    }
                                }
                            @endphp
                            <span class="px-2 py-0.5 rounded text-2xs font-mono font-bold uppercase border {{ $colorClass }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-800 max-w-md">
                            {{ $log->description }}
                        </td>
                        <td class="px-5 py-3.5 text-right font-mono text-2xs text-slate-400 whitespace-nowrap">
                            {{ $log->ip_address ?: '127.0.0.1' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-xs">
                            Belum ada riwayat aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
