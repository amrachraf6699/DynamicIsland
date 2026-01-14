<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Analytics
        Setting::set('analytics', 'ga_id', '');
        Setting::set('analytics', 'meta_pixel_id', '');

        // Contact (multi)
        Setting::set('contact', 'phones', []);
        Setting::set('contact', 'emails', []);
        Setting::set('contact', 'address', '');

        // Mail SMTP
        Setting::set('mail', 'host', '');
        Setting::set('mail', 'port', '');
        Setting::set('mail', 'username', '');
        Setting::set('mail', 'password', '');
        Setting::set('mail', 'encryption', '');
        Setting::set('mail', 'from_address', '');
        Setting::set('mail', 'from_name', '');

        // Social links
        foreach (['facebook', 'instagram', 'x', 'linkedin', 'whatsapp', 'youtube', 'tiktok'] as $key) {
            Setting::set('social', $key, '');
        }

        // Notifications
        Setting::set('notifications', 'notify_admins_contact_submit', true);
        Setting::set('notifications', 'notify_user_contact_submit', true);
        Setting::set('notifications', 'notify_admins_contact_reply', true);
        Setting::set('notifications', 'notify_user_contact_reply', true);
        Setting::set('notifications', 'notify_admins_service_request', true);
        Setting::set('notifications', 'notify_user_service_request', true);

        // Website defaults
        Setting::set('website', 'name', config('app.name', 'Dynamic Island CMS'));
        Setting::set('website', 'tagline', '');
        Setting::set('website', 'favicon', '');
        Setting::set('website', 'meta_title', '');
        Setting::set('website', 'meta_description', '');
        Setting::set('website', 'meta_keywords', '');
        Setting::set('website', 'primary_color', '#6f7bf7');
        Setting::set('website', 'primary_dark_color', '#5a66e8');
        Setting::set('website', 'secondary_color', '#22c55e');
        Setting::set('website', 'accent_color', '#0ea5e9');
        Setting::set('website', 'surface_color', '#f6f7fb');
        Setting::set('website', 'text_color', '#111827');
        Setting::set('website', 'contact_form_enabled', true);
        Setting::set('website', 'sticky_service_request', false);
        Setting::set('website', 'admin_prefix', 'admin');
    }
}
