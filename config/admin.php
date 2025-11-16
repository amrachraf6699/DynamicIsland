<?php

return [
    'brand' => [
        'logo' => 'logo.png',
        'loading' => 'loading.gif',
        'name' => env('APP_NAME', 'Dynamic Island CMS'),
    ],

    'resources' => [
        ['label' => 'لوحة التحكم', 'icon' => 'home', 'route' => 'admin.dashboard'],
        ['label' => 'مجموعات الصفحات', 'icon' => 'rectangle-group', 'route' => 'admin.page-groups.index', 'model' => \App\Models\PageGroup::class],
        ['label' => 'الصفحات', 'icon' => 'document-text', 'route' => 'admin.pages.index', 'model' => \App\Models\Page::class],
        ['label' => 'الأقسام الفرعية', 'icon' => 'puzzle-piece', 'route' => 'admin.partials.index', 'model' => \App\Models\Partial::class],
        ['label' => 'الخدمات', 'icon' => 'sparkles', 'route' => 'admin.services.index', 'model' => \App\Models\Service::class],
        ['label' => 'المشاريع', 'icon' => 'briefcase', 'route' => 'admin.projects.index', 'model' => \App\Models\Project::class],
        ['label' => 'آراء العملاء', 'icon' => 'chat-bubble-left-ellipsis', 'route' => 'admin.testimonials.index', 'model' => \App\Models\Testimonial::class],
        ['label' => 'السلايدر', 'icon' => 'photo', 'route' => 'admin.sliders.index', 'model' => \App\Models\Slider::class],
        ['label' => 'أعضاء الفريق', 'icon' => 'users', 'route' => 'admin.team-members.index', 'model' => \App\Models\TeamMember::class],
        ['label' => 'أقسام المدونة', 'icon' => 'view-columns', 'route' => 'admin.blog-sections.index', 'model' => \App\Models\BlogSection::class],
        ['label' => 'المقالات', 'icon' => 'newspaper', 'route' => 'admin.blogs.index', 'model' => \App\Models\Blog::class],
        ['label' => 'الإحصائيات', 'icon' => 'chart-bar', 'route' => 'admin.statistics.index', 'model' => \App\Models\Statistic::class],
        ['label' => 'الوظائف', 'icon' => 'receipt-percent', 'route' => 'admin.job-postings.index', 'model' => \App\Models\JobPosting::class],
        ['label' => 'أقسام المعرض', 'icon' => 'square-3-stack-3d', 'route' => 'admin.gallery-sections.index', 'model' => \App\Models\GallerySection::class],
        ['label' => 'المعرض', 'icon' => 'photo', 'route' => 'admin.galleries.index', 'model' => \App\Models\Gallery::class],
        ['label' => 'الشركاء', 'icon' => 'handshake', 'route' => 'admin.partners.index', 'model' => \App\Models\Partner::class],
        ['label' => 'الجوائز', 'icon' => 'trophy', 'route' => 'admin.awards.index', 'model' => \App\Models\Award::class],
    ],
];
