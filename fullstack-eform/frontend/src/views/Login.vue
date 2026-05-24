<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm">
      <div class="text-center mb-8">
        <div class="text-4xl mb-3">📋</div>
        <h1 class="text-2xl font-bold text-gray-900">機房巡檢系統</h1>
        <p class="text-sm text-gray-400 mt-1">請登入您的帳號</p>
      </div>
      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">帳號</label>
          <input v-model="username" type="text" required
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-400"
            placeholder="engineer1 / pm1 / admin1" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">密碼</label>
          <input v-model="password" type="password" required
            class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-400"
            placeholder="123456" />
        </div>
        <p v-if="error" class="text-red-500 text-xs">{{ error }}</p>
        <button type="submit"
          class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-md"
          :disabled="loading">
          {{ loading ? '登入中...' : '登入' }}
        </button>
      </form>
      <p class="text-xs text-gray-400 text-center mt-4">Demo: engineer1 / 123456</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const username = ref('engineer1')
const password = ref('123456')
const error = ref('')
const loading = ref(false)

async function handleLogin() {
  error.value = ''
  loading.value = true
  try {
    await auth.login(username.value, password.value)
    router.push('/')
  } catch (e: any) {
    error.value = e.message || '登入失敗'
  } finally {
    loading.value = false
  }
}
</script>
