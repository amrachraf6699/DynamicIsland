<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['استعلام', 'طلب تسعير', 'مشكلة تقنية', 'ملاحظة', 'اقتراح'];

        for ($i = 1; $i <= 20; $i++) {

            $createdAt = Carbon::now()->subDays(rand(1, 365));

            Contact::create([
                'name' => 'مستخدم ' . $i,
                'email' => 'user' . $i . '@example.com',
                'phone' => '010' . rand(10000000, 99999999),
                'subject' => $subjects[array_rand($subjects)],
                'message' => Str::limit(
                    'هذه رسالة تجريبية رقم ' . $i . ' للتجربة على نظام الإدارة.',
                    200
                ),
                'is_read' => (bool) rand(0, 1),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
