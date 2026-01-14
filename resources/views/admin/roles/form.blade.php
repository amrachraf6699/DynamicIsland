@php
    $isEdit = $role?->exists;
    $title = $isEdit ? 'تعديل الدور' : 'إنشاء دور';
    $assigned = collect($assigned ?? []);
@endphp

<x-admin.layout :title="$title">
    <form method="POST" action="{{ $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store') }}" class="space-y-5">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <section class="glass-panel rounded-3xl p-5 grid gap-4 sm:grid-cols-2">
            <x-admin.inputs.text name="name" label="اسم الدور" :value="old('name', $role->name)" required />
        </section>

        <section class="glass-panel rounded-3xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-800">الصلاحيات</h3>
                <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                    <input type="checkbox" id="toggle-all-permissions" class="sr-only peer">
                    <span class="relative h-6 w-12 rounded-full bg-slate-200 ring-1 ring-inset ring-slate-200 transition-all duration-300 peer-checked:bg-indigo-600 peer-checked:ring-indigo-500/40 after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-white after:shadow after:transition after:duration-300 peer-checked:after:translate-x-6"></span>
                    <span>تحديد الكل</span>
                </label>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($groups as $group)
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs font-semibold text-slate-700">{{ $group['label'] }}</div>
                            <label class="inline-flex items-center gap-2 text-[11px] text-slate-600">
                                <input type="checkbox" class="sr-only peer group-toggle" data-group="{{ $group['key'] }}">
                                <span class="relative h-5 w-10 rounded-full bg-slate-200 ring-1 ring-inset ring-slate-200 transition-all duration-300 peer-checked:bg-indigo-600 peer-checked:ring-indigo-500/40 after:absolute after:left-1 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:shadow after:transition after:duration-300 peer-checked:after:translate-x-5"></span>
                                <span>الكل</span>
                            </label>
                        </div>
                        <div class="space-y-2">
                            @foreach($group['permissions'] as $perm)
                                @php
                                    $checked = $assigned->contains($perm['name']);
                                @endphp
                                <label class="flex items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2">
                                    <span class="text-xs text-slate-700">{{ $perm['label'] }}</span>
                                    <input type="checkbox" name="permissions[]" value="{{ $perm['name'] }}" class="sr-only peer permission-toggle" data-group="{{ $group['key'] }}" @checked($checked)>
                                    <span class="relative h-5 w-10 rounded-full bg-slate-200 ring-1 ring-inset ring-slate-200 transition-all duration-300 peer-checked:bg-indigo-600 peer-checked:ring-indigo-500/40 after:absolute after:left-1 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:shadow after:transition after:duration-300 peer-checked:after:translate-x-5"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div>
            <button class="rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">حفظ</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allToggle = document.getElementById('toggle-all-permissions');
            const groupToggles = Array.from(document.querySelectorAll('.group-toggle'));
            const permToggles = Array.from(document.querySelectorAll('.permission-toggle'));

            function setChecked(inputs, checked) {
                inputs.forEach(input => { input.checked = checked; });
            }

            function refreshGroupState(groupKey) {
                const inGroup = permToggles.filter(p => p.dataset.group === groupKey);
                const groupToggle = groupToggles.find(g => g.dataset.group === groupKey);
                if (!groupToggle) return;
                groupToggle.checked = inGroup.length > 0 && inGroup.every(p => p.checked);
            }

            function refreshAllState() {
                allToggle.checked = permToggles.length > 0 && permToggles.every(p => p.checked);
            }

            // Initialize group and global toggles based on current selections
            const groupKeys = [...new Set(groupToggles.map(g => g.dataset.group))];
            groupKeys.forEach(refreshGroupState);
            refreshAllState();

            allToggle?.addEventListener('change', (e) => {
                const checked = e.target.checked;
                setChecked(permToggles, checked);
                setChecked(groupToggles, checked);
            });

            groupToggles.forEach(gt => {
                gt.addEventListener('change', (e) => {
                    const group = e.target.dataset.group;
                    const inGroup = permToggles.filter(p => p.dataset.group === group);
                    setChecked(inGroup, e.target.checked);
                    refreshAllState();
                });
            });

            permToggles.forEach(pt => {
                pt.addEventListener('change', (e) => {
                    const group = e.target.dataset.group;
                    refreshGroupState(group);
                    refreshAllState();
                });
            });
        });
    </script>
</x-admin.layout>
