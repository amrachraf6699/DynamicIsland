<?php

namespace Database\Seeders;

use App\Models\Font;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FontSeeder extends Seeder
{
    /**
        * Run the database seeds.
        */
    public function run(): void
    {
        $fallbackStack = '"Helvetica Neue", Arial, sans-serif';

        $fonts = [
            [
                'slug' => 'cairo',
                'name' => 'Cairo',
                'font_family' => '"Cairo", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'almarai',
                'name' => 'Almarai',
                'font_family' => '"Almarai", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'tajawal',
                'name' => 'Tajawal',
                'font_family' => '"Tajawal", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'changa',
                'name' => 'Changa',
                'font_family' => '"Changa", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Changa:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'ibm-plex-sans-arabic',
                'name' => 'IBM Plex Sans Arabic',
                'font_family' => '"IBM Plex Sans Arabic", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'noto-sans-arabic',
                'name' => 'Noto Sans Arabic',
                'font_family' => '"Noto Sans Arabic", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'markazi-text',
                'name' => 'Markazi Text',
                'font_family' => '"Markazi Text", Georgia, ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Markazi+Text:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'amiri',
                'name' => 'Amiri',
                'font_family' => '"Amiri", "Times New Roman", Times, serif',
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'el-messiri',
                'name' => 'El Messiri',
                'font_family' => '"El Messiri", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'baloo-bhaijaan-2',
                'name' => 'Baloo Bhaijaan 2',
                'font_family' => '"Baloo Bhaijaan 2", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'reem-kufi',
                'name' => 'Reem Kufi',
                'font_family' => '"Reem Kufi", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'scheherazade-new',
                'name' => 'Scheherazade New',
                'font_family' => '"Scheherazade New", "Times New Roman", Times, serif',
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'katibeh',
                'name' => 'Katibeh',
                'font_family' => '"Katibeh", "Trebuchet MS", "Helvetica Neue", Arial, sans-serif',
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Katibeh&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'harmattan',
                'name' => 'Harmattan',
                'font_family' => '"Harmattan", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Harmattan:wght@400;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'rakkas',
                'name' => 'Rakkas',
                'font_family' => '"Rakkas", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Rakkas&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'aref-ruqaa',
                'name' => 'Aref Ruqaa',
                'font_family' => '"Aref Ruqaa", "Times New Roman", Times, serif',
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Aref+Ruqaa&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'noto-kufi-arabic',
                'name' => 'Noto Kufi Arabic',
                'font_family' => '"Noto Kufi Arabic", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap',
                'provider' => 'google',
            ],
            [
                'slug' => 'mada',
                'name' => 'Mada',
                'font_family' => '"Mada", ' . $fallbackStack,
                'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Mada:wght@300;400;500;600;700&display=swap',
                'provider' => 'google',
            ],
        ];

        $timestamp = now();

        $payload = collect($fonts)->map(function (array $font) use ($timestamp) {
            return array_merge($font, [
                'slug' => Str::slug($font['slug']),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        })->all();

        Font::query()->upsert(
            $payload,
            ['slug'],
            ['name', 'font_family', 'stylesheet_url', 'provider', 'updated_at']
        );
    }
}
