<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} — TiketKita.com</title>
    
    <!-- Apple Typography System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Text"', '"SF Pro Display"', '"Inter"', 'sans-serif'],
                        display: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"Inter"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        canvas: '#07090E',
                        surface: '#0E131F',
                        brand: '#FF4757',
                        neonGreen: '#05C46B',
                        slateBorder: '#1A2333',
                        textMuted: '#6B7C93'
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            background-color: #07090E; 
            color: #F1F5F9; 
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", "Inter", sans-serif; 
            letter-spacing: -0.015em;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, .font-display, button, .btn {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Inter", sans-serif;
            letter-spacing: -0.02em;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-brand selection:text-white">

    <!-- Top Navigation -->
    <header class="w-full border-b border-slateBorder/50 py-4 px-6 md:px-12 flex justify-between items-center bg-canvas/90 backdrop-blur-md sticky top-0 z-50">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-brand text-canvas rounded-xl flex items-center justify-center font-black font-display text-xl">L</div>
            <span class="font-extrabold tracking-tight text-xl font-display text-white">TiketKita<span class="text-brand">.com</span></span>
        </a>

        <a href="/" class="text-xs font-display font-semibold text-textMuted hover:text-white transition-colors">
            ← Kembali ke Katalog
        </a>
    </header>

    @php
        $banner = $event->banner_path ?? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80';
        $customServices = is_array($event->custom_services) ? $event->custom_services : [];
    @endphp

    <main class="max-w-7xl mx-auto px-6 py-8 w-full space-y-8">
        
        <!-- Event Header Banner -->
        <div class="relative rounded-3xl overflow-hidden h-[320px] md:h-[420px] border border-slateBorder">
            <img src="{{ $banner }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-canvas via-canvas/40 to-transparent flex flex-col justify-end p-8 md:p-12 space-y-2">
                <span class="bg-brand text-white text-[10px] font-display font-extrabold px-3 py-1 rounded-lg w-fit uppercase tracking-wider">
                    {{ $event->category ?? 'Event' }}
                </span>
                <h1 class="text-3xl md:text-5xl font-black font-display text-white leading-tight tracking-tight">
                    {{ $event->title }}
                </h1>
                <p class="text-sm font-sans text-textMuted">
                    Dioperasikan oleh: <strong class="text-white font-display">{{ $event->user->name }}</strong>
                </p>
            </div>
        </div>

        <!-- Detail Grid (Kiri: Deskripsi & Lokasi, Kanan: Pilihan Kategori Tiket Ala Loket) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Info (7 Cols) -->
            <div class="lg:col-span-7 space-y-8">
                
                <!-- Event Meta Card -->
                <div class="bg-surface p-6 rounded-2xl border border-slateBorder grid grid-cols-2 gap-4 text-xs font-sans">
                    <div class="space-y-1">
                        <span class="text-textMuted font-display font-semibold uppercase tracking-wider text-[10px]">📅 TANGGAL & WAKTU</span>
                        <p class="text-sm font-bold font-display text-white">{{ $event->date_time->format('d M Y') }}</p>
                        <p class="text-xs text-brand font-bold font-display">{{ $event->date_time->format('H:i') }} WIB</p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-textMuted font-display font-semibold uppercase tracking-wider text-[10px]">📍 LOKASI EVENT</span>
                        <p class="text-sm font-bold font-display text-white">{{ $event->location_name }}</p>
                    </div>
                </div>

                <!-- Deskripsi Event -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold font-display text-white border-b border-slateBorder pb-2">Deskripsi Event</h3>
                    <p class="text-sm text-textMuted leading-relaxed whitespace-pre-line font-sans">
                        {{ $event->description }}
                    </p>
                </div>

            </div>

            <!-- Right Ticket Options (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-surface p-6 rounded-3xl border border-slateBorder space-y-6 sticky top-24">
                    <div class="border-b border-slateBorder pb-4">
                        <h3 class="text-lg font-bold font-display text-white">Kategori Tiket Tersedia</h3>
                        <p class="text-xs text-textMuted font-sans">Pilih kategori tiket yang ingin kamu pesan</p>
                    </div>

                    <!-- Loop Pilihan Kategori Tiket (VIP/Regular) -->
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-canvas border border-slateBorder space-y-3">
                            <div class="flex justify-between items-center">
                                <h4 class="font-bold text-white text-sm font-display">TIKET REGULAR</h4>
                                <span class="text-base font-black font-display text-neonGreen tracking-tight">
                                    Rp {{ number_format($event->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-xs text-textMuted font-sans">Sisa Kuota: {{ $event->quota }} Tiket</p>
                        </div>
                    </div>

                    @if(!empty($customServices))
                    <div class="border-t border-slateBorder pt-4 pb-2 mt-4">
                        <h3 class="text-sm font-bold font-display text-white mb-3">Layanan Tambahan (Add-ons)</h3>
                        <div class="space-y-3">
                            @foreach($customServices as $service)
                            <div class="p-3 rounded-xl bg-canvas/50 border border-slateBorder flex justify-between items-center">
                                <span class="text-xs text-white">{{ $service['name'] ?? 'Layanan Tambahan' }}</span>
                                <span class="text-xs font-bold text-brand">+ Rp {{ number_format($service['price'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Pembayaran & Kontak -->
                    <div class="border-t border-slateBorder pt-4 mt-4 space-y-4">
                        <div class="bg-canvas p-4 rounded-xl border border-slateBorder space-y-2">
                            <p class="text-[10px] text-textMuted uppercase font-bold tracking-wider">Tujuan Transfer Pembayaran:</p>
                            <p class="text-sm text-white font-mono">{{ $event->bank_account ?? 'Silakan hubungi panitia' }}</p>
                        </div>
                        
                        <a href="https://wa.me/{{ $event->whatsapp_number ?? '6282114073679' }}?text=Halo%20panitia%20event%20{{ urlencode($event->title) }},%20saya%20ingin%20membeli%20tiket..." target="_blank" class="block text-center w-full bg-brand hover:bg-red-500 text-white font-bold text-xs py-3 rounded-xl transition-all font-display hover:-translate-y-0.5 shadow-md shadow-brand/10">
                            Konfirmasi Pembayaran via WA 📲
                        </a>
                        <p class="text-[10px] text-textMuted text-center font-sans">Kamu akan diarahkan ke WhatsApp untuk verifikasi tiket.</p>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slateBorder/60 py-6 px-6 md:px-12 flex justify-between items-center text-xs font-sans text-textMuted bg-canvas/90">
        <p>© 2026 TiketKita.com — Detail Pemesanan Tiket.</p>
    </footer>

</body>
</html>
