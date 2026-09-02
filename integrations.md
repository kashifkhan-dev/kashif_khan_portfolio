# System Integrations & External Services

## 1. Database & Persistence Layer (MySQL)

- **Engine**: MySQL 8.x / MariaDB
- **ORM**: Laravel Eloquent
- **Connection Configuration**: `.env` driven parameters (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- **Features**: Foreign keys, soft deletes (where applicable), JSON attribute casting for tech stacks, and transaction safety.

---

## 2. Frontend Interactivity & UI Stack

### A. Vue 3 (Composition API)
- Utilizes `<script setup>` syntax across all page views and reusable components.

### B. Pinia State Management
- Reactive state management across views.
- Keeps client state synchronized with server responses returned by Inertia page props.

### C. Shadcn Vue & Tailwind CSS
- Accessible UI components (Dialogs, Dropdowns, Cards, Badges, Tooltips).
- Tailwind utilities with glassmorphism aesthetic (`backdrop-blur-md`, custom gradients, dark mode support).

### D. Lucide Icons (`lucide-vue-next` / `lucide-react`)
- Vector iconography for skills, navigation, admin sidebar, and social links.

---

## 3. Email & Gmail SMTP Integration

The portfolio includes an administrative Gmail-style inbox supporting direct email replies sent directly via your Gmail account using SMTP.

### A. Environment Configuration (`.env`)
To enable direct email sending from the dashboard, set the following parameters in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_16_character_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="Kashif Khan Dev"
```

### B. How to Obtain a Gmail App Password:
1. Go to your [Google Account Security](https://myaccount.google.com/security) page.
2. Ensure **2-Step Verification** is enabled for your Google account.
3. In the search bar at the top of Google Account, search for **App Passwords**.
4. Create a new App Password (App name: `Portfolio Dashboard`).
5. Copy the generated 16-character password (e.g. `abcd efgh ijkl mnop`) and paste it into `MAIL_PASSWORD` in your `.env` file without spaces.

### C. Inquiry Dispatch Workflow:
- When a client sends a message via the contact form on your portfolio landing page, it is stored in the database.
- Admin opens the **Gmail Inquiries** inbox in the dashboard and writes a response in the built-in email composer canvas.
- Clicking **Send** dispatches an HTML email response directly to the client's email address via Gmail SMTP.
- The complete message thread (original inquiry + all sequential replies) is saved in the database.

---

## 4. Optional AI Integration (Gemini AI Chatbot)

- **Package**: `@google/genai`
- **Purpose**: Optional interactive portfolio AI assistant capable of answering recruiter questions about Kashif's experience, background, and tech stack in real-time.
- **Environment Key**:
  ```env
  GEMINI_API_KEY="YOUR_GEMINI_API_KEY"
  ```
