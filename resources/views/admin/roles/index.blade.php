@php
    $title = 'إدارة الأدوار والصلاحيات';
@endphp

<x-admin.layout :title="$title">
    <div class="space-y-4">
        @foreach($roles as $role)
            <div class="glass-panel rounded-3xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-800">الدور: {{ $role->name }}</h3>
                </div>
                <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($groupedPermissions as $group => $perms)
                            <div class="rounded-xl border border-slate-200 p-3">
                                <div class="text-xs font-semibold text-slate-600 mb-2">{{ $group }}</div>
                                <div class="space-y-2">
                                    @foreach($perms as $perm)
                                        <label class="flex items-center gap-2 text-xs text-slate-700">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded border-slate-300" @checked($role->hasPermissionTo($perm->name))>
                                            <span>{{ $perm->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <button class="rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">حفظ</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</x-admin.layout>

