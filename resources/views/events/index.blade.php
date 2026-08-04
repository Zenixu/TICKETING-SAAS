<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Event — TiketKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        canvas: '#0B0F17',
                        surface: '#131924',
                        border: '#1E2638',
                        accent: '#FF4757',
                        mint: '#05C46B',
                        subtle: '#8C98A9'
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0B0F17; color: #F1F5F9; font-family: 'Plus Jakarta Sans', sans-serif; }
        .hairline-border { border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased">

    <!-- Top Navigation -->
    <header class="w-full border-b border-border/60 py-4 px-6 md:px-12 flex justify-between items-center bg-surface/80 backdrop-blur-md sticky top-0 z-50">
        <a href="/" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-accent text-canvas rounded-lg flex items-center justify-center font-black font-mono text-base">T</div>
            <span class="font-extrabold tracking-tight text-white">TiketKita<span class="text-accent">.</span></span>
        </a>

        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="text-xs font-mono text-white bg-surface hover:bg-border px-4 py-2 rounded-lg hairline-border transition-all">
                    Dashboard Console ↗
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-mono text-subtle hover:text-white transition-all">Masuk</a>
                <a href="{{ route('register') }}" class="text-xs font-mono text-canvas bg-white hover:bg-gray-200 px-4 py-2 rounded-lg font-bold transition-all">Daftar</a>
            @endauth
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="max-w-7xl mx-auto px-6 py-12 w-full space-y-12">
        
        <!-- Header -->
        <div class="space-y-2 border-b border-border/60 pb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-white leading-none">Jelajahi Event Komunitas</h1>
            <p class="text-sm text-subtle">Temukan meetup, webinar, dan workshop dari berbagai komunitas lokal.</p>
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if($events->isEmpty())
                <div class="col-span-3 text-center py-16 bg-surface rounded-2xl hairline-border text-xs font-mono text-subtle">
                    Tidak ada event aktif yang tersedia saat ini.
                </div>
            @else
                @foreach($events as $event)
                    <div class="bg-surface rounded-2xl hairline-border overflow-hidden hover:border-accent/40 transition-colors flex flex-col justify-between p-6 space-y-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <span class="px-2.5 py-1 rounded-md bg-accent/10 text-accent text-[10px] font-mono uppercase tracking-wider">
                                    {{ strtoupper($event->status) }}
                                </span>
                                <span class="text-[10px] font-mono text-subtle uppercase">ORGANIZER: {{ $event->user->name }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-white leading-snug">{{ $event->title }}</h3>
                            <p class="text-sm text-subtle line-clamp-3 leading-relaxed">{{ $event->description }}</p>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-border/40 text-xs text-subtle">
                            <div class="flex justify-between">
                                <span class="font-mono">📅 TANGGAL:</span>
                                <span class="text-white font-bold">{{ $event->date_time->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-mono">📍 LOKASI:</span>
                                <span class="text-white font-bold">{{ $event->location_name }}</span>
                            </div>

                            <a href="{{ route('events.public-show', $event->id) }}" class="block text-center w-full bg-accent hover:bg-red-500 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-md shadow-accent/10">
                                Beli Tiket / Daftar
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-border/60 py-6 px-6 md:px-12 flex justify-between items-center text-xs font-mono text-subtle">
        <p>© 2026 TiketKita. Portal Eksplorasi Event.</p>
    </footer>

</body>
</html>
