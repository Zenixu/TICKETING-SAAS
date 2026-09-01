@extends('layouts.glass')

@section('title', 'Scanner — ' . $event->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-6">

    {{-- Back link --}}
    <a href="{{ route('organizer.events.attendees', $event) }}" class="inline-flex items-center gap-1.5 text-xs text-text-muted hover:text-coral transition-colors">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Kembali ke Daftar Peserta
    </a>

    {{-- Header --}}
    <div class="space-y-2">
        <span class="glass-pill text-mint text-[10px] font-mono tracking-wider uppercase px-3 py-1 inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[12px]">qr_code_scanner</span>
            Check-in Scanner
        </span>
        <h1 class="text-2xl sm:text-3xl font-display font-bold tracking-[-0.02em]">{{ $event->title }}</h1>
        <p class="text-xs text-text-muted font-mono">
            {{ $event->date_time->translatedFormat('d M Y · H:i') }} · {{ $event->location_name }}
        </p>
    </div>

    {{-- Live Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="glass rounded-2xl p-4 space-y-1">
            <p class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">Total</p>
            <p class="text-2xl font-display font-bold text-text-primary num">{{ $stats['total'] }}</p>
            <p class="text-[10px] text-text-dim font-mono">dari {{ $stats['quota'] }} kuota</p>
        </div>
        <div class="glass rounded-2xl p-4 space-y-1 border-mint/30 bg-mint/5">
            <p class="text-[10px] font-semibold tracking-widest uppercase text-mint">Check-in</p>
            <p class="text-2xl font-display font-bold text-mint num">{{ $stats['checked_in'] }}</p>
            <p class="text-[10px] text-mint/70 font-mono">{{ $stats['registered'] > 0 ? round(($stats['checked_in'] / max($stats['registered'] + $stats['checked_in'], 1)) * 100) : 0 }}% confirmed</p>
        </div>
        <div class="glass rounded-2xl p-4 space-y-1">
            <p class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">Teregistrasi</p>
            <p class="text-2xl font-display font-bold text-text-primary num">{{ $stats['registered'] }}</p>
            <p class="text-[10px] text-text-dim font-mono">siap check-in</p>
        </div>
        <div class="glass rounded-2xl p-4 space-y-1">
            <p class="text-[10px] font-semibold tracking-widest uppercase text-coral">Pending Bayar</p>
            <p class="text-2xl font-display font-bold text-coral num">{{ $stats['pending'] }}</p>
            <p class="text-[10px] text-coral/70 font-mono">blocked</p>
        </div>
    </div>

    {{-- Flash Message (last scan result) --}}
    @if(session('success'))
        <div class="glass-strong rounded-2xl p-5 border-mint/30 bg-mint/5 flex items-start gap-4 animate-[fadeIn_0.3s_ease-out]">
            <span class="material-symbols-outlined text-mint text-3xl">check_circle</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-mint uppercase tracking-wide">Check-in Berhasil</p>
                <p class="text-base text-text-primary mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @elseif(session('warning'))
        <div class="glass-strong rounded-2xl p-5 border-coral/30 bg-coral/5 flex items-start gap-4 animate-[fadeIn_0.3s_ease-out]">
            <span class="material-symbols-outlined text-coral text-3xl">warning</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-coral uppercase tracking-wide">Sudah Check-in</p>
                <p class="text-base text-text-primary mt-1">{{ session('warning') }}</p>
            </div>
        </div>
    @elseif(session('error'))
        <div class="glass-strong rounded-2xl p-5 border-coral/30 bg-coral/5 flex items-start gap-4 animate-[fadeIn_0.3s_ease-out]">
            <span class="material-symbols-outlined text-coral text-3xl">error</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-coral uppercase tracking-wide">Gagal</p>
                <p class="text-base text-text-primary mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Scanner Input --}}
    <form method="POST" action="{{ route('organizer.events.scan.process', $event) }}" class="glass-strong rounded-3xl p-6 sm:p-8 space-y-4">
        @csrf
        <div class="space-y-2">
            <label class="text-[10px] font-semibold tracking-widest uppercase text-text-muted flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">qr_code_2</span>
                QR Code Token
            </label>
            <input
                type="text"
                name="qr_code_token"
                id="qr-input"
                required
                autofocus
                autocomplete="off"
                spellcheck="false"
                class="w-full bg-canvas/60 border border-white/10 focus:border-coral rounded-2xl px-5 py-4 text-lg font-mono text-text-primary placeholder:text-text-dim focus:outline-none focus:ring-2 focus:ring-coral/30 transition-colors"
                placeholder="Tempel atau ketik token QR di sini…">
            <p class="text-[10px] text-text-dim font-mono">Tekan Enter atau klik tombol di bawah untuk proses check-in.</p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="press flex-1 bg-coral hover:bg-coral-hover text-white font-semibold py-3.5 rounded-full text-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                Proses Check-in
            </button>
            <a href="{{ route('organizer.events.attendees', $event) }}" class="press bg-white/5 hover:bg-white/10 text-text-primary font-medium px-5 py-3.5 rounded-full text-sm">
                Lihat Daftar
            </a>
        </div>
    </form>

    {{-- History (5 scan terakhir) --}}
    @if(count($history) > 0)
        <div class="glass rounded-2xl p-5 space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-semibold tracking-widest uppercase text-text-muted flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">history</span>
                    Riwayat Scan
                </h3>
                <span class="text-[10px] text-text-dim font-mono">{{ count($history) }} terakhir</span>
            </div>
            <div class="space-y-2">
                @foreach($history as $h)
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-canvas/40 border border-white/5">
                        <span class="material-symbols-outlined text-[18px] flex-shrink-0 mt-0.5
                            {{ $h['type'] === 'success' ? 'text-mint' : 'text-coral' }}">
                            {{ $h['type'] === 'success' ? 'check_circle' : ($h['type'] === 'duplicate' ? 'check_circle' : 'error') }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-text-primary">{{ $h['message'] }}</p>
                            <p class="text-[10px] text-text-dim font-mono mt-0.5">
                                {{ $h['time'] }} · token <span class="text-text-muted">{{ $h['token'] }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
