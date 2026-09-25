<template>
  <span
    :class="[
      'inline-flex items-center justify-center shrink-0 overflow-hidden leading-none',
      size || 'w-4 h-4'
    ]"
  >
    <!-- Direct URL or Base64 Image -->
    <img
      v-if="isUrl(name)"
      :src="name"
      alt="icon"
      class="w-full h-full object-contain"
    />

    <!-- Predefined High-Quality Brand SVGs (Sharp dark glyphs matching reference) -->
    <!-- HTML5 -->
    <svg v-else-if="cleanName === 'html' || cleanName === 'html5'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#E34F26" d="M3 2l1.8 17.5L12 22l7.2-2.5L21 2H3zm14.8 5.6h-7.6l.2 2.3h7.2l-.6 6.7-4.6 1.3-4.6-1.3-.3-3.6h2.3l.2 1.8 2.4.6 2.4-.6.3-2.9H7.6L7 4.3h11l-.2 3.3z"/>
    </svg>

    <!-- CSS3 -->
    <svg v-else-if="cleanName === 'css' || cleanName === 'css3'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#1572B6" d="M3 2l1.8 17.5L12 22l7.2-2.5L21 2H3zm14.8 5.6h-7.6l.2 2.3h7.2l-.6 6.7-4.6 1.3-4.6-1.3-.3-3.6h2.3l.2 1.8 2.4.6 2.4-.6.3-2.9H7.6L7 4.3h11l-.2 3.3z"/>
    </svg>

    <!-- JavaScript (JS) -->
    <svg v-else-if="cleanName === 'javascript' || cleanName === 'js'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#F7DF1E" d="M0 0h24v24H0z"/>
      <path fill="#000" d="M6.7 19.3c.7 1.2 1.8 1.9 3.5 1.9 1.4 0 2.4-.6 2.4-1.6 0-1.1-.9-1.5-2.4-2.1l-.8-.3c-2.3-1-3.8-2.3-3.8-4.9 0-2.8 2.2-4.8 5.6-4.8 2.5 0 4.1.9 5.1 2.7l-2.4 1.5c-.6-1-1.3-1.4-2.6-1.4-1.1 0-1.8.6-1.8 1.4 0 .9.7 1.3 2.1 1.9l.8.3c2.7 1.1 4.2 2.4 4.2 5.1 0 3.2-2.5 5-6.2 5-3.3 0-5.3-1.5-6.3-3.4l2.6-1.3zm10.7-11.8v13.7h-3.4V7.5h3.4z"/>
    </svg>

    <!-- React.js -->
    <svg v-else-if="cleanName === 'react' || cleanName === 'reactjs'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#61DAFB" d="M12 9a3 3 0 100 6 3 3 0 000-6zm0-2a5 5 0 110 10 5 5 0 010-10z"/>
      <ellipse cx="12" cy="12" rx="10" ry="4.5" fill="none" stroke="#61DAFB" stroke-width="1.3" transform="rotate(30 12 12)"/>
      <ellipse cx="12" cy="12" rx="10" ry="4.5" fill="none" stroke="#61DAFB" stroke-width="1.3" transform="rotate(90 12 12)"/>
      <ellipse cx="12" cy="12" rx="10" ry="4.5" fill="none" stroke="#61DAFB" stroke-width="1.3" transform="rotate(150 12 12)"/>
    </svg>

    <!-- MongoDB (Leaf) -->
    <svg v-else-if="cleanName === 'mongodb' || cleanName === 'mongo'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#47A248" d="M12.44 2.15c-.17-.15-.41-.15-.58 0-1.82 1.63-6.52 6.64-6.36 12.35.13 4.54 3.73 7.85 6.22 8.35v-9.5c0-.28.22-.5.5-.5s.5.22.5.5v9.5c2.49-.5 6.09-3.81 6.22-8.35.16-5.71-4.54-10.72-6.5-12.35z"/>
    </svg>

    <!-- Express.js (ex) -->
    <div v-else-if="cleanName === 'express' || cleanName === 'expressjs'" class="w-full h-full rounded bg-neutral-800 flex items-center justify-center font-bold text-white tracking-tighter text-base sm:text-lg select-none">
      ex
    </div>

    <!-- Node.js (Cube) -->
    <svg v-else-if="cleanName === 'node' || cleanName === 'nodejs'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#339933" d="M12 2L2 7.5v9L12 22l10-5.5v-9L12 2zm-1 14.5l-5-2.8v-5.4l5 2.8v5.4zm2 0v-5.4l5-2.8v5.4l-5 2.8zm6-7.8l-7 3.9-7-3.9 7-3.9 7 3.9z"/>
    </svg>

    <!-- Tailwind CSS -->
    <svg v-else-if="cleanName === 'tailwind' || cleanName === 'tailwindcss'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#38BDF8" d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.336 6.182 14.975 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C7.666 17.818 9.027 19.2 12.001 19.2c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.336 13.382 8.975 12 6.001 12z"/>
    </svg>

    <!-- Bootstrap -->
    <svg v-else-if="cleanName === 'bootstrap'" viewBox="0 0 512 512" class="w-full h-full">
      <rect width="448" height="448" x="32" y="32" fill="#7952B3" rx="96"/>
      <path fill="#FFFFFF" d="M185.8 136h88.6c32.8 0 54.4 15.6 54.4 42.4 0 20-12 33.6-28.8 38.8 22.4 4.8 36.8 20.4 36.8 44.4 0 31.6-24.8 48.4-60.8 48.4h-90.2V136zm44 33.6v40.4h40c14.8 0 24-7.2 24-20.4 0-12.8-9.2-20-24-20h-40zm0 72.8v44h43.2c16.4 0 26.4-7.6 26.4-22 0-14.8-10-22-26.4-22h-43.2z"/>
    </svg>

    <!-- Photoshop (Ps) -->
    <div v-else-if="cleanName === 'photoshop' || cleanName === 'ps'" class="w-full h-full rounded-lg bg-[#001E36] flex items-center justify-center font-bold text-[#31A8FF] text-sm sm:text-base select-none">
      Ps
    </div>

    <!-- Illustrator (Ai) -->
    <div v-else-if="cleanName === 'illustrator' || cleanName === 'ai'" class="w-full h-full rounded-lg bg-[#330000] flex items-center justify-center font-bold text-[#FF9A00] text-sm sm:text-base select-none">
      Ai
    </div>

    <!-- Figma -->
    <svg v-else-if="cleanName === 'figma'" viewBox="0 0 38 57" class="w-full h-full max-w-[80%]">
      <path fill="#1ABCFE" d="M19 28.5a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z"/>
      <path fill="#0ACF83" d="M0 47.5a9.5 9.5 0 009.5 9.5 9.5 9.5 0 009.5-9.5V38H9.5A9.5 9.5 0 000 47.5z"/>
      <path fill="#FF7262" d="M19 0v19h9.5a9.5 9.5 0 100-19H19z"/>
      <path fill="#F24E1E" d="M0 9.5A9.5 9.5 0 009.5 19H19V0H9.5A9.5 9.5 0 000 9.5z"/>
      <path fill="#A259FF" d="M0 28.5A9.5 9.5 0 009.5 38H19V19H9.5A9.5 9.5 0 000 28.5z"/>
    </svg>

    <!-- Adobe XD (Xd) -->
    <div v-else-if="cleanName === 'xd' || cleanName === 'adobexd'" class="w-full h-full rounded-lg bg-[#470137] flex items-center justify-center font-bold text-[#FF61F6] text-sm sm:text-base select-none">
      Xd
    </div>

    <!-- TypeScript (TS) -->
    <div v-else-if="cleanName === 'typescript' || cleanName === 'ts'" class="w-full h-full rounded-lg bg-[#3178C6] flex items-center justify-center font-bold text-white text-sm sm:text-base select-none">
      TS
    </div>

    <!-- Vite -->
    <svg v-else-if="cleanName === 'vite'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#646CFF" d="M12 2L2 6l10 16L22 6L12 2z"/>
      <path fill="#FFD43B" d="M12 4.5L4.5 7.5L12 19.5L19.5 7.5L12 4.5z"/>
    </svg>

    <!-- Next.js -->
    <svg v-else-if="cleanName === 'next' || cleanName === 'nextjs'" viewBox="0 0 128 128" class="w-full h-full">
      <circle cx="64" cy="64" r="60" fill="#0a0a0a" stroke="#ffffff" stroke-width="5"/>
      <path fill="#FFFFFF" d="M39.6 94.6V33.4h11.2v61.2H39.6zm42.7.2L55.4 51.5v43.3H44.8V33.4h11.2l26.9 43.3V33.4h10.6v61.4H82.3z"/>
    </svg>

    <!-- PHP -->
    <svg v-else-if="cleanName === 'php'" viewBox="0 0 24 24" class="w-full h-full">
      <ellipse cx="12" cy="12" rx="10" ry="6" fill="#777BB4"/>
      <path fill="#FFFFFF" d="M8.5 13.5H7.1l.6-3h1.3c.9 0 1.5.4 1.3 1.2-.2.9-.9 1.8-1.8 1.8zm3.5-3h1.3l-.6 3H11.4l.6-3zm4.5 3h-1.4l.6-3h1.3c.9 0 1.5.4 1.3 1.2-.2.9-.9 1.8-1.8 1.8z"/>
    </svg>

    <!-- Vue.js -->
    <svg v-else-if="cleanName === 'vue' || cleanName === 'vuejs'" viewBox="0 0 128 128" class="w-full h-full">
      <path fill="#42b883" d="M78.8 10.4L64 36 49.2 10.4H0l64 111 64-111z"/>
      <path fill="#35495e" d="M78.8 10.4L64 36 49.2 10.4H25.6L64 77 102.4 10.4z"/>
    </svg>

    <!-- Laravel -->
    <svg v-else-if="cleanName === 'laravel'" viewBox="0 0 512 512" class="w-full h-full">
      <path fill="#FF2D20" d="M433 162.5L271.8 69.4c-9.8-5.7-21.8-5.7-31.6 0L79 162.5C69.2 168.2 63.2 178.6 63.2 190v132c0 11.4 6 21.8 15.8 27.5l161.2 93.1c9.8 5.7 21.8 5.7 31.6 0L433 349.5c9.8-5.7 15.8-16.1 15.8-27.5V190c0-11.4-6-21.8-15.8-27.5zM256 112.5l115.6 66.8-115.6 66.7-115.6-66.7L256 112.5zm-144 191.6V199.3l116 67v104.8l-116-67zm288 0l-116 67V266.3l116-67v104.8z"/>
    </svg>

    <!-- Inertia.js -->
    <svg v-else-if="cleanName === 'inertia'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#9553E9" d="M15.75 3L8.25 10.5H21L15.75 3ZM8.25 13.5L15.75 21H3L8.25 13.5Z"/>
    </svg>

    <!-- MySQL -->
    <svg v-else-if="cleanName === 'mysql' || cleanName === 'database'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#4479A1" d="M12 3c-4.97 0-9 1.79-9 4v10c0 2.21 4.03 4 9 4s9-1.79 9-4V7c0-2.21-4.03-4-9-4zm0 2c3.87 0 7 1.34 7 2s-3.13 2-7 2-7-1.34-7-2 3.13-2 7-2zm-7 5.38c1.62.94 4.18 1.62 7 1.62s5.38-.68 7-1.62V11c0 .66-3.13 2-7 2s-7-1.34-7-2V10.38zm0 5c1.62.94 4.18 1.62 7 1.62s5.38-.68 7-1.62V16c0 .66-3.13 2-7 2s-7-1.34-7-2v-.62z"/>
    </svg>

    <!-- PostgreSQL -->
    <svg v-else-if="cleanName === 'postgres' || cleanName === 'postgresql'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#336791" d="M12 2A10 10 0 002 12a10 10 0 0010 10 10 10 0 0010-10A10 10 0 0012 2zm1 14.5h-2v-4H9v-2h2V9a2 2 0 012-2h2v2h-2v1.5h2v2h-2v4z"/>
    </svg>

    <!-- Redis -->
    <svg v-else-if="cleanName === 'redis'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#D82C20" d="M12 2L2 7l10 5 10-5-10-5zm0 9L2 6v6l10 5 10-5V6l-10 5zm0 6l-10-5v5l10 5 10-5v-5l-10 5z"/>
    </svg>

    <!-- Docker -->
    <svg v-else-if="cleanName === 'docker'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#2496ED" d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm-2.954-5.43h2.118a.185.185 0 00.186-.186V3.575a.185.185 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.083.186.185.186zm0 5.43h2.118a.185.185 0 00.186-.185V9.006a.185.185 0 00-.186-.186h-2.118a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm-2.955 0h2.119a.186.186 0 00.185-.185V9.006a.186.186 0 00-.185-.186H8.074a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm0-2.715h2.119a.186.186 0 00.185-.186V6.29a.186.186 0 00-.185-.186H8.074a.185.185 0 00-.185.186v1.887c0 .102.083.186.185.186zm-2.955 2.715h2.119a.186.186 0 00.185-.185V9.006a.186.186 0 00-.185-.186H5.119a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm0-2.715h2.119a.186.186 0 00.185-.186V6.29a.186.186 0 00-.185-.186H5.119a.185.185 0 00-.185.186v1.887c0 .102.083.186.185.186zm-2.954 2.715h2.118a.185.185 0 00.186-.185V9.006a.185.185 0 00-.186-.186H2.165a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm0-2.715h2.118a.185.185 0 00.186-.186V6.29a.185.185 0 00-.186-.186H2.165a.185.185 0 00-.185.186v1.887c0 .102.083.186.185.186zM.07 12.392a8.653 8.653 0 004.912 6.947c4.685 2.215 10.37.904 13.565-2.915 2.05-2.454 2.872-5.748 2.203-8.868-.21-.041-.42-.083-.63-.104a3.834 3.834 0 00-3.085 1.157c-.89.878-1.427 2.062-1.427 3.32h-1.46c0-1.637.662-3.177 1.832-4.305.58-.559 1.285-.972 2.046-1.222a1.86 1.86 0 00-.518-.083h-3.414c-.114 0-.207.093-.207.207v.062c.073 1.954-.653 3.882-2.003 5.3-1.48 1.554-3.564 2.443-5.736 2.443-2.172 0-4.256-.889-5.736-2.443A7.545 7.545 0 011.385 12.44.207.207 0 001.178 12.23H.277a.207.207 0 00-.207.207v.003z"/>
    </svg>

    <!-- AWS -->
    <svg v-else-if="cleanName === 'aws' || cleanName === 'amazon'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#FF9900" d="M18.75 14.25c-.2 0-.39-.06-.55-.17-.16-.11-1.74-1.25-3.8-1.25-1.43 0-2.61.54-3.58 1.62-.26.29-.68.31-.97.05s-.31-.68-.05-.97C11.02 12.18 12.56 11.5 14.4 11.5c2.3 0 4.15 1.24 4.41 1.42.27.19.34.57.15.84-.13.18-.34.29-.56.29zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
    </svg>

    <!-- Git -->
    <svg v-else-if="cleanName === 'git'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#F05032" d="M21.6 10.9L13.1 2.4c-.8-.8-2.1-.8-2.9 0L8 4.6l3.6 3.6c.4-.1.8 0 1.1.3.6.6.6 1.5 0 2.1-.5.5-1.4.6-2 .1l-3.3 3.3v.9c.4.2.7.6.7 1.1 0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5c0-.6.3-1 .8-1.3v-4.1c-.5-.3-.8-.7-.8-1.3 0-.6.3-1.1.8-1.3L6.4 6 2.4 10c-.8.8-.8 2.1 0 2.9l8.5 8.5c.8.8 2.1.8 2.9 0l7.8-7.8c.8-.8.8-2.1 0-2.7z"/>
    </svg>

    <!-- GitHub -->
    <svg v-else-if="cleanName === 'github'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#FFFFFF" d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
    </svg>

    <!-- LinkedIn (in) -->
    <svg v-else-if="cleanName === 'linkedin'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#0A66C2" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
    </svg>

    <!-- Twitter / X -->
    <svg v-else-if="cleanName === 'twitter' || cleanName === 'x'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#1DA1F2" d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.936 9.936 0 0024 4.59z"/>
    </svg>

    <!-- Instagram -->
    <svg v-else-if="cleanName === 'instagram'" viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#E4405F" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
    </svg>

    <!-- Dev.to (DEV) -->
    <div v-else-if="cleanName === 'dev' || cleanName === 'devto'" class="w-full h-full rounded-lg bg-black border border-neutral-700 flex items-center justify-center font-black text-white text-xs sm:text-sm tracking-tighter select-none">
      DEV
    </div>

    <!-- Global CDN Fallback for other tech stacks -->
    <img
      v-else-if="cleanName && !hasFailedCdn"
      :src="cdnUrl"
      :alt="cleanName"
      @error="handleCdnError"
      class="w-full h-full object-contain"
    />

    <!-- Fallback Generic API Code Icon -->
    <svg v-else viewBox="0 0 24 24" class="w-full h-full">
      <path fill="#38BDF8" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
    </svg>
  </span>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  name: String,
  size: {
    type: String,
    default: '',
  },
});

const hasFailedCdn = ref(false);

const cleanName = computed(() => {
  if (!props.name) return '';
  return props.name.toLowerCase().trim().replace(/[^a-z0-9]/g, '');
});

const cdnUrl = computed(() => {
  if (!cleanName.value) return '';
  return `https://cdn.simpleicons.org/${cleanName.value}`;
});

watch(() => props.name, () => {
  hasFailedCdn.value = false;
});

function isUrl(str) {
  if (!str) return false;
  return str.startsWith('http://') || str.startsWith('https://') || str.startsWith('data:image/');
}

function handleCdnError() {
  hasFailedCdn.value = true;
}
</script>
