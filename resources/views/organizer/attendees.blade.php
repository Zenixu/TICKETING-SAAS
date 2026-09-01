@extends('layouts.glass')

@section('title', 'Peserta — ' . $event->title)

@section('content')
@php
    $filterLabels = [
        'all' => 'Semua',
        'registered' => 'Teregistrasi',
        'checked_in' => 'Sudah Check-in',
        'pending_payment' => 'Menunggu Bayar',
        'pending_verification' => 'Verifikasi Bukti',
        'cancelled' => 'Dibatalkan',
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="glass rounded-2xl p-4 border-mint/30 bg-mint/5 flex items-start gap-3">
            <span class="material-symbols-outlined text-mint">check_circle</span>
            <p class="text-sm text-text-primary flex-1">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="glass rounded-2xl p-4 border-coral/30 bg-coral/5 flex items-start gap-3">
            <span class="material-symbols-outlined text-coral">error</span>
            <p class="text-sm text-text-primary flex-1">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Header --}}
    <div class="space-y-2">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-text-muted hover:text-coral transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Dashboard
        </a>
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <span class="glass-pill text-coral text-[10px] font-mono tracking-wider uppercase px-3 py-1 inline-flex items-center gap-1.5 mb-2">
                    <span class="material-symbols-outlined text-[12px]">group</span>
                    Daftar Peserta
                </span>
                <h1 class="text-2xl sm:text-3xl font-display font-bold tracking-[-0.02em]">{{ $event->title }}</h1>
                <p class="text-xs text-text-muted mt-1 font-mono">
                    {{ $event->date_time->translatedFormat('d M Y · H:i') }} · {{ $event->location_name }}
                </p>
            </div>
            <a href="{{ route('organizer.events.scan', $event) }}" class="press inline-flex items-center gap-2 bg-coral hover:bg-coral-hover text-white font-semibold px-5 py-2.5 rounded-full text-sm">
                <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                Buka Scanner
            </a>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="glass rounded-2xl p-2 flex items-center gap-1 overflow-x-auto">
        @foreach($filterLabels as $key => $label)
            <a href="{{ route('organizer.events.attendees', ['event' => $event->id, 'status' => $key]) }}"
               class="press flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium whitespace-nowrap transition-colors
                      {{ $filter === $key ? 'bg-coral/15 text-coral border border-coral/30' : 'text-text-muted hover:text-text-primary hover:bg-white/5' }}">
                <span>{{ $label }}</span>
                <span class="font-mono text-[10px] opacity-70">{{ $counts[$key] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('organizer.events.attendees', $event) }}" class="glass rounded-2xl p-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-text-muted ml-2">search</span>
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            placeholder="Cari nama, email, atau nomor WhatsApp…"
            class="flex-1 bg-transparent text-sm text-text-primary placeholder:text-text-dim focus:outline-none px-2 py-1.5">
        @if($filter !== 'all')
            <input type="hidden" name="status" value="{{ $filter }}">
        @endif
        <button type="submit" class="press bg-coral/10 text-coral hover:bg-coral/20 px-4 py-1.5 rounded-lg text-xs font-semibold">
            Cari
        </button>
        @if($search !== '')
            <a href="{{ route('organizer.events.attendees', ['event' => $event->id, 'status' => $filter]) }}" class="text-text-muted hover:text-coral px-2 text-xs">
                Reset
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="glass-strong rounded-3xl overflow-hidden">
        @if($attendees->isEmpty())
            <div class="p-12 text-center space-y-3">
                <span class="material-symbols-outlined text-5xl text-text-dim">person_off</span>
                <h3 class="text-base font-semibold text-text-primary">Tidak ada peserta</h3>
                <p class="text-xs text-text-muted max-w-sm mx-auto">
                    @if($search !== '')
                        Tidak ada peserta yang cocok dengan pencarian "{{ $search }}".
                    @elseif($filter !== 'all')
                        Tidak ada peserta dengan status "{{ $filterLabels[$filter] }}".
                    @else
                        Belum ada peserta yang terdaftar untuk event ini.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-canvas/40 border-b border-white/5">
                        <tr>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold tracking-widest uppercase text-text-muted">Peserta</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold tracking-widest uppercase text-text-muted hidden md:table-cell">Kontak</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold tracking-widest uppercase text-text-muted">Status</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold tracking-widest uppercase text-text-muted hidden lg:table-cell">Check-in</th>
                            <th class="text-right px-5 py-3 text-[10px] font-semibold tracking-widest uppercase text-text-muted">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($attendees as $attendee)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-coral/30 to-mint/30 flex items-center justify-center font-mono text-[11px] font-bold text-text-primary flex-shrink-0">
                                            {{ strtoupper(substr($attendee->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-text-primary truncate">{{ $attendee->name }}</p>
                                            <p class="text-[10px] text-text-dim font-mono truncate">#{{ substr($attendee->id, 0, 8) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 hidden md:table-cell">
                                    <p class="text-xs text-text-primary truncate">{{ $attendee->email }}</p>
                                    @if($attendee->phone_number)
                                        <p class="text-[10px] text-text-muted font-mono">{{ $attendee->phone_number }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="glass-pill text-[10px] font-semibold tracking-wide uppercase px-2.5 py-1 inline-flex items-center gap-1
                                        {{ $attendee->status === 'registered' ? 'text-text-primary' : '' }}
                                        {{ $attendee->status === 'checked_in' ? 'text-mint bg-mint/10 border-mint/30' : '' }}
                                        {{ $attendee->status === 'pending_payment' ? 'text-coral bg-coral/10 border-coral/30' : '' }}
                                        {{ $attendee->status === 'cancelled' ? 'text-text-dim' : '' }}">
                                        @if($attendee->status === 'checked_in')
                                            <span class="material-symbols-outlined text-[12px]">verified</span>
                                        @elseif($attendee->status === 'pending_payment')
                                            <span class="material-symbols-outlined text-[12px]">hourglass_empty</span>
                                        @endif
                                        {{ $attendee->statusLabel() }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 hidden lg:table-cell">
                                    @if($attendee->checked_in_at)
                                        <p class="text-xs text-text-primary font-mono">{{ $attendee->checked_in_at->translatedFormat('d M · H:i') }}</p>
                                    @else
                                        <p class="text-xs text-text-dim">—</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    @if($attendee->status === 'registered')
                                        <form method="POST" action="{{ route('organizer.events.attendees.checkin', ['event' => $event->id, 'attendee' => $attendee->id]) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="press inline-flex items-center gap-1 text-[11px] text-mint hover:text-mint/80 font-medium px-2.5 py-1 rounded-lg hover:bg-mint/10">
                                                <span class="material-symbols-outlined text-[14px]">check</span>
                                                Check-in
                                            </button>
                                        </form>
                                    @elseif($attendee->status === 'checked_in')
                                        <span class="text-[10px] text-text-dim font-mono">✓ Selesai</span>
                                    @else
                                        <span class="text-[10px] text-text-dim">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-3 border-t border-white/5 flex items-center justify-between text-[11px] text-text-muted">
                <span>Menampilkan <span class="text-text-primary font-mono">{{ $attendees->count() }}</span> peserta</span>
                <span class="font-mono">Halaman 1 dari 1</span>
            </div>
        @endif
    </div>

</div>
@endsection
