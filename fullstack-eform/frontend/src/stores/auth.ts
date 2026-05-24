import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authApi } from '../api'
import { useRouter } from 'vue-router'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('token') || '')
  const username = ref(localStorage.getItem('username') || '')
  const displayName = ref(localStorage.getItem('displayName') || '')
  const role = ref(localStorage.getItem('role') || '')

  const isLoggedIn = computed(() => !!token.value)
  const isAdmin = computed(() => role.value === 'ADMIN')

  async function login(user: string, pass: string) {
    const res = await authApi.login(user, pass)
    if (!res.data.success) throw new Error(res.data.message)
    const d = res.data.data
    token.value = d.token
    username.value = d.username
    displayName.value = d.displayName
    role.value = d.role
    localStorage.setItem('token', d.token)
    localStorage.setItem('username', d.username)
    localStorage.setItem('displayName', d.displayName)
    localStorage.setItem('role', d.role)
  }

  function logout() {
    token.value = ''
    localStorage.clear()
    window.location.href = '/login'
  }

  return { token, username, displayName, role, isLoggedIn, isAdmin, login, logout }
})
