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
        
        @if(session('success'))
        <div class="bg-mint/10 border border-mint text-mint px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-accent/10 border border-accent text-accent px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Welcome Banner / Stat Summary -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-surface p-8 rounded-2xl hairline-border">
            <div class="space-y-1">
                <span class="text-xs font-mono text-mint uppercase tracking-widest">● Active Event License</span>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white">Panel Event Komunitas</h1>
                <p class="text-sm text-subtle">Ringkasan statistik tiket, check-in, dan penjualan lisensi event kamu.</p>
            </div>

            <button onclick="document.getElementById('createEventModal').classList.remove('hidden')" class="bg-accent hover:bg-red-500 text-white font-bold px-5 py-3 rounded-xl transition-all text-sm flex items-center gap-2 shadow-lg shadow-accent/20">
                <span>+</span> Buat Event Baru
            </button>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Event Ditayangkan</span>
                <p class="text-3xl font-extrabold font-mono text-white">{{ $totalEvents ?? 0 }}</p>
                <span class="text-[11px] font-mono text-mint">Event Tersedia</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Peserta Terdaftar</span>
                <p class="text-3xl font-extrabold font-mono text-white">{{ $totalAttendees ?? 0 }}</p>
                <span class="text-[11px] font-mono text-subtle">Dari Semua Event</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Peserta Check-in</span>
                <p class="text-3xl font-extrabold font-mono text-mint">0</p>
                <span class="text-[11px] font-mono text-mint">Dalam Pengembangan</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Sertifikat Terbit</span>
                <p class="text-3xl font-extrabold font-mono text-white">0</p>
                <span class="text-[11px] font-mono text-subtle">Dalam Pengembangan</span>
            </div>
        </div>

        <!-- Event Table / List -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-mono text-subtle uppercase tracking-wider">// Daftar Event Terkini</h2>
                <span class="text-xs font-mono text-subtle">Total: {{ $totalEvents ?? 0 }} Event</span>
            </div>

            <div class="bg-surface rounded-2xl hairline-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-canvas/50 text-xs font-mono text-subtle uppercase border-b border-border/60">
                            <tr>
                                <th class="p-4">Nama Event</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Tanggal & Waktu</th>
                                <th class="p-4">Lokasi</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y border-border/40 text-subtle">
                            @if(isset($events) && $events->count() > 0)
                                @foreach($events as $event)
                                <tr class="hover:bg-canvas/30 transition-colors">
                                    <td class="p-4 font-bold text-white">{{ $event->title }}</td>
                                    <td class="p-4 font-mono text-xs">{{ $event->category ?? '-' }}</td>
                                    <td class="p-4 font-mono text-xs">{{ $event->date_time->format('d M Y, H:i') }} WIB</td>
                                    <td class="p-4">{{ $event->location_name }}</td>
                                    <td class="p-4 text-white">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                                    <td class="p-4 text-right space-x-2 flex justify-end items-center">
                                        <a href="{{ route('events.public-show', $event->id) }}" class="px-3 py-1.5 bg-canvas border border-border text-xs text-subtle rounded-lg hover:text-white transition-colors">Detail</a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-accent/10 border border-accent/20 text-xs text-accent rounded-lg hover:bg-accent hover:text-white transition-colors">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-subtle">Belum ada event yang dibuat.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Modal Form Buat Event Baru -->
    <div id="createEventModal" class="fixed inset-0 z-[100] hidden bg-black/80 backdrop-blur-sm overflow-y-auto w-full h-full">
        <div class="relative p-5 mx-auto w-full max-w-3xl top-10 mb-20">
            <div class="bg-surface rounded-2xl hairline-border shadow-2xl flex flex-col">
                <div class="flex justify-between items-center p-6 border-b border-border/60">
                    <h3 class="text-xl font-bold text-white">Buat Event Baru</h3>
                    <button onclick="document.getElementById('createEventModal').classList.add('hidden')" class="text-subtle hover:text-white transition-colors font-bold text-xl">&times;</button>
                </div>
                <div class="p-6">
                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informasi Dasar -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-mint font-mono border-b border-border/60 pb-2">1. INFORMASI UMUM</h4>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Nama Event</label>
                                    <input type="text" name="title" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent" placeholder="Contoh: Anime Fest 2026">
                                </div>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Kategori Event</label>
                                    <select name="category" class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                        <option value="Musik">Musik & Konser</option>
                                        <option value="Cosplay">Cosplay & Jejepangan</option>
                                        <option value="Workshop">Workshop & Kelas</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Deskripsi Lengkap</label>
                                    <textarea name="description" required rows="4" class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Link URL Banner/Poster Event (Opsional)</label>
                                    <input type="url" name="banner_path" class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent" placeholder="https://example.com/image.jpg">
                                </div>
                            </div>
                            
                            <!-- Jadwal, Tiket & Kontak -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-mint font-mono border-b border-border/60 pb-2">2. JADWAL & TIKET</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-subtle mb-1">Waktu Pelaksanaan</label>
                                        <input type="datetime-local" name="date_time" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-subtle mb-1">Lokasi Event</label>
                                        <input type="text" name="location_name" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-subtle mb-1">Harga Tiket Dasar (Rp)</label>
                                        <input type="number" name="price" value="0" min="0" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-subtle mb-1">Kuota Maksimal</label>
                                        <input type="number" name="quota" value="100" min="1" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                    </div>
                                </div>
                                
                                <h4 class="text-sm font-bold text-mint font-mono border-b border-border/60 pb-2 pt-2">3. KONTAK & PEMBAYARAN</h4>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Nomor WhatsApp Panitia (ex: 08123...)</label>
                                    <input type="text" name="whatsapp_number" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent">
                                </div>
                                <div>
                                    <label class="block text-xs text-subtle mb-1">Informasi Bank (Bank - No Rek - Atas Nama)</label>
                                    <input type="text" name="bank_account" required class="w-full bg-canvas border border-border rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-accent" placeholder="BCA - 12345678 - Budi">
                                </div>
                            </div>
                        </div>

                        <!-- Custom Service / Layanan Tambahan -->
                        <div class="pt-4 border-t border-border/60">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-bold text-mint font-mono">4. LAYANAN TAMBAHAN (CUSTOM SERVICE)</h4>
                                <button type="button" onclick="addServiceField()" class="text-xs bg-canvas border border-border px-3 py-1.5 rounded-lg hover:border-accent text-white transition-all">+ Tambah Layanan</button>
                            </div>
                            <div id="servicesContainer" class="space-y-3">
                                <!-- JS akan memunculkan field di sini -->
                            </div>
                        </div>

                        <div class="pt-6 border-t border-border/60 flex justify-end gap-3">
                            <button type="button" onclick="document.getElementById('createEventModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-border text-subtle hover:text-white transition-colors">Batal</button>
                            <button type="submit" class="bg-accent hover:bg-red-500 text-white font-bold px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-accent/20">Publikasikan Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full border-t border-border/60 py-6 px-6 md:px-12 flex justify-between items-center text-xs font-mono text-subtle mt-auto">
        <p>© 2026 TiketKita SaaS. Dashboard Console.</p>
        <span class="text-mint">● Server Connected</span>
    </footer>

    <script>
        let serviceIndex = 0;
        function addServiceField() {
            const container = document.getElementById('servicesContainer');
            const html = `
                <div class="flex items-center gap-3 bg-canvas p-3 rounded-lg border border-border/50 relative" id="service_${serviceIndex}">
                    <div class="flex-grow">
                        <input type="text" name="custom_services[${serviceIndex}][name]" required class="w-full bg-transparent text-sm text-white focus:outline-none border-b border-border/50 pb-1 mb-2" placeholder="Nama Layanan (Contoh: VIP Fast Track)">
                        <input type="number" name="custom_services[${serviceIndex}][price]" required class="w-full bg-transparent text-sm text-white focus:outline-none" placeholder="Harga Layanan (Rp)">
                    </div>
                    <button type="button" onclick="document.getElementById('service_${serviceIndex}').remove()" class="text-accent hover:text-red-400 font-bold px-3 py-2 text-xl">&times;</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            serviceIndex++;
        }
    </script>

</body>
</html>
