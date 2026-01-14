<?php

return [
    'route_prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
    'brand' => [
        'logo' => 'logo.png',
        'loading' => 'loading.gif',
        'name' => env('APP_NAME', 'Dynamic Island CMS'),
    ],

    'resources' => [
        ['label' => 'لوحة التحكم', 'icon' => 'home', 'route' => 'admin.dashboard'],

        ['label' => 'مجموعات الصفحات', 'icon' => 'rectangle-group', 'route' => 'admin.page-groups.index', 'model' => \App\Models\PageGroup::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'position', 'label' => 'الموضع'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'الصفحات', 'icon' => 'document-text', 'route' => 'admin.pages.index', 'model' => \App\Models\Page::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'slug', 'label' => 'الرابط'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'الخدمات', 'icon' => 'sparkles', 'route' => 'admin.services.index', 'model' => \App\Models\Service::class,
            'columns' => [
                ['key' => 'title', 'label' => 'العنوان'],
                ['key' => 'is_active', 'label' => 'نشط'],
                ['key' => 'requests_count', 'label' => 'طلبات الخدمة', 'type' => 'badge'],
                ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'],
            ] ],

        ['label' => 'المشاريع', 'icon' => 'briefcase', 'route' => 'admin.projects.index', 'model' => \App\Models\Project::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'client', 'label' => 'العميل'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'date', 'label' => 'التاريخ', 'type' => 'datetime'] ] ],

        ['label' => 'آراء العملاء', 'icon' => 'chat-bubble-left-ellipsis', 'route' => 'admin.testimonials.index', 'model' => \App\Models\Testimonial::class,
            'columns' => [ ['key' => 'name', 'label' => 'الاسم'], ['key' => 'company', 'label' => 'الشركة'], ['key' => 'rating', 'label' => 'التقييم'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'السلايدر', 'icon' => 'photo', 'route' => 'admin.sliders.index', 'model' => \App\Models\Slider::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'أعضاء الفريق', 'icon' => 'users', 'route' => 'admin.team-members.index', 'model' => \App\Models\TeamMember::class,
            'columns' => [ ['key' => 'name', 'label' => 'الاسم'], ['key' => 'job_title', 'label' => 'المسمى الوظيفي'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'joined_at', 'label' => 'تاريخ الانضمام', 'type' => 'datetime'] ] ],

        ['label' => 'أقسام المدونة', 'icon' => 'view-columns', 'route' => 'admin.blog-sections.index', 'model' => \App\Models\BlogSection::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'order', 'label' => 'الترتيب'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'المقالات', 'icon' => 'newspaper', 'route' => 'admin.blogs.index', 'model' => \App\Models\Blog::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'section.title', 'label' => 'القسم'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'created_at', 'label' => 'تاريخ الإنشاء', 'type' => 'datetime'] ] ],

        ['label' => 'الإحصائيات', 'icon' => 'chart-bar', 'route' => 'admin.statistics.index', 'model' => \App\Models\Statistic::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'value', 'label' => 'القيمة'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'order', 'label' => 'الترتيب'] ] ],

        ['label' => 'الوظائف', 'icon' => 'receipt-percent', 'route' => 'admin.job-postings.index', 'model' => \App\Models\JobPosting::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'department', 'label' => 'القسم'], ['key' => 'location', 'label' => 'الموقع'], ['key' => 'employment_type', 'label' => 'نوع التوظيف'], ['key' => 'is_active', 'label' => 'نشط'] ] ],

        ['label' => 'أقسام المعرض', 'icon' => 'square-3-stack-3d', 'route' => 'admin.gallery-sections.index', 'model' => \App\Models\GallerySection::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'order', 'label' => 'الترتيب'] ] ],

        ['label' => 'المعرض', 'icon' => 'photo', 'route' => 'admin.galleries.index', 'model' => \App\Models\Gallery::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'section.title', 'label' => 'القسم'], ['key' => 'type', 'label' => 'النوع'], ['key' => 'is_active', 'label' => 'نشط'] ] ],

        ['label' => 'الشركاء', 'icon' => 'heart', 'route' => 'admin.partners.index', 'model' => \App\Models\Partner::class,
            'columns' => [ ['key' => 'name', 'label' => 'الاسم'], ['key' => 'website', 'label' => 'الموقع الإلكتروني'], ['key' => 'is_active', 'label' => 'نشط'], ['key' => 'order', 'label' => 'الترتيب'] ] ],

        ['label' => 'الجوائز', 'icon' => 'trophy', 'route' => 'admin.awards.index', 'model' => \App\Models\Award::class,
            'columns' => [ ['key' => 'title', 'label' => 'العنوان'], ['key' => 'organization', 'label' => 'الجهة'], ['key' => 'awarded_at', 'label' => 'تاريخ الحصول', 'type' => 'datetime'], ['key' => 'is_active', 'label' => 'نشط'] ] ],

        ['label' => 'النشرة البريدية', 'icon' => 'envelope-open', 'route' => 'admin.newsletters.index', 'model' => \App\Models\NewsletterSubscription::class,
            'columns' => [ ['key' => 'email', 'label' => 'البريد الإلكتروني'], ['key' => 'created_at', 'label' => 'تاريخ الاشتراك', 'type' => 'datetime'] ] ],
        ['label' => 'رسائل التواصل', 'icon' => 'chat-bubble-left-ellipsis', 'route' => 'admin.contacts.index', 'model' => \App\Models\Contact::class,
            'columns' => [ ['key' => 'name', 'label' => 'الاسم'], ['key' => 'email', 'label' => 'البريد الإلكتروني'], ['key' => 'subject', 'label' => 'الموضوع'], ['key' => 'created_at', 'label' => 'تاريخ الإرسال', 'type' => 'datetime'], ['key' => 'replied_at', 'label' => 'تاريخ الرد', 'type' => 'datetime'] ] ],
    ],
];
