# 🎨 LoketKita — Design System Roadmap & Action Items

Dokumen ini disusun sebagai panduan refactor antarmuka (UI/UX) dan perbaikan fungsional platform **LoketKita** berdasarkan prinsip-prinsip desain modern (Clean, Human, Tactile — bebas nuansa AI generik).

---

## 🏛️ Inspirasi & Referensi Design Systems

### 1. Material Design 3 (Google M3)
- **Key Concepts:**
  - Dynamic Color Tokens: `surface-container-lowest` (#0C0E13), `surface` (#111319), `primary-container` (#FF525E), `secondary` (#05C46B).
  - Tonal Elevation: Kedalaman visual tidak hanya mengandalkan shadow gelap, tapi pergantian tone container surface.
  - Expressive Shapes: Sudut membulat organik (pill shape 9999px untuk CTA utama, 24px untuk kartu/modal).

### 2. Apple Human Interface Guidelines (HIG)
- **Key Concepts:**
  - SF Pro Typography: Hierarchy ketat, letter spacing negatif rapat (`-0.02em` untuk headline, `-0.01em` untuk body), SF Mono strictly untuk data teknis.
  - Vibrancy & Materials: Translucent glassmorphism (`backdrop-blur-xl bg-surface/70 border-white/10`).
  - Tactile Feedback: Micro-interactions halus, state hover/active yang tegas tanpa animasi berlebihan.

### 3. Microsoft Fluent Design System
- **Key Concepts:**
  - Acrylic Material & Mica: Efek kaca lapis ganda dengan tekstur halus.
  - Light & Depth: Aksen pencahayaan radial lembut di background.
  - Conscious Spacing: Margin 8-pt grid system konsisten.

### 4. Ant Design (Enterprise UX)
- **Key Concepts:**
  - Data Clarity: Tabel padat, badge status eksplisit, action button langsung di row tabel.
  - Form Layout: Two-column responsive modal, validation error langsung di bawah field input.

---

## 🛠️ Checklist Perbaikan Bug & Tombol

- [x] **Filter Kategori Event:** Perbaikan query dari JSON nested ke kolom flat `category`.
- [x] **Database Seeding:** 5 dummy events lintas genre (Musik, Cosplay, Workshop) dengan UUID.
- [x] **Header CTA Button:** Tombol "Buat Event" mengarah ke register (guest) atau modal/request organizer (user).
- [x] **Hero CTA Button:** Tombol "Buat Event Sekarang 🚀" mengarah ke form request-organizer jika role user biasa.
- [x] **Auth Navigation:** Tambah tombol "← Kembali ke Katalog" di login & register.
- [x] **Custom Services:** Input array dinamis pada modal event baru tersimpan ke kolom JSON database.
- [ ] **Unifikasi Branding:** Menyamakan semua penyebutan "TiketKita" menjadi "LoketKita" di Dashboard Console dan Admin Console.
- [ ] **Tampilan Checkout / QRIS:** Pastikan modal invoice tiket pop-up mulus dan mengarah ke konfirmasi WhatsApp dengan auto-fill template pesan.

---

## 🎯 Panduan Style & Aturan Desain (Clean & Human)
1. **Hindari Elemen Klise AI:** Jangan gunakan border glow pelangi berlebihan atau teks marketing generik. Gunakan visual *tactile dark-mode* dengan kontras tinggi (Neon Red/Coral + Mint Green).
2. **Glassmorphism Elegan:** Gunakan `backdrop-blur-md` dengan border `rgba(255,255,255,0.08)`.
3. **Font Standard:** Gunakan `-apple-system, "SF Pro Display", "Inter"` sebagai font utama, dan `"JetBrains Mono"` khusus untuk harga, tanggal, kuota, dan kode tiket.
