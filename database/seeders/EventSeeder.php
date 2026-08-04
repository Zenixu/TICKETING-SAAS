<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Organizer Contoh
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@loketkita.com'],
            [
                'name' => 'Soundscape Indonesia Production',
                'password' => Hash::make('Organizer123!@#'),
                'role' => 'organizer',
                'organizer_status' => 'approved',
            ]
        );

        // 2. Clear Dummy Event Lama
        Event::truncate();

        // 3. Buat Dummy Events ala LOKET.COM (Konser, Workshop, Festival, Standup)
        
        // Event 1: Konser Musik Fest
        Event::create([
            'user_id' => $organizer->id,
            'title' => 'NOAH & SHEILA ON 7: Soundwave Fest 2026 Jakarta',
            'description' => 'Konser megah perayaan musik Indonesia menghadirkan NOAH, Sheila on 7, dan Maliq & D\'Essentials dalam satu panggung spektakuler! Nikmati pengalaman audio visual kelas dunia.',
            'date_time' => now()->addDays(14)->setTime(19, 0),
            'location_name' => 'GBK Senayan Stadium, Jakarta Pusat',
            'status' => 'active',
            'price' => 350000.00, // Harga mulai dari Regular
            'quota' => 5000,
            'material_links' => [
                'banner_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Konser Musik',
                'ticket_types' => [
                    [
                        'name' => 'REGULAR - FESTIVAL (Standing)',
                        'price' => 350000,
                        'quota' => 3000,
                        'description' => 'Akses area berdiri Festival B, pintu masuk gate 3'
                    ],
                    [
                        'name' => 'VIP - FRONT STAGE (Free Seating)',
                        'price' => 750000,
                        'quota' => 1500,
                        'description' => 'Akses area khusus depan panggung, lanyard eksklusif, & snack box'
                    ],
                    [
                        'name' => 'VVIP - MEET & GREET (Numbered Seating)',
                        'price' => 1500000,
                        'quota' => 500,
                        'description' => 'Akses kursi bernomor terdepan, foto bersama artis, merchandise pack & Fast Track Gate'
                    ]
                ]
            ]
        ]);

        // Event 2: Tech Conference
        Event::create([
            'user_id' => $organizer->id,
            'title' => 'Indonesia AI & Tech Summit 2026',
            'description' => 'Konferensi teknologi terbesar tahun ini! Pelajari tren Generative AI, Cloud Native, & Software Engineering dari 15+ pembicara kelas internasional dari Google, GoTo, & Tokopedia.',
            'date_time' => now()->addDays(20)->setTime(9, 0),
            'location_name' => 'Jakarta Convention Center (JCC) Hall A',
            'status' => 'active',
            'price' => 150000.00,
            'quota' => 800,
            'material_links' => [
                'banner_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Konferensi & Seminar',
                'ticket_types' => [
                    [
                        'name' => 'EARLY BIRD - Student Pass',
                        'price' => 150000,
                        'quota' => 200,
                        'description' => 'Akses 2 hari seminar + Sertifikat Digital (Wajib Kartu Tanda Mahasiswa)'
                    ],
                    [
                        'name' => 'PROFESSIONAL PASS',
                        'price' => 450000,
                        'quota' => 500,
                        'description' => 'Akses penuh seminar, Networking Lunch, & Slide Materi Pembicara'
                    ]
                ]
            ]
        ]);

        // Event 3: Standup Comedy Tour
        Event::create([
            'user_id' => $organizer->id,
            'title' => 'Raditya Dika Tour: "Masa Depan" Live in Bandung',
            'description' => 'Pertunjukan tunggal Standup Comedy Raditya Dika. Durasi 2 jam penuh tawa membahas kehidupan, pernikahan, dan komedi absurd harian.',
            'date_time' => now()->addDays(30)->setTime(20, 0),
            'location_name' => 'Sabuga Convention Hall, Bandung',
            'status' => 'active',
            'price' => 200000.00,
            'quota' => 1200,
            'material_links' => [
                'banner_url' => 'https://images.unsplash.com/photo-1585699324551-f6c309eedeca?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Hiburan & Komedi',
                'ticket_types' => [
                    [
                        'name' => 'TRIBUN ATAS',
                        'price' => 200000,
                        'quota' => 600,
                        'description' => 'Akses tempat duduk tribun atas, pandangan bebas ke panggung'
                    ],
                    [
                        'name' => 'VIP UTAMA (Lantai Bawah)',
                        'price' => 500000,
                        'quota' => 600,
                        'description' => 'Akses tempat duduk terdekat panggung + Poster bertandatangan'
                    ]
                ]
            ]
        ]);

        // Event 4: Workshop / Meetup Komunitas
        Event::create([
            'user_id' => $organizer->id,
            'title' => 'Laravel 12 & React Fullstack Masterclass - Offline Meetup',
            'description' => 'Belajar langsung membuat aplikasi SaaS berskala produksi menggunakan Laravel 12 & React Tailwind v4 bersama praktisi industri. Bawa laptop sendiri!',
            'date_time' => now()->addDays(7)->setTime(13, 30),
            'location_name' => 'CoHive Coworking Space, SCBD Jakarta',
            'status' => 'active',
            'price' => 50000.00,
            'quota' => 50,
            'material_links' => [
                'banner_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Workshop & Hobi',
                'ticket_types' => [
                    [
                        'name' => 'TIKET WORKSHOP + COFFEE BREAK',
                        'price' => 50000,
                        'quota' => 50,
                        'description' => 'Akses sesi latihan, Coffee Break, & E-Sertifikat Pembelajaran'
                    ]
                ]
            ]
        ]);
    }
}
