@extends('layouts.glass')

@section('title', 'Verifikasi Pembayaran — ' . $event->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">

    {{-- Back link --}}
    <div>
        <a href="{{ route('dashboard') }}" class="press text-xs text-text-muted hover:text-text-primary inline-flex items-center gap-1 transition-colors">
            <span class="material-symbols-outlined text-[14px]">arrow_back</span>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Header --}}
    <header class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
        <div>
            <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-coral">Verifikasi Pembayaran</p>
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary tracking-tight mt-1">{{ $event->title }}</h1>
            <p class="text-sm text-text-muted mt-1">Setujui atau tolak bukti pembayaran yang dikirim peserta.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('organizer.events.attendees', $event->id) }}" class="press glass-pill text-mint border-mint/30 hover:bg-mint hover:text-canvas px-4 py-2 text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">group</span>
                Daftar Peserta
            </a>
            <a href="{{ route('organizer.events.scan', $event->id) }}" class="press glass-pill text-coral border-coral/30 hover:bg-coral hover:text-white px-4 py-2 text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">qr_code_scanner</span>
                Scanner
            </a>
        </div>
    </header>

    {{-- Stat Cards --}}
    <section class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="glass rounded-2xl p-4 flex flex-col gap-1.5">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Total</span>
            <span class="text-2xl font-bold text-text-primary num">{{ $counts['all'] }}</span>
        </div>
        <div class="glass rounded-2xl p-4 flex flex-col gap-1.5">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-coral">Verifikasi</span>
            <span class="text-2xl font-bold text-coral num">{{ $counts['pending_verification'] }}</span>
            <span class="text-[10px] font-mono text-text-dim">Perlu tindakan</span>
        </div>
        <div class="glass rounded-2xl p-4 flex flex-col gap-1.5">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-mint">Diterima</span>
            <span class="text-2xl font-bold text-mint num">{{ $counts['registered'] }}</span>
            <span class="text-[10px] font-mono text-text-dim">Siap check-in</span>
        </div>
        <div class="glass rounded-2xl p-4 flex flex-col gap-1.5">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Belum Bayar</span>
            <span class="text-2xl font-bold text-text-muted num">{{ $counts['pending_payment'] }}</span>
            <span class="text-[10px] font-mono text-text-dim">Tanpa bukti</span>
        </div>
    </section>

    {{-- Filter Tabs --}}
    <div class="glass rounded-2xl p-2 inline-flex flex-wrap gap-1">
        <a href="{{ route('organizer.events.payments', $event->id) }}" class="press {{ $filter === 'pending_verification' ? 'bg-coral text-white' : 'text-text-muted hover:text-text-primary' }} px-4 py-2 text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px]">pending_actions</span>
            Menunggu Verifikasi
            @if($counts['pending_verification'] > 0)
                <span class="glass-pill text-[10px] px-1.5 py-0.5 {{ $filter === 'pending_verification' ? 'bg-white/20 text-white' : 'bg-coral/20 text-coral' }}">{{ $counts['pending_verification'] }}</span>
            @endif
        </a>
        <a href="{{ route('organizer.events.payments', ['event' => $event->id, 'status' => 'registered']) }}" class="press {{ $filter === 'registered' ? 'bg-mint text-canvas' : 'text-text-muted hover:text-text-primary' }} px-4 py-2 text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px]">verified</span>
            Diterima
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="glass-strong rounded-2xl p-4 border-mint/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-mint text-[20px]">check_circle</span>
            <p class="text-sm text-text-primary font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('warning'))
        <div class="glass-strong rounded-2xl p-4 border-coral/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-coral text-[20px]">warning</span>
            <p class="text-sm text-text-primary font-medium">{{ session('warning') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="glass-strong rounded-2xl p-4 border-coral/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-coral text-[20px]">error</span>
            <p class="text-sm text-text-primary font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Payment List --}}
    <section class="space-y-3">
        @if($attendees->isEmpty())
            <div class="glass rounded-2xl p-8 sm:p-12 text-center">
                <span class="material-symbols-outlined text-text-dim text-[48px] mx-auto">inbox</span>
                <p class="text-sm text-text-muted mt-3">
                    @if($filter === 'pending_verification')
                        Tidak ada pembayaran yang menunggu verifikasi.
                    @else
                        Belum ada peserta yang diterima.
                    @endif
                </p>
            </div>
        @else
            @foreach($attendees as $att)
                @php
                    $proof = $att->paymentProof;
                @endphp
                <article class="glass rounded-2xl p-5 sm:p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-base font-semibold text-text-primary tracking-tight">{{ $att->name }}</h3>
                                <span class="glass-pill text-[10px] font-mono font-bold uppercase px-2 py-0.5
                                    @if($att->status === 'registered') text-mint border-mint/30
                                    @elseif($att->status === 'pending_verification') text-coral border-coral/30
                                    @else text-text-muted @endif">
                                    {{ $att->statusLabel() }}
                                </span>
                            </div>
                            <p class="text-xs text-text-muted font-mono">{{ $att->email }} · {{ $att->phone_number ?? '—' }}</p>
                            <p class="text-[10px] font-mono text-text-dim mt-1">Daftar: {{ $att->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        @if($att->status === 'pending_verification' && $proof)
                        <div class="flex items-center gap-2 shrink-0">
                            <form method="POST" action="{{ route('organizer.events.payments.reject', ['event' => $event->id, 'attendee' => $att->id]) }}" onsubmit="return confirm('Tolak bukti pembayaran dari {{ $att->name }}?');" class="inline">
                                @csrf
                                <input type="hidden" name="rejection_reason" value="Bukti transfer tidak valid atau tidak sesuai nominal. Silakan upload ulang bukti yang benar.">
                                <button type="submit" class="press glass-pill text-text-muted hover:bg-white/10 hover:text-text-primary px-4 py-2 text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px]">close</span>
                                    Tolak
                                </button>
                            </form>
                            <form method="POST" action="{{ route('organizer.events.payments.verify', ['event' => $event->id, 'attendee' => $att->id]) }}" onsubmit="return confirm('Setujui bukti pembayaran dari {{ $att->name }}?');" class="inline">
                                @csrf
                                <button type="submit" class="press bg-mint text-canvas font-semibold px-4 py-2 text-xs rounded-full transition-colors hover:bg-mint/90 inline-flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px]">check</span>
                                    Setujui
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    @if($proof)
                    <div class="hairline-t pt-4 grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-4">
                        {{-- Bukti Image --}}
                        <div class="space-y-2">
                            @if($proof->imageUrl())
                                <a href="{{ $proof->imageUrl() }}" target="_blank" class="block glass rounded-xl overflow-hidden group">
                                    <img src="{{ $proof->imageUrl() }}" alt="Bukti Transfer" class="w-full h-32 object-cover group-hover:opacity-80 transition-opacity" />
                                </a>
                                <p class="text-[10px] font-mono text-text-dim text-center">Klik untuk memperbesar</p>
                            @else
                                <div class="glass rounded-xl h-32 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-text-dim text-[32px]">broken_image</span>
                                </div>
                            @endif
                        </div>

                        {{-- Detail --}}
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Nominal</p>
                                <p class="text-text-primary font-semibold num">Rp {{ number_format($proof->amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Bank Pengirim</p>
                                <p class="text-text-primary font-semibold">{{ $proof->bank_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Nama Pengirim</p>
                                <p class="text-text-muted">{{ $proof->account_holder_name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Tanggal</p>
                                <p class="text-text-muted num">{{ $proof->transfer_date->format('d M Y') }}</p>
                            </div>
                            @if($proof->notes)
                            <div class="col-span-2">
                                <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Catatan</p>
                                <p class="text-text-muted italic">"{{ $proof->notes }}"</p>
                            </div>
                            @endif
                            @if($proof->isVerified() && $proof->verifier)
                            <div class="col-span-2 hairline-t pt-2 mt-1">
                                <p class="text-[10px] font-mono text-mint">✓ Diverifikasi oleh {{ $proof->verifier->name }} pada {{ $proof->verified_at->format('d M Y, H:i') }}</p>
                            </div>
                            @endif
                            @if($proof->isRejected() && $proof->rejection_reason)
                            <div class="col-span-2 hairline-t pt-2 mt-1">
                                <p class="text-[10px] font-mono text-coral">✗ Ditolak: {{ $proof->rejection_reason }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </article>
            @endforeach
        @endif
    </section>

</div>
@endsection
