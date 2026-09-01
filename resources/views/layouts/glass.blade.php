{{-- 
    Layout: Glassmorphism base untuk halaman dengan Tailwind CDN.
    Pakai: @extends('layouts.glass') ... @section('content') ... @endsection
    Variable: $title (optional), $showHeader (default true)
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'TiketKita') — TiketKita</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "canvas":        "#0C0E13",
                        "surface-1":     "#111319",
                        "surface-2":     "#1D2025",
                        "surface-3":     "#282A30",
                        "hairline":      "rgba(255,255,255,0.08)",
                        "coral":         "#FF525E",
                        "coral-hover":   "#ff3847",
                        "mint":          "#05C46B",
                        "mint-hover":    "#04b05f",
                        "text-primary":  "#E2E2EA",
                        "text-muted":    "#8891A5",
                        "text-dim":      "#4B5563",
                    },
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"SF Pro Text"', '"Inter"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    borderRadius: {
                        "glass": "1.25rem",
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    <style>
        html, body {
            background-color: #0C0E13;
            color: #E2E2EA;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Display", "Inter", sans-serif;
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.011em;
        }
        ::-webkit-scrollbar { display: none; }

        /* === Glassmorphism primitives === */
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

        .num { font-family: "JetBrains Mono", ui-monospace, monospace; font-variant-numeric: tabular-nums; }

        .field {
            background: rgba(12, 14, 19, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #E2E2EA;
            transition: border-color 180ms, box-shadow 180ms;
        }
        .field:focus {
            outline: none;
            border-color: rgba(255, 82, 94, 0.6);
            box-shadow: 0 0 0 3px rgba(255, 82, 94, 0.12);
        }
        .field::placeholder { color: #4B5563; }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    @if($showHeader ?? true)
    {{-- HEADER --}}
    <header class="sticky top-0 z-40 glass hairline-b">
        <div class="h-16 md:h-20 w-full px-4 md:px-8 xl:px-12 flex items-center justify-between gap-4 max-w-[1440px] mx-auto">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 shrink-0 group">
                <div class="w-9 h-9 md:w-10 md:h-10 glass rounded-xl flex items-center justify-center font-black text-coral text-lg group-hover:border-coral/40 transition-colors">
                    T
                </div>
                <span class="text-base md:text-lg font-bold text-text-primary tracking-tight">
                    TiketKita<span class="text-coral">.com</span>
                </span>
            </a>

            <nav class="flex items-center gap-2 md:gap-3">
                <a href="{{ route('my-tickets') }}" class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-text-muted hover:text-text-primary transition-colors px-3 py-2 rounded-full">
                    <span class="material-symbols-outlined text-[16px]">confirmation_number</span>
                    Tiket Saya
                </a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a class="text-xs font-semibold text-coral glass-pill px-4 py-2 rounded-full hover:border-coral/40 transition-colors" href="{{ route('admin.index') }}">
                            Admin Console
                        </a>
                    @elseif(Auth::user()->role === 'organizer')
                        <a class="text-xs font-semibold text-text-primary glass-pill px-4 py-2 rounded-full hover:border-white/20 transition-colors" href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    @else
                        <form method="POST" action="{{ route('request-organizer') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-text-primary glass-pill px-4 py-2 rounded-full hover:border-white/20 transition-colors">
                                Buat Event
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('my-tickets') }}" class="sm:hidden flex items-center justify-center w-9 h-9 glass-pill rounded-full">
                        <span class="material-symbols-outlined text-[18px]">confirmation_number</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-text-muted hover:text-coral transition-colors px-2">
                            Keluar
                        </button>
                    </form>
                @else
                    <a class="text-xs font-medium text-text-muted hover:text-text-primary transition-colors px-2" href="{{ route('login') }}">Masuk</a>
                    <a class="text-xs font-medium text-text-muted hover:text-text-primary transition-colors px-2 hidden sm:inline" href="{{ route('register') }}">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>
    @endif

    {{-- FLASH MESSAGE --}}
    @if(session('success') || session('error') || session('info'))
        <div class="fixed top-20 sm:top-24 left-1/2 -translate-x-1/2 z-50 max-w-md w-[90%] sm:w-auto px-4">
            @if(session('success'))
                <div class="glass-strong rounded-2xl px-5 py-3.5 flex items-center gap-3 border-mint/30">
                    <span class="material-symbols-outlined text-mint text-xl">check_circle</span>
                    <p class="text-sm font-medium text-text-primary flex-1">{{ session('success') }}</p>
                </div>
            @elseif(session('error'))
                <div class="glass-strong rounded-2xl px-5 py-3.5 flex items-center gap-3 border-coral/30">
                    <span class="material-symbols-outlined text-coral text-xl">error</span>
                    <p class="text-sm font-medium text-text-primary flex-1">{{ session('error') }}</p>
                </div>
            @elseif(session('info'))
                <div class="glass-strong rounded-2xl px-5 py-3.5 flex items-center gap-3 border-white/20">
                    <span class="material-symbols-outlined text-text-primary text-xl">info</span>
                    <p class="text-sm font-medium text-text-primary flex-1">{{ session('info') }}</p>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="hairline-t py-6 px-4 sm:px-8 text-center">
        <p class="text-[11px] text-text-dim font-mono">
            &copy; 2026 TiketKita — Built with care · 0% commission · <a href="{{ route('welcome') }}" class="hover:text-coral transition-colors">Beranda</a>
        </p>
    </footer>

</body>
</html>
