<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panitia — TiketKita</title>
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
        body {
            background-color: #0B0F17;
            color: #F1F5F9;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hairline-border {
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased">

    <!-- Top Navigation -->
    <header class="w-full border-b border-border/60 py-4 px-6 md:px-12 flex justify-between items-center bg-surface/60 backdrop-blur-md sticky top-0 z-50">
        <a href="/" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-accent text-canvas rounded-lg flex items-center justify-center font-black font-mono text-base">T</div>
            <span class="font-extrabold tracking-tight text-white">TiketKita<span class="text-accent">.</span></span>
            <span class="text-xs font-mono text-subtle px-2 py-0.5 rounded bg-canvas border border-border">CONSOLE</span>
        </a>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-white">{{ Auth::user()->name ?? 'Organizer' }}</p>
                <p class="text-[10px] font-mono text-subtle">{{ Auth::user()->email ?? 'admin@komunitas.com' }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-mono text-subtle hover:text-accent border border-border hover:border-accent/40 bg-canvas px-3 py-1.5 rounded-lg transition-all">
                    Keluar 🚪
                </button>
            </form>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="max-w-7xl mx-auto px-6 py-10 w-full space-y-10">
        
        <!-- Welcome Banner / Stat Summary -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-surface p-8 rounded-2xl hairline-border">
            <div class="space-y-1">
                <span class="text-xs font-mono text-mint uppercase tracking-widest">● Active Event License</span>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white">Panel Event Komunitas</h1>
                <p class="text-sm text-subtle">Ringkasan statistik tiket, check-in, dan penjualan lisensi event kamu.</p>
            </div>

            <button class="bg-accent hover:bg-red-500 text-white font-bold px-5 py-3 rounded-xl transition-all text-sm flex items-center gap-2 shadow-lg shadow-accent/20">
                <span>+</span> Buat Event Baru
            </button>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Event Ditayangkan</span>
                <p class="text-3xl font-extrabold font-mono text-white">04</p>
                <span class="text-[11px] font-mono text-mint">1 Event Siap Check-in</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Peserta Terdaftar</span>
                <p class="text-3xl font-extrabold font-mono text-white">128</p>
                <span class="text-[11px] font-mono text-subtle">Dari 4 Event Aktif</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Peserta Check-in</span>
                <p class="text-3xl font-extrabold font-mono text-mint">94</p>
                <span class="text-[11px] font-mono text-mint">73% Attendance Rate</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Sertifikat Terbit</span>
                <p class="text-3xl font-extrabold font-mono text-white">88</p>
                <span class="text-[11px] font-mono text-subtle">Klaim via Feedback</span>
            </div>
        </div>

        <!-- Event Table / List -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-mono text-subtle uppercase tracking-wider">// Daftar Event Terkini</h2>
                <span class="text-xs font-mono text-subtle">Total: 1 Event</span>
            </div>

            <div class="bg-surface rounded-2xl hairline-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-canvas/50 text-xs font-mono text-subtle uppercase border-b border-border/60">
                            <tr>
                                <th class="p-4">Nama Event</th>
                                <th class="p-4">Tanggal & Waktu</th>
                                <th class="p-4">Lokasi</th>
                                <th class="p-4">Status Lisensi</th>
                                <th class="p-4">Peserta</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y border-border/40 text-subtle">
                            <tr class="hover:bg-canvas/30 transition-colors">
                                <td class="p-4 font-bold text-white">Meetup Dev Komunitas #1</td>
                                <td class="p-4 font-mono text-xs">15 Aug 2026, 19:00 WIB</td>
                                <td class="p-4">Kopi Hub, Jakarta</td>
                                <td class="p-4"><span class="px-2.5 py-1 rounded-md bg-mint/10 text-mint text-xs font-mono">Aktif</span></td>
                                <td class="p-4 font-mono text-xs text-white">42 / 50</td>
                                <td class="p-4 text-right space-x-2">
                                    <button class="px-3 py-1.5 bg-canvas border border-border text-xs text-white rounded-lg hover:border-white transition-colors">Scanner QR</button>
                                    <button class="px-3 py-1.5 bg-canvas border border-border text-xs text-subtle rounded-lg hover:text-white transition-colors">Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-border/60 py-6 px-6 md:px-12 flex justify-between items-center text-xs font-mono text-subtle">
        <p>© 2026 TiketKita SaaS. Dashboard Console.</p>
        <span class="text-mint">● Server Connected</span>
    </footer>

</body>
</html>
