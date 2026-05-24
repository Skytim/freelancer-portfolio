<template>
<v-app><v-main class="d-flex align-center justify-center bg-blue-accent-4" style="min-height:100vh">
<v-card width="420" class="pa-8"><v-card-title class="text-h5 text-center">📋 機房巡檢系統</v-card-title><v-card-subtitle class="text-center pb-6">請登入您的帳號</v-card-subtitle>
<v-form @submit.prevent="login"><v-text-field v-model="u" label="帳號" prepend-inner-icon="mdi-account" required></v-text-field><v-text-field v-model="p" label="密碼" type="password" prepend-inner-icon="mdi-lock" class="mt-2" required></v-text-field><v-alert v-if="err" type="error" density="compact" class="mb-4">{{err}}</v-alert><v-btn type="submit" block color="blue-accent-4" size="large" class="mt-4">登入</v-btn></v-form>
<p class="text-caption text-center mt-4 text-grey">Demo: engineer1 / 123456</p>
</v-card></v-main></v-app>
</template>
<script setup lang="ts">import {ref} from 'vue';import {useAuthStore} from '../stores/auth';import {useRouter} from 'vue-router';
const auth=useAuthStore();const router=useRouter();const u=ref('engineer1'),p=ref('123456'),err=ref('');
async function login(){try{await auth.login(u.value,p.value);router.push('/')}catch(e:any){err.value=e.message||'登入失敗'}}
</script>
