<template>
<div class="min-h-screen bg-gradient-to-br from-emerald-600 to-emerald-900 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm">
<div class="text-center mb-8"><div class="text-4xl mb-3">📦</div><h1 class="text-2xl font-bold text-gray-900">進銷存管理系統</h1><p class="text-sm text-gray-400 mt-1">請登入</p></div>
<form @submit.prevent="login" class="space-y-4">
<input v-model="u" type="text" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm" placeholder="帳號">
<input v-model="p" type="password" required class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm" placeholder="密碼">
<p v-if="err" class="text-red-500 text-xs">{{err}}</p>
<button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-medium hover:bg-emerald-700 shadow-md">登入</button>
</form>
</div></div>
</template>
<script setup lang="ts">
import {ref} from 'vue'; import {authApi} from '../api'; import {useRouter} from 'vue-router';
const u=ref(''),p=ref(''),err=ref(''),router=useRouter();
async function login(){try{const r=await authApi.login(u.value,p.value);if(r.data.success){localStorage.setItem('token',r.data.data.token);router.push('/')}else err.value=r.data.message}catch(e:any){err.value='登入失敗'}}
</script>
