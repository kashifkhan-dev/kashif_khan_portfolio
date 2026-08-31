# Comprehensive Developer & Operational Documentation

## 1. Project Directory Structure

```
kashif-khan-portfolio/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LandingController.php      # Serves public portfolio views via Inertia
│   │       ├── ContactController.php      # Processes contact form submissions
│   │       └── Admin/
│   │           ├── DashboardController.php# Admin dashboard metrics
│   │           ├── ProjectController.php  # Projects CRUD logic
│   │           ├── SkillController.php    # Skills CRUD logic
│   │           ├── ExperienceController.php# Experience CRUD logic
│   │           ├── MessageController.php  # Inbox logic
│   │           └── SettingController.php  # Site profile settings
│   └── Models/
│       ├── Project.php
│       ├── Skill.php
│       ├── Experience.php
│       ├── Message.php
│       └── Setting.php
├── config/
├── database/
│   ├── migrations/                        # DB schema definition files
│   └── seeders/                           # Seed initial portfolio & admin data
├── resources/
│   ├── js/
│   │   ├── app.js                         # Inertia + Vue 3 + Pinia entry script
│   │   ├── Components/                    # Reusable Shadcn & UI components
│   │   │   ├── PrimaryButton.vue
│   │   │   ├── ProjectCard.vue
│   │   │   ├── SkillBadge.vue
│   │   │   ├── Modal.vue
│   │   │   └── Toast.vue
│   │   ├── Layouts/
│   │   │   ├── GuestLayout.vue            # Public navigation & footer layout
│   │   │   └── AuthenticatedLayout.vue    # Admin dashboard layout
│   │   ├── Pages/
│   │   │   ├── Welcome.vue                # Main Portfolio Landing Page
│   │   │   ├── Auth/                      # Login & authentication pages
│   │   │   └── Admin/                     # Admin section pages
│   │   │       ├── Dashboard.vue
│   │   │       ├── Projects/
│   │   │       ├── Skills/
│   │   │       ├── Experiences/
│   │   │       ├── Messages/
│   │   │       └── Settings.vue
│   │   └── stores/                        # Pinia state stores
│   │       ├── usePortfolioStore.js
│   │       ├── useAdminStore.js
│   │       └── useNotificationStore.js
│   └── css/
│       └── app.css                        # Tailwind CSS styles & custom glassmorphism
├── routes/
│   ├── web.php                            # Inertia web routes & admin middleware routes
│   └── auth.php                           # Authentication routes
├── architecture.md                        # Architecture documentation
├── features.md                            # Feature breakdown
├── docs.md                                # Developer guide (this file)
└── integrations.md                        # Third-party integrations
```

---

## 2. Environment Configuration (`.env`)

Ensure your MySQL server is running locally (e.g. via XAMPP or MySQL Service) and create a database named `kashif_portfolio`.

```env
APP_NAME="Kashif Khan Portfolio"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kashif_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Pinia State Management Guide

Pinia is configured in `resources/js/app.js`:

```javascript
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';

const pinia = createPinia();

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .mount(el);
  },
});
```

---

## 4. Default Seeded Admin Credentials

After running `php artisan migrate:fresh --seed`, default login credentials for the admin dashboard will be created:

- **Login URL**: `http://localhost:8000/login`
- **Email**: `admin@kashifkhan.com`
- **Password**: `password` (or custom configured password)

> [!WARNING]
> Change the default admin password in production immediately after first login.
