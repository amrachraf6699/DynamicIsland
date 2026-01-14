@php
$actions = [
    [
        'label' => 'حذف',
        'type' => 'delete',
        'route' => 'admin.newsletters.destroy',
        'ability' => 'delete',
    ],
];

$createButton = [
    'route' => route('admin.newsletters.campaign'),
    'label' => 'إرسال حملة',
    'ability' => 'newsletters.update',
];
@endphp

@include('admin.resources.index', compact('actions', 'createButton'))
