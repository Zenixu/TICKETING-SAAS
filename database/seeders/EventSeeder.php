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
        // 1. Ensure Dummy Organizer Exists
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

        // 2. Dummy Event Niche 1: MUSIK / GIG INDIE
        Event::updateOrCreate(
            ['title' => 'NOAH & SHEILA ON 7: Soundwave Fest 2026'],
            [
                'user_id' => $organizer->id,
                'description' => "Konser megah perayaan musik Indonesia menghadirkan NOAH, Sheila on 7, dan Maliq & D'Essentials dalam satu panggung spektakuler di GBK Senayan!",
                'date_time' => now()->addDays(20)->setTime(18, 30),
                'location_name' => 'GBK Senayan Stadium, Jakarta Pusat',
                'status' => 'active',
                'price' => 350000,
                'quota' => 5000,
                'material_links' => [
                    'category' => 'Musik',
                    'banner_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80',
                    'organizer_whatsapp' => '082114073679',
                    'ticket_types' => [
                        [
                            'name' => 'REGULAR FESTIVAL (Standing)',
                            'price' => 350000,
                            'quota' => 3000,
                            'description' => 'Akses masuk gate festival berdiri di area lapangan utama.'
                        ],
                        [
                            'name' => 'VIP FRONT STAGE (Free Seating)',
                            'price' => 750000,
                            'quota' => 1500,
                            'description' => 'Akses dekat panggung + Lanyard Official + Fast-track Gate.'
                        ],
                        [
                            'name' => 'VVIP MEET & GREET (Numbered Seating)',
                            'price' => 1500000,
                            'quota' => 500,
                            'description' => 'Akses dudukan bernomor + Sesi Foto Bareng Artis + Official Merch Pack.'
                        ]
                    ]
                ]
            ]
        );

        // 3. Dummy Event Niche 2: COSPLAY / ANIME FEST
        Event::updateOrCreate(
            ['title' => 'NIPPON MATSURI 2026: Cosplay & Animetion Fest'],
            [
                'user_id' => $organizer->id,
                'description' => "Festival budaya Jepang & Cosplay terbesar di Bandung! Menampilkan Guest Star Cosplayer Internasional, Lomba Coswalk, Anisong DJ Party, dan Stand Merch Official.",
                'date_time' => now()->addDays(35)->setTime(10, 0),
                'location_name' => 'Sabuga Convention Hall, Bandung',
                'status' => 'active',
                'price' => 45000,
                'quota' => 2000,
                'material_links' => [
                    'category' => 'Cosplay',
                    'banner_url' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=1200&q=80',
                    'organizer_whatsapp' => '082114073679',
                    'ticket_types' => [
                        [
                            'name' => 'REGULAR DAY PASS',
                            'price' => 45000,
                            'quota' => 1200,
                            'description' => 'Tiket masuk area festival, panggung anisong, dan booth komunitas.'
                        ],
                        [
                            'name' => 'VIP BUNDLE - COSPLAY MERCH PACK',
                            'price' => 120000,
                            'quota' => 500,
                            'description' => 'Fast Track Gate + Standee Akrilik Exclusive + Keychain + Poster Guest Star.'
                        ],
                        [
                            'name' => 'COSWALK COMPETITION PASS',
                            'price' => 35000,
                            'quota' => 300,
                            'description' => 'Pendaftaran Peserta Lomba Coswalk + Akses Ruang Ganti VIP & Mirror Station.'
                        ]
                    ]
                ]
            ]
        );
    }
}
