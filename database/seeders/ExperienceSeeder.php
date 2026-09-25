<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'company' => 'Meshsq Pvt Ltd',
                'role' => 'Full Stack Developer',
                'period' => 'April 20, 2026 – Present',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Contributing to the development of DocHyve, a full-stack web application built with Laravel, React.js, and Tailwind CSS.',
                'highlights' => [
                    'Contributing to the development of DocHyve, a full-stack web application built with Laravel, React.js, and Tailwind CSS.',
                    'Developing and maintaining scalable backend functionality using Laravel, including RESTful APIs, business logic, database operations, and application integrations.',
                    'Building responsive and reusable frontend components with React.js and Tailwind CSS, focusing on usability, performance, and maintainable UI architecture.',
                    'Collaborating with the development team to analyze requirements, implement new features, troubleshoot issues, and continuously improve the DocHyve platform.',
                    'Following clean coding practices, Git-based development workflows, code reviews, and established software engineering standards to deliver reliable and maintainable solutions.',
                ],
                'technologies' => ['Laravel', 'React.js', 'Tailwind CSS', 'RESTful APIs', 'Git'],
                'type' => 'work',
                'order' => 1,
            ],
            [
                'company' => 'Goritmi Pvt Ltd',
                'role' => 'Senior Software Developer | Team Lead',
                'period' => 'Sept 1, 2025 – 1 April, 2026',
                'location' => 'Peshawar, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Led a cross-functional development team in architecting and delivering a scalable, high-performance EPOS System using Laravel, Vue.js, and Tailwind CSS.',
                'highlights' => [
                    'Led a cross-functional development team in architecting and delivering a scalable, high-performance EPOS System using Laravel, Vue.js, and Tailwind CSS.',
                    'Architected and implemented key modules, including POS order management, cashier and shift tracking, promotions and discounts, automated receipt printing, customer display interface, real-time inventory synchronization, and automated X and Z reports.',
                    'Built real-time customer view and live order updates, enhancing user engagement and operational efficiency.',
                    'Integrated third-party services including Stripe, SendGrid, and AWS S3 to enhance system functionality and reliability.',
                    'Optimized database performance through efficient indexing, caching, and query tuning, while enforcing clean architecture and modular coding practices to ensure long-term maintainability.',
                    'Collaborated with stakeholders and internal teams to define product requirements, manage sprints, and deliver critical features on schedule, improving business operations and user experience.',
                ],
                'technologies' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'Stripe', 'SendGrid', 'AWS S3', 'EPOS System', 'RESTful APIs'],
                'type' => 'work',
                'order' => 2,
            ],
            [
                'company' => 'Cloud Rexpo',
                'role' => 'Laravel Developer',
                'period' => 'May, 2025 – 30 Aug, 2025',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Contributed to the development of a Real Estate CRM System built with Laravel, third-party integrations, and RBAC.',
                'highlights' => [
                    'Contributed to the development of a Real Estate CRM System built with Laravel.',
                    'Collaborated with senior developers to debug complex issues, refactor legacy code, and integrate additional modules, including Stripe payment integration, Google Calendar, AWS for image upload, SendGrid, and Gmail Inbox.',
                    'Engineered a secure user role-based access control (RBAC) system and introduced real-time notifications, improving operational transparency and reducing response time for user actions.',
                ],
                'technologies' => ['Laravel', 'Stripe', 'Google Calendar', 'AWS S3', 'SendGrid', 'RBAC', 'RESTful APIs'],
                'type' => 'work',
                'order' => 3,
            ],
            [
                'company' => 'Techinn360',
                'role' => 'Full Stack Developer',
                'period' => 'June, 2024 – May 2025',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Architected and developed diverse web applications including a GCC-wide Automotive E-Commerce Platform, Real-Time Speed Auction Application, and Spartan LMS.',
                'highlights' => [
                    'Leveraged full-stack expertise (Laravel, Vue.js, React) to architect, develop, and implement diverse web applications, including a UAE-based Automotive E-Commerce Platform serving customers across the UAE and the wider GCC region (Oman, Saudi Arabia, Bahrain, Kuwait, Qatar) with a 168+ product catalog, a Real-Time Speed Auction Application, and a Spartan Learning Management System.',
                    'Achieved a 93 Accessibility, 96 Best Practices, and 100 SEO score (Google Lighthouse) on the Automotive E-Commerce Platform, ensuring compliance with Web Content Accessibility Guidelines (WCAG) 2.2 and improving accessibility for users.',
                    'Applied Test-Driven Development (TDD) practices to deliver high-quality, maintainable, and reliable code.',
                    'Enhanced team collaboration and streamlined development workflows by adopting Agile methodologies, including Scrum, resulting in more efficient software delivery and better adaptation to project needs.',
                    'Effectively analyzed complex technical challenges, such as optimizing application performance for high traffic, integrating systems, and implementing robust state management solutions in complex UIs, and implemented creative and efficient solutions, contributing to the successful development and deployment of applications.',
                    'Ensured code quality and resolved issues through thorough debugging, comprehensive testing, and adherence to established best practices.',
                ],
                'technologies' => ['Laravel', 'Vue.js', 'React', 'TDD', 'Agile/Scrum', 'WCAG 2.2', 'SEO', 'E-Commerce'],
                'type' => 'work',
                'order' => 4,
            ],
            [
                'company' => 'TriTech Soft Solutions',
                'role' => 'Junior Laravel Developer',
                'period' => 'March, 2023 – June 2024',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Developed dynamic web applications, backend logic, and RESTful APIs for CRM systems with Laravel, Vue.js, and React.',
                'highlights' => [
                    'Worked extensively with databases, JavaScript, React.js, Vue.js, and Laravel to develop and maintain dynamic web applications, implementing efficient backend logic and robust database management practices.',
                    'Developed and maintained RESTful APIs for a CRM System, showcasing strong backend logic experience transferable to Laravel’s MVC structure and API resources.',
                    'Utilized Git version control for seamless collaboration with team members, effectively organizing modifications and tracking task assignments.',
                ],
                'technologies' => ['Laravel', 'JavaScript', 'React.js', 'Vue.js', 'RESTful APIs', 'Git', 'MySQL'],
                'type' => 'work',
                'order' => 5,
            ],
            [
                'company' => 'National Freelancing Training Program (NFTP)',
                'role' => 'Full Stack Training',
                'period' => 'Dec 09, 2022 – March 2023',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Completed comprehensive freelancing and software development training, focusing on industry-standard tools and practices.',
                'highlights' => [
                    'Completed comprehensive freelancing and software development training, focusing on industry-standard tools and practices.',
                    'Developed practical skills in areas such as full-stack development, project management, and client communication.',
                ],
                'technologies' => ['Full Stack Development', 'JavaScript', 'PHP', 'Freelancing', 'Project Management'],
                'type' => 'certification',
                'order' => 6,
            ],
            [
                'company' => 'University of Engineering and Technology Mardan',
                'role' => 'Bachelor of Computer Software Engineering',
                'period' => 'Oct, 2020 – June 2024',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Degree',
                'description' => 'Bachelor of Computer Software Engineering with core focus on Software Architecture, Data Structures, Relational Database Systems, and Object-Oriented Software Design.',
                'highlights' => [
                    'Bachelor of Computer Software Engineering with core focus on Software Architecture, Data Structures, Relational Database Systems, and Object-Oriented Software Design.',
                    'Studied modern web technologies, distributed applications, and engineering best practices.',
                ],
                'technologies' => ['Software Engineering', 'Algorithms', 'Databases', 'Git', 'Web Development'],
                'type' => 'education',
                'order' => 7,
            ],
        ];

        Experience::truncate();
        foreach ($experiences as $expData) {
            Experience::create($expData);
        }
    }
}
