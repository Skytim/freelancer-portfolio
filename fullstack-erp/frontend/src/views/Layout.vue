<template>
<v-layout>
  <v-navigation-drawer permanent width="220" color="grey-darken-4" theme="dark">
    <v-list-item title="📦 進銷存系統" subtitle="Inventory ERP" class="px-4 pt-4 pb-2"></v-list-item>
    <v-divider class="mb-2"></v-divider>
    <v-list nav density="compact">
      <v-list-item to="/" prepend-icon="mdi-view-dashboard" title="儀表板" base-color="white"></v-list-item>
      <v-list-item to="/products" prepend-icon="mdi-package-variant" title="商品管理" base-color="white"></v-list-item>
      <v-list-item to="/purchase" prepend-icon="mdi-truck-delivery" title="進貨管理" base-color="white"></v-list-item>
      <v-list-item to="/sales" prepend-icon="mdi-truck-fast" title="出貨管理" base-color="white"></v-list-item>
      <v-list-item to="/inventory" prepend-icon="mdi-clipboard-list" title="庫存查詢" base-color="white"></v-list-item>
    </v-list>
    <template #append><div class="pa-3"><v-btn block variant="text" prepend-icon="mdi-logout" @click="logout">登出</v-btn></div></template>
  </v-navigation-drawer>
  <v-main class="bg-grey-lighten-4"><div class="pa-6"><router-view/></div></v-main>
</v-layout>
</template>
<script setup lang="ts">function logout(){localStorage.clear();window.location.href='/login'}</script>
