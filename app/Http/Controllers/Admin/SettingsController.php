<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    protected array $groups = ['analytics', 'contact', 'mail', 'social', 'notifications', 'website'];

    public function edit(string $group)
    {
        abort_unless(in_array($group, $this->groups, true), 404);
        abort_unless(auth()->user()->can("settings.$group.update"), 403);

        $data = $this->loadGroup($group);
        return view('admin.settings.edit', compact('group', 'data'));
    }

    public function update(Request $request, string $group)
    {
        abort_unless(in_array($group, $this->groups, true), 404);
        abort_unless(auth()->user()->can("settings.$group.update"), 403);

        $validated = $this->validateGroup($request, $group);
        $this->storeGroup($group, $validated);

        return redirect()->route('admin.settings.edit', $group)->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    protected function loadGroup(string $group): array
    {
        switch ($group) {
            case 'analytics':
                return [
                    'ga_id' => Setting::get('analytics', 'ga_id', ''),
                    'meta_pixel_id' => Setting::get('analytics', 'meta_pixel_id', ''),
                ];
            case 'contact':
                return [
                    'phones' => Setting::get('contact', 'phones', []),
                    'emails' => Setting::get('contact', 'emails', []),
                    'address' => Setting::get('contact', 'address', ''),
                ];
            case 'mail':
                return [
                    'host' => Setting::get('mail', 'host', ''),
                    'port' => Setting::get('mail', 'port', ''),
                    'username' => Setting::get('mail', 'username', ''),
                    'password' => Setting::get('mail', 'password', ''),
                    'encryption' => Setting::get('mail', 'encryption', ''),
                    'from_address' => Setting::get('mail', 'from_address', ''),
                    'from_name' => Setting::get('mail', 'from_name', ''),
                ];
            case 'social':
                return [
                    'facebook' => Setting::get('social', 'facebook', ''),
                    'instagram' => Setting::get('social', 'instagram', ''),
                    'x' => Setting::get('social', 'x', ''),
                    'linkedin' => Setting::get('social', 'linkedin', ''),
                    'whatsapp' => Setting::get('social', 'whatsapp', ''),
                    'youtube' => Setting::get('social', 'youtube', ''),
                    'tiktok' => Setting::get('social', 'tiktok', ''),
                ];
            case 'notifications':
                return [
                    'notify_admins_contact_submit' => Setting::get('notifications', 'notify_admins_contact_submit', true),
                    'notify_user_contact_submit' => Setting::get('notifications', 'notify_user_contact_submit', true),
                    'notify_admins_contact_reply' => Setting::get('notifications', 'notify_admins_contact_reply', true),
                    'notify_user_contact_reply' => Setting::get('notifications', 'notify_user_contact_reply', true),
                    'notify_admins_service_request' => Setting::get('notifications', 'notify_admins_service_request', true),
                    'notify_user_service_request' => Setting::get('notifications', 'notify_user_service_request', true),
                ];
            case 'website':
                return [
                    'name' => Setting::get('website', 'name', config('app.name')),
                    'tagline' => Setting::get('website', 'tagline', ''),
                    'logo' => Setting::get('website', 'logo', ''),
                    'favicon' => Setting::get('website', 'favicon', ''),
                    'meta_title' => Setting::get('website', 'meta_title', ''),
                    'meta_description' => Setting::get('website', 'meta_description', ''),
                    'meta_keywords' => Setting::get('website', 'meta_keywords', ''),
                    'primary_color' => Setting::get('website', 'primary_color', '#6f7bf7'),
                    'primary_dark_color' => Setting::get('website', 'primary_dark_color', '#5a66e8'),
                    'secondary_color' => Setting::get('website', 'secondary_color', '#22c55e'),
                    'accent_color' => Setting::get('website', 'accent_color', '#0ea5e9'),
                    'surface_color' => Setting::get('website', 'surface_color', '#f6f7fb'),
                    'text_color' => Setting::get('website', 'text_color', '#111827'),
                    'contact_form_enabled' => Setting::get('website', 'contact_form_enabled', true),
                    'sticky_service_request' => Setting::get('website', 'sticky_service_request', false),
                ];
        }

        return [];
    }

    protected function validateGroup(Request $request, string $group): array
    {
        switch ($group) {
            case 'analytics':
                return $request->validate([
                    'ga_id' => ['nullable', 'string', 'max:255'],
                    'meta_pixel_id' => ['nullable', 'string', 'max:255'],
                ]);
            case 'contact':
                $validated = $request->validate([
                    'phones' => ['nullable', 'string'],
                    'emails' => ['nullable', 'string'],
                    'address' => ['nullable', 'string', 'max:500'],
                ]);
                return [
                    'phones' => collect(preg_split('/\r?\n/', $validated['phones'] ?? ''))
                        ->map(fn($v) => trim($v))
                        ->filter()
                        ->values()
                        ->all(),
                    'emails' => collect(preg_split('/\r?\n/', $validated['emails'] ?? ''))
                        ->map(fn($v) => trim($v))
                        ->filter()
                        ->values()
                        ->all(),
                    'address' => $validated['address'] ?? '',
                ];
            case 'mail':
                return $request->validate([
                    'host' => ['nullable', 'string'],
                    'port' => ['nullable', 'numeric'],
                    'username' => ['nullable', 'string'],
                    'password' => ['nullable', 'string'],
                    'encryption' => ['nullable', 'string'],
                    'from_address' => ['nullable', 'email'],
                    'from_name' => ['nullable', 'string'],
                ]);
            case 'social':
                return $request->validate([
                    'facebook' => ['nullable', 'url'],
                    'instagram' => ['nullable', 'url'],
                    'x' => ['nullable', 'url'],
                    'linkedin' => ['nullable', 'url'],
                    'whatsapp' => ['nullable', 'string'],
                    'youtube' => ['nullable', 'url'],
                    'tiktok' => ['nullable', 'url'],
                ]);
            case 'notifications':
                $request->validate([
                    'notify_admins_contact_submit' => ['nullable', 'boolean'],
                    'notify_user_contact_submit' => ['nullable', 'boolean'],
                    'notify_admins_contact_reply' => ['nullable', 'boolean'],
                    'notify_user_contact_reply' => ['nullable', 'boolean'],
                    'notify_admins_service_request' => ['nullable', 'boolean'],
                    'notify_user_service_request' => ['nullable', 'boolean'],
                ]);
                return [
                    'notify_admins_contact_submit' => $request->boolean('notify_admins_contact_submit'),
                    'notify_user_contact_submit' => $request->boolean('notify_user_contact_submit'),
                    'notify_admins_contact_reply' => $request->boolean('notify_admins_contact_reply'),
                    'notify_user_contact_reply' => $request->boolean('notify_user_contact_reply'),
                    'notify_admins_service_request' => $request->boolean('notify_admins_service_request'),
                    'notify_user_service_request' => $request->boolean('notify_user_service_request'),
                ];
            case 'website':
                $validated = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'tagline' => ['nullable', 'string', 'max:255'],
                    'logo' => ['nullable', 'image', 'max:5120'],
                    'favicon' => ['nullable', 'image', 'max:2048'],
                    'meta_title' => ['nullable', 'string', 'max:255'],
                    'meta_description' => ['nullable', 'string', 'max:500'],
                    'meta_keywords' => ['nullable', 'string', 'max:255'],
                    'primary_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'primary_dark_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'secondary_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'accent_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'surface_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'text_color' => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
                    'contact_form_enabled' => ['nullable', 'boolean'],
                    'sticky_service_request' => ['nullable', 'boolean'],
                ]);

                $validated['contact_form_enabled'] = $request->boolean('contact_form_enabled');
                $validated['sticky_service_request'] = $request->boolean('sticky_service_request');

                if ($request->boolean('remove_logo')) {
                    $validated['logo'] = null;
                }

                if (! $request->hasFile('logo') && ! array_key_exists('logo', $validated)) {
                    unset($validated['logo']);
                }

                if ($request->boolean('remove_favicon')) {
                    $validated['favicon'] = null;
                }

                if (! $request->hasFile('favicon') && ! array_key_exists('favicon', $validated)) {
                    unset($validated['favicon']);
                }

                return $validated;
        }
        return [];
    }

    protected function storeGroup(string $group, array $data): void
    {
        if ($group === 'website') {
            $data = $this->handleWebsiteUploads($data);
        }

        foreach ($data as $key => $value) {
            if ($value === null) {
                $this->deleteSettingValue($group, $key);
                continue;
            }
            Setting::set($group, $key, $value);
        }
    }

    protected function handleWebsiteUploads(array $data): array
    {
        foreach (['logo', 'favicon'] as $field) {
            if (! array_key_exists($field, $data)) {
                continue;
            }

            $value = $data[$field];

            if ($value instanceof UploadedFile) {
                $this->deleteStoredFile(Setting::get('website', $field));
                $data[$field] = $value->store('settings', 'public');
            } elseif ($value === null) {
                $this->deleteStoredFile(Setting::get('website', $field));
            }
        }

        return $data;
    }

    protected function deleteSettingValue(string $group, string $key): void
    {
        Setting::query()->where(compact('group', 'key'))->delete();
    }

    protected function deleteStoredFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
