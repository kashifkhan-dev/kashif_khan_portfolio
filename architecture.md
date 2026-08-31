# System Architecture & Technical Specifications

## 1. High-Level Architecture Overview

The system uses the **Inertia.js Modern Monolith** pattern with **Laravel 11** powering backend business logic, ORM models, authentication, and database transactions, while **Vue 3 (Composition API)** and **Pinia State Management** handle client-side view rendering, interactivity, and UI state management.

```
                  +-----------------------------------+
                  |        Browser / Client           |
                  |  Vue 3 + Pinia + Shadcn UI + CSS  |
                  +-----------------+-----------------+
                                    |
                          Inertia.js Protocol
                                    |
                  +-----------------v-----------------+
                  |         Laravel 11 Kernel         |
                  | Controllers | Middleware | Auth   |
                  +-----------------+-----------------+
                                    |
                             Eloquent ORM
                                    |
                  +-----------------v-----------------+
                  |          MySQL Database           |
                  | (Projects, Skills, Messages, etc) |
                  +-----------------------------------+
```

---

## 2. Pinia State Management Architecture

Pinia provides predictable, centralized reactive stores across both public layout and admin dashboard:

```
src/
└── stores/
    ├── usePortfolioStore.js   # Global portfolio data (projects, filter states, skills, site profile)
    ├── useAdminStore.js       # Admin panel state (active drawer, inline table edit state, modal forms)
    ├── useNotificationStore.js# Global toast alerts, banner messages, error feedback
    └── useThemeStore.js       # Dark / Light theme toggles & accent colors persistence
```

### Store Responsibilities:
1. **`usePortfolioStore`**:
   - Holds active category filter (`All`, `Fullstack`, `Frontend`, `Laravel/Vue`, `AI`).
   - Manages selected project detail modal state.
   - Provides getter filters for featured projects and top skills.

2. **`useAdminStore`**:
   - Manages CRUD dialog state (Create/Edit Project Modal, Skill Form Modal, Experience Timeline Modal).
   - Tracks optimistic updates before server sync.
   - Maintains unread contact message counters in header.

3. **`useNotificationStore`**:
   - Dispatches temporary feedback toasts upon contact form submission or admin updates.

---

## 3. Database Entity Relationship Diagram (ERD)

```
+-------------------+       +-------------------+       +-------------------+
|       Users       |       |     Projects      |       |      Skills       |
+-------------------+       +-------------------+       +-------------------+
| id (PK)           |       | id (PK)           |       | id (PK)           |
| name              |       | title             |       | name              |
| email             |       | slug              |       | category          |
| password          |       | summary           |       | proficiency       |
| remember_token    |       | description       |       | icon              |
| created_at        |       | image_path        |       | order             |
| updated_at        |       | tech_stack (json) |       | is_featured       |
+-------------------+       | demo_url          |       +-------------------+
                            | github_url        |
                            | is_featured       |       +-------------------+
                            | order             |       |    Experiences    |
                            +-------------------+       +-------------------+
                                                        | id (PK)           |
+-------------------+       +-------------------+       | company           |
|     Messages      |       |     Settings      |       | role              |
+-------------------+       +-------------------+       | period            |
| id (PK)           |       | id (PK)           |       | description       |
| sender_name       |       | key (unique)      |       | type (job/edu)    |
| sender_email      |       | value (text/json) |       | order             |
| subject           |       +-------------------+       +-------------------+
| body              |
| is_read           |
| created_at        |
+-------------------+
```

---

## 4. Security & Middleware Layer

- **Authentication**: Laravel Session-based Auth protecting all `/admin/*` endpoints.
- **CSRF Protection**: Native Laravel CSRF tokens passed automatically by Inertia.
- **Sanitization**: Form request validation rules enforcing strict inputs for portfolio content & contact messages.
- **Rate Limiting**: Contact endpoint restricted to prevent spam submissions.
