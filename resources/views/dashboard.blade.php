<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panitia — TiketKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "canvas":       "#0C0E13",
                        "surface-1":    "#111319",
                        "surface-2":    "#1D2025",
                        "surface-3":    "#282A30",
                        "hairline":     "rgba(255,255,255,0.08)",
                        "coral":        "#FF525E",
                        "coral-hover":  "#ff3847",
                        "mint":         "#05C46B",
                        "mint-hover":   "#04b05f",
                        "text-primary": "#E2E2EA",
                        "text-muted":   "#8891A5",
                        "text-dim":     "#4B5563",
                    },
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"SF Pro Text"', '"Inter"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        html, body {
            background-color: #0C0E13;
            color: #E2E2EA;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", "Inter", sans-serif;
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.011em;
        }
        ::-webkit-scrollbar { display: none; }

        /* === Glassmorphism primitives (sync dengan welcome.blade.php) === */
        .glass {
            background: rgba(17, 19, 25, 0.55);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.06),
                0 8px 32px rgba(0, 0, 0, 0.32);
        }
        .glass-strong {
            background: rgba(29, 32, 37, 0.78);
            backdrop-filter: blur(24px) saturate(150%);
            -webkit-backdrop-filter: blur(24px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.08),
                0 20px 60px rgba(0, 0, 0, 0.45);
        }
        .glass-pill {
            background: rgba(29, 32, 37, 0.6);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .hairline-b { border-bottom: 1px solid rgba(255, 255, 255, 0.06); }
        .hairline-t { border-top: 1px solid rgba(255, 255, 255, 0.06); }

        .press { transition: transform 180ms cubic-bezier(0.16, 1, 0.3, 1); }
        .press:active { transform: translateY(1px) scale(0.985); }

        @keyframes livepulse {
            0%   { box-shadow: 0 0 0 0 rgba(5, 196, 107, 0.5); }
            70%  { box-shadow: 0 0 0 8px rgba(5, 196, 107, 0); }
            100% { box-shadow: 0 0 0 0 rgba(5, 196, 107, 0); }
        }
        .live-dot { animation: livepulse 2.2s infinite; }

        .num { font-family: "JetBrains Mono", ui-monospace, monospace; font-variant-numeric: tabular-nums; }

        /* Form input treatment — surface lebih dalam saat focus */
        .field {
            background: rgba(12, 14, 19, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #E2E2EA;
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            width: 100%;
            transition: border-color 180ms ease, background-color 180ms ease;
        }
        .field:focus {
            outline: none;
            border-color: rgba(255, 82, 94, 0.55);
            background: rgba(12, 14, 19, 0.85);
        }
        .field::placeholder { color: #4B5563; }

        /* Table row hairline */
        .row-hairline > * + * { border-left: 1px solid rgba(255, 255, 255, 0.04); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- =========== HEADER =========== -->
    <header class="sticky top-0 z-40 glass hairline-b">
        <div class="h-16 md:h-20 w-full px-4 md:px-8 xl:px-12 flex items-center justify-between gap-4 max-w-[1440px] mx-auto">
            <a href="/" class="flex items-center gap-2.5 shrink-0 group">
                <div class="w-9 h-9 md:w-10 md:h-10 glass rounded-xl flex items-center justify-center font-black text-coral text-lg group-hover:border-coral/40 transition-colors">
                    T
                </div>
                <span class="text-base md:text-lg font-bold text-text-primary tracking-tight">
                    TiketKita<span class="text-coral">.com</span>
                </span>
                <span class="hidden sm:inline-block glass-pill text-coral text-[10px] font-mono font-bold uppercase tracking-wider px-2.5 py-1">
                    Console
                </span>
            </a>

            <div class="flex items-center gap-3 md:gap-4">
                <a href="/" class="hidden sm:inline-flex items-center gap-1.5 text-xs text-text-muted hover:text-text-primary transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    Lihat Katalog
                </a>
                <div class="text-right hidden md:block">
                    <p class="text-xs font-semibold text-text-primary">{{ Auth::user()->name ?? 'Organizer' }}</p>
                    <p class="text-[10px] text-text-muted num">{{ Auth::user()->email ?? 'admin@komunitas.com' }}</p>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" class="text-[10px] text-coral hover:underline font-mono">Admin Console →</a>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="press glass-pill text-text-muted hover:text-coral hover:border-coral/40 text-xs font-mono font-semibold px-3.5 py-2 transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- =========== MAIN =========== -->
    <main class="flex-1 w-full max-w-[1440px] mx-auto px-4 md:px-8 xl:px-12 py-8 md:py-10 space-y-6 md:space-y-8">

        @if(session('success'))
            <div class="glass rounded-xl p-4 border-mint/40 flex items-start gap-3">
                <span class="material-symbols-outlined text-mint text-[20px]">check_circle</span>
                <div>
                    <p class="text-sm font-semibold text-mint">Berhasil</p>
                    <p class="text-xs text-text-muted">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="glass rounded-xl p-4 border-coral/40 flex items-start gap-3">
                <span class="material-symbols-outlined text-coral text-[20px]">error</span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-coral">Gagal memproses</p>
                    <ul class="text-xs text-text-muted mt-1 space-y-0.5 list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- =========== WELCOME BANNER =========== -->
        <section class="glass-strong rounded-[20px] p-6 sm:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 text-[10px] font-mono font-bold uppercase tracking-wider text-mint">
                    <span class="w-1.5 h-1.5 rounded-full bg-mint live-dot"></span>
                    Active Event License
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-text-primary tracking-tight">
                    Panel Event Komunitas
                </h1>
                <p class="text-sm text-text-muted max-w-xl">
                    Ringkasan statistik tiket, check-in, dan penjualan lisensi event kamu.
                </p>
            </div>
            <button onclick="openEventModal()" class="press bg-coral hover:bg-coral-hover text-white font-semibold px-5 py-3 rounded-full text-sm flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Event Baru
            </button>
        </section>

        <!-- =========== BENTO METRIC GRID =========== -->
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">

            <div class="glass rounded-2xl p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Event Ditayangkan</span>
                    <span class="material-symbols-outlined text-coral text-[20px]">event</span>
                </div>
                <div class="text-3xl font-bold text-text-primary num tracking-tight">
                    {{ $totalEvents ?? 0 }}
                </div>
                <span class="text-[10px] font-mono text-mint">Event tersedia</span>
            </div>

            <div class="glass rounded-2xl p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Peserta Terdaftar</span>
                    <span class="material-symbols-outlined text-mint text-[20px]">group</span>
                </div>
                <div class="text-3xl font-bold text-text-primary num tracking-tight">
                    {{ $totalAttendees ?? 0 }}
                </div>
                <span class="text-[10px] font-mono text-text-muted">Dari semua event</span>
            </div>

            <div class="glass rounded-2xl p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Check-in Berhasil</span>
                    <span class="material-symbols-outlined text-mint text-[20px]">qr_code_scanner</span>
                </div>
                <div class="text-3xl font-bold text-text-dim num tracking-tight">0</div>
                <span class="text-[10px] font-mono text-text-dim">Dalam pengembangan</span>
            </div>

            <div class="glass rounded-2xl p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Sertifikat Terbit</span>
                    <span class="material-symbols-outlined text-coral text-[20px]">verified</span>
                </div>
                <div class="text-3xl font-bold text-text-dim num tracking-tight">0</div>
                <span class="text-[10px] font-mono text-text-dim">Dalam pengembangan</span>
            </div>

        </section>

        <!-- =========== EVENT TABLE =========== -->
        <section class="space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-sm font-mono font-bold text-text-muted uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">list_alt</span>
                    Daftar Event Terkini
                </h2>
                <span class="text-[11px] font-mono text-text-muted">
                    Total: <span class="text-text-primary font-bold num">{{ $totalEvents ?? 0 }}</span> event
                </span>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm min-w-[720px]">
                        <thead class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">
                            <tr class="hairline-b">
                                <th class="p-4">Event</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Tanggal &amp; Waktu</th>
                                <th class="p-4">Lokasi</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($events) && $events->count() > 0)
                                @foreach($events as $event)
                                    <tr class="hairline-b hover:bg-white/[0.02] transition-colors">
                                        <td class="p-4">
                                            <p class="font-semibold text-text-primary tracking-tight">{{ $event->title }}</p>
                                            <p class="text-[10px] font-mono text-text-dim mt-0.5 num">{{ Str::limit($event->id, 18, '') }}</p>
                                        </td>
                                        <td class="p-4">
                                            <span class="glass-pill text-coral text-[10px] font-mono font-bold uppercase tracking-wider px-2.5 py-1">
                                                {{ $event->category ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-xs text-text-muted num whitespace-nowrap">
                                            {{ $event->date_time->format('d M Y, H:i') }} WIB
                                        </td>
                                        <td class="p-4 text-xs text-text-muted">
                                            {{ $event->location_name }}
                                        </td>
                                        <td class="p-4 text-sm font-semibold text-text-primary num whitespace-nowrap">
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('events.public-show', $event->id) }}" class="press glass-pill text-text-muted hover:text-text-primary hover:border-white/20 px-3 py-1.5 text-xs font-semibold rounded-full transition-colors flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">visibility</span>
                                                    Detail
                                                </a>
                                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini? Tindakan tidak dapat dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="press glass-pill text-coral hover:bg-coral hover:text-white hover:border-coral px-3 py-1.5 text-xs font-semibold rounded-full transition-colors flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-[14px]">delete</span>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="p-12 text-center">
                                        <span class="material-symbols-outlined text-text-dim text-5xl">event_busy</span>
                                        <p class="text-text-muted mt-3 text-sm">Belum ada event yang dibuat.</p>
                                        <button onclick="openEventModal()" class="press mt-4 inline-flex items-center gap-1.5 glass-pill text-coral hover:border-coral/40 px-4 py-2 rounded-full text-xs font-semibold transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">add</span>
                                            Buat event pertama
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    <!-- =========== FOOTER =========== -->
    <footer class="w-full glass hairline-t py-6 px-4 md:px-8 xl:px-12 mt-6">
        <div class="max-w-[1440px] mx-auto flex flex-col sm:flex-row justify-between items-center gap-3 text-center sm:text-left">
            <p class="text-xs text-text-muted">
                © 2026 TiketKita SaaS. Dashboard Console.
            </p>
            <div class="flex items-center gap-2 text-[10px] font-mono font-bold text-mint uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-mint live-dot"></span>
                Server Connected
            </div>
        </div>
    </footer>

    <!-- =========== MODAL: BUAT EVENT =========== -->
    <div id="createEventModal" class="fixed inset-0 z-[100] hidden bg-black/70 backdrop-blur-md overflow-y-auto w-full h-full flex items-start justify-center p-4">
        <div class="relative w-full max-w-3xl my-6">
            <div class="glass-strong rounded-[20px] flex flex-col overflow-hidden max-h-[calc(100vh-3rem)]">

                <div class="flex justify-between items-center p-5 sm:p-6 hairline-b shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-text-primary">Buat Event Baru</h3>
                        <p class="text-xs text-text-muted mt-0.5">Publikasikan event kamu ke katalog publik.</p>
                    </div>
                    <button onclick="closeEventModal()" class="press w-9 h-9 flex items-center justify-center rounded-full glass-pill text-text-muted hover:text-coral hover:border-coral/40 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('events.store') }}" method="POST" class="flex flex-col flex-1 min-h-0">
                    @csrf
                    <div class="p-5 sm:p-6 space-y-6 overflow-y-auto flex-1">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="space-y-4">
                            <h4 class="text-[11px] font-mono font-bold text-mint uppercase tracking-wider hairline-b pb-2">1. Informasi Umum</h4>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Nama event</label>
                                <input type="text" name="title" required class="field" placeholder="Contoh: Anime Fest 2026">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Kategori</label>
                                <select name="category" class="field">
                                    <option value="Musik">Musik &amp; Konser</option>
                                    <option value="Cosplay">Cosplay &amp; Jejepangan</option>
                                    <option value="Workshop">Workshop &amp; Kelas</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Deskripsi lengkap</label>
                                <textarea name="description" required rows="4" class="field resize-none"></textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">URL banner / poster <span class="text-text-dim">(opsional)</span></label>
                                <input type="url" name="banner_path" class="field" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-[11px] font-mono font-bold text-mint uppercase tracking-wider hairline-b pb-2">2. Jadwal &amp; Tiket</h4>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Waktu pelaksanaan</label>
                                <input type="datetime-local" name="date_time" required class="field">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Lokasi event</label>
                                <input type="text" name="location_name" required class="field" placeholder="Contoh: Sabuga Convention Hall, Bandung">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Harga tiket (Rp)</label>
                                    <input type="number" name="price" value="0" min="0" required class="field">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Kuota maksimal</label>
                                    <input type="number" name="quota" value="100" min="1" required class="field">
                                </div>
                            </div>

                            <h4 class="text-[11px] font-mono font-bold text-mint uppercase tracking-wider hairline-b pb-2 pt-2">3. Kontak &amp; Pembayaran</h4>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">WhatsApp panitia</label>
                                <input type="text" name="whatsapp_number" required class="field num" placeholder="08123xxx">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-text-muted mb-1.5">Info bank <span class="text-text-dim">(Bank - No Rek - Atas Nama)</span></label>
                                <input type="text" name="bank_account" required class="field" placeholder="BCA - 12345678 - Budi">
                            </div>
                        </div>
                    </div>

                    <div class="hairline-t pt-5">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-[11px] font-mono font-bold text-mint uppercase tracking-wider">4. Layanan Tambahan (Add-ons)</h4>
                            <button type="button" onclick="addServiceField()" class="press glass-pill text-mint hover:border-mint/40 px-3 py-1.5 text-xs font-semibold rounded-full transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">add</span>
                                Tambah Layanan
                            </button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="hairline-t hairline-b-0 p-5 sm:p-6 flex flex-col-reverse sm:flex-row justify-end gap-3 shrink-0 bg-surface-2/30">
                        <button type="button" onclick="closeEventModal()" class="press glass-pill text-text-muted hover:text-text-primary hover:border-white/20 px-5 py-2.5 text-sm font-semibold rounded-full transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="press bg-coral hover:bg-coral-hover text-white font-semibold px-6 py-2.5 text-sm rounded-full transition-colors flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">publish</span>
                            Publikasikan Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== Modal control =====
        const eventModal = document.getElementById('createEventModal');
        function openEventModal() {
            eventModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeEventModal() {
            eventModal.classList.add('hidden');
            document.body.style.overflow = '';
        }
        eventModal.addEventListener('click', function (e) {
            if (e.target === this) closeEventModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeEventModal();
        });

        // ===== Dynamic service fields =====
        let serviceIndex = 0;
        function addServiceField() {
            const container = document.getElementById('servicesContainer');
            const id = `service_${serviceIndex}`;
            const html = `
                <div class="glass-pill rounded-xl p-3 flex items-start gap-3" id="${id}">
                    <div class="flex-1 space-y-2">
                        <input type="text" name="custom_services[${serviceIndex}][name]" required
                               class="w-full bg-transparent text-sm text-text-primary focus:outline-none border-b border-white/10 pb-1.5 placeholder:text-text-dim"
                               placeholder="Nama layanan (Contoh: VIP Fast Track)">
                        <input type="number" name="custom_services[${serviceIndex}][price]" required
                               class="w-full bg-transparent text-sm text-text-primary focus:outline-none num placeholder:text-text-dim"
                               placeholder="Harga layanan (Rp)">
                    </div>
                    <button type="button" onclick="document.getElementById('${id}').remove()"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full text-text-muted hover:text-coral hover:bg-coral/10 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            serviceIndex++;
        }
    </script>
</body>
</html>
