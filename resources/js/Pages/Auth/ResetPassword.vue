<template>
  <div class="min-h-screen bg-black text-white flex items-center justify-center p-4 relative font-sans selection:bg-neutral-800 selection:text-white">
    <Head title="Reset Password - Kashif Khan Portfolio" />

    <div class="w-full max-w-md space-y-6">
      <!-- Back to Login Link -->
      <div class="text-left">
        <Link :href="route('login')" class="text-xs text-neutral-400 hover:text-white font-semibold inline-flex items-center space-x-1.5 transition-colors">
          <span>&larr;</span>
          <span>Back to Login</span>
        </Link>
      </div>

      <!-- Main Card -->
      <div class="bg-neutral-950 p-8 sm:p-10 rounded-md border border-neutral-800 shadow-2xl space-y-6 relative">
        <!-- Header -->
        <div class="text-center space-y-2">
          <div class="inline-flex w-10 h-10 rounded-md bg-white text-black font-extrabold text-sm items-center justify-center shadow-md mb-2">
            KK
          </div>
          <h2 class="text-2xl font-extrabold text-white tracking-tight">Create New Password</h2>
          <p class="text-xs text-neutral-400">Please enter your email and set your new admin password.</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label for="email" class="block text-xs font-semibold text-neutral-300 mb-1.5">Email Address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              autofocus
              placeholder="admin@kashifkhan.com"
              class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-xs placeholder-neutral-500 focus:outline-none focus:border-white transition-colors"
            />
            <span v-if="form.errors.email" class="text-xs text-rose-400 mt-1 block">{{ form.errors.email }}</span>
          </div>

          <div>
            <label for="password" class="block text-xs font-semibold text-neutral-300 mb-1.5">New Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-xs placeholder-neutral-500 focus:outline-none focus:border-white transition-colors"
            />
            <span v-if="form.errors.password" class="text-xs text-rose-400 mt-1 block">{{ form.errors.password }}</span>
          </div>

          <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-neutral-300 mb-1.5">Confirm New Password</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              placeholder="••••••••"
              class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-xs placeholder-neutral-500 focus:outline-none focus:border-white transition-colors"
            />
            <span v-if="form.errors.password_confirmation" class="text-xs text-rose-400 mt-1 block">{{ form.errors.password_confirmation }}</span>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-3 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-xs shadow-md transition-all disabled:opacity-50 mt-2 cursor-pointer flex items-center justify-center"
          >
            <span v-if="form.processing" class="inline-flex items-center space-x-2">
              <svg class="animate-spin w-4 h-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>Updating...</span>
            </span>
            <span v-else>Reset Password</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
