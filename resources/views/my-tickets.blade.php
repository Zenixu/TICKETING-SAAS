@extends('layouts.glass')

@section('title', 'Tiket Saya — TiketKita')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    {{-- Header --}}
    <div class="mb-8 sm:mb-10">
        <span class="glass-pill text-coral text-[10px] font-mono tracking-wider uppercase px-3 py-1 inline-flex items-center gap-1.5 mb-3">
            <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
            Tiket Saya
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-display font-bold tracking-[-0.03em]">
            {{ $attendees->count() }} Tiket
        </h1>
        <p class="text-sm text-text-muted mt-2">
            @if($attendees->count() === 0)
                Kamu belum punya tiket. Yuk jelajahi event menarik di katalog.
            @else
                Tunjukkan QR code di bawah ini saat check-in di lokasi event.
            @endif
        </p>
    </div>

    @if($attendees->count() === 0)
        {{-- Empty State --}}
        <div class="glass-strong rounded-3xl p-10 sm:p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-text-dim mb-4">confirmation_number</span>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Belum ada tiket</h3>
            <p class="text-sm text-text-muted mb-6 max-w-md mx-auto">Mulai cari event seru — dari gig musik intim hingga festival cosplay nasional.</p>
            <a href="{{ route('welcome') }}" class="press inline-flex items-center gap-2 bg-coral hover:bg-coral-hover text-white font-semibold px-6 py-3 rounded-full text-sm">
                <span class="material-symbols-outlined text-[18px]">explore</span>
                Jelajahi Katalog
            </a>
        </div>
    @else
        {{-- Tickets Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
            @foreach($attendees as $attendee)
                @php
                    $event = $attendee->event;
                    $isPending = $attendee->status === 'pending_payment';
                    $isVerifying = $attendee->status === 'pending_verification';
                    $isCheckedIn = $attendee->status === 'checked_in';
                @endphp
                <div class="glass-strong rounded-3xl overflow-hidden hover:border-coral/30 transition-colors group">
                    <a href="{{ route('events.success', ['event' => $event->id, 'attendee' => $attendee->id]) }}" class="block">

                    {{-- Status Banner --}}
                    <div class="px-5 py-2.5 {{ $isPending || $isVerifying ? 'bg-coral/10 border-b border-coral/20' : ($isCheckedIn ? 'bg-mint/10 border-b border-mint/20' : 'bg-white/5 border-b border-white/5') }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px] {{ $isPending ? 'text-coral' : ($isCheckedIn ? 'text-mint' : 'text-text-primary') }}">
                                    {{ $isPending ? 'hourglass_empty' : ($isVerifying ? 'pending_actions' : ($isCheckedIn ? 'verified' : 'check_circle')) }}
                                </span>
                                <span class="text-[10px] font-semibold tracking-wide uppercase {{ $isPending || $isVerifying ? 'text-coral' : ($isCheckedIn ? 'text-mint' : 'text-text-primary') }}">
                                    {{ $isPending ? 'Menunggu Pembayaran' : ($isVerifying ? 'Verifikasi Bukti' : ($isCheckedIn ? 'Sudah Check-in' : 'Tiket Aktif')) }}
                                </span>
                            </div>
                            <span class="text-[10px] font-mono text-text-dim">#{{ substr($attendee->id, 0, 8) }}</span>
                        </div>
                    </div>

                    {{-- Event Cover --}}
                    <div class="relative h-36 overflow-hidden">
                        <img src="{{ $event->banner_path ?? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-canvas to-transparent"></div>
                        <span class="absolute top-3 left-3 glass-pill text-coral text-[9px] font-mono tracking-wider uppercase px-2.5 py-1">
                            {{ $event->category ?? 'Event' }}
                        </span>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 space-y-3">
                        <h3 class="text-base font-semibold text-text-primary leading-snug line-clamp-2 group-hover:text-coral transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="grid grid-cols-2 gap-3 text-[11px]">
                            <div>
                                <p class="text-text-dim font-mono uppercase tracking-wider text-[9px] mb-0.5">Tanggal</p>
                                <p class="text-text-primary font-medium">{{ $event->date_time->translatedFormat('d M Y · H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-text-dim font-mono uppercase tracking-wider text-[9px] mb-0.5">Lokasi</p>
                                <p class="text-text-primary font-medium truncate">{{ $event->location_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-white/5">
                            <span class="text-[10px] text-text-muted font-mono">{{ $isPending ? 'Belum upload bukti' : 'QR tersedia' }}</span>
                            <span class="text-[11px] text-coral font-medium inline-flex items-center gap-1">
                                Lihat QR
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </div>
                    </a>

                    {{-- Action Button (for unpaid/verifying) --}}
                    @if($isPending || $isVerifying)
                    <div class="px-5 pb-5 -mt-2">
                        <a href="{{ route('payment.submit-form', $attendee->id) }}" class="press bg-coral text-white font-semibold px-4 py-2.5 text-xs rounded-full transition-colors hover:bg-coral/90 inline-flex items-center justify-center gap-2 w-full">
                            <span class="material-symbols-outlined text-[16px]">upload_file</span>
                            {{ $isPending ? 'Upload Bukti Bayar' : 'Upload Ulang Bukti' }}
                        </a>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
