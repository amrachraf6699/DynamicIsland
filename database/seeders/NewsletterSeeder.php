<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = [
            'newsletter@example.com',
            'updates@example.com',
            'press@example.com',
            'hello@example.com',
            'team@example.com',
        ];

        foreach ($emails as $email) {
            NewsletterSubscription::firstOrCreate(['email' => $email]);
        }
    }
}
