# 🧱 Service Layer & Thin Controllers Architecture (`services.md`)

To maintain clean code separation, maximum testability, and slim controllers, this project enforces the **Form Request + Service Layer Architecture**.

---

## 🏛️ Architectural Flow

```
HTTP Request 
   │
   ▼
Form Request Class (app/Http/Requests/*)
   │ (Validation & Authorization)
   ▼
Controller Action (app/Http/Controllers/*)
   │ (Thin Delegate - 1 to 3 lines)
   ▼
Service Class (app/Services/*)
   │ (Business Logic, DB Transactions, Model Manipulation)
   ▼
Inertia Response / Redirect Response
```

---

## 📁 Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── LandingController.php        (Delegates to LandingService)
│   │   ├── ContactController.php        (Delegates to ContactService)
│   │   └── Admin/
│   │       ├── DashboardController.php  (Delegates to DashboardService)
│   │       ├── ProjectController.php    (Delegates to ProjectService)
│   │       ├── SkillController.php      (Delegates to SkillService)
│   │       ├── ExperienceController.php (Delegates to ExperienceService)
│   │       ├── MessageController.php    (Delegates to MessageService)
│   │       └── SettingController.php    (Delegates to SettingService)
│   │
│   └── Requests/
│       ├── ContactRequest.php
│       └── Admin/
│           ├── StoreProjectRequest.php
│           ├── UpdateProjectRequest.php
│           ├── StoreSkillRequest.php
│           ├── UpdateSkillRequest.php
│           ├── StoreExperienceRequest.php
│           ├── UpdateExperienceRequest.php
│           └── UpdateSettingRequest.php
│
└── Services/
    ├── LandingService.php
    ├── ContactService.php
    ├── DashboardService.php
    ├── ProjectService.php
    ├── SkillService.php
    ├── ExperienceService.php
    ├── MessageService.php
    └── SettingService.php
```

---

## 📋 Architectural Rules & Developer Commandments

1. **No Inline Validation in Controllers**: Controllers must NEVER call `$request->validate([...])`. Always type-hint a dedicated `FormRequest` class.
2. **No Eloquent Queries in Controllers**: Controllers must NEVER directly invoke `Model::create()`, `Model::where()`, or `Model::find()`. All database interactions belong inside `app/Services/`.
3. **Controller Responsibilities**: Controllers only type-hint Form Requests/Services and return `Inertia::render()` or `redirect()->back()`.
4. **Service Class Responsibilities**: Services execute database persistence, slug formatting, file uploads, notifications, and aggregate metrics.
