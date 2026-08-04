<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoketKita — Panggung Event & Konser Indonesia</title>
    
    <!-- Apple Typography System: SF Pro Display / SF Pro Text & Inter Fallback -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"SF Pro Text"', '"Inter"', 'sans-serif'],
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
            -moz-osx-font-smoothing: grayscale;
            background-image: 
                radial-gradient(circle at 10% 15%, rgba(255, 71, 87, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 90% 85%, rgba(5, 196, 107, 0.04) 0%, transparent 45%);
        }
        h1, h2, h3, h4, .font-display {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Inter", sans-serif;
            letter-spacing: -0.025em;
        }
        .card-glow:hover {
            box-shadow: 0 10px 40px -10px rgba(255, 71, 87, 0.18);
            border-color: rgba(255, 71, 87, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-brand selection:text-white">

    <!-- Top Navigation (Loket.com Style) -->
    <header class="w-full border-b border-slateBorder/50 py-4 px-6 md:px-12 flex justify-between items-center backdrop-blur-md sticky top-0 z-50 bg-canvas/90">
        <a href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-brand text-canvas rounded-xl flex items-center justify-center font-black font-display text-xl group-hover:scale-105 transition-all shadow-lg shadow-brand/20">
                L
            </div>
            <span class="font-extrabold tracking-tight text-xl font-display text-white">LoketKita<span class="text-brand">.com</span></span>
        </a>

        <!-- Search Bar Ala Loket -->
        <div class="hidden lg:flex items-center gap-3 bg-surface border border-slateBorder rounded-xl px-4 py-2 w-96 text-sm text-textMuted focus-within:border-brand/50 transition-all">
            <svg class="w-4 h-4 text-textMuted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari konser, festival, atau workshop..." class="bg-transparent border-none outline-none text-white w-full text-xs font-sans placeholder:text-textMuted">
        </div>

        <div class="flex items-center gap-4">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" class="text-xs font-mono font-bold text-brand bg-brand/10 border border-brand/20 px-4 py-2.5 rounded-xl transition-all hover:bg-brand/20">
                        Admin Console 🛠
                    </a>
                @elseif(Auth::user()->role === 'organizer')
                    <a href="{{ route('dashboard') }}" class="text-xs font-mono font-bold text-white bg-surface hover:bg-slateBorder px-4 py-2.5 rounded-xl border border-slateBorder transition-all">
                        Dashboard Organizer ↗
                    </a>
                @else
                    <form method="POST" action="{{ route('request-organizer') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-mono font-bold text-white bg-surface hover:bg-slateBorder px-4 py-2.5 rounded-xl border border-slateBorder transition-all">
                            Buat Event Kamu 🚀
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-mono font-bold text-textMuted hover:text-brand border border-slateBorder hover:border-brand/40 bg-canvas px-4 py-2.5 rounded-xl transition-all">
                        Keluar 🚪
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-xs font-mono font-bold text-textMuted hover:text-white transition-colors mr-2">Masuk</a>
                <a href="{{ route('register') }}" class="text-xs font-mono font-bold text-canvas bg-white hover:bg-gray-200 px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-white/5">
                    Daftar
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="w-full space-y-12 pb-24">
        
        <!-- 1. HERO BANNER CAROUSEL (Mewah & Menarik) -->
        <section class="max-w-7xl mx-auto px-6 pt-8">
            <div class="relative rounded-3xl overflow-hidden border border-slateBorder group h-[380px] md:h-[480px]">
                <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-canvas via-canvas/60 to-transparent flex flex-col justify-end p-8 md:p-12 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand text-white text-[10px] font-mono font-bold uppercase tracking-wider w-fit">
                        🔥 HOT EVENT WEEKENED
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black font-display text-white max-w-3xl leading-tight">
                        NOAH & SHEILA ON 7: Soundwave Fest 2026 Jakarta
                    </h1>
                    <p class="text-sm md:text-base text-gray-300 max-w-2xl line-clamp-2">
                        Konser megah perayaan musik Indonesia menghadirkan NOAH, Sheila on 7, dan Maliq & D'Essentials dalam satu panggung spektakuler!
                    </p>
                    <div class="flex items-center gap-6 pt-2">
                        <span class="text-xl font-bold font-mono text-neonGreen">Mulai Rp 350.000</span>
                        <a href="/catalog/1" class="bg-brand hover:bg-red-500 text-white font-bold font-display px-6 py-3 rounded-xl shadow-lg shadow-brand/30 transition-all text-sm">
                            Beli Tiket Sekarang 🎟
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. CATEGORY PILLS (Navigasi Kategori Loket) -->
        <section class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none text-xs font-mono">
                <a href="/" class="px-5 py-3 rounded-xl border {{ !$category ? 'bg-brand border-brand text-white font-bold' : 'bg-surface border-slateBorder text-textMuted hover:text-white' }} transition-all whitespace-nowrap">
                    🔥 Semua Event
                </a>
                <a href="/?category=Konser+Musik" class="px-5 py-3 rounded-xl border {{ $category === 'Konser Musik' ? 'bg-brand border-brand text-white font-bold' : 'bg-surface border-slateBorder text-textMuted hover:text-white' }} transition-all whitespace-nowrap">
                    🎵 Konser Musik
                </a>
                <a href="/?category=Konferensi+%26+Seminar" class="px-5 py-3 rounded-xl border {{ $category === 'Konferensi & Seminar' ? 'bg-brand border-brand text-white font-bold' : 'bg-surface border-slateBorder text-textMuted hover:text-white' }} transition-all whitespace-nowrap">
                    💻 Tech & Konferensi
                </a>
                <a href="/?category=Hiburan+%26+Komedi" class="px-5 py-3 rounded-xl border {{ $category === 'Hiburan & Komedi' ? 'bg-brand border-brand text-white font-bold' : 'bg-surface border-slateBorder text-textMuted hover:text-white' }} transition-all whitespace-nowrap">
                    🎭 Standup & Komedi
                </a>
                <a href="/?category=Workshop+%26+Hobi" class="px-5 py-3 rounded-xl border {{ $category === 'Workshop & Hobi' ? 'bg-brand border-brand text-white font-bold' : 'bg-surface border-slateBorder text-textMuted hover:text-white' }} transition-all whitespace-nowrap">
                    🎨 Workshop & Hobi
                </a>
            </div>
        </section>

        <!-- 3. EVENT GRID (Katalog Konser & Event Interaktif) -->
        <section class="max-w-7xl mx-auto px-6 space-y-6">
            <div class="flex justify-between items-end border-b border-slateBorder/60 pb-4">
                <div>
                    <h2 class="text-2xl font-bold font-display text-white">Event Populer Minggu Ini</h2>
                    <p class="text-xs text-textMuted">Temukan konser dan acara favoritmu lalu pesan tiketnya sekarang</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($events as $event)
                    @php
                        $banner = $event->material_links['banner_url'] ?? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80';
                        $catName = $event->material_links['category'] ?? 'Event';
                    @endphp
                    <div class="bg-surface rounded-2xl border border-slateBorder overflow-hidden card-glow transition-all flex flex-col justify-between group">
                        
                        <!-- Event Banner Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $banner }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <span class="absolute top-3 left-3 bg-canvas/80 backdrop-blur-md text-white text-[10px] font-mono px-2.5 py-1 rounded-lg border border-white/10 font-bold">
                                {{ strtoupper($catName) }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-4 flex-grow flex flex-col justify-between">
                            <div class="space-y-2">
                                <p class="text-[11px] font-mono text-brand font-bold">
                                    📅 {{ $event->date_time->format('d M Y') }} • {{ $event->date_time->format('H:i') }} WIB
                                </p>
                                <h3 class="text-base font-bold text-white font-display line-clamp-2 leading-snug group-hover:text-brand transition-colors">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-xs text-textMuted line-clamp-1">📍 {{ $event->location_name }}</p>
                            </div>

                            <div class="pt-4 border-t border-slateBorder/60 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-mono text-textMuted">Mulai dari</p>
                                    <p class="text-sm font-extrabold font-mono text-neonGreen">
                                        Rp {{ number_format($event->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('events.public-show', $event->id) }}" class="bg-brand/10 hover:bg-brand text-brand hover:text-white font-bold text-xs px-3.5 py-2 rounded-xl border border-brand/20 transition-all font-mono">
                                    Beli Tiket 🎟
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>

        <!-- 4. ORGANIZER CALL-TO-ACTION (Buat Event Komunitas) -->
        <section class="max-w-7xl mx-auto px-6 pt-12">
            <div class="bg-gradient-to-r from-surface via-slateBorder/30 to-surface p-8 md:p-12 rounded-3xl border border-slateBorder flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="space-y-2 text-center md:text-left">
                    <span class="text-xs font-mono text-brand font-bold tracking-widest">// BAGI PENYELENGGARA EVENT</span>
                    <h3 class="text-2xl font-bold font-display text-white">Ingin Buat Konser atau Meetup Komunitas Sendiri?</h3>
                    <p class="text-xs text-textMuted max-w-xl">
                        Gunakan sistem ticketing otomatis LoketKita tanpa komisi tiket. Terbitkan E-Tiket QR Code instan dan kirim E-Sertifikat otomatis pasca event.
                    </p>
                </div>
                <form method="POST" action="{{ route('request-organizer') }}">
                    @csrf
                    <button type="submit" class="bg-white hover:bg-gray-200 text-canvas font-bold font-display px-6 py-3.5 rounded-xl transition-all whitespace-nowrap text-sm">
                        Buat Event Sekarang 🚀
                    </button>
                </form>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slateBorder/60 py-8 px-6 md:px-12 flex flex-col md:flex-row justify-between items-center text-xs font-mono text-textMuted gap-4 bg-canvas/80">
        <p>© 2026 LoketKita.com — Platform Tiketing & Event Komunitas Indonesia.</p>
        <div class="flex gap-6">
            <span class="text-neonGreen">● System Operational</span>
            <span>Laravel v12.x</span>
        </div>
    </footer>

</body>
</html>
