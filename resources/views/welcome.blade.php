<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiketKita — Platform Tiket & Event Komunitas</title>
    
    <!-- Premium Google Fonts: DM Sans, Lexend, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"DM Sans"', 'sans-serif'],
                        display: ['"Lexend"', 'sans-serif'],
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
            font-family: 'DM Sans', sans-serif;
            background-image: 
                radial-gradient(circle at 10% 15%, rgba(255, 71, 87, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 90% 85%, rgba(5, 196, 107, 0.04) 0%, transparent 45%);
        }
        .text-glow {
            text-shadow: 0 0 30px rgba(255, 71, 87, 0.3);
        }
        .card-glow:hover {
            box-shadow: 0 10px 40px -10px rgba(255, 71, 87, 0.12);
            border-color: rgba(255, 71, 87, 0.25);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-brand selection:text-white">

    <!-- Top Navigation -->
    <header class="w-full border-b border-slateBorder/50 py-5 px-6 md:px-12 flex justify-between items-center backdrop-blur-md sticky top-0 z-50 bg-canvas/80">
        <a href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-brand text-canvas rounded-xl flex items-center justify-center font-black font-display text-xl group-hover:scale-105 transition-all shadow-lg shadow-brand/10">
                T
            </div>
            <span class="font-extrabold tracking-tight text-xl font-display text-white">TiketKita<span class="text-brand">.</span></span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="{{ route('events.catalog') }}" class="text-textMuted hover:text-white transition-colors">Katalog Event</a>
            <a href="#cara-kerja" class="text-textMuted hover:text-white transition-colors">Cara Kerja</a>
            <a href="#fitur" class="text-textMuted hover:text-white transition-colors">Fitur Unggulan</a>
        </nav>

        <div class="flex items-center gap-4">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" class="text-xs font-mono font-bold text-brand bg-brand/10 border border-brand/20 px-4 py-2.5 rounded-xl transition-all hover:bg-brand/20">
                        Admin Console 🛠
                    </a>
                @elseif(Auth::user()->role === 'organizer')
                    <a href="{{ route('dashboard') }}" class="text-xs font-mono font-bold text-white bg-surface hover:bg-slateBorder px-4 py-2.5 rounded-xl border border-slateBorder transition-all">
                        Dashboard Console ↗
                    </a>
                @else
                    @if(Auth::user()->organizer_status === 'pending')
                        <span class="text-xs font-mono font-bold text-neonGreen bg-neonGreen/10 border border-neonGreen/20 px-4 py-2.5 rounded-xl">
                            ⏳ Pengajuan Pending
                        </span>
                    @else
                        <form method="POST" action="{{ route('request-organizer') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-mono font-bold text-white bg-surface hover:bg-slateBorder px-4 py-2.5 rounded-xl border border-slateBorder transition-all">
                                Ajukan Pembuat Event 🚀
                            </button>
                        </form>
                    @endif
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
                    Daftar Akun
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="w-full">
        
        <!-- 1. HERO SECTION (Persuasive, Visual Anchor) -->
        <section class="max-w-6xl mx-auto px-6 pt-16 md:py-32 grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            <div class="space-y-8 md:col-span-7">
                <!-- Live Tag -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface border border-slateBorder">
                    <span class="w-2 h-2 rounded-full bg-neonGreen animate-pulse"></span>
                    <span class="text-xs font-mono text-white tracking-wider">MODERN PLATFORM V1.0</span>
                </div>

                <!-- Epic Headline -->
                <h1 class="text-4xl md:text-7xl font-black font-display tracking-tight text-white leading-[1.05]">
                    Buat Event Komunitas.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand via-pink-500 to-orange-400 text-glow">Tanpa Komisi.</span>
                </h1>

                <p class="text-base md:text-lg text-textMuted leading-relaxed max-w-xl">
                    Kami tidak mengambil keuntungan dari penjualan tiket kamu. Platform ticketing modern dengan penerbitan tiket QR Code instan, verifikasi scanner lapangan cepat, dan kirim e-sertifikat otomatis.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('events.catalog') }}" class="bg-brand hover:bg-red-500 text-white font-bold font-display px-8 py-4 rounded-xl shadow-lg shadow-brand/20 transition-all hover:-translate-y-0.5 text-base">
                        Jelajahi Katalog Event
                    </a>
                    @auth
                        @if(Auth::user()->role === 'user' && Auth::user()->organizer_status === 'none')
                            <form method="POST" action="{{ route('request-organizer') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-surface hover:bg-slateBorder text-white font-bold font-display px-6 py-4 rounded-xl border border-slateBorder transition-all text-base hover:-translate-y-0.5">
                                    Ajukan Diri Buat Event 🚀
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Visual Anchor Element (The Interactive Matrix Cards) -->
            <div class="md:col-span-5 relative hidden md:block">
                <div class="absolute -inset-4 bg-brand/5 rounded-3xl blur-2xl"></div>
                <div class="relative bg-surface p-8 rounded-3xl border border-slateBorder space-y-6">
                    <div class="flex justify-between items-center border-b border-slateBorder pb-4">
                        <span class="text-xs font-mono text-textMuted">TICKET CONSOLE // PRO</span>
                        <span class="text-xs font-mono text-neonGreen">● ONLINE</span>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 rounded-xl bg-canvas border border-slateBorder space-y-1">
                            <p class="text-[10px] font-mono text-textMuted">PENERBITAN TIKET</p>
                            <p class="text-sm font-bold text-white">QR Code Ter-enkripsi Instan</p>
                        </div>
                        <div class="p-4 rounded-xl bg-canvas border border-slateBorder space-y-1">
                            <p class="text-[10px] font-mono text-textMuted">KONFIRMASI BAYAR</p>
                            <p class="text-sm font-bold text-white">Sistem Validasi Manual QRIS/OVO</p>
                        </div>
                        <div class="p-4 rounded-xl bg-canvas border border-slateBorder space-y-1">
                            <p class="text-[10px] font-mono text-textMuted">PASCA EVENT</p>
                            <p class="text-sm font-bold text-white">Klaim Sertifikat & Materi PDF Otomatis</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. CARA KERJA (Symmetric Grid with High Restraint) -->
        <section id="cara-kerja" class="bg-surface border-y border-slateBorder/60 py-24">
            <div class="max-w-6xl mx-auto px-6 space-y-16">
                <div class="text-center space-y-4">
                    <h2 class="text-sm font-mono text-brand uppercase tracking-widest">// ALUR ALIR KERJA PLATFORM</h2>
                    <p class="text-3xl font-extrabold font-display text-white">Sangat Mudah, Terarah, dan Terstruktur</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Langkah 1 -->
                    <div class="space-y-4 p-6 rounded-2xl border border-slateBorder/40 hover:border-brand/30 transition-all bg-canvas/40">
                        <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-black font-display text-xl">1</div>
                        <h3 class="text-xl font-bold text-white">Ajukan Jadi Pembuat Event</h3>
                        <p class="text-sm text-textMuted leading-relaxed">
                            Cukup klik tombol pengajuan di halaman utama. Admin kami akan memverifikasi akun komunitas kamu dalam sekejap.
                        </p>
                    </div>

                    <!-- Langkah 2 -->
                    <div class="space-y-4 p-6 rounded-2xl border border-slateBorder/40 hover:border-brand/30 transition-all bg-canvas/40">
                        <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-black font-display text-xl">2</div>
                        <h3 class="text-xl font-bold text-white">Rancang Event & Terbitkan Tiket</h3>
                        <p class="text-sm text-textMuted leading-relaxed">
                            Isi detail event, atur kuota, pasang harga tiket, sertakan materi, lalu publikasikan langsung ke katalog nasional kami.
                        </p>
                    </div>

                    <!-- Langkah 3 -->
                    <div class="space-y-4 p-6 rounded-2xl border border-slateBorder/40 hover:border-brand/30 transition-all bg-canvas/40">
                        <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-black font-display text-xl">3</div>
                        <h3 class="text-xl font-bold text-white">Kelola & Otomatisasi Pasca-Event</h3>
                        <p class="text-sm text-textMuted leading-relaxed">
                            Gunakan scanner QR lapangan untuk check-in instan. Setelah check-in, sertifikat & materi event otomatis rilis ke dashboard peserta.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. MOTIVATIONAL BANNER (Pendorong Agar Tertarik Membuat Event) -->
        <section class="max-w-6xl mx-auto px-6 py-24">
            <div class="bg-gradient-to-br from-surface to-canvas p-8 md:p-16 rounded-3xl border border-slateBorder flex flex-col md:flex-row justify-between items-center gap-8 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand/10 rounded-full blur-3xl"></div>
                
                <div class="space-y-4 max-w-xl text-center md:text-left">
                    <span class="text-xs font-mono text-brand font-bold tracking-widest">// CO-DEVELOP WITH COMMUNITY</span>
                    <h2 class="text-2xl md:text-4xl font-extrabold font-display text-white leading-tight">Miliki Event Sendiri Tanpa Khawatir Biaya Komisi Tiket</h2>
                    <p class="text-sm text-textMuted leading-relaxed">
                        Kami percaya bahwa meetup komunitas lokal tidak seharusnya terbebani potongan biaya ticketing yang mencekik. Bergabunglah sekarang dan rasakan manajemen event yang sesungguhnya.
                    </p>
                </div>

                <div class="flex flex-col gap-3 min-w-[200px]">
                    @auth
                        @if(Auth::user()->role === 'user' && Auth::user()->organizer_status === 'none')
                            <form method="POST" action="{{ route('request-organizer') }}">
                                @csrf
                                <button type="submit" class="w-full text-center bg-white hover:bg-gray-100 text-canvas font-bold font-display px-6 py-4 rounded-xl transition-all">
                                    Ajukan Akun Sekarang 🚀
                                </button>
                            </form>
                        @else
                            <a href="{{ route('dashboard') }}" class="w-full text-center bg-white hover:bg-gray-100 text-canvas font-bold font-display px-6 py-4 rounded-xl transition-all">
                                Masuk Console Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="w-full text-center bg-white hover:bg-gray-100 text-canvas font-bold font-display px-6 py-4 rounded-xl transition-all">
                            Daftar Komunitas Gratis
                        </a>
                        <a href="{{ route('login') }}" class="w-full text-center border border-slateBorder hover:border-brand/40 text-white font-mono text-xs px-6 py-4 rounded-xl transition-all">
                            Sudah punya akun? Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </section>

    </main>

    <!-- Top-Tier Footer -->
    <footer class="w-full border-t border-slateBorder/60 py-10 px-6 md:px-12 flex flex-col md:flex-row justify-between items-center text-xs font-mono text-textMuted gap-4 bg-canvas/40">
        <p>© 2026 TiketKita. Built with precision for community growth.</p>
        <div class="flex gap-6">
            <span class="text-neonGreen">● System Operational</span>
            <span>Framework: Laravel v12.x</span>
        </div>
    </footer>

</body>
</html>
