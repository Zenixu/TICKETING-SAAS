<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Console — TiketKita</title>
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
            <div class="w-8 h-8 bg-accent text-canvas rounded-lg flex items-center justify-center font-black font-mono text-base">A</div>
            <span class="font-extrabold tracking-tight text-white">TiketKita<span class="text-accent">.</span></span>
            <span class="text-xs font-mono text-accent px-2 py-0.5 rounded bg-accent/10 border border-accent/20">SYSTEM ADMIN</span>
        </a>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-white">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-mono text-mint">ROLE: {{ strtoupper(Auth::user()->role) }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-mono text-subtle hover:text-accent border border-border hover:border-accent/40 bg-canvas px-3 py-1.5 rounded-lg transition-all">
                    Keluar 🚪
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-10 w-full space-y-10">
        
        <!-- Flash Alert -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-mint/10 border border-mint/30 text-mint text-xs font-mono">
                ✔ {{ session('success') }}
            </div>
        @endif

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Pengguna Terdaftar</span>
                <p class="text-3xl font-extrabold font-mono text-white">{{ $usersCount }}</p>
                <span class="text-[11px] font-mono text-subtle">Seluruh Role System</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Pending Approval Organizer</span>
                <p class="text-3xl font-extrabold font-mono text-accent">{{ $pendingOrganizers->count() }}</p>
                <span class="text-[11px] font-mono text-accent">Menunggu Persetujuan</span>
            </div>

            <div class="bg-surface p-6 rounded-xl hairline-border space-y-2">
                <span class="text-xs font-mono text-subtle uppercase">Total Event Dibuat</span>
                <p class="text-3xl font-extrabold font-mono text-white">{{ $eventsCount }}</p>
                <span class="text-[11px] font-mono text-mint">System Wide Events</span>
            </div>
        </div>

        <!-- Section 1: Pengajuan Organizer (Pending Approvals) -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-mono text-accent uppercase tracking-wider">// Pengajuan Organizer Event (Perlu Persetujuan)</h2>
            </div>

            <div class="bg-surface rounded-2xl hairline-border overflow-hidden">
                @if($pendingOrganizers->isEmpty())
                    <div class="p-8 text-center text-xs font-mono text-subtle">
                        Tidak ada pengajuan Organizer baru saat ini.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-canvas/50 text-xs font-mono text-subtle uppercase border-b border-border/60">
                                <tr>
                                    <th class="p-4">Nama User / Komunitas</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Tanggal Daftar</th>
                                    <th class="p-4 text-right">Aksi Persetujuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y border-border/40 text-subtle">
                                @foreach($pendingOrganizers as $user)
                                    <tr class="hover:bg-canvas/30 transition-colors">
                                        <td class="p-4 font-bold text-white">{{ $user->name }}</td>
                                        <td class="p-4 font-mono text-xs">{{ $user->email }}</td>
                                        <td class="p-4 font-mono text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="p-4 text-right space-x-2">
                                            <form method="POST" action="{{ route('admin.organizers.approve', $user->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-mint/10 border border-mint/30 text-mint hover:bg-mint hover:text-canvas text-xs font-bold rounded-lg transition-all">
                                                    Setujui (Approve) ✔
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.organizers.reject', $user->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-accent/10 border border-accent/30 text-accent hover:bg-accent hover:text-white text-xs font-bold rounded-lg transition-all">
                                                    Tolak ✖
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section 2: Manajemen Seluruh User & Role Assignment -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-mono text-subtle uppercase tracking-wider">// Kelola Seluruh Pengguna & Role</h2>
            </div>

            <div class="bg-surface rounded-2xl hairline-border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-canvas/50 text-xs font-mono text-subtle uppercase border-b border-border/60">
                            <tr>
                                <th class="p-4">Nama</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Role Saat Ini</th>
                                <th class="p-4">Status Organizer</th>
                                <th class="p-4 text-right">Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y border-border/40 text-subtle">
                            @foreach($allUsers as $user)
                                <tr class="hover:bg-canvas/30 transition-colors">
                                    <td class="p-4 font-bold text-white">{{ $user->name }}</td>
                                    <td class="p-4 font-mono text-xs">{{ $user->email }}</td>
                                    <td class="p-4 font-mono text-xs">
                                        @if($user->role === 'admin')
                                            <span class="px-2 py-0.5 rounded bg-accent/10 text-accent border border-accent/20">ADMIN</span>
                                        @elseif($user->role === 'organizer')
                                            <span class="px-2 py-0.5 rounded bg-mint/10 text-mint border border-mint/20">ORGANIZER</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-canvas text-subtle border border-border">USER BIASA</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-mono text-xs uppercase">{{ $user->organizer_status }}</td>
                                    <td class="p-4 text-right">
                                        <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}" class="inline-flex gap-2">
                                            @csrf
                                            <select name="role" class="bg-canvas border border-border text-xs text-white rounded-lg px-2 py-1 focus:outline-none focus:border-accent">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>USER</option>
                                                <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>ORGANIZER</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ADMIN</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-surface border border-border hover:border-white text-xs text-white rounded-lg transition-colors">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-border/60 py-6 px-6 md:px-12 flex justify-between items-center text-xs font-mono text-subtle">
        <p>© 2026 TiketKita SaaS. Admin Console Management.</p>
    </footer>

</body>
</html>
