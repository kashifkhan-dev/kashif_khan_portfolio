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

## 3. Optional AI Integration (Gemini AI Chatbot)

- **Package**: `@google/genai`
- **Purpose**: Optional interactive portfolio AI assistant capable of answering recruiter questions about Kashif's experience, background, and tech stack in real-time.
- **Environment Key**:
  ```env
  GEMINI_API_KEY="YOUR_GEMINI_API_KEY"
  ```
