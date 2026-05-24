<template>
<v-layout>
  <v-navigation-drawer permanent width="220" color="grey-darken-4" theme="dark">
    <v-list-item title="📋 巡檢系統" :subtitle="auth.displayName" class="px-4 pt-4 pb-2"></v-list-item><v-divider class="mb-2"></v-divider>
    <v-list nav density="compact">
      <v-list-item to="/" prepend-icon="mdi-view-dashboard" title="儀表板" base-color="white"></v-list-item>
      <v-list-item to="/inspect" prepend-icon="mdi-clipboard-edit" title="填寫巡檢表" base-color="white"></v-list-item>
      <v-list-item to="/orders" prepend-icon="mdi-file-document" title="工單紀錄" base-color="white"></v-list-item>
      <v-list-item v-if="auth.isAdmin" to="/templates" prepend-icon="mdi-cog" title="表單模板" base-color="white"></v-list-item>
    </v-list>
    <template #append><div class="pa-3"><v-btn block variant="text" prepend-icon="mdi-logout" @click="auth.logout()">登出</v-btn></div></template>
  </v-navigation-drawer>
  <v-main class="bg-grey-lighten-4"><div class="pa-6"><router-view/></div></v-main>
</v-layout>
</template>
<script setup lang="ts">import {useAuthStore} from '../stores/auth';const auth=useAuthStore();</script>
