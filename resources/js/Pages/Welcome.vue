<template>
  <GuestLayout :canLogin="canLogin" :settings="settings">
    <Head title="Kashif Khan - Full-Stack Engineer" />

    <!-- 1. HERO SECTION -->
    <section id="about" class="min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto py-24 bg-white dark:bg-black transition-colors duration-300">
      <div class="w-full text-center space-y-8">
        <!-- Status Pill -->
        <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-md bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-800 dark:text-neutral-200 text-sm font-sans font-medium shadow-xs">
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
          <span>{{ settings.availability_status || 'Available for Full-time Roles & Contracts' }}</span>
        </div>

        <!-- Headline -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-slate-900 dark:text-white">
          <span>{{ settings.hero_title_1 || "Hi, I'm Kashif Khan." }}</span> <br v-if="settings.hero_title_2 || !settings.hero_title_1" />
          <span class="text-slate-600 dark:text-neutral-300">{{ settings.hero_title_2 || "Full-Stack Web Engineer." }}</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg sm:text-xl text-slate-600 dark:text-neutral-300 leading-relaxed max-w-3xl mx-auto">
          {{ settings.hero_subtitle || 'Specializing in React.js, Next.js, Vue 3, Laravel, Tailwind CSS, and modern web applications. Over 5+ years of experience building fast, reliable digital products.' }}
        </p>

        <!-- CTA Buttons -->
        <div class="pt-4 flex flex-wrap items-center justify-center gap-5">
          <a
            :href="settings.hero_cta_primary_link || '#projects'"
            class="px-8 py-4 rounded-md bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-neutral-200 text-white dark:text-black font-bold text-base shadow-xl transition-all transform hover:scale-[1.02]"
          >
            {{ settings.hero_cta_primary_text || 'View My Projects' }}
          </a>
          <a
            :href="settings.hero_cta_secondary_link || '#contact'"
            class="px-8 py-4 rounded-md bg-white hover:bg-slate-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-neutral-200 font-semibold text-base shadow-xs hover:shadow-sm transition-all"
          >
            {{ settings.hero_cta_secondary_text || 'Get in Touch' }}
          </a>
        </div>
      </div>
    </section>

    <!-- 2. CLEAN MINIMALIST TECH STACK SECTION -->
    <section id="skills" class="py-16 bg-white dark:bg-black transition-colors duration-300 overflow-hidden relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3 mb-10">
        <h2 class="text-xs font-mono uppercase tracking-widest text-slate-500 dark:text-neutral-400">Technical Capability</h2>
        <h3 class="text-3xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">Skills &amp; Technologies</h3>
        <p class="text-slate-600 dark:text-neutral-300 text-sm sm:text-base max-w-xl mx-auto">Frameworks, languages, and modern tools I engineer solutions with.</p>
      </div>

      <!-- Infinite Logo Ticker Ribbon (Borderless Canvas) -->
      <div class="relative w-full overflow-hidden py-4">
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-white dark:from-black to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-white dark:from-black to-transparent z-10 pointer-events-none"></div>

        <div class="animate-marquee space-x-10">
          <div
            v-for="(item, idx) in marqueeItems"
            :key="idx"
            class="text-slate-700 hover:text-slate-900 dark:text-neutral-300 dark:hover:text-white text-base sm:text-lg font-bold font-sans tracking-tight flex items-center space-x-3 shrink-0 transition-colors cursor-default"
          >
            <TechIcon :name="item.icon || 'api'" class="w-6 h-6 opacity-90" />
            <span>{{ item.name }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. PROJECTS SHOWCASE -->
    <section id="projects" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-white dark:bg-black transition-colors duration-300">
      <div class="text-center space-y-4 mb-16">
        <h2 class="text-sm font-mono uppercase tracking-widest text-slate-500 dark:text-neutral-400">Portfolio</h2>
        <h3 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">Featured Projects</h3>
        <p class="text-slate-600 dark:text-neutral-300 text-base sm:text-lg max-w-lg mx-auto">A selection of recent web applications and platforms.</p>

        <!-- Category Filters -->
        <div class="pt-6 flex flex-wrap items-center justify-center gap-3">
          <button
            v-for="cat in portfolioStore.availableCategories"
            :key="cat"
            @click="portfolioStore.setProjectCategory(cat)"
            class="px-5 py-2 rounded-md text-sm font-medium transition-all cursor-pointer"
            :class="portfolioStore.activeProjectCategory === cat
              ? 'bg-slate-900 text-white dark:bg-white dark:text-black font-bold shadow-md'
              : 'bg-white text-slate-700 hover:text-slate-900 dark:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800 border border-slate-200 dark:border-neutral-800 shadow-xs'"
          >
            {{ cat }}
          </button>
        </div>
      </div>

      <!-- Project Grid (Top Curated Projects driven by Admin settings) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in (projects || []).slice(0, Number(settings?.featured_projects_count) || 3)"
          :key="project.id"
          class="bg-white dark:bg-neutral-950 border border-slate-200 dark:border-neutral-800 rounded-md overflow-hidden hover:border-slate-300 dark:hover:border-neutral-700 transition-all flex flex-col justify-between group shadow-sm dark:shadow-lg"
        >
          <div>
            <!-- Image Header -->
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="relative h-56 w-full overflow-hidden bg-slate-100 dark:bg-black cursor-pointer block"
            >
              <img
                :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                :alt="project.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90 group-hover:opacity-100"
              />
              <div class="absolute top-4 left-4 flex items-center space-x-2">
                <span
                  v-if="project.is_featured"
                  class="px-2.5 py-1 rounded-md bg-slate-900 text-white dark:bg-white dark:text-black text-xs font-bold uppercase"
                >
                  Featured
                </span>
                <span class="px-2.5 py-1 rounded-md bg-white/90 text-slate-800 dark:bg-black/80 dark:text-neutral-200 text-xs font-mono border border-slate-200 dark:border-neutral-800 shadow-xs">
                  {{ project.category }}
                </span>
              </div>
            </Link>

            <!-- Content Body -->
            <div class="p-5 space-y-3">
              <Link :href="route('projects.show', project.slug || project.id)" class="block">
                <h4 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-neutral-300 transition-colors cursor-pointer">
                  {{ project.title }}
                </h4>
              </Link>
              <p class="text-slate-600 dark:text-neutral-300 text-sm sm:text-base leading-relaxed line-clamp-3">
                {{ project.summary || project.description }}
              </p>

              <!-- Tech Pills -->
              <div class="flex flex-wrap gap-1.5 pt-1">
                <span
                  v-for="(tech, i) in (project.tech_stack || [])"
                  :key="i"
                  class="px-2.5 py-1 rounded-md bg-white text-slate-700 dark:bg-neutral-900 dark:text-neutral-200 text-xs font-mono border border-slate-200 dark:border-neutral-800 shadow-xs"
                >
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>

          <!-- Card Actions / Footer -->
          <div class="px-5 py-3.5 flex items-center justify-between border-t border-slate-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-950/60 mt-auto">
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="text-sm font-bold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-neutral-300 transition-colors flex items-center space-x-1.5 cursor-pointer"
            >
              <span>View Details</span>
              <span>→</span>
            </Link>
            <div class="flex items-center space-x-3 text-sm">
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                class="text-slate-600 hover:text-slate-900 dark:text-neutral-300 dark:hover:text-white font-mono text-xs flex items-center space-x-1.5 transition-colors"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
                <span>GitHub</span>
              </a>
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="px-3.5 py-2 rounded-sm bg-slate-900 text-white hover:bg-slate-800 dark:bg-white dark:text-black font-bold text-xs dark:hover:bg-neutral-200 transition-colors flex items-center space-x-1.5"
              >
                <span>Demo</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Dedicated /projects Page CTA Link -->
      <div v-if="(projects || []).length > (Number(settings?.featured_projects_count) || 3)" class="mt-10 text-center">
        <Link
          :href="route('projects.index')"
          class="px-6 py-2.5 rounded-md bg-slate-900 hover:bg-slate-800 text-white dark:bg-white dark:hover:bg-neutral-200 dark:text-black font-bold text-xs sm:text-sm shadow-lg transition-all inline-flex items-center space-x-2 cursor-pointer group hover:scale-105 transform"
        >
          <span>Explore All Projects ({{ (projects || []).length }})</span>
          <span class="group-hover:translate-x-1 transition-transform font-mono">→</span>
        </Link>
      </div>
    </section>

    <!-- 4. NOTION / LINEAR NESTED COLLAPSIBLE EXPERIENCE SECTION -->
    <section id="experience" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-white dark:bg-black transition-colors duration-300 border-t border-slate-200/80 dark:border-neutral-800/60">
      <!-- Section Title -->
      <div class="mb-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Experience</h2>
      </div>

      <!-- Main Experience Accordion List (Borderless Canvas) -->
      <div class="space-y-10 divide-y divide-neutral-900">
        <div
          v-for="(company, cIdx) in companyExperiences"
          :key="company.id"
          :class="{ 'pt-10': cIdx > 0 }"
          class="space-y-6"
        >
          <!-- Company Header -->
          <div class="flex items-center space-x-3">
            <!-- Company Logo Badge -->
            <div
              class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 shadow-sm"
              :class="company.logoBg"
            >
              <span>{{ company.logoText }}</span>
            </div>

            <!-- Company Name & Active Status Dot -->
            <div class="flex items-center space-x-2">
              <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                {{ company.company }}
              </h3>
              <span
                v-if="company.isActive"
                class="w-2.5 h-2.5 rounded-full bg-cyan-500 dark:bg-cyan-400 animate-pulse"
                title="Current Employer"
              ></span>
            </div>
          </div>

          <!-- Nested Roles Under Company -->
          <div class="space-y-6 pl-2 sm:pl-4">
            <div
              v-for="(role, rIdx) in company.roles"
              :key="role.id"
              class="space-y-3 border-l-2 border-slate-200 dark:border-neutral-900 pl-4 sm:pl-6 transition-colors"
              :class="{ 'border-slate-400 dark:border-neutral-700': role.isOpen }"
            >
              <!-- Role Header Row -->
              <div
                @click="toggleRole(cIdx, rIdx)"
                class="flex items-start justify-between cursor-pointer group py-1 select-none"
              >
                <div class="flex items-start space-x-3">
                  <!-- Code Icon Badge -->
                  <div class="w-7 h-7 rounded-md bg-slate-100 dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-600 dark:text-neutral-400 group-hover:text-slate-900 dark:group-hover:text-white group-hover:border-slate-300 dark:group-hover:border-neutral-700 text-xs font-mono flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                    <span>&lt;/&gt;</span>
                  </div>

                  <div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-neutral-200 transition-colors">
                      {{ role.role }}
                    </h4>
                    <p class="text-xs font-mono text-slate-500 dark:text-neutral-400 mt-0.5 flex items-center space-x-2">
                      <span>{{ role.employmentType }}</span>
                      <span>&bull;</span>
                      <span>{{ role.period }}</span>
                    </p>
                  </div>
                </div>

                <!-- Chevron Collapse Button -->
                <button
                  class="p-1.5 text-slate-500 dark:text-neutral-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors cursor-pointer"
                  :aria-label="role.isOpen ? 'Collapse details' : 'Expand details'"
                >
                  <svg
                    class="w-4 h-4 transform transition-transform duration-200"
                    :class="{ 'rotate-180': role.isOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
              </div>

              <!-- Expanded Role Details (Bullet Points & Rich Text Description & Tech Stack Tags) -->
              <div v-if="role.isOpen" class="pt-2 pb-2 space-y-4">
                <!-- Rich Text Description (if HTML) -->
                <div 
                  v-if="role.rawDescription" 
                  v-html="role.rawDescription" 
                  class="prose-experience text-slate-800 dark:text-neutral-200 font-medium"
                ></div>

                <!-- Bullet Highlights List (if highlights exist) -->
                <ul 
                  v-if="role.bullets && role.bullets.length" 
                  class="space-y-2.5 text-sm text-slate-800 dark:text-neutral-200 font-sans font-medium leading-relaxed pl-2 sm:pl-4 pt-1"
                >
                  <li
                    v-for="(bullet, bIdx) in role.bullets"
                    :key="bIdx"
                    class="flex items-start space-x-3 text-slate-800 dark:text-neutral-200"
                  >
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-neutral-400 mt-2 shrink-0"></span>
                    <span v-html="bullet"></span>
                  </li>
                </ul>

                <!-- Tech Stack Pills -->
                <div v-if="role.tags && role.tags.length" class="flex flex-wrap gap-2 pt-2">
                  <span
                    v-for="(tag, tIdx) in role.tags"
                    :key="tIdx"
                    class="px-2.5 py-1 rounded-md bg-white text-slate-700 dark:bg-neutral-900 dark:text-neutral-300 border border-slate-200 dark:border-neutral-800 text-xs font-mono shadow-xs hover:border-slate-300 dark:hover:border-neutral-700 transition-colors"
                  >
                    {{ tag }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. CLIENT ENDORSEMENTS & RECOMMENDATIONS CAROUSEL -->
    <section id="testimonials" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-white dark:bg-black transition-colors duration-300 border-t border-slate-200/80 dark:border-neutral-800/60 overflow-hidden">
      <div class="text-center space-y-4 mb-16 max-w-3xl mx-auto">
        <h2 class="text-sm font-mono uppercase tracking-widest text-slate-500 dark:text-neutral-400">Recommendations</h2>
        <h3 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">Client Endorsements</h3>
        <p class="text-slate-600 dark:text-neutral-300 text-base sm:text-lg max-w-lg mx-auto">
          Feedback from technical directors, product managers, and founders on engineering delivery and leadership.
        </p>
      </div>

      <!-- Coverflow Deck Carousel Container -->
      <div
        v-if="displayedTestimonials.length"
        @mouseenter="stopAutoplay"
        @mouseleave="startAutoplay"
        @touchstart="handleTouchStart"
        @touchend="handleTouchEnd"
        class="relative w-full py-6 sm:py-10 space-y-8 select-none overflow-hidden"
      >
        <!-- Background Ambient Rings & Glow (Matches user reference) -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
          <div class="w-[500px] sm:w-[650px] h-[320px] rounded-full bg-gradient-to-r from-blue-600/10 via-indigo-500/10 to-purple-600/10 blur-3xl opacity-70"></div>
          <div class="absolute w-[400px] sm:w-[480px] h-[400px] sm:h-[480px] rounded-full border border-dashed border-slate-300/40 dark:border-neutral-800/60"></div>
          <div class="absolute w-[580px] sm:w-[680px] h-[580px] sm:h-[680px] rounded-full border border-dashed border-slate-200/30 dark:border-neutral-800/30"></div>
        </div>

        <!-- Cards Stage (Stacked overlapping cards) -->
        <div class="relative w-full h-[400px] sm:h-[380px] flex items-center justify-center">
          
          <!-- Floating Left Arrow Button (Desktop / Tablet) -->
          <button
            @click="prevTestimonial"
            class="hidden sm:flex absolute left-2 lg:left-6 z-40 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-slate-200 dark:border-neutral-800 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md text-slate-700 dark:text-neutral-200 hover:bg-slate-100 dark:hover:bg-neutral-800 hover:scale-110 active:scale-95 transition-all shadow-xl items-center justify-center cursor-pointer"
            title="Previous Endorsement"
          >
            <ChevronLeft class="h-5 w-5" />
          </button>

          <!-- Layered Deck of Cards -->
          <div
            v-for="(item, idx) in displayedTestimonials"
            :key="item.id || idx"
            @click="onCardClick(idx)"
            class="absolute top-1/2 left-1/2 w-[86vw] sm:w-[440px] md:w-[480px] lg:w-[500px] h-[360px] sm:h-[350px] rounded-2xl p-6 sm:p-8 flex flex-col justify-between transition-all duration-500 ease-out shadow-2xl"
            :style="getCardStyle(idx)"
            :class="[
              isCardActive(idx)
                ? 'border-2 border-slate-300 dark:border-neutral-700 bg-white dark:bg-neutral-950 shadow-2xl shadow-indigo-500/10'
                : 'border border-slate-200/70 dark:border-neutral-800/80 bg-slate-50/90 dark:bg-neutral-950/90 hover:opacity-90 cursor-pointer shadow-lg'
            ]"
          >
            <!-- Watermark Quote Icon in Top Right -->
            <Quote class="absolute top-4 right-4 h-16 w-16 text-slate-200/50 dark:text-neutral-900/70 pointer-events-none select-none -rotate-6" />

            <!-- Card Top: Rating & Project Reference -->
            <div class="relative z-10 flex items-center justify-between gap-3">
              <div class="flex items-center gap-1.5 text-amber-400 bg-amber-400/10 dark:bg-amber-400/10 px-2.5 py-1 rounded-full border border-amber-400/20">
                <Star
                  v-for="s in 5"
                  :key="s"
                  class="h-3.5 w-3.5"
                  :class="s <= (item.rating || 5) ? 'fill-amber-400 text-amber-400' : 'text-slate-300 dark:text-neutral-700'"
                />
                <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 ml-0.5">5.0</span>
              </div>

              <span
                v-if="item.project_reference"
                class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-700 dark:text-neutral-300 truncate max-w-[200px]"
                :title="item.project_reference"
              >
                {{ item.project_reference }}
              </span>
            </div>

            <!-- Card Body: Quote -->
            <div class="relative z-10 my-auto py-2">
              <p class="text-sm sm:text-base font-sans font-medium text-slate-800 dark:text-neutral-100 leading-relaxed line-clamp-5">
                &ldquo;{{ item.quote }}&rdquo;
              </p>
            </div>

            <!-- Card Bottom: Client Info -->
            <div class="relative z-10 pt-4 border-t border-slate-200/70 dark:border-neutral-800/80 flex items-center justify-between gap-3">
              <div class="flex items-center gap-3 min-w-0">
                <div class="w-11 h-11 rounded-full overflow-hidden border-2 border-slate-200 dark:border-neutral-700 bg-slate-200 dark:bg-neutral-800 shrink-0 shadow-xs">
                  <img
                    v-if="item.client_avatar"
                    :src="item.client_avatar"
                    :alt="item.client_name"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center font-bold text-xs bg-indigo-600 text-white">
                    {{ getClientInitials(item.client_name) }}
                  </div>
                </div>

                <div class="min-w-0">
                  <div class="flex items-center gap-1.5">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                      {{ item.client_name }}
                    </h4>
                    <a
                      v-if="item.linkedin_url"
                      :href="item.linkedin_url"
                      target="_blank"
                      @click.stop
                      class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0"
                      title="Verified LinkedIn Recommendation"
                    >
                      <Linkedin class="h-3 w-3" />
                    </a>
                  </div>
                  <p class="text-[11px] text-slate-500 dark:text-neutral-400 truncate">
                    {{ item.client_role }} <span v-if="item.company">&bull; {{ item.company }}</span>
                  </p>
                </div>
              </div>

              <div class="hidden sm:flex items-center gap-1 text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-900/60 shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Verified</span>
              </div>
            </div>
          </div>

          <!-- Floating Right Arrow Button (Desktop / Tablet) -->
          <button
            @click="nextTestimonial"
            class="hidden sm:flex absolute right-2 lg:right-6 z-40 w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-slate-200 dark:border-neutral-800 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md text-slate-700 dark:text-neutral-200 hover:bg-slate-100 dark:hover:bg-neutral-800 hover:scale-110 active:scale-95 transition-all shadow-xl items-center justify-center cursor-pointer"
            title="Next Endorsement"
          >
            <ChevronRight class="h-5 w-5" />
          </button>
        </div>

        <!-- Bottom Controls: Prev/Next for mobile + Dots Indicator & Counter -->
        <div class="flex items-center justify-center gap-3 pt-2">
          <!-- Mobile Prev Button -->
          <button
            @click="prevTestimonial"
            class="sm:hidden w-8 h-8 rounded-full border border-slate-200 dark:border-neutral-800 bg-white/90 dark:bg-neutral-900/90 text-slate-700 dark:text-neutral-200 flex items-center justify-center cursor-pointer shadow-xs active:scale-95"
            title="Previous Endorsement"
          >
            <ChevronLeft class="h-4 w-4" />
          </button>

          <!-- Animated Indicator Dots -->
          <div class="flex items-center gap-2">
            <button
              v-for="(item, idx) in displayedTestimonials"
              :key="idx"
              @click="currentTestimonialIndex = idx"
              class="h-2 rounded-full transition-all duration-300 cursor-pointer"
              :class="currentTestimonialIndex === idx 
                ? 'w-8 bg-slate-900 dark:bg-white shadow-xs' 
                : 'w-2 bg-slate-300 dark:bg-neutral-800 hover:bg-slate-400 dark:hover:bg-neutral-600'"
              :title="`Jump to endorsement ${idx + 1}`"
            />
          </div>

          <!-- Counter Pill -->
          <span class="text-xs font-mono font-medium text-slate-400 dark:text-neutral-500 select-none">
            0{{ currentTestimonialIndex + 1 }} / 0{{ displayedTestimonials.length }}
          </span>

          <!-- Mobile Next Button -->
          <button
            @click="nextTestimonial"
            class="sm:hidden w-8 h-8 rounded-full border border-slate-200 dark:border-neutral-800 bg-white/90 dark:bg-neutral-900/90 text-slate-700 dark:text-neutral-200 flex items-center justify-center cursor-pointer shadow-xs active:scale-95"
            title="Next Endorsement"
          >
            <ChevronRight class="h-4 w-4" />
          </button>
        </div>
      </div>
    </section>

    <!-- 6. LATEST TECHNICAL ARTICLES & CASE STUDIES -->
    <section id="articles" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-white dark:bg-black transition-colors duration-300 border-t border-slate-200/80 dark:border-neutral-800/60">
      <div class="text-center space-y-4 mb-16 max-w-3xl mx-auto">
        <h2 class="text-sm font-mono uppercase tracking-widest text-slate-500 dark:text-neutral-400">Technical Articles</h2>
        <h3 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">Engineering Notes &amp; Case Studies</h3>
        <p class="text-slate-600 dark:text-neutral-300 text-base sm:text-lg max-w-lg mx-auto">
          In-depth architectural writeups and software optimization benchmarks.
        </p>
      </div>

      <!-- Articles Grid -->
      <div v-if="displayedArticles.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <article
          v-for="article in displayedArticles"
          :key="article.id"
          class="rounded-md border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 overflow-hidden shadow-xs hover:border-slate-300 dark:hover:border-neutral-700 hover:shadow-md transition-all flex flex-col justify-between group"
        >
          <div>
            <!-- Thumbnail -->
            <div class="w-full h-48 overflow-hidden bg-neutral-100 dark:bg-neutral-900 relative">
              <img
                v-if="article.cover_image"
                :src="article.cover_image"
                :alt="article.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
              <div v-else class="w-full h-full flex items-center justify-center text-slate-400 dark:text-neutral-600">
                <BookOpen class="h-8 w-8" />
              </div>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-3">
              <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-neutral-400">
                <span class="flex items-center gap-1">
                  <Clock class="h-3 w-3" />
                  <span>{{ article.read_time || 5 }} min read</span>
                </span>
                <span>{{ formatArticleDate(article.published_at) }}</span>
              </div>

              <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                <Link :href="route('articles.show', article.slug)">
                  {{ article.title }}
                </Link>
              </h3>

              <p class="text-xs sm:text-sm text-slate-600 dark:text-neutral-400 line-clamp-3 leading-relaxed">
                {{ article.excerpt }}
              </p>
            </div>
          </div>

          <!-- Card Footer -->
          <div class="p-6 pt-0 space-y-3 border-t border-slate-100 dark:border-neutral-900/80">
            <div v-if="article.tags && article.tags.length" class="flex flex-wrap gap-1 pt-3">
              <span
                v-for="t in article.tags.slice(0, 3)"
                :key="t"
                class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 dark:bg-neutral-900 border border-slate-200/60 dark:border-neutral-800 text-slate-600 dark:text-neutral-400"
              >
                {{ t }}
              </span>
            </div>

            <Link
              :href="route('articles.show', article.slug)"
              class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors pt-1"
            >
              <span>Read Full Article</span>
              <ArrowRight class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
            </Link>
          </div>
        </article>
      </div>

      <!-- Explore Hub CTA -->
      <div class="mt-12 text-center">
        <Link
          :href="route('articles.index')"
          class="px-6 py-3 rounded-md bg-slate-900 hover:bg-slate-800 text-white dark:bg-white dark:hover:bg-neutral-200 dark:text-black font-bold text-xs sm:text-sm shadow-lg transition-all inline-flex items-center space-x-2 cursor-pointer group hover:scale-105 transform"
        >
          <span>Explore All Articles &amp; Case Studies</span>
          <span class="group-hover:translate-x-1 transition-transform font-mono">→</span>
        </Link>
      </div>
    </section>

    <!-- 7. CREATIVE 2-COLUMN EXECUTIVE CONTACT SECTION -->
    <section id="contact" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-white dark:bg-black transition-colors duration-300">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <!-- LEFT COLUMN: Engaging Contact Pitch & Info -->
        <div class="lg:col-span-6 space-y-8">
          <div class="space-y-4">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
              {{ settings.contact_headline_title || "Let's build something extraordinary together." }}
            </h2>
            <p class="text-slate-600 dark:text-neutral-400 text-base sm:text-lg leading-relaxed">
              {{ settings.contact_subtitle || "Have a project in mind, a software engineering role to discuss, or just want to talk tech? Drop a message or connect directly." }}
            </p>
          </div>

          <!-- Contact Cards -->
          <div class="space-y-3 pt-1 max-w-md">
            <!-- Email Item -->
            <a
              :href="`mailto:${settings.contact_email || 'kashifkhan.dev@gmail.com'}`"
              class="p-4 rounded-md bg-white dark:bg-neutral-950 border border-slate-200 dark:border-neutral-800 hover:border-slate-300 dark:hover:border-neutral-700 flex items-center space-x-4 transition-all group w-full shadow-xs"
            >
              <div class="w-10 h-10 rounded-md bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-white flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <div class="text-xs font-sans font-semibold text-slate-500 dark:text-neutral-400 uppercase tracking-wider">Direct Email</div>
                <div class="text-sm sm:text-base font-bold text-slate-900 dark:text-white font-sans group-hover:text-indigo-600 dark:group-hover:text-neutral-200 transition-colors">
                  {{ settings.contact_email || 'kashifkhan.dev@gmail.com' }}
                </div>
              </div>
            </a>

            <!-- Availability & Location Item -->
            <div class="p-4 rounded-md bg-white dark:bg-neutral-950 border border-slate-200 dark:border-neutral-800 flex items-center space-x-4 w-full shadow-xs">
              <div class="w-10 h-10 rounded-md bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <div>
                <div class="text-xs font-sans font-semibold text-slate-500 dark:text-neutral-400 uppercase tracking-wider">Location &amp; Work</div>
                <div class="text-sm font-bold text-slate-900 dark:text-white">
                  {{ settings.contact_location || 'Worldwide (Remote / On-site)' }}
                </div>
              </div>
            </div>
          </div>

          <!-- Response Guarantee Pill -->
          <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-md bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-xs font-sans font-medium text-slate-800 dark:text-neutral-200 shadow-xs">
            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
            <span>{{ settings.contact_response_time || 'Typical Response Time: < 24 Hours' }}</span>
          </div>
        </div>

        <!-- RIGHT COLUMN: Clean Compact Message Form -->
        <div class="lg:col-span-6">
          <div class="bg-white dark:bg-neutral-950 border border-slate-200 dark:border-neutral-800 p-6 sm:p-8 rounded-md space-y-6 shadow-sm dark:shadow-xl w-full">
            <div>
              <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                {{ settings.contact_form_title || 'Send a Message' }}
              </h3>
            </div>

            <form @submit.prevent="submitContactForm" class="space-y-5">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-sans font-medium text-slate-700 dark:text-neutral-300 mb-1.5 uppercase tracking-wider">Your Name</label>
                  <input
                    v-model="form.sender_name"
                    type="text"
                    required
                    placeholder="John Doe"
                    class="w-full px-4 py-2.5 rounded-md bg-white dark:bg-black border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-slate-900 dark:focus:border-white transition-colors"
                  />
                </div>
                <div>
                  <label class="block text-xs font-sans font-medium text-slate-700 dark:text-neutral-300 mb-1.5 uppercase tracking-wider">Your Email</label>
                  <input
                    v-model="form.sender_email"
                    type="email"
                    required
                    placeholder="john@example.com"
                    class="w-full px-4 py-2.5 rounded-md bg-white dark:bg-black border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-slate-900 dark:focus:border-white transition-colors"
                  />
                </div>
              </div>

              <div>
                <label class="block text-xs font-sans font-medium text-slate-700 dark:text-neutral-300 mb-1.5 uppercase tracking-wider">Subject</label>
                <input
                  v-model="form.subject"
                  type="text"
                  placeholder="Project Inquiry"
                  class="w-full px-4 py-2.5 rounded-md bg-white dark:bg-black border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-slate-900 dark:focus:border-white transition-colors"
                />
              </div>

              <div>
                <label class="block text-xs font-sans font-medium text-slate-700 dark:text-neutral-300 mb-1.5 uppercase tracking-wider">Message</label>
                <textarea
                  v-model="form.body"
                  rows="4"
                  required
                  placeholder="Your message..."
                  class="w-full px-4 py-2.5 rounded-md bg-white dark:bg-black border border-slate-200 dark:border-neutral-800 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-slate-900 dark:focus:border-white transition-colors"
                ></textarea>
              </div>

              <button
                type="submit"
                :disabled="isSubmitting || form.processing"
                class="w-full py-3.5 rounded-md bg-slate-900 hover:bg-slate-800 text-white dark:bg-white dark:hover:bg-neutral-200 dark:text-black font-bold text-sm uppercase tracking-wider transition-all disabled:opacity-75 flex items-center justify-center space-x-2 shadow-md cursor-pointer"
              >
                <!-- Inline Spinner Icon -->
                <svg
                  v-if="isSubmitting || form.processing"
                  class="animate-spin h-4 w-4 text-black shrink-0"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span v-if="isSubmitting || form.processing">Transmitting Message...</span>
                <span v-else>{{ settings.contact_submit_btn_text || 'Send Message' }}</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </section>

    <!-- Modal Popup -->
    <ProjectModal
      :isOpen="portfolioStore.isProjectModalOpen"
      :project="portfolioStore.selectedProject"
      @close="portfolioStore.closeProjectModal()"
    />
  </GuestLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ProjectModal from '@/Components/ProjectModal.vue';
import TechIcon from '@/Components/TechIcon.vue';
import { usePortfolioStore } from '@/stores/usePortfolioStore';
import { useToast } from '@/Composables/useToast';
import {
  Star,
  Quote,
  ChevronLeft,
  ChevronRight,
  Clock,
  BookOpen,
  ArrowRight,
  Linkedin,
} from 'lucide-vue-next';

const isSubmitting = ref(false);
const { toast } = useToast();

const props = defineProps({
  projects: Array,
  skills: Array,
  experiences: Array,
  testimonials: Array,
  articles: Array,
  settings: Object,
  canLogin: Boolean,
});

const portfolioStore = usePortfolioStore();

function openModal(project) {
  portfolioStore.openProjectModal(project);
}

// Master Fallback Tech Stack
const fullTechStack = [
  { name: 'React.js', icon: 'react' },
  { name: 'Next.js', icon: 'next' },
  { name: 'Vue.js 3', icon: 'vue' },
  { name: 'Laravel 11', icon: 'laravel' },
  { name: 'Tailwind CSS', icon: 'tailwind' },
  { name: 'TypeScript', icon: 'typescript' },
  { name: 'Inertia.js', icon: 'inertia' },
  { name: 'Node.js', icon: 'node' },
  { name: 'PHP 8.2+', icon: 'php' },
  { name: 'MySQL', icon: 'mysql' },
  { name: 'Docker', icon: 'docker' },
  { name: 'Git & GitHub', icon: 'git' },
  { name: 'Vite', icon: 'vite' },
  { name: 'REST & GraphQL', icon: 'api' },
];

// Active Skills from database or fallback stack
const activeSkillsList = computed(() => {
  if (props.skills && props.skills.length > 0) {
    return props.skills.map(s => ({
      id: s.id,
      name: s.name,
      icon: s.icon ? s.icon.toLowerCase() : 'api',
      category: s.category || 'General',
      proficiency: s.proficiency,
    }));
  }
  return fullTechStack;
});

const marqueeItems = computed(() => [
  ...activeSkillsList.value,
  ...activeSkillsList.value,
  ...activeSkillsList.value
]);

const groupedSkills = computed(() => {
  if (props.skills && props.skills.length > 0) {
    return props.skills.reduce((acc, skill) => {
      const cat = skill.category || 'General';
      if (!acc[cat]) acc[cat] = [];
      acc[cat].push(skill);
      return acc;
    }, {});
  }
  return {};
});

// Notion / Linear Style Nested Collapsible Experience Data
const defaultExperiences = [
  {
    id: 'apex',
    company: 'Apex Cloud Systems',
    logoText: 'AC',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-white',
    isActive: true,
    roles: [
      {
        id: 'lead-dev',
        role: 'Lead Full-Stack Engineer',
        employmentType: 'Full-time',
        period: '07.2024 — Present',
        isOpen: true,
        bullets: [
          'Develop scalable SaaS applications using modern web technologies including Laravel 11, Vue 3, and Inertia.js.',
          'Build cross-platform applications, custom API integrations, and real-time dashboard notification systems.',
          'Architect and develop full-stack solutions with high-performance MySQL databases and Redis queues.',
          'Design and implement RESTful APIs with PHP 8.2+, Node.js, Express, and microservices architecture.',
          'Build responsive, performant frontend applications with Vue 3, Tailwind CSS, and Pinia state management.',
          'Integrate third-party APIs, webhooks, and real-time features using WebSockets.',
          'Collaborate with cross-functional teams in a remote environment to drive architecture and design decisions.',
          'Optimize application performance, SQL query execution plans, and ensure overall code quality.'
        ],
        tags: [
          'Laravel 11', 'Vue.js 3', 'Inertia.js', 'Tailwind CSS', 'TypeScript',
          'MySQL', 'Redis', 'RESTful APIs', 'SaaS Development', 'Remote Work', 'WebSockets', 'Problem-solving'
        ]
      }
    ]
  },
  {
    id: 'digital-hub',
    company: 'Digital Innovations Hub',
    logoText: 'DH',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-blue-400',
    isActive: false,
    roles: [
      {
        id: 'pos-dev',
        role: 'Senior Frontend & Laravel Specialist',
        employmentType: 'Full-time',
        period: '01.2022 — 01.2024',
        isOpen: false,
        bullets: [
          'Developed custom web portals, customer management systems, and interactive client dashboards.',
          'Built custom payment integrations with Stripe and automated billing workflows.'
        ],
        tags: ['React.js', 'Next.js', 'Laravel Breeze', 'Tailwind CSS', 'Stripe', 'PostgreSQL']
      }
    ]
  },
  {
    id: 'education',
    company: 'University of Computer Science',
    logoText: 'BS',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-emerald-400',
    isActive: false,
    roles: [
      {
        id: 'web-inst',
        role: 'B.S. in Software Engineering',
        employmentType: 'Honor Graduate',
        period: '09.2018 — 06.2022',
        isOpen: false,
        bullets: [
          'Focused on Data Structures, Object-Oriented Design, Relational Database Systems, and Distributed Computing.',
          'Completed senior capstone project on automated application security auditing and web performance optimization.'
        ],
        tags: ['Software Architecture', 'Algorithms', 'Databases', 'Git', 'System Design']
      }
    ]
  }
];

const companyExperiences = ref(defaultExperiences);

// Known technology keywords for auto-tagging
const knownTechs = [
  'Laravel', 'Vue.js', 'Vue 3', 'Tailwind CSS', 'React.js', 'React', 'Next.js', 
  'TypeScript', 'JavaScript', 'Node.js', 'PHP', 'MySQL', 'PostgreSQL', 'Redis', 
  'Docker', 'AWS S3', 'AWS', 'Stripe', 'SendGrid', 'Inertia.js', 'WebSockets', 
  'RESTful APIs', 'GraphQL', 'Git', 'Vite', 'Express', 'Microservices'
];

function extractTechTags(exp) {
  let techs = exp.technologies;
  if (typeof techs === 'string' && techs.trim()) {
    try {
      techs = JSON.parse(techs);
    } catch (e) {
      techs = techs.split(',').map(s => s.trim()).filter(Boolean);
    }
  }
  if (Array.isArray(techs) && techs.length) return techs;

  // Strict rule: If no technologies entered in Admin, show NOTHING on frontend!
  return [];
}

// Dynamically bind DB experiences if provided from Laravel
if (props.experiences && props.experiences.length) {
  const dbCompanies = props.experiences.map((exp, idx) => {
    const logoInitials = exp.company
      ? exp.company.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase()
      : 'EXP';
      
    // Handle highlights array or string
    let highlightsArr = [];
    if (Array.isArray(exp.highlights)) {
      highlightsArr = exp.highlights;
    } else if (typeof exp.highlights === 'string' && exp.highlights.trim()) {
      try {
        highlightsArr = JSON.parse(exp.highlights);
      } catch (e) {
        highlightsArr = exp.highlights.split(',').map(s => s.trim()).filter(Boolean);
      }
    }

    const hasHtml = exp.description && /<[a-z][\s\S]*>/i.test(exp.description);
    const tagsList = extractTechTags(exp);

    // Format location + work type (e.g. "Peshawar • Remote")
    let empType = exp.location || '';
    if (exp.work_type) {
      empType = empType ? `${empType} • ${exp.work_type}` : exp.work_type;
    }
    if (!empType) empType = 'Full-time';

    return {
      id: exp.id || `db-exp-${idx}`,
      company: exp.company || 'Company Name',
      logoText: logoInitials,
      logoBg: 'bg-neutral-900 border border-neutral-800 text-white',
      isActive: idx === 0,
      roles: [
        {
          id: `role-${exp.id || idx}`,
          role: exp.role || exp.title || 'Software Engineer',
          employmentType: empType,
          period: exp.period || '2024 — Present',
          isOpen: idx === 0,
          rawDescription: hasHtml ? exp.description : null,
          bullets: highlightsArr.length 
            ? highlightsArr 
            : (!hasHtml && exp.description ? exp.description.split('. ').map(b => b.trim()).filter(Boolean) : []),
          tags: tagsList
        }
      ]
    };
  });
  companyExperiences.value = dbCompanies;
}

function toggleRole(companyIdx, roleIdx) {
  companyExperiences.value[companyIdx].roles[roleIdx].isOpen = !companyExperiences.value[companyIdx].roles[roleIdx].isOpen;
}

const form = useForm({
  sender_name: '',
  sender_email: '',
  subject: '',
  body: '',
});

const showAllProjects = ref(false);

const filteredProjects = computed(() => {
  if (portfolioStore.activeProjectCategory === 'All') {
    return props.projects || [];
  }
  return (props.projects || []).filter(p => p.category === portfolioStore.activeProjectCategory);
});

const displayedProjects = computed(() => {
  if (showAllProjects.value) {
    return filteredProjects.value;
  }
  return filteredProjects.value.slice(0, 3);
});

function submitContactForm() {
  if (isSubmitting.value) return;

  isSubmitting.value = true;

  axios.post(route('contact.store'), {
    sender_name: form.sender_name,
    sender_email: form.sender_email,
    subject: form.subject,
    body: form.body,
  })
  .then(() => {
    form.reset();
    toast({
      title: 'Message Sent Successfully!',
      description: 'Thank you for reaching out. Your message has been received.',
      type: 'success',
    });
  })
  .catch((err) => {
    toast({
      title: 'Form Error',
      description: err.response?.data?.message || 'Please check your inputs and try again.',
      type: 'error',
    });
  })
  .finally(() => {
    isSubmitting.value = false;
  });
}

// ----------------------------------------------------------------------
// Testimonials Carousel Logic
// ----------------------------------------------------------------------
const fallbackTestimonials = [
  {
    client_name: 'Sarah Jenkins',
    client_role: 'VP of Engineering',
    company: 'CloudScale Networks',
    quote: 'Kashif transformed our legacy admin portal into a lightning-fast Inertia + Vue 3 architecture. His attention to design systems, UX subtleties, and backend query optimization reduced our page load times by over 60%.',
    rating: 5,
    project_reference: 'Nexus SaaS Telemetry Dashboard',
    linkedin_url: 'https://linkedin.com',
  },
  {
    client_name: 'David Sterling',
    client_role: 'Founder & CEO',
    company: 'AeroSwift Digital',
    quote: 'Working with Kashif on the 3D product visualizer was a breath of fresh air. He merged Three.js WebGL rendering with a buttery-smooth Tailwind UI that blew our executive board away. Delivered ahead of schedule with zero friction.',
    rating: 5,
    project_reference: 'AeroSwift 3D Product Customizer',
    linkedin_url: 'https://linkedin.com',
  },
];

const displayedTestimonials = computed(() => {
  if (props.testimonials && props.testimonials.length > 0) {
    return props.testimonials;
  }
  return fallbackTestimonials;
});

const currentTestimonialIndex = ref(0);

const currentTestimonial = computed(() => {
  const list = displayedTestimonials.value;
  if (!list.length) return null;
  return list[currentTestimonialIndex.value % list.length];
});

function nextTestimonial() {
  if (!displayedTestimonials.value.length) return;
  currentTestimonialIndex.value = (currentTestimonialIndex.value + 1) % displayedTestimonials.value.length;
}

function prevTestimonial() {
  if (!displayedTestimonials.value.length) return;
  currentTestimonialIndex.value = (currentTestimonialIndex.value - 1 + displayedTestimonials.value.length) % displayedTestimonials.value.length;
}

function isCardActive(index) {
  const n = displayedTestimonials.value.length;
  if (!n) return false;
  return (currentTestimonialIndex.value % n) === index;
}

function onCardClick(index) {
  if (currentTestimonialIndex.value !== index) {
    currentTestimonialIndex.value = index;
  }
}

function getCardStyle(index) {
  const n = displayedTestimonials.value.length;
  if (!n) return {};
  if (n === 1) {
    return {
      transform: 'translate(-50%, -50%) scale(1)',
      zIndex: 30,
      opacity: 1,
      pointerEvents: 'auto',
    };
  }

  // Calculate shortest circular difference from active card
  let diff = (index - (currentTestimonialIndex.value % n)) % n;
  if (diff > n / 2) diff -= n;
  if (diff < -n / 2) diff += n;

  // Active Center Card
  if (diff === 0) {
    return {
      transform: 'translate(-50%, -50%) scale(1)',
      zIndex: 30,
      opacity: 1,
      pointerEvents: 'auto',
    };
  }

  // Immediate Left Card
  if (diff === -1) {
    return {
      transform: 'translate(calc(-50% - 46%), -50%) scale(0.9)',
      zIndex: 20,
      opacity: 0.72,
      pointerEvents: 'auto',
    };
  }

  // Immediate Right Card
  if (diff === 1) {
    return {
      transform: 'translate(calc(-50% + 46%), -50%) scale(0.9)',
      zIndex: 20,
      opacity: 0.72,
      pointerEvents: 'auto',
    };
  }

  // Outer Left Card
  if (diff === -2) {
    return {
      transform: 'translate(calc(-50% - 84%), -50%) scale(0.8)',
      zIndex: 10,
      opacity: 0.35,
      pointerEvents: 'auto',
    };
  }

  // Outer Right Card
  if (diff === 2) {
    return {
      transform: 'translate(calc(-50% + 84%), -50%) scale(0.8)',
      zIndex: 10,
      opacity: 0.35,
      pointerEvents: 'auto',
    };
  }

  // Far Away Cards (Fade out completely)
  const xOffset = diff > 0 ? '110%' : '-110%';
  return {
    transform: `translate(calc(-50% + ${xOffset}), -50%) scale(0.7)`,
    zIndex: 0,
    opacity: 0,
    pointerEvents: 'none',
  };
}

let touchStartX = 0;
function handleTouchStart(e) {
  if (e.touches && e.touches[0]) {
    touchStartX = e.touches[0].clientX;
  }
}

function handleTouchEnd(e) {
  if (e.changedTouches && e.changedTouches[0]) {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (diff > 40) {
      nextTestimonial();
    } else if (diff < -40) {
      prevTestimonial();
    }
  }
}

let autoplayTimer = null;

function startAutoplay() {
  stopAutoplay();
  autoplayTimer = setInterval(() => {
    nextTestimonial();
  }, 7000);
}

function stopAutoplay() {
  if (autoplayTimer) {
    clearInterval(autoplayTimer);
    autoplayTimer = null;
  }
}

function getClientInitials(name) {
  if (!name) return 'KK';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
}

onMounted(() => {
  startAutoplay();
});

onUnmounted(() => {
  stopAutoplay();
});

// ----------------------------------------------------------------------
// Articles Section Logic
// ----------------------------------------------------------------------
const displayedArticles = computed(() => {
  return (props.articles && props.articles.length > 0) ? props.articles.slice(0, 3) : [];
});

function formatArticleDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}
</script>
