# Features & Module Specifications

## 🎯 Public Portfolio Landing Page

### 1. Hero Section
- **Dynamic Profile Details**: Displays dynamic headline, bio text, availability badge ("Available for Freelance/Full-time Roles"), and downloadable resume trigger managed from Admin Dashboard.
- **Social Media Quick Links**: GitHub, LinkedIn, Twitter/X, Email, and custom portfolio links dynamically rendered from database settings.
- **Interactive Quick Metrics**: Real-time stats (Years of experience, Completed projects, Technologies mastered, Code contributions).

### 2. Projects Showcase
- **Category Filter Tabs**: Instant filtering by tags (All, Full-Stack, Vue.js & Laravel, Mobile, AI/Machine Learning).
- **Featured Highlights Carousel / Grid**: Glassmorphism cards with smooth hover tilt effect, high-res previews, tech stack badges, GitHub repo link, and live demo buttons.
- **Project Detail Modal**: Rich modal dialog showing complete project breakdown, key features, screenshot galleries, and architecture notes.

### 3. Interactive Skills Matrix
- **Category Grouping**: Grouped into Frontend, Backend, Database/DevOps, and Tools/Libraries.
- **Visual Proficiency Meters**: Animated percentage progress bars and icon badges.
- **Filterable Search Bar**: Search skills by name or technology stack.

### 4. Experience & Career Timeline
- **Interactive Vertical Timeline**: Dual view for Work Experience and Education.
- **Expandable Achievement Highlights**: Bullet points detailing role responsibilities, key metrics, and tools utilized.

### 5. Contact & Inquiries Module
- **Real-Time Inertia Contact Form**: Submits messages directly into the database inbox with instant Pinia toast feedback.
- **Input Validation**: Client-side & server-side validation for name, valid email, subject, and message.
- **Rate Limit & Bot Prevention**: Rate limiting applied to backend endpoints.

---

## 🔒 Admin Dashboard Panel (`/admin`)

### 1. Dashboard Overview
- **Key Metrics Summary**: Stat cards displaying Total Projects, Total Skills, Total Messages, Unread Messages count.
- **Quick Action Bar**: One-click actions to add new project, add new skill, or view latest messages.
- **Recent Activities Feed**: Latest contact entries and site update logs.

### 2. Projects Manager
- **CRUD Operations**: Create, Read, Edit, and Delete portfolio projects.
- **Media & Link Management**: Upload images/provide links, set live demo URLs, GitHub repository URLs, and tag technologies.
- **Featured Toggle**: Instant switch to flag projects for hero/featured display.
- **Custom Ordering**: Re-order projects to control display hierarchy on the landing page.

### 3. Skills Manager
- **Category & Level Management**: Add and update skills with proficiency percentages (1-100%) and icons.
- **Quick Toggle**: Enable or disable skill badges from public view.

### 4. Experience & Education Manager
- **Timeline Entry Editor**: Manage company names, job titles, start/end dates, current status, and achievements.

### 5. Messages Inbox
- **Inquiries Table**: View all messages submitted via the portfolio contact form.
- **Read / Unread Status**: Click to open full message body and mark as read.
- **Quick Actions**: Direct mailto reply trigger and delete action.

### 6. Profile & Site Settings Editor
- **Live Profile Customizer**: Edit headline title, bio paragraph, status badge, resume URL, contact email, and social media handles.
