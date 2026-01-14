@php
    $title = 'إدارة المستخدمين';
@endphp

<x-admin.layout :title="$title">
    <div class="space-y-4">
        <div
            class="glass-panel flex flex-col gap-4 rounded-3xl p-4 text-right lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" class="scroll-thin flex flex-nowrap items-end gap-4 overflow-x-auto pb-1" data-filter-form>
                <div class="min-w-[14rem] shrink-0">
                    <label class="mb-2 block text-xs font-semibold text-slate-600">بحث</label>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="ابحث في {{ $title }}..."
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                        dir="rtl">
                </div>

                @foreach(($filters ?? []) as $filter)
                @php
                $name = $filter['key'] ?? '';
                $label = $filter['label'] ?? \Illuminate\Support\Str::headline($name);
                $type = $filter['type'] ?? 'text';
                $options = $filter['options'] ?? [];
                @endphp

                @if(in_array($type, ['select', 'boolean'], true))
                <div class="min-w-[10rem] shrink-0">
                    <label class="mb-2 block text-xs font-semibold text-slate-600">{{ $label }}</label>
                    <select name="{{ $name }}"
                        class="js-select2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                        dir="rtl">
                        <option value="">{{ $filter['placeholder'] ?? 'اختر' }}</option>
                        @foreach($options as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" @selected((string) request($name)===(string) $optionValue)>
                            {{ $optionLabel }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="min-w-[10rem] shrink-0">
                    <label class="mb-2 block text-xs font-semibold text-slate-600">{{ $label }}</label>
                    <input type="{{ $type }}" name="{{ $name }}" value="{{ request($name) }}"
                        placeholder="{{ $filter['placeholder'] ?? ('ابحث عن ' . $label . '...') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                        dir="rtl">
                </div>
                @endif
                @endforeach

                <button type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:text-rose-600"
                    data-filter-reset aria-label="إعادة تعيين الفلاتر" title="إعادة تعيين الفلاتر">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12a8 8 0 11-2.34-5.66M20 4v6h-6" />
                    </svg>
                </button>
            </form>

            @can(($resourceName ?? 'users') . '.create')
            <a href="{{ Route::has('admin.' . ($resourceName ?? 'users') . '.create') ? route('admin.' . ($resourceName ?? 'users') . '.create') : '#' }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                إضافة {{ $title }}
            </a>
            @endcan
        </div>

        <div class="glass-panel rounded-3xl p-4">
            <table class="w-full text-right text-sm">
                <thead class="border-b border-slate-200 text-slate-600">
                    <tr>
                        <th class="py-2">الاسم</th>
                        <th class="py-2">البريد الإلكتروني</th>
                        <th class="py-2">الأدوار</th>
                        <th class="py-2">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                    <tr>
                        <td class="py-3">{{ $user->name }}</td>
                        <td class="py-3">{{ $user->email }}</td>
                        <td class="py-3">
                            <form action="{{ route('admin.' . ($resourceName ?? 'users') . '.update', $user) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="roles[]" multiple class="js-select2 w-64 rounded-2xl border border-slate-200 px-3 py-2 text-sm" dir="rtl">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button class="rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">حفظ</button>
                            </form>
                        </td>
                        <td class="py-3">
                            <div class="flex items-center justify-end gap-2">
                                @can(($resourceName ?? 'users') . '.update')
                                <a href="{{ route('admin.' . ($resourceName ?? 'users') . '.edit', $user) }}"
                                   class="inline-flex items-center gap-1 rounded-2xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:border-indigo-300 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687 1.687m-2.56-0.126l-7.5 7.5a2.25 2.25 0 00-.564.96l-.6 2.4 2.4-.6a2.25 2.25 0 00.96-.564l7.5-7.5m-2.196-3.786a1.875 1.875 0 112.652 2.652" />
                                    </svg>
                                    تعديل
                                </a>
                                @endcan

                                @can(($resourceName ?? 'users') . '.delete')
                                <form action="{{ route('admin.' . ($resourceName ?? 'users') . '.destroy', $user) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا المستخدم؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-2xl bg-rose-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0V5a1 1 0 011-1h4a1 1 0 011 1v2m-1 0v11a2 2 0 01-2 2H9a2 2 0 01-2-2V7h10z" />
                                        </svg>
                                        حذف
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-filter-form]');
        if (!form) return;

        const inputs = form.querySelectorAll('input, select');
        let timer;

        const submit = () => form.submit();
        const debouncedSubmit = () => {
            clearTimeout(timer);
            timer = setTimeout(submit, 350);
        };

        inputs.forEach((input) => {
            const eventName = input.tagName === 'SELECT' ? 'change' : 'input';
            input.addEventListener(eventName, debouncedSubmit);
        });

        if (window.jQuery) {
            window.jQuery(form).find('.js-select2').on('select2:select select2:clear', debouncedSubmit);
        }

        const resetButton = form.querySelector('[data-filter-reset]');
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                inputs.forEach((input) => {
                    if (input.tagName === 'SELECT') {
                        input.value = '';
                        if (window.jQuery) {
                            window.jQuery(input).val('').trigger('change');
                        }
                    } else {
                        input.value = '';
                    }
                });
                form.submit();
            });
        }
    });
</script>

