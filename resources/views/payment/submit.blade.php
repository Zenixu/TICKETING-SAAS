@extends('layouts.glass')

@section('title', 'Upload Bukti Bayar — ' . $event->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-6">

    {{-- Back link --}}
    <div>
        <a href="{{ route('my-tickets') }}" class="press text-xs text-text-muted hover:text-text-primary inline-flex items-center gap-1 transition-colors">
            <span class="material-symbols-outlined text-[14px]">arrow_back</span>
            Kembali ke Tiket Saya
        </a>
    </div>

    {{-- Header --}}
    <header class="space-y-1">
        <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-coral">Konfirmasi Pembayaran</p>
        <h1 class="text-2xl sm:text-3xl font-bold text-text-primary tracking-tight">{{ $event->title }}</h1>
        <p class="text-sm text-text-muted">Upload bukti transfer Anda untuk menyelesaikan pendaftaran.</p>
    </header>

    {{-- Payment Info Event --}}
    <div class="glass-strong rounded-2xl p-5 sm:p-6 space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Total Tagihan</span>
            <span class="material-symbols-outlined text-coral text-[20px]">payments</span>
        </div>
        <div class="text-3xl sm:text-4xl font-bold text-text-primary num tracking-tight">
            Rp {{ number_format($event->price, 0, ',', '.') }}
        </div>
        @if($event->bank_account)
        <div class="hairline-t pt-3 space-y-1.5">
            <p class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted">Transfer ke</p>
            <pre class="text-xs text-text-primary font-mono whitespace-pre-wrap leading-relaxed">{{ $event->bank_account }}</pre>
        </div>
        @endif
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('payment.submit', $attendee->id) }}" enctype="multipart/form-data" class="glass rounded-2xl p-5 sm:p-7 space-y-5">
        @csrf

        <div class="space-y-2">
            <h2 class="text-base font-semibold text-text-primary tracking-tight flex items-center gap-2">
                <span class="material-symbols-outlined text-mint text-[18px]">upload_file</span>
                Data Transfer
            </h2>
            <p class="text-xs text-text-muted">Lengkapi data di bawah ini dengan informasi transfer yang sebenarnya.</p>
        </div>

        {{-- Amount (pre-filled) --}}
        <div>
            <label for="amount" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Nominal Transfer</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted text-sm font-mono">Rp</span>
                <input type="number" id="amount" name="amount" value="{{ old('amount', $event->price) }}" min="1" required
                    class="w-full field pl-12 font-mono num" />
            </div>
            @error('amount')<p class="text-xs text-coral mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Bank Name --}}
        <div>
            <label for="bank_name" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Bank Pengirim</label>
            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                placeholder="BCA, Mandiri, BNI, dll" maxlength="100" required class="w-full field" />
            @error('bank_name')<p class="text-xs text-coral mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Account Holder --}}
        <div>
            <label for="account_holder_name" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Nama Pengirim <span class="text-text-dim font-normal">(opsional)</span></label>
            <input type="text" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name') }}"
                placeholder="Nama pemilik rekening" maxlength="255" class="w-full field" />
        </div>

        {{-- Transfer Date --}}
        <div>
            <label for="transfer_date" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Tanggal Transfer</label>
            <input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}"
                max="{{ date('Y-m-d') }}" required class="w-full field" />
            @error('transfer_date')<p class="text-xs text-coral mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Notes --}}
        <div>
            <label for="notes" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Catatan <span class="text-text-dim font-normal">(opsional)</span></label>
            <textarea id="notes" name="notes" rows="2" maxlength="500" placeholder="Pesan tambahan untuk penyelenggara"
                class="w-full field resize-none">{{ old('notes') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div>
            <label for="image" class="text-[10px] font-mono font-bold uppercase tracking-wider text-text-muted block mb-2">Bukti Transfer <span class="text-coral">*</span></label>
            <div class="relative">
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required
                    class="block w-full text-xs text-text-primary file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-mint file:text-canvas hover:file:opacity-90 file:cursor-pointer cursor-pointer glass rounded-xl" />
            </div>
            <p class="text-[10px] font-mono text-text-dim mt-1.5">JPG/PNG/WEBP · Maks 2MB</p>
            @error('image')<p class="text-xs text-coral mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Submit --}}
        <div class="flex flex-col-reverse sm:flex-row gap-2 pt-2">
            <a href="{{ route('my-tickets') }}" class="press flex-1 text-center glass-pill text-text-muted hover:text-text-primary px-5 py-2.5 text-sm font-semibold rounded-full transition-colors">
                Nanti Saja
            </a>
            <button type="submit" class="press flex-1 bg-coral text-white font-semibold px-5 py-2.5 text-sm rounded-full transition-colors hover:bg-coral/90 inline-flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Kirim Bukti Pembayaran
            </button>
        </div>
    </form>

    {{-- Info --}}
    <div class="glass rounded-2xl p-4 sm:p-5 flex gap-3">
        <span class="material-symbols-outlined text-mint text-[20px] shrink-0 mt-0.5">info</span>
        <div class="text-xs text-text-muted leading-relaxed space-y-1">
            <p>Bukti pembayaran akan diverifikasi oleh penyelenggara dalam <strong class="text-text-primary">maksimal 1x24 jam</strong>.</p>
            <p>Setelah diverifikasi, status tiket Anda akan berubah menjadi <strong class="text-mint">Terdaftar</strong> dan siap untuk di-check-in saat hari H.</p>
        </div>
    </div>

</div>
@endsection
