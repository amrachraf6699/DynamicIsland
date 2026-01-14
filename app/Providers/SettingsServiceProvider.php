<?php

namespace App\Providers;

use App\Models\Font;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $settings = Setting::query()
            ->get()
            ->groupBy('group')
            ->map(fn ($items) => $items->pluck('value', 'key')->toArray())
            ->toArray();

        $this->applyWebsiteConfig($settings['website'] ?? []);
        $this->applyNotificationConfig($settings['notifications'] ?? []);
        $this->applyMailConfig($settings['mail'] ?? []);
    }

    protected function applyWebsiteConfig(array $website): void
    {
        $defaults = [
            'name' => config('app.name', 'Dynamic Island'),
            'tagline' => '',
            'logo' => null,
            'favicon' => null,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'font_id' => null,
            'primary_color' => '#6f7bf7',
            'primary_dark_color' => '#5a66e8',
            'secondary_color' => '#22c55e',
            'accent_color' => '#0ea5e9',
            'surface_color' => '#f6f7fb',
            'text_color' => '#111827',
            'contact_form_enabled' => true,
            'sticky_service_request' => false,
            'admin_prefix' => 'admin',
        ];

        $website = array_merge($defaults, $website);
        $website['font_id'] = $website['font_id'] ? (int) $website['font_id'] : null;

        $logoUrl = $this->resolveMediaUrl($website['logo']);
        $faviconUrl = $this->resolveMediaUrl($website['favicon']);
        $contactEnabled = (bool) $website['contact_form_enabled'];
        $stickyRequest = (bool) $website['sticky_service_request'];
        $adminPrefix = Str::of($website['admin_prefix'])
            ->trim('/ ')
            ->lower()
            ->value() ?: 'admin';
        $website['admin_prefix'] = $adminPrefix;

        $colors = [
            'primary' => $website['primary_color'],
            'primary_dark' => $website['primary_dark_color'],
            'secondary' => $website['secondary_color'],
            'accent' => $website['accent_color'],
            'surface' => $website['surface_color'],
            'text' => $website['text_color'],
        ];

        $brand = array_merge([
            'logo' => 'logo.png',
            'loading' => 'loading.gif',
            'name' => config('app.name'),
        ], config('admin.brand', []));

        $font = $this->resolveFont($website['font_id']);
        $website['font_id'] = $font['id'] ?? $website['font_id'];

        if ($logoUrl) {
            $brand['logo'] = $logoUrl;
        }

        $brand['name'] = $website['name'] ?: $brand['name'];

        config([
            'app.name' => $website['name'] ?: config('app.name'),
            'admin.brand' => $brand,
            'admin.route_prefix' => $adminPrefix,
            'settings.website' => array_merge($website, [
                'logo_url' => $logoUrl,
                'favicon_url' => $faviconUrl,
                'colors' => $colors,
                'contact_form_enabled' => $contactEnabled,
                'sticky_service_request' => $stickyRequest,
                'admin_prefix' => $adminPrefix,
                'font' => $font,
            ]),
        ]);
    }

    protected function applyNotificationConfig(array $notifications): void
    {
        $defaults = [
            'notify_admins_contact_submit' => true,
            'notify_user_contact_submit' => true,
            'notify_admins_contact_reply' => true,
            'notify_user_contact_reply' => true,
            'notify_admins_service_request' => true,
            'notify_user_service_request' => true,
        ];

        $resolved = array_merge($defaults, $notifications);

        foreach ($resolved as $key => $value) {
            $resolved[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($resolved[$key] === null) {
                $resolved[$key] = false;
            }
        }

        config([
            'settings.notifications' => $resolved,
        ]);
    }

    protected function applyMailConfig(array $mail): void
    {
        $mailConfig = [];

        if (! empty($mail['host'])) {
            $mailConfig['mail.mailers.smtp.host'] = $mail['host'];
        }

        if (isset($mail['port']) && $mail['port'] !== '') {
            $mailConfig['mail.mailers.smtp.port'] = (int) $mail['port'];
        }

        if (! empty($mail['username'])) {
            $mailConfig['mail.mailers.smtp.username'] = $mail['username'];
        }

        if (! empty($mail['password'])) {
            $mailConfig['mail.mailers.smtp.password'] = $mail['password'];
        }

        if (! empty($mail['encryption'])) {
            $mailConfig['mail.mailers.smtp.encryption'] = $mail['encryption'];
        }

        if (! empty($mail['from_address'])) {
            $mailConfig['mail.from.address'] = $mail['from_address'];
        }

        if (! empty($mail['from_name'])) {
            $mailConfig['mail.from.name'] = $mail['from_name'];
        }

        if (! empty($mailConfig)) {
            config($mailConfig);
        }
    }

    protected function resolveMediaUrl(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        if (Str::startsWith($value, ['/'])) {
            return $value;
        }

        if (Storage::disk('public')->exists($value)) {
            return Storage::url($value);
        }

        return asset($value);
    }

    protected function resolveFont(?int $fontId): array
    {
        $fallback = [
            'id' => null,
            'name' => 'Cairo',
            'slug' => 'cairo',
            'font_family' => '"Cairo", "Helvetica Neue", Arial, sans-serif',
            'stylesheet_url' => 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap',
        ];

        if (! Schema::hasTable('fonts')) {
            return $fallback;
        }

        $font = null;

        if ($fontId) {
            $font = Font::query()->find($fontId);
        }

        if (! $font) {
            $font = Font::query()
                ->where('slug', 'cairo')
                ->first() ?? Font::query()->orderBy('id')->first();
        }

        if (! $font) {
            return $fallback;
        }

        return [
            'id' => $font->id,
            'name' => $font->name,
            'slug' => $font->slug,
            'font_family' => $font->font_family,
            'stylesheet_url' => $font->stylesheet_url,
        ];
    }
}
