<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 relative overflow-hidden font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Ambient background light glows -->
    <div class="fixed top-1/4 left-1/3 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none -z-10 animate-glow"></div>
    <div class="fixed bottom-1/4 right-1/3 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none -z-10 animate-glow" style="animation-delay: 1.5s"></div>

    <Head title="Admin Login - Kashif Khan Portfolio" />

    <div class="w-full max-w-md space-y-6">
      <!-- Back link -->
      <div class="text-left">
        <Link href="/" class="text-xs text-slate-400 hover:text-indigo-400 font-semibold inline-flex items-center space-x-1 transition-colors">
          <span>&larr;</span>
          <span>Back to Portfolio</span>
        </Link>
      </div>

      <!-- Main Login Card -->
      <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl space-y-6 relative">
        <!-- Header -->
        <div class="text-center space-y-2">
          <div class="inline-flex w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 p-0.5 shadow-xl mb-2">
            <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center font-bold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-400 to-pink-400 text-xl">
              KK
            </div>
          </div>
          <h2 class="text-2xl font-extrabold text-white tracking-tight">Admin CMS Portal</h2>
          <p class="text-xs text-slate-400">Sign in to manage portfolio content, skills & inquiries.</p>
        </div>

        <!-- Quick Credentials Banner -->
        <div class="p-3.5 rounded-2xl bg-indigo-950/40 border border-indigo-800/40 text-xs text-indigo-300 space-y-1">
          <div class="flex items-center justify-between font-bold text-indigo-200">
            <span>🔑 Default Admin Login:</span>
            <button type="button" @click="fillDefaultCredentials" class="text-[10px] text-pink-400 hover:underline">Auto-fill</button>
          </div>
          <p class="font-mono text-[11px]">Email: <span class="text-white">admin@kashifkhan.com</span></p>
          <p class="font-mono text-[11px]">Pass: <span class="text-white">password</span></p>
        </div>

        <div v-if="status" class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs text-center font-medium">
          {{ status }}
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email Address</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              autofocus
              placeholder="admin@kashifkhan.com"
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-xs placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors"
            />
            <span v-if="form.errors.email" class="text-xs text-rose-400 mt-1 block">{{ form.errors.email }}</span>
          </div>

          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="password" class="block text-xs font-semibold text-slate-300">Password</label>
              <Link v-if="canResetPassword" :href="route('password.request')" class="text-[11px] text-indigo-400 hover:underline">
                Forgot password?
              </Link>
            </div>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-xs placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors"
            />
            <span v-if="form.errors.password" class="text-xs text-rose-400 mt-1 block">{{ form.errors.password }}</span>
          </div>

          <div class="flex items-center justify-between pt-1">
            <label class="flex items-center space-x-2 text-xs text-slate-300 cursor-pointer">
              <input
                v-model="form.remember"
                type="checkbox"
                class="rounded bg-slate-900 border-slate-800 text-indigo-600 focus:ring-0"
              />
              <span>Remember me</span>
            </label>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-500 hover:to-pink-500 text-white font-bold text-xs shadow-xl shadow-indigo-600/30 transition-all disabled:opacity-50 mt-2"
          >
            <span v-if="form.processing">Signing in...</span>
            <span v-else>Log In to Dashboard</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function fillDefaultCredentials() {
  form.email = 'admin@kashifkhan.com';
  form.password = 'password';
}

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>
