@extends('layouts.glass')

@section('title', 'Tiket Aktif — ' . $event->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

    {{-- Success Hero --}}
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-mint/10 border border-mint/30 mb-5">
            <span class="material-symbols-outlined text-mint text-4xl">check_circle</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-display font-semibold tracking-tight mb-3">
            Tiket Anda siap!
        </h1>
        <p class="text-white/60 max-w-md mx-auto">
            @if($attendee->status === 'pending_payment')
                Pendaftaran berhasil. Mohon tunggu konfirmasi pembayaran dari organizer.
            @else
                Tunjukkan QR code di bawah ini saat check-in di lokasi event.
            @endif
        </p>
    </div>

    {{-- Ticket Card --}}
    <div class="glass-strong rounded-3xl overflow-hidden">

        {{-- Status Banner --}}
        <div class="px-6 py-3 {{ $attendee->status === 'pending_payment' ? 'bg-coral/10 border-b border-coral/20' : 'bg-mint/10 border-b border-mint/20' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base {{ $attendee->status === 'pending_payment' ? 'text-coral' : 'text-mint' }}">
                        {{ $attendee->status === 'pending_payment' ? 'hourglass_empty' : 'verified' }}
                    </span>
                    <span class="text-xs font-semibold tracking-wide uppercase {{ $attendee->status === 'pending_payment' ? 'text-coral' : 'text-mint' }}">
                        {{ $attendee->status === 'pending_payment' ? 'Menunggu Pembayaran' : 'Tiket Aktif' }}
                    </span>
                </div>
                <span class="text-[10px] font-mono text-white/40">#{{ substr($attendee->id, 0, 8) }}</span>
            </div>
        </div>

        {{-- Event Title --}}
        <div class="px-6 sm:px-8 pt-6 pb-2">
            <span class="text-[10px] font-semibold tracking-widest uppercase text-coral">
                {{ $event->category ?? 'Event' }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-display font-semibold tracking-tight mt-1 leading-tight">
                {{ $event->title }}
            </h2>
        </div>

        {{-- QR Code --}}
        <div class="px-6 sm:px-8 py-6 flex flex-col items-center">
            <div class="bg-white p-4 rounded-2xl shadow-2xl">
                {!! QrCode::size(220)->color(12, 14, 19)->backgroundColor(255, 255, 255)->margin(1)->generate($attendee->qr_code_token) !!}
            </div>
            <p class="mt-3 text-[10px] font-mono text-white/40 break-all max-w-xs text-center">
                {{ $attendee->qr_code_token }}
            </p>
        </div>

        {{-- Event Details Grid --}}
        <div class="px-6 sm:px-8 py-4 grid grid-cols-2 gap-4 border-t border-white/5">
            <div>
                <p class="text-[10px] font-semibold tracking-widest uppercase text-white/40 mb-1">Tanggal</p>
                <p class="text-sm font-medium">{{ $event->date_time->translatedFormat('d M Y') }}</p>
                <p class="text-xs text-white/60">{{ $event->date_time->translatedFormat('H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-[10px] font-semibold tracking-widest uppercase text-white/40 mb-1">Lokasi</p>
                <p class="text-sm font-medium leading-snug">{{ $event->location_name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-semibold tracking-widest uppercase text-white/40 mb-1">Pemegang Tiket</p>
                <p class="text-sm font-medium">{{ $attendee->name }}</p>
                <p class="text-xs text-white/60 font-mono">{{ $attendee->phone_number }}</p>
            </div>
            <div>
                <p class="text-[10px] font-semibold tracking-widest uppercase text-white/40 mb-1">Harga</p>
                @if($event->price > 0)
                    <p class="text-sm font-medium">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                    <p class="text-xs {{ $attendee->status === 'pending_payment' ? 'text-coral' : 'text-mint' }}">
                        {{ $attendee->status === 'pending_payment' ? 'Belum dibayar' : 'Lunas' }}
                    </p>
                @else
                    <p class="text-sm font-medium text-mint">Gratis</p>
                    <p class="text-xs text-white/60">Tanpa biaya</p>
                @endif
            </div>
        </div>

        {{-- Pending Payment Info --}}
        @if($attendee->status === 'pending_payment')
            <div class="px-6 sm:px-8 py-4 border-t border-white/5 bg-coral/5">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-coral text-lg mt-0.5">info</span>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-white/80 mb-1">Instruksi Pembayaran</p>
                        <p class="text-xs text-white/60 leading-relaxed">
                            Transfer tepat <span class="font-semibold text-white">Rp {{ number_format($event->price, 0, ',', '.') }}</span> ke:
                        </p>
                        <p class="text-sm font-mono text-coral mt-1">{{ $event->bank_account }}</p>
                        <p class="text-[11px] text-white/50 mt-2">
                            Lalu upload bukti transfer via WhatsApp organizer:
                            <a href="https://wa.me/{{ $event->whatsapp_number }}" class="text-mint hover:underline">{{ $event->whatsapp_number }}</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3 mt-8">
        <a href="{{ route('my-tickets') }}" class="flex-1 glass-pill py-3 px-5 text-sm font-medium text-center hover:bg-white/10 transition flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-base">confirmation_number</span>
            Lihat Tiket Saya
        </a>
        <a href="{{ route('welcome') }}" class="flex-1 bg-white/5 border border-white/10 rounded-full py-3 px-5 text-sm font-medium text-center hover:bg-white/10 transition flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-base">explore</span>
            Cari Event Lain
        </a>
    </div>

</div>
@endsection
