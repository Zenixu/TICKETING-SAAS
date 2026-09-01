@extends('layouts.glass')

@section('title', $event->title . ' — TiketKita.com')

@section('content')
@php
    $banner = $event->banner_path ?? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80';
    $customServices = is_array($event->custom_services) ? $event->custom_services : [];
    $isFree = $event->price <= 0;
    $isPast = $event->date_time->isPast();
    $currentAttendees = $event->attendees()->whereIn('status', ['registered', 'checked_in', 'pending_payment'])->count();
    $isFull = $currentAttendees >= $event->quota;
    $alreadyRegistered = auth()->check() && $event->attendees()
        ->where('user_id', auth()->id())
        ->whereIn('status', ['registered', 'checked_in', 'pending_payment'])
        ->exists();
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 w-full space-y-6 sm:space-y-8">    {{-- Back Link --}}
    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-1.5 text-xs text-text-muted hover:text-coral transition-colors">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Kembali ke Katalog
    </a>

    {{-- Hero Banner --}}
    <div class="relative rounded-3xl overflow-hidden h-[280px] sm:h-[360px] md:h-[420px] border border-white/10">
        <img src="{{ $banner }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-canvas via-canvas/40 to-transparent flex flex-col justify-end p-6 sm:p-10 space-y-2">
            <span class="glass-pill text-coral text-[10px] font-mono tracking-wider uppercase px-3 py-1 inline-flex items-center gap-1.5 w-fit">
                {{ $event->category ?? 'Event' }}
            </span>
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-display font-extrabold text-text-primary leading-[1.05] tracking-[-0.03em] max-w-3xl">
                {{ $event->title }}
            </h1>
            <p class="text-xs sm:text-sm text-text-muted">
                Diselenggarakan oleh <strong class="text-text-primary">{{ $event->user->name ?? '—' }}</strong>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">

        {{-- LEFT: Description & Location --}}
        <div class="lg:col-span-7 space-y-6">

            {{-- Event Meta --}}
            <div class="glass rounded-2xl p-5 sm:p-6 grid grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-1">
                    <p class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">📅 Tanggal & Waktu</p>
                    <p class="text-sm font-semibold text-text-primary">{{ $event->date_time->translatedFormat('d M Y') }}</p>
                    <p class="text-xs text-coral font-mono">{{ $event->date_time->translatedFormat('H:i') }} WIB</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">📍 Lokasi</p>
                    <p class="text-sm font-semibold text-text-primary leading-snug">{{ $event->location_name }}</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="glass rounded-2xl p-5 sm:p-6 space-y-3">
                <h3 class="text-base font-semibold text-text-primary border-b border-white/5 pb-2">Deskripsi Event</h3>
                <p class="text-sm text-text-muted leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </p>
            </div>

            {{-- Add-ons --}}
            @if(!empty($customServices))
                <div class="glass rounded-2xl p-5 sm:p-6 space-y-3">
                    <h3 class="text-base font-semibold text-text-primary border-b border-white/5 pb-2">Layanan Tambahan</h3>
                    <div class="space-y-2.5">
                        @foreach($customServices as $service)
                            <div class="flex justify-between items-center p-3 rounded-xl bg-canvas/40 border border-white/5">
                                <span class="text-xs text-text-primary">{{ $service['name'] ?? 'Layanan' }}</span>
                                <span class="text-xs font-bold text-coral font-mono num">+ Rp {{ number_format($service['price'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT: Ticket Form (sticky) --}}
        <div class="lg:col-span-5">
            <div class="glass-strong rounded-3xl p-5 sm:p-6 space-y-5 lg:sticky lg:top-24">

                <div class="border-b border-white/5 pb-3">
                    <h3 class="text-base font-semibold text-text-primary">Daftar Tiket</h3>
                    <p class="text-xs text-text-muted mt-0.5">Isi data di bawah untuk mendapatkan QR tiket.</p>
                </div>

                {{-- Ticket Info --}}
                <div class="p-4 rounded-2xl bg-canvas/40 border border-white/5 space-y-2">
                    <div class="flex justify-between items-center">
                        <h4 class="font-semibold text-text-primary text-sm">Tiket Regular</h4>
                        <span class="text-base font-bold {{ $isFree ? 'text-mint' : 'text-coral' }} font-mono num">
                            {{ $isFree ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="text-[11px] text-text-muted font-mono">
                        Sisa Kuota: <span class="text-text-primary">{{ max(0, $event->quota - $currentAttendees) }}</span> / {{ $event->quota }}
                    </p>
                </div>

                {{-- Conditional: Sudah lewat --}}
                @if($isPast)
                    <div class="p-4 rounded-2xl bg-coral/10 border border-coral/30 text-center">
                        <span class="material-symbols-outlined text-coral text-3xl mb-1">event_busy</span>
                        <p class="text-sm font-semibold text-coral">Event Sudah Lewat</p>
                        <p class="text-[11px] text-text-muted mt-1">Pendaftaran sudah ditutup.</p>
                    </div>

                {{-- Conditional: Sudah terdaftar --}}
                @elseif($alreadyRegistered)
                    <div class="p-4 rounded-2xl bg-mint/10 border border-mint/30 text-center">
                        <span class="material-symbols-outlined text-mint text-3xl mb-1">check_circle</span>
                        <p class="text-sm font-semibold text-mint">Anda Sudah Terdaftar</p>
                        <p class="text-[11px] text-text-muted mt-1">Lihat tiket Anda di halaman Tiket Saya.</p>
                        <a href="{{ route('my-tickets') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs text-mint hover:underline font-medium">
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            Lihat Tiket Saya
                        </a>
                    </div>

                {{-- Conditional: Kuota penuh --}}
                @elseif($isFull)
                    <div class="p-4 rounded-2xl bg-coral/10 border border-coral/30 text-center">
                        <span class="material-symbols-outlined text-coral text-3xl mb-1">group_off</span>
                        <p class="text-sm font-semibold text-coral">Kuota Penuh</p>
                        <p class="text-[11px] text-text-muted mt-1">Cari event menarik lainnya di katalog.</p>
                        <a href="{{ route('welcome') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs text-mint hover:underline font-medium">
                            <span class="material-symbols-outlined text-[14px]">explore</span>
                            Cari Event Lain
                        </a>
                    </div>

                {{-- Conditional: Belum login --}}
                @elseif(!auth()->check())
                    <div class="space-y-3">
                        <div class="p-4 rounded-2xl bg-mint/5 border border-mint/20 text-center">
                            <span class="material-symbols-outlined text-mint text-2xl mb-1">login</span>
                            <p class="text-sm font-semibold text-text-primary">Login untuk Mendaftar</p>
                            <p class="text-[11px] text-text-muted mt-1">Anda butuh akun untuk menyimpan tiket.</p>
                        </div>
                        <a href="{{ route('login') }}" class="press block text-center w-full bg-coral hover:bg-coral-hover text-white font-semibold py-3 rounded-full text-sm">
                            Masuk / Daftar
                        </a>
                    </div>

                {{-- FORM AKTIF --}}
                @else
                    <form method="POST" action="{{ route('events.register', $event) }}" class="space-y-4">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                required
                                maxlength="100"
                                class="field w-full rounded-xl px-3.5 py-2.5 text-sm"
                                placeholder="Sesuai KTP/identitas">
                            @error('name') <p class="text-[10px] text-coral mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                required
                                class="field w-full rounded-xl px-3.5 py-2.5 text-sm"
                                placeholder="email@domain.com">
                            @error('email') <p class="text-[10px] text-coral mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">No. WhatsApp</label>
                            <input
                                type="tel"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                required
                                minlength="10"
                                maxlength="20"
                                class="field w-full rounded-xl px-3.5 py-2.5 text-sm font-mono"
                                placeholder="081234567890">
                            @error('phone_number') <p class="text-[10px] text-coral mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if(!$isFree && $event->bank_account)
                            <div class="p-3 rounded-xl bg-canvas/40 border border-white/5 space-y-1.5">
                                <p class="text-[10px] font-semibold tracking-widest uppercase text-text-muted">Tujuan Transfer</p>
                                <p class="text-xs text-text-primary font-mono break-words">{{ $event->bank_account }}</p>
                                <p class="text-[10px] text-text-muted mt-1">
                                    Setelah submit, upload bukti transfer via WA:
                                    <a href="https://wa.me/{{ $event->whatsapp_number }}" class="text-mint hover:underline">{{ $event->whatsapp_number }}</a>
                                </p>
                            </div>
                        @endif

                        <button type="submit" class="press w-full bg-coral hover:bg-coral-hover text-white font-semibold py-3 rounded-full text-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">confirmation_number</span>
                            {{ $isFree ? 'Klaim Tiket Gratis' : 'Daftar & Bayar' }}
                        </button>

                        <p class="text-[10px] text-text-dim text-center font-mono">
                            Dengan mendaftar, Anda menyetujui S&K TiketKita
                        </p>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
