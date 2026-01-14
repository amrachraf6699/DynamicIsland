<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'تصميم الهوية البصرية المتكاملة',
                'content' => '<p>نساعدك في تصميم هوية بصرية احترافية تشمل الشعار، الألوان، والخطوط بما يعكس قيم علامتك التجارية.</p>',
                'delivery_days' => 14,
                'featured' => true,
                'is_active' => true,
                'requestable' => true,
                'meta_title' => 'تصميم هوية بصرية',
                'meta_description' => 'بناء هوية متكاملة للعلامات التجارية.',
                'requests' => [
                    [
                        'name' => 'خالد علي',
                        'email' => 'khaled@example.com',
                        'phone_country_code' => '+971',
                        'phone_number' => '501234567',
                    ],
                    [
                        'name' => 'سارة محمود',
                        'email' => 'sara@example.com',
                        'phone_country_code' => '+20',
                        'phone_number' => '1098765432',
                    ],
                ],
            ],
            [
                'title' => 'تطوير مواقع الشركات',
                'content' => '<p>نطور مواقع مخصصة بأحدث التقنيات، مع التركيز على الأداء وتجربة المستخدم.</p>',
                'delivery_days' => 21,
                'featured' => false,
                'is_active' => true,
                'requestable' => true,
                'meta_title' => 'تطوير مواقع الشركات',
                'meta_description' => 'بناء مواقع حديثة للشركات والمؤسسات.',
                'requests' => [
                    [
                        'name' => 'مروان شريف',
                        'email' => null,
                        'phone_country_code' => '+966',
                        'phone_number' => '541112233',
                    ],
                ],
            ],
            [
                'title' => 'تحسين محركات البحث (SEO)',
                'content' => '<p>نعمل على تحسين ظهور موقعك في نتائج البحث من خلال استراتيجية محتوى وروابط محسّنة.</p>',
                'delivery_days' => 30,
                'featured' => false,
                'is_active' => true,
                'requestable' => true,
                'meta_title' => 'خدمة SEO',
                'meta_description' => 'تحسين ترتيب الموقع في نتائج البحث.',
                'requests' => [
                    [
                        'name' => 'ليان فهد',
                        'email' => 'lian@example.com',
                        'phone_country_code' => null,
                        'phone_number' => null,
                    ],
                    [
                        'name' => 'أحمد سالم',
                        'email' => 'ahmad@example.com',
                        'phone_country_code' => '+974',
                        'phone_number' => '66123456',
                    ],
                ],
            ],
        ];

        foreach ($services as $entry) {
            $requests = Arr::pull($entry, 'requests', []);

            $createdAt = Carbon::now()->subDays(rand(1, 180));

            $service = Service::updateOrCreate(
                ['title' => $entry['title']],
                array_merge($entry, [
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])
            );

            foreach ($requests as $requestData) {
                $requestCreatedAt = Carbon::now()->subDays(rand(0, 365));

                ServiceRequest::firstOrCreate(
                    [
                        'service_id' => $service->id,
                        'name' => $requestData['name'],
                        'email' => $requestData['email'],
                        'phone_number' => $requestData['phone_number'],
                    ],
                    array_merge($requestData, [
                        'service_id' => $service->id,
                        'created_at' => $requestCreatedAt,
                        'updated_at' => $requestCreatedAt,
                    ])
                );
            }
        }
    }
}
