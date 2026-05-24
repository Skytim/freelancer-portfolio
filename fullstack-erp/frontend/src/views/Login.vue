<template>
<v-app><v-main class="d-flex align-center justify-center bg-blue-accent-4" style="min-height:100vh">
<v-card width="420" class="pa-8 mx-auto">
  <v-card-title class="text-h5 text-center">📦 進銷存管理系統</v-card-title>
  <v-card-subtitle class="text-center pb-6">請登入您的帳號</v-card-subtitle>
  <v-form @submit.prevent="login">
    <v-text-field v-model="u" label="帳號" prepend-inner-icon="mdi-account" required></v-text-field>
    <v-text-field v-model="p" label="密碼" type="password" prepend-inner-icon="mdi-lock" class="mt-2" required></v-text-field>
    <v-alert v-if="err" type="error" density="compact" class="mb-4">{{err}}</v-alert>
    <v-btn type="submit" block color="blue-accent-4" size="large" class="mt-4">登入</v-btn>
  </v-form>
  <p class="text-caption text-center mt-4 text-grey">任意帳號 + 密碼 123456</p>
</v-card>
</v-main></v-app>
</template>
<script setup lang="ts">import {ref} from 'vue';import {authApi} from '../api';import {useRouter} from 'vue-router';
const u=ref(''),p=ref(''),err=ref(''),router=useRouter();
async function login(){try{const r=await authApi.login(u.value,p.value);if(r.data.success){localStorage.setItem('token',r.data.data.token);router.push('/')}else err.value=r.data.message}catch(e:any){err.value='登入失敗'}}
</script>
