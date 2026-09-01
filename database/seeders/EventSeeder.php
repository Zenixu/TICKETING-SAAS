<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan Dummy Organizer Exists
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@loketkita.com'],
            [
                'name' => 'Soundscape & Animetion Production',
                'password' => Hash::make('Password123!'),
                'role' => 'organizer',
                'organizer_status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // Organizer kedua
        $organizer2 = User::firstOrCreate(
            ['email' => 'studio@indiegigs.id'],
            [
                'name' => 'Indie Gigs Studio Bandung',
                'password' => Hash::make('Password123!'),
                'role' => 'organizer',
                'organizer_status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // 2. MUSIK: NOAH & Sheila On 7
        Event::updateOrCreate(
            ['title' => 'NOAH & SHEILA ON 7: Soundwave Fest 2026'],
            [
                'user_id' => $organizer->id,
                'description' => "Konser megah perayaan musik Indonesia menghadirkan NOAH, Sheila on 7, dan Maliq & D'Essentials dalam satu panggung spektakuler di GBK Senayan!\n\nLine up: NOAH, Sheila on 7, Maliq & D'Essentials, The Changcuters, Vierratale.\n\nInclude: Sound system line array premium, lighting konser 360°, multi-camera screen, area food court UMKM lokal.",
                'date_time' => now()->addDays(20)->setTime(18, 30),
                'location_name' => 'GBK Senayan Stadium, Jakarta Pusat',
                'status' => 'active',
                'price' => 350000,
                'quota' => 5000,
                'banner_path' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Musik',
                'whatsapp_number' => '628114073679',
                'bank_account' => 'BCA - 1234567890 - PT Soundscape Production',
                'custom_services' => [
                    ['name' => 'Parkir VIP', 'price' => 50000],
                    ['name' => 'Makanan & Minuman Premium', 'price' => 75000],
                ],
            ]
        );

        // 3. COSPLAY: Nippon Matsuri
        Event::updateOrCreate(
            ['title' => 'NIPPON MATSURI 2026: Cosplay & Animetion Fest'],
            [
                'user_id' => $organizer->id,
                'description' => "Festival budaya Jepang & Cosplay terbesar di Bandung! Menampilkan Guest Star Cosplayer Internasional, Lomba Coswalk, Anisong DJ Party, dan Stand Merch Official.\n\nGuest Star: Reika (Jepang), Haku (Thailand), Lomba Cosplay, Anime Song DJ Party, Bazaar Merch UMKM, Workshop Manga Drawing.",
                'date_time' => now()->addDays(35)->setTime(10, 0),
                'location_name' => 'Sabuga Convention Hall, Bandung',
                'status' => 'active',
                'price' => 45000,
                'quota' => 2000,
                'banner_path' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Cosplay',
                'whatsapp_number' => '628114073679',
                'bank_account' => 'BCA - 1234567890 - PT Soundscape Production',
                'custom_services' => [
                    ['name' => 'Standee Akrilik Exclusive', 'price' => 75000],
                    ['name' => 'Goodie Bag + Poster', 'price' => 50000],
                ],
            ]
        );

        // 4. MUSIK: Indie Gigs Studio (organizer 2)
        Event::updateOrCreate(
            ['title' => 'Sunset Indie Session Vol. 3'],
            [
                'user_id' => $organizer2->id,
                'description' => "Intimate gig session sore-sore di rooftop kota Bandung. Featuring 5 band indie lokal terbaik: Kunto Aji, Sal Priadi, Pamungkas, Nadin Amizah, dan Idgitaf.\n\nFormat: Acoustic + full band, panggung intimate (max 300 pax), dengan sunset view kota Bandung sebagai backdrop.",
                'date_time' => now()->addDays(12)->setTime(16, 0),
                'location_name' => 'Roof Top Hotel Savoy Homann, Bandung',
                'status' => 'active',
                'price' => 150000,
                'quota' => 300,
                'banner_path' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Musik',
                'whatsapp_number' => '6282212345678',
                'bank_account' => 'Mandiri - 9876543210 - Indie Gigs Studio',
                'custom_services' => [
                    ['name' => 'Merch Bundle (Tote bag + Sticker pack)', 'price' => 65000],
                ],
            ]
        );

        // 5. WORKSHOP: Workshop Manga Drawing
        Event::updateOrCreate(
            ['title' => 'Workshop Manga Drawing: From Sketch to Panel'],
            [
                'user_id' => $organizer2->id,
                'description' => "Workshop menggambar manga 1 hari penuh dengan mentor profesional dari Jepang. Peserta akan belajar teknik sketch, inking, screentone, hingga finalisasi panel manga.\n\nTermasuk: Modul cetak, alat gambar (pen, marker, screentone), makan siang, dan e-certificate.",
                'date_time' => now()->addDays(45)->setTime(9, 0),
                'location_name' => 'Creative Hub SCBD, Jakarta Selatan',
                'status' => 'active',
                'price' => 250000,
                'quota' => 50,
                'banner_path' => 'https://images.unsplash.com/photo-1607457561901-e6ec3a6d16cf?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Workshop',
                'whatsapp_number' => '6282212345678',
                'bank_account' => 'Mandiri - 9876543210 - Indie Gigs Studio',
                'custom_services' => null,
            ]
        );

        // 6. MUSIK: EDM Festival
        Event::updateOrCreate(
            ['title' => 'WEEKEND FEST 2026: EDM & House Music'],
            [
                'user_id' => $organizer->id,
                'description' => "Festival EDM tahunan terbesar di Indonesia! Featuring DJ Internasional: Martin Garrix, Zedd, dan Tiesto. Line up 20+ DJ lokal dan internasional.\n\nPanggung utama outdoor dengan kapasitas 20.000 pax, multi-stage area, food & beverage district, camping ground, dan instalasi seni cahaya.",
                'date_time' => now()->addDays(60)->setTime(16, 0),
                'location_name' => 'Carnaval Beach Ancol, Jakarta Utara',
                'status' => 'active',
                'price' => 850000,
                'quota' => 20000,
                'banner_path' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Musik',
                'whatsapp_number' => '628114073679',
                'bank_account' => 'BCA - 1234567890 - PT Soundscape Production',
                'custom_services' => [
                    ['name' => 'Camping Pass (2D1N)', 'price' => 250000],
                    ['name' => 'Locker Premium', 'price' => 80000],
                    ['name' => 'Welcome Drink + Glow Stick Pack', 'price' => 35000],
                ],
            ]
        );
    }
}
