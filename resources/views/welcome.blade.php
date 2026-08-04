<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LoketKita — SaaS Tiketing Khusus Event Musik & Cosplay</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-tint": "#ffb3b2",
                        "inverse-primary": "#bc0d2e",
                        "inverse-on-surface": "#2e3036",
                        "on-secondary-fixed": "#00210d",
                        "on-surface": "#e2e2ea",
                        "secondary-container": "#07c46b",
                        "surface-dim": "#111319",
                        "error-container": "#93000a",
                        "on-tertiary": "#283141",
                        "tertiary-container": "#8891a5",
                        "surface-container": "#1d2025",
                        "on-primary-fixed-variant": "#920020",
                        "surface-variant": "#33353b",
                        "tertiary-fixed": "#dae2f9",
                        "on-primary": "#680013",
                        "surface": "#111319",
                        "primary-fixed-dim": "#ffb3b2",
                        "secondary-fixed": "#64fe9e",
                        "secondary": "#41e184",
                        "on-surface-variant": "#e4bdbc",
                        "surface-container-lowest": "#0c0e13",
                        "on-error-container": "#ffdad6",
                        "error": "#ffb4ab",
                        "on-primary-container": "#5b0010",
                        "on-primary-fixed": "#410008",
                        "on-secondary": "#00391b",
                        "on-secondary-container": "#004a24",
                        "on-error": "#690005",
                        "secondary-fixed-dim": "#41e184",
                        "on-secondary-fixed-variant": "#005229",
                        "inverse-surface": "#e2e2ea",
                        "surface-container-low": "#191c21",
                        "surface-container-highest": "#33353b",
                        "tertiary-fixed-dim": "#bec7dc",
                        "on-tertiary-fixed": "#131c2b",
                        "surface-container-high": "#282a30",
                        "primary-container": "#ff525e",
                        "on-background": "#e2e2ea",
                        "outline-variant": "#5b403f",
                        "on-tertiary-container": "#212a3a",
                        "background": "#111319",
                        "outline": "#ab8888",
                        "surface-bright": "#37393f",
                        "on-tertiary-fixed-variant": "#3e4758",
                        "tertiary": "#bec7dc",
                        "primary": "#ffb3b2",
                        "primary-fixed": "#ffdad9"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "xs": "4px",
                        "lg": "48px",
                        "base": "8px",
                        "gutter": "24px",
                        "sm": "12px",
                        "xl": "80px",
                        "md": "24px",
                        "container-max": "1440px"
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet"/>
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", "Inter", sans-serif;
            background-color: #0c0e13;
            background-image: 
                radial-gradient(circle at 0% 20%, rgba(255, 82, 94, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 100% 80%, rgba(65, 225, 132, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }
        ::-webkit-scrollbar { display: none; }
        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-move {
            display: inline-block;
            animation: ticker 35s linear infinite;
        }
        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
    </style>
</head>
<body class="bg-surface-container-lowest font-body-md text-on-surface antialiased min-h-screen flex flex-col justify-between">

    <!-- RUNNING TICKER STREAM (Ornamen Visual Atas Layar Penuh) -->
    <div class="w-full bg-surface-container-high/90 border-b border-outline-variant/20 py-2 font-label-mono text-[11px] text-on-surface-variant ticker-wrap z-50">
        <div class="ticker-move flex items-center gap-8">
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary-container"></span> ⚡ FLAT-FEE LICENSE: 0% TICKET COMMISSION FOR ALL COMMUNITIES</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-secondary-fixed"></span> 🎵 LIVE MUSIC GIGS & FESTIVALS READY</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary-container"></span> 🎭 COSPLAY & ANIME FESTIVAL BUNDLING MERCH</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-secondary-fixed"></span> 📲 FAST GATE QR CODE SCANNER INSTANT CHECK-IN</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary-container"></span> ⚡ FLAT-FEE LICENSE: 0% TICKET COMMISSION FOR ALL COMMUNITIES</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-secondary-fixed"></span> 🎵 LIVE MUSIC GIGS & FESTIVALS READY</span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary-container"></span> 🎭 COSPLAY & ANIME FESTIVAL BUNDLING MERCH</span>
        </div>
    </div>

    <!-- HEADER / NAVIGATION BAR (Lebar Penuh dengan Padding Gap Sesuai) -->
    <header class="sticky top-0 w-full z-40 bg-surface-container-lowest/90 backdrop-blur-xl border-b border-outline-variant/20">
        <div class="h-20 w-full px-4 sm:px-6 lg:px-8 xl:px-12 flex items-center justify-between gap-md mx-auto">
            <a href="/" class="flex items-center gap-sm shrink-0 group">
                <div class="w-10 h-10 bg-primary-container text-on-primary-container rounded-xl flex items-center justify-center font-black text-xl group-hover:scale-105 transition-all shadow-[0_0_15px_rgba(255,82,94,0.4)]">
                    L
                </div>
                <span class="font-headline-md text-xl font-bold text-on-surface tracking-tighter">LoketKita<span class="text-primary-container">.com</span></span>
            </a>

            <!-- Search Bar (Loket.com Style) -->
            <div class="hidden md:flex flex-1 max-w-2xl relative group mx-8">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full bg-surface-container-highest border border-outline-variant/30 rounded-full py-2.5 pl-12 pr-md text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-secondary transition-all text-sm" placeholder="Cari konser musik atau anime fest..." type="text"/>
            </div>

            <!-- Nav Actions -->
            <nav class="flex items-center gap-md">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a class="text-xs font-bold text-primary-container bg-primary-container/10 px-md py-base rounded-full border border-primary-container/20 transition-all hover:bg-primary-container/20" href="{{ route('admin.index') }}">Admin Console 🛠</a>
                    @elseif(Auth::user()->role === 'organizer')
                        <a class="text-xs font-bold text-on-surface bg-surface-container-high px-md py-base rounded-full border border-outline-variant/30 transition-all hover:bg-surface-container-highest" href="{{ route('dashboard') }}">Dashboard Organizer ↗</a>
                    @else
                        <a class="text-xs font-bold text-on-surface bg-surface-container-high px-md py-base rounded-full border border-outline-variant/30 transition-all hover:bg-surface-container-highest" href="https://wa.me/6282114073679?text=Halo%20Admin%20LoketKita,%20saya%20tertarik%20mendaftarkan%20event%20komunitas%20saya" target="_blank">Buat Event Kamu 🚀</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-on-surface-variant hover:text-primary-container transition-colors">Keluar 🚪</button>
                    </form>
                @else
                    <a class="hidden sm:inline-block text-xs font-bold text-on-surface-variant hover:text-on-surface" href="{{ route('login') }}">Masuk</a>
                    <a class="hidden sm:inline-block text-xs font-bold text-on-surface-variant hover:text-on-surface" href="{{ route('register') }}">Daftar</a>
                    <a href="https://wa.me/6282114073679?text=Halo%20Admin%20LoketKita,%20saya%20tertarik%20mendaftarkan%20event%20komunitas%20saya" target="_blank" class="bg-primary-container hover:bg-primary-container/90 text-on-primary-container px-md py-2.5 rounded-full text-xs font-bold shadow-[0_0_20px_rgba(255,82,94,0.3)] transition-all flex items-center gap-xs shrink-0">
                        Buat Event
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT (Expanded Widescreen Layout 100%) -->
    <main class="pt-6 w-full">
        
        <!-- HERO SECTION (Loket.com Style Banner Carousel & Headline Combo) -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- KIRI: Value Proposition & CTAs (Loket.com Copywriting Style) -->
                <div class="lg:col-span-6 flex flex-col items-start text-left z-10 space-y-6">
                    <div class="bg-primary-container/20 text-primary-container font-label-mono text-xs px-4 py-2 rounded-full inline-flex items-center gap-2 shadow-[inset_1px_1px_0_rgba(255,179,178,0.2)]">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">local_activity</span>
                        Platform Tiket Mandiri No. 1 untuk Musik & Cosplay
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-black text-on-surface leading-tight tracking-tight">
                        Ciptakan Event Seru.<br/>
                        Kelola Tiket <span class="text-primary-fixed">Otomatis.</span><br/>
                        <span class="text-secondary-fixed">0% Komisi Transaksi.</span>
                    </h1>
                    
                    <p class="text-sm md:text-base text-on-surface-variant max-w-2xl font-sans leading-relaxed">
                        Mulai dari gig musik studio hingga festival cosplay nasional, buat halaman penjualan tiket digital berstandar professional dalam hitungan menit. Kirim e-tiket QR otomatis tanpa ribet potongan platform.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="https://wa.me/6282114073679?text=Halo%20Admin%20LoketKita,%20saya%20ingin%20membuat%20event%20di%20LoketKita" target="_blank" class="bg-primary-container hover:bg-primary-container/90 text-on-primary-container font-bold px-8 py-3.5 rounded-full shadow-[0_0_24px_rgba(255,82,94,0.3)] transition-all flex items-center gap-2 text-sm hover:-translate-y-0.5">
                            Buat Event Sekarang 🚀
                        </a>
                        <a href="#events-section" class="bg-surface-container-high hover:bg-surface-container-highest text-on-surface border border-outline-variant/30 font-bold px-8 py-3.5 rounded-full transition-all text-sm hover:-translate-y-0.5">
                            Cari Event Menarik 🎟
                        </a>
                    </div>
                </div>

                <!-- KANAN: Loket.com Style Featured Banner Slider/Display (With Dot Navigation) -->
                <div class="lg:col-span-6 flex flex-col justify-center items-center w-full">
                    <div class="relative w-full max-w-[640px] h-[340px] rounded-3xl overflow-hidden shadow-2xl z-10 border border-outline-variant/20 bg-cover bg-center transition-all duration-700" id="featured-carousel" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDg7bbXH7hX427XdNNzQP97rThV5uN3xHZx1qioqS37Qfe0A4_0siM2m9FF8j-T6X4pts00E-7OCzrP61GUkPSiRsyEsNwinDRJt1rzJb-b9aEeJlpn2dUv5Zci_YwT1cSw2THXN6IdLRX6JbnRkqRgWvp4cCRNxZVBc1RcF0kOiEAlV04n-oG5XmoJmS8re-5xCQdKP9wlJpt7CuiIi5tJvT0Mown4oJ7AGnuI5t2HVMGL6n7kCWo0Ig')">
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-dim via-surface-dim/20 to-transparent"></div>
                        
                        <!-- Overlay Details (Hot Deal / Trending) -->
                        <div class="absolute top-4 left-4 bg-primary-container text-on-primary-container text-[10px] font-bold font-label-mono px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                            🔥 Rekomendasi Pekan Ini
                        </div>

                        <!-- Ticket Carousel Details Info -->
                        <div class="absolute bottom-4 left-4 right-4 bg-surface-container/90 backdrop-blur-xl p-5 rounded-2xl flex justify-between items-center border border-white/10 shadow-2xl">
                            <div>
                                <span class="font-label-mono text-[10px] text-secondary-fixed font-bold tracking-widest uppercase">CONCERT FESTIVAL</span>
                                <h3 class="text-lg font-black text-on-surface line-clamp-1 leading-tight mt-0.5" id="carousel-title">NOAH & SHEILA ON 7: Soundwave Fest</h3>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="block text-[9px] text-on-surface-variant uppercase font-bold">Mulai dari</span>
                                <span class="text-sm font-black text-secondary-fixed" id="carousel-price">Rp 350.000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Slide Navigation Dots (Loket.com Style) -->
                    <div class="flex items-center gap-2.5 mt-4">
                        <button class="w-3 h-3 rounded-full bg-primary-container transition-all cursor-pointer" onclick="switchSlide(0)" id="dot-0"></button>
                        <button class="w-3 h-3 rounded-full bg-outline-variant/40 transition-all cursor-pointer hover:bg-white/40" onclick="switchSlide(1)" id="dot-1"></button>
                    </div>
                </div>

            </div>
        </section>

        <!-- CATEGORY QUICK LINKS (Loket.com Pill Selector) -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-4">
            <div class="bg-surface-container-high/60 border border-outline-variant/10 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-4">
                <span class="text-xs font-display font-bold text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand text-sm">explore</span> Jelajahi Kategori Populer LoketKita:
                </span>
                <div class="flex items-center flex-wrap gap-2 text-xs font-bold">
                    <a href="/?category=Musik" class="px-5 py-2.5 rounded-xl bg-surface border border-outline-variant/30 hover:border-brand/40 text-on-surface hover:text-white transition-all flex items-center gap-2">
                        🎵 Konser & Gigs Musik
                    </a>
                    <a href="/?category=Cosplay" class="px-5 py-2.5 rounded-xl bg-surface border border-outline-variant/30 hover:border-brand/40 text-on-surface hover:text-white transition-all flex items-center gap-2">
                        🎭 Cosplay & Anime Fest
                    </a>
                    <a href="https://wa.me/6282114073679?text=Halo%20Admin%20LoketKita,%20saya%20tertarik%20mendaftarkan%20event%20komunitas%20saya" target="_blank" class="px-5 py-2.5 rounded-xl bg-primary-container/10 border border-primary-container/20 text-primary-container hover:bg-primary-container/20 transition-all flex items-center gap-2">
                        🚀 Ajukan Event Kustom
                    </a>
                </div>
            </div>
        </section>

        <!-- BENTO SHOWCASE SECTION (Penuh Layar) -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-4 my-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Music Card -->
                <div class="bg-surface-container-high rounded-3xl p-8 shadow-xl flex flex-col justify-between gap-6 border border-outline-variant/20 relative overflow-hidden group">
                    <div class="space-y-4 z-10">
                        <div class="bg-primary/10 text-primary-fixed-dim font-label-mono text-xs font-bold px-4 py-1.5 inline-flex items-center gap-2 rounded-full border border-primary/20">
                            <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">headphones</span>
                            Live Music Optimization
                        </div>
                        <h2 class="text-2xl font-bold text-on-surface">Sistem Manajemen Front Stage & VIP Konser</h2>
                        <p class="text-xs md:text-sm text-on-surface-variant font-sans leading-relaxed">
                            Dirancang khusus untuk gig indie & festival musik besar dengan pembagian zona panggung presisi dan scanner pintu masuk ultra-cepat.
                        </p>
                        <ul class="space-y-2 text-xs text-on-surface-variant font-sans pt-2">
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary-fixed text-base">check_circle</span> Fast Gate QR Code Scanner untuk cegah penumpukan antrean</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary-fixed text-base">check_circle</span> Classification Tiket: Regular Festival, VIP Front Stage, VVIP Meet & Greet</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary-fixed text-base">check_circle</span> Real-time capacity tracking per zone panggung</li>
                        </ul>
                    </div>
                    <a href="/?category=Musik" class="inline-flex items-center gap-2 text-xs font-bold text-primary-fixed hover:underline z-10 pt-4 border-t border-outline-variant/10">
                        Lihat Contoh Event Musik ↗
                    </a>
                </div>

                <!-- Anime Card -->
                <div class="bg-surface-container rounded-3xl p-8 shadow-xl flex flex-col justify-between gap-6 border border-outline-variant/20 relative overflow-hidden group">
                    <div class="space-y-4 z-10">
                        <div class="bg-secondary/10 text-secondary-fixed-dim font-label-mono text-xs font-bold px-4 py-1.5 inline-flex items-center gap-2 rounded-full border border-secondary/20">
                            <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">theater_comedy</span>
                            Anime Fest Ready
                        </div>
                        <h2 class="text-2xl font-bold text-on-surface">Bundling Merchandise & Coswalk Pass</h2>
                        <p class="text-xs md:text-sm text-on-surface-variant font-sans leading-relaxed">
                            Solusi terintegrasi untuk gath cosplay & festival anime dengan bundling merchandise exclusive dan pendaftaran lomba coswalk.
                        </p>
                        <ul class="space-y-2 text-xs text-on-surface-variant font-sans pt-2">
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-secondary-fixed text-base">check_circle</span> Sistem Add-on Pre-order Merch (Akrilik Standee, Keychain, Goodie Bag)</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-secondary-fixed text-base">check_circle</span> Tiket Registrasi Coswalk Pass + Akses Ruang Ganti VIP & Mirror Station</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-secondary-fixed text-base">check_circle</span> Otomatisasi E-Certificate bagi para pemenang kompetisi</li>
                        </ul>
                    </div>
                    <a href="/?category=Cosplay" class="inline-flex items-center gap-2 text-xs font-bold text-secondary-fixed hover:underline z-10 pt-4 border-t border-outline-variant/10">
                        Lihat Contoh Event Cosplay ↗
                    </a>
                </div>

            </div>
        </section>

        <!-- LIVE EVENTS EXHIBIT SHOWCASE (Penuh 4-Grid Kolom - Loket.com Card Design) -->
        <section id="events-section" class="w-full bg-surface-container-low py-12 px-4 sm:px-6 lg:px-8 xl:px-12 border-y border-outline-variant/10 my-8">
            <div class="w-full space-y-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant/10 pb-4">
                    <div class="flex items-center gap-2 font-label-mono text-xs text-secondary-fixed font-bold tracking-widest">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary-fixed opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-secondary-fixed"></span>
                        </span>
                        UPDATING LIVE KATALOG EVENT
                    </div>

                    <!-- Filter Pill Niche -->
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <a href="/" class="px-5 py-2.5 rounded-full border {{ !$category ? 'bg-primary-container text-on-primary-container border-primary-container' : 'bg-surface-container-high text-on-surface-variant border-outline-variant/30 hover:text-on-surface' }} transition-all">
                            Semua Event
                        </a>
                        <a href="/?category=Musik" class="px-5 py-2.5 rounded-full border {{ $category === 'Musik' ? 'bg-primary-container text-on-primary-container border-primary-container' : 'bg-surface-container-high text-on-surface-variant border-outline-variant/30 hover:text-on-surface' }} transition-all">
                            🎵 Musik
                        </a>
                        <a href="/?category=Cosplay" class="px-5 py-2.5 rounded-full border {{ $category === 'Cosplay' ? 'bg-primary-container text-on-primary-container border-primary-container' : 'bg-surface-container-high text-on-surface-variant border-outline-variant/30 hover:text-on-surface' }} transition-all">
                            🎭 Cosplay
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($events as $event)
                        @php
                            $banner = $event->material_links['banner_url'] ?? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80';
                            $catName = $event->material_links['category'] ?? 'Event';
                        @endphp
                        <div class="bg-surface-container-high rounded-2xl overflow-hidden shadow-lg border border-outline-variant/10 transition-all hover:-translate-y-1.5 hover:shadow-2xl hover:border-brand/30 flex flex-col justify-between group">
                            
                            <!-- Poster Area (Vertical 4:3 style) -->
                            <div class="w-full h-52 overflow-hidden relative shadow-md shrink-0">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $banner }}"/>
                                <div class="absolute top-3 left-3 bg-surface-container/90 backdrop-blur-md px-3 py-1 rounded-lg font-label-mono text-primary-fixed text-[10px] font-bold border border-white/10 uppercase tracking-widest">
                                    {{ $catName }}
                                </div>
                            </div>
                            
                            <!-- Event Details (Loket.com Style Layout) -->
                            <div class="p-5 flex-grow flex flex-col justify-between gap-4">
                                <div class="space-y-2">
                                    <div class="font-label-mono text-xs text-primary-container font-bold flex items-center gap-1">
                                        📅 {{ $event->date_time->format('d M Y') }}
                                    </div>
                                    <h3 class="text-base font-extrabold text-on-surface line-clamp-2 leading-snug group-hover:text-primary-container transition-colors tracking-tight font-display">
                                        {{ $event->title }}
                                    </h3>
                                    <div class="flex items-center gap-1 text-xs text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant">location_on</span> {{ $event->location_name }}
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-outline-variant/10 flex items-center justify-between">
                                    <div>
                                        <p class="text-[9px] font-bold uppercase tracking-wider text-on-surface-variant">Mulai dari</p>
                                        <div class="text-base font-black text-secondary-fixed">
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('events.public-show', $event->id) }}" class="bg-primary-container hover:bg-primary-container/90 text-on-primary-container px-4 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md font-display">
                                        Beli Tiket 🎟
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- BANNER MONETISASI LISENSI WA (Penuh Layar) -->
        <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 my-12">
            <div class="bg-primary-container rounded-3xl shadow-[0_20px_40px_rgba(255,82,94,0.15)] flex flex-col md:flex-row items-center justify-between p-8 md:p-12 gap-8 relative overflow-hidden">
                <svg class="absolute right-0 top-0 h-full text-on-primary-container/10 mix-blend-overlay pointer-events-none" fill="currentColor" preserveaspectratio="none" viewBox="0 0 200 200">
                    <path d="M100 0L200 100L100 200L0 100Z"></path>
                    <circle cx="100" cy="100" fill="none" r="50" stroke="currentColor" stroke-width="2"></circle>
                </svg>
                <div class="flex flex-col items-center md:items-start text-center md:text-left z-10 space-y-2">
                    <span class="text-xs font-mono font-bold uppercase tracking-widest text-on-primary-container/80">// ALUR LISENSI FLAT-FEE WA</span>
                    <h2 class="text-2xl md:text-4xl font-extrabold text-on-primary-container tracking-tight">
                        0% TICKET COMMISSION
                    </h2>
                    <p class="text-xs md:text-sm text-on-primary-container/80 max-w-2xl font-sans">
                        Berhenti membuang budget komunitas Anda untuk potongan platform. Gunakan model flat-fee licensing kami dan simpan 100% pendapatan tiket Anda.
                    </p>
                </div>
                <a href="https://wa.me/6282114073679?text=Halo%20Admin%20LoketKita,%20saya%20tertarik%20mendaftarkan%20event%20komunitas%20saya" target="_blank" class="bg-surface text-on-surface font-bold text-sm px-8 py-4 rounded-full shadow-2xl transition-all z-10 flex items-center gap-2 whitespace-nowrap hover:-translate-y-0.5">
                    Hubungi Admin WA (082114073679)
                    <span class="material-symbols-outlined text-primary-container">chat</span>
                </a>
            </div>
        </section>

    </main>

    <!-- FOOTER (Penuh Layar) -->
    <footer class="w-full bg-surface-container-lowest border-t border-outline-variant/10 py-8 px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="w-full flex flex-col md:flex-row justify-between items-center gap-md">
            <p class="text-xs text-on-surface-variant text-center md:text-left font-sans">© 2026 LoketKita.com — Platform SaaS Tiketing Khusus Event Musik & Cosplay Indonesia.</p>
            <div class="flex items-center gap-sm bg-surface-container-high px-4 py-2 rounded-full border border-outline-variant/20">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                </span>
                <span class="font-label-mono text-xs font-bold text-secondary uppercase tracking-widest">System Operational</span>
            </div>
        </div>
    </footer>

    <!-- CAROUSEL SLIDE JAVASCRIPT (Loket.com Interaction) -->
    <script>
        const slides = [
            {
                image: "https://lh3.googleusercontent.com/aida-public/AB6AXuDg7bbXH7hX427XdNNzQP97rThV5uN3xHZx1qioqS37Qfe0A4_0siM2m9FF8j-T6X4pts00E-7OCzrP61GUkPSiRsyEsNwinDRJt1rzJb-b9aEeJlpn2dUv5Zci_YwT1cSw2THXN6IdLRX6JbnRkqRgWvp4cCRNxZVBc1RcF0kOiEAlV04n-oG5XmoJmS8re-5xCQdKP9wlJpt7CuiIi5tJvT0Mown4oJ7AGnuI5t2HVMGL6n7kCWo0Ig",
                title: "NOAH & SHEILA ON 7: Soundwave Fest",
                price: "Rp 350.000"
            },
            {
                image: "https://lh3.googleusercontent.com/aida-public/AB6AXuAS63EY5ovd1Uz6IfoQTmvvP56sSKShm3BV0N3hKsVIiijhA7GSAZ_zv1swuxTCbfoQjk1lp-mv21MzoYhROOB3pQE8KYtE7gz5vy24iOS6Ss1WDQDKjDINpTSnjuvleRkgkjU3QvvcXoR8XSQsov9By18B25FHxT_hBCS6DVQPlyjlfd7x9aAp5nJDRm8-ecQfoY6P5hlShl4hVQvKGxyufzjEsRkpoQ9Sb4KTDff3bwWq31cugaqIww",
                title: "NIPPON MATSURI 2026: Cosplay & Animetion Fest",
                price: "Rp 45.000"
            }
        ];

        let currentSlide = 0;
        const carousel = document.getElementById('featured-carousel');
        const carouselTitle = document.getElementById('carousel-title');
        const carouselPrice = document.getElementById('carousel-price');

        function switchSlide(index) {
            currentSlide = index;
            carousel.style.backgroundImage = `url('${slides[index].image}')`;
            carouselTitle.innerText = slides[index].title;
            carouselPrice.innerText = slides[index].price;

            // Update dots active class
            document.getElementById('dot-0').className = `w-3 h-3 rounded-full transition-all cursor-pointer ${index === 0 ? 'bg-primary-container' : 'bg-outline-variant/40 hover:bg-white/40'}`;
            document.getElementById('dot-1').className = `w-3 h-3 rounded-full transition-all cursor-pointer ${index === 1 ? 'bg-primary-container' : 'bg-outline-variant/40 hover:bg-white/40'}`;
        }

        // Auto slide every 5 seconds
        setInterval(() => {
            const nextSlide = (currentSlide + 1) % slides.length;
            switchSlide(nextSlide);
        }, 5000);
    </script>
</body>
</html>
