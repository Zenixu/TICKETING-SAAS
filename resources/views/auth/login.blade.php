<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — TiketKita</title>
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
            background-image: radial-gradient(circle at 50% 30%, rgba(255, 71, 87, 0.04) 0%, transparent 50%);
        }
        .hairline-border {
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="w-full max-w-md bg-surface p-8 rounded-2xl hairline-border shadow-2xl space-y-8">
        
        <!-- Header -->
        <div class="space-y-2 text-center">
            <a href="/" class="inline-flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-accent text-canvas rounded-lg flex items-center justify-center font-black font-mono text-lg">T</div>
                <span class="font-extrabold text-white text-lg tracking-tight">TiketKita<span class="text-accent">.</span></span>
            </a>
            <h1 class="text-2xl font-bold text-white tracking-tight">Masuk ke Portal</h1>
            <p class="text-xs text-subtle font-mono">PANITIA & ORGANIZER EVENT</p>
        </div>

        <!-- Error Alert -->
        @if($errors->any())
            <div class="p-4 rounded-xl bg-accent/10 border border-accent/30 text-accent text-xs font-mono">
                ⚠ {{ $errors->first() }}
            </div>
        @endif

        <!-- Google OAuth CTA (Utama & Minimalis) -->
        <div class="space-y-3">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-100 text-canvas font-bold py-3.5 px-4 rounded-xl transition-all text-sm font-sans shadow-lg shadow-white/5">
                <!-- Google Icon SVG -->
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.18 1-.78 1.85-1.63 2.42v2.01h2.64c1.54-1.42 2.43-3.5 2.43-5.93z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-2.64-2.01c-.73.49-1.66.78-2.64.78-2.83 0-5.22-1.91-6.07-4.49H1.15v2.07C2.97 20.24 7.16 23 12 23z" fill="#34A853"/>
                    <path d="M5.93 14.62c-.22-.66-.35-1.37-.35-2.12s.13-1.46.35-2.12V8.31H1.15C.41 9.81 0 11.48 0 13s.41 3.19 1.15 4.69l4.78-2.07z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.16 1 2.97 3.76 1.15 7.31l4.78 2.07c.85-2.58 3.24-4.49 6.07-4.49z" fill="#EA4335"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>
            
            <div class="relative flex items-center justify-center py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border/60"></div>
                </div>
                <span class="relative bg-surface px-4 text-[10px] font-mono text-subtle uppercase">Atau gunakan email</span>
            </div>
        </div>

        <!-- Form Manual (Kini Berada di Bawah) -->
        <form method="POST" action="/login" class="space-y-5">
            @csrf
            
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-mono text-subtle uppercase tracking-wider">Email Organizer</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full bg-canvas border border-border rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-colors font-sans placeholder:text-subtle/40"
                    placeholder="nama@komunitas.com"
                    required
                >
            </div>

            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-mono text-subtle uppercase tracking-wider">Kata Sandi</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full bg-canvas border border-border rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-accent transition-colors font-sans placeholder:text-subtle/40"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="w-full bg-surface border border-border hover:border-white text-white font-bold py-3 px-4 rounded-xl transition-all text-xs font-mono uppercase tracking-wider">
                Masuk Manual
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center text-xs text-subtle font-mono pt-4 border-t border-border/60">
            Belum punya akun? <a href="/register" class="text-white hover:text-accent transition-colors underline underline-offset-4">Daftar Komunitas</a>
        </div>

    </div>

</body>
</html>
