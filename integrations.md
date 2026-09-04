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

## 3. Contact Inquiry & Direct Gmail Workflow

The portfolio manages client contact inquiries through a zero-dependency, high-performance database & direct Gmail deep-link workflow.

### A. Inquiry Submission:
- When a client submits a message via the website contact form (`/contact`), it is saved directly into the database.
- Fast, secure, and immune to server timeout limits or hosting SMTP port blocks.

### B. Direct Gmail Reply Workflow:
- In the **Admin Dashboard (`/admin/messages`)**, every inquiry displays the client's details, message snippet, and status.
- **1-Click Gmail Deep Linking**: Hovering over any message row or viewing an inquiry displays a prominent **"Open in Gmail Web"** action button.
- Clicking **"Open in Gmail Web"** opens a pre-filled Gmail Compose window in a new browser tab (`To: client@email.com`, `Subject: Re: ...`) so you can reply to and manage all client conversations directly inside your Gmail inbox.

### C. Simplified Environment Configuration (`.env`):
No Google App Passwords or SMTP credentials are required in `.env`:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="kashifkhannee@gmail.com"
MAIL_FROM_NAME="Kashif Khan Dev"
```

---

## 4. Optional AI Integration (Gemini AI Chatbot)

- **Package**: `@google/genai`
- **Purpose**: Optional interactive portfolio AI assistant capable of answering recruiter questions about Kashif's experience, background, and tech stack in real-time.
- **Environment Key**:
  ```env
  GEMINI_API_KEY="YOUR_GEMINI_API_KEY"
  ```
