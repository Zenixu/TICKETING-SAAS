<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttendeeSeeder extends Seeder
{
    /**
     * Seed dummy attendees supaya counter dashboard organizer jadi real.
     * Distribusi: registered (3), checked_in (2), cancelled (1), pending_payment (2).
     */
    public function run(): void
    {
        // Ambil semua user dengan role 'user' sebagai calon attendee
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            // Kalau belum ada user biasa, buat 5 dummy
            $dummyNames = [
                ['name' => 'Rina Wulandari', 'email' => 'rina.wulandari@gmail.com'],
                ['name' => 'Bagas Saputra', 'email' => 'bagas.saputra@gmail.com'],
                ['name' => 'Putri Maharani', 'email' => 'putri.maharani@gmail.com'],
                ['name' => 'Dimas Prasetyo', 'email' => 'dimas.prasetyo@gmail.com'],
                ['name' => 'Aulia Rachma', 'email' => 'aulia.rachma@gmail.com'],
            ];

            foreach ($dummyNames as $d) {
                $users->push(User::firstOrCreate(
                    ['email' => $d['email']],
                    [
                        'name' => $d['name'],
                        'password' => bcrypt('password'),
                        'role' => 'user',
                        'organizer_status' => 'none',
                        'email_verified_at' => now(),
                    ]
                ));
            }
        }

        // Ambil event aktif (skip yang sudah lewat)
        $events = Event::where('status', 'active')
            ->where('date_time', '>', now()->subDay())
            ->orderBy('date_time')
            ->get();

        if ($events->isEmpty()) {
            $this->command->warn('Tidak ada event aktif, skip attendee seeder.');
            return;
        }

        // Distribusi status untuk 1 event pertama (NOAH), biar dashboard organizer penuh
        $firstEvent = $events->first();
        $statusPool = [
            ['status' => 'registered', 'count' => 4],
            ['status' => 'checked_in', 'count' => 2],
            ['status' => 'pending_payment', 'count' => 2],
            ['status' => 'cancelled', 'count' => 1],
        ];

        $created = 0;
        foreach ($statusPool as $pool) {
            for ($i = 0; $i < $pool['count']; $i++) {
                $user = $users->random();
                // Idempotent: skip kalau user+event combination sudah ada
                $exists = Attendee::where('event_id', $firstEvent->id)
                    ->where('user_id', $user->id)
                    ->exists();
                if ($exists) continue;

                Attendee::create([
                    'event_id' => $firstEvent->id,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => '6281' . random_int(10000000, 99999999),
                    'qr_code_token' => Str::random(32),
                    'status' => $pool['status'],
                    'checked_in_at' => $pool['status'] === 'checked_in' ? now()->subHours(random_int(1, 24)) : null,
                ]);
                $created++;
            }
        }

        // Tambahkan 1 registered per event kosong/paid-only agar ada sample untuk testing check-in
        foreach ($events as $event) {
            $hasRegistered = $event->attendees()->where('status', 'registered')->exists();
            if ($hasRegistered) {
                continue;
            }
            $event->attendees()->create([
                'name' => 'Sample Peserta ' . Str::random(4),
                'email' => 'sample-' . Str::random(6) . '@tiketkita.test',
                'phone_number' => '0812' . str_pad((string) random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'qr_code_token' => 'TKT-' . strtoupper(Str::random(20)),
                'status' => 'registered',
            ]);
        }

        $this->command->info("✓ AttendeeSeeder: {$created} attendee berhasil di-seed di {$events->count()} event.");
    }
}
