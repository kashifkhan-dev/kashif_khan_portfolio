<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'hero_title' => 'Senior Full-Stack Architect & AI Developer',
            'hero_title_1' => 'Kashif Khan',
            'hero_title_2' => 'Software Engineer',
            'hero_title_3' => 'Fullstack Developer',
            'hero_subtitle' => 'Building scalable web applications, modern interactive platforms, and robust enterprise solutions with Laravel, Vue 3, and Cloud Infrastructures.',
            'bio' => 'Passionate Software Engineer with 5+ years of experience architecting high-performance web applications, API integrations, and intuitive dashboards. Specialized in Laravel, Vue.js, Tailwind CSS, Inertia.js, and AI automation.',
            'availability_status' => 'Available for Full-time Roles & Contracts',
            'contact_email' => 'kashifkhannee@gmail.com',
            'cal_url' => 'https://cal.com/kashif-khan',
            'github_url' => 'https://github.com/KashifKhan456',
            'linkedin_url' => 'https://linkedin.com/in/kashifkhan',
            'twitter_url' => 'https://x.com/kashifkhan',
            'resume_url' => '#',
        ];

        foreach ($settings as $key => $value) {
            Setting::setByKey($key, $value);
        }
    }
}
