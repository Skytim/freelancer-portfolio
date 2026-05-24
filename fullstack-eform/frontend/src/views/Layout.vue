<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <aside class="w-56 bg-slate-800 text-white flex-shrink-0 hidden md:block">
      <div class="px-5 py-5 border-b border-slate-700">
        <h1 class="font-bold">📋 巡檢系統</h1>
        <p class="text-xs text-slate-400 mt-1">{{ auth.displayName }} · {{ roleLabel }}</p>
      </div>
      <nav class="p-3 space-y-1 text-sm">
        <router-link to="/" class="nav-link" active-class="bg-blue-600 text-white"
          >📊 儀表板</router-link>
        <router-link to="/inspect" class="nav-link" active-class="bg-blue-600 text-white"
          >📝 填寫巡檢表</router-link>
        <router-link to="/orders" class="nav-link" active-class="bg-blue-600 text-white"
          >📋 工單紀錄</router-link>
        <router-link v-if="auth.isAdmin" to="/templates" class="nav-link" active-class="bg-blue-600 text-white"
          >🔧 表單模板</router-link>
      </nav>
      <div class="absolute bottom-0 w-56 p-3 border-t border-slate-700">
        <button @click="auth.logout()" class="w-full text-left text-xs text-slate-400 hover:text-white px-3 py-2">
          🚪 登出
        </button>
      </div>
    </aside>
    <!-- Main -->
    <main class="flex-1">
      <header class="bg-white px-6 py-4 border-b flex md:hidden items-center justify-between">
        <h1 class="font-bold">📋 巡檢系統</h1>
        <button @click="auth.logout()" class="text-xs text-gray-400">登出</button>
      </header>
      <div class="p-6">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'
const auth = useAuthStore()
const roleLabel = computed(() => ({ ENGINEER: '工程師', PM: 'PM', ADMIN: '管理員' }[auth.role] || ''))
</script>

<style scoped>
.nav-link { @apply flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors; }
</style>
