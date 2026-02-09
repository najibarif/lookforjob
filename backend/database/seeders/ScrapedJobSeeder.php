<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScrapedJob;

class ScrapedJobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'position' => 'Senior Backend Engineer',
                'company' => 'Grab',
                'location' => 'Jakarta, Indonesia',
                'salary' => 'IDR 25.000.000 - 45.000.000',
                'jobUrl' => 'https://www.linkedin.com/jobs/search?keywords=Grab%20Backend%20Engineer&location=Indonesia',
                'companyLogo' => 'https://grab.careers/wp-content/uploads/2021/05/grab-logo-green.svg',
                'agoTime' => '2 days ago',
                'keyword' => 'Backend'
            ],
            [
                'position' => 'Frontend Engineer',
                'company' => 'Tripla Co., Ltd.',
                'location' => 'Remote / Indonesia',
                'salary' => 'Confidential',
                'jobUrl' => 'https://www.linkedin.com/jobs/search?keywords=Tripla%20Frontend&location=Indonesia',
                'companyLogo' => 'https://tripla.io/wp-content/themes/tripla/assets/images/logo.svg',
                'agoTime' => '1 day ago',
                'keyword' => 'Frontend'
            ],
            [
                'position' => 'Backend Developer',
                'company' => 'Shopee',
                'location' => 'Jakarta, Indonesia',
                'salary' => 'Competitive',
                'jobUrl' => 'https://www.jobstreet.co.id/id/job-search?keywords=Shopee%20Backend',
                'companyLogo' => 'https://deo.shopeemobile.com/shopee/shopee-careers-live-sg/assets/img/shopee-logo.4623787.png',
                'agoTime' => '3 days ago',
                'keyword' => 'Backend'
            ],
            [
                'position' => 'Software Engineer',
                'company' => 'Tokopedia',
                'location' => 'Jakarta, Indonesia',
                'salary' => 'Competitive',
                'jobUrl' => 'https://www.linkedin.com/jobs/search?keywords=Tokopedia%20Software%20Engineer&location=Indonesia',
                'companyLogo' => 'https://ecs7.tokopedia.net/assets-tokopedia-lite/v2/zeus/production/e5b8438b.svg',
                'agoTime' => '1 day ago',
                'keyword' => 'Fullstack'
            ],
            [
                'position' => 'Frontend Developer',
                'company' => 'MultitudeX',
                'location' => 'Jakarta, Indonesia',
                'salary' => 'IDR 8.000.000 - 15.000.000',
                'jobUrl' => 'https://glints.com/id/opportunities/jobs/explore?keyword=MultitudeX',
                'companyLogo' => 'https://images.glints.com/unsafe/glints-dashboard.s3.amazonaws.com/company-logo/85df1f6c407675276634739265f21223.png',
                'agoTime' => '2 days ago',
                'keyword' => 'Frontend'
            ],
            [
                'position' => 'Full Stack Developer',
                'company' => 'Eiger Adventure',
                'location' => 'Bandung, Indonesia',
                'salary' => 'IDR 10.000.000 - 15.000.000',
                'jobUrl' => 'https://www.jobstreet.co.id/id/job-search?keywords=Eiger%20Adventure%20Full%20Stack',
                'companyLogo' => 'https://eigerindo.co.id/wp-content/uploads/2021/08/logo-eiger-new.png',
                'agoTime' => '1 week ago',
                'keyword' => 'Fullstack'
            ]
        ];

        foreach ($jobs as $job) {
            ScrapedJob::create([
                'position' => $job['position'],
                'company' => $job['company'],
                'location' => $job['location'],
                'date' => now(), // Add required date field
                'salary' => $job['salary'],
                'jobUrl' => $job['jobUrl'],
                'companyLogo' => $job['companyLogo'],
                'agoTime' => $job['agoTime'],
                'keyword' => $job['keyword'],
            ]);
        }
    }
}
