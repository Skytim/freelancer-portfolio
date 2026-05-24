<template>
<div class="min-h-screen bg-gray-50 flex">
<aside class="w-56 bg-slate-800 text-white flex-shrink-0 hidden md:flex md:flex-col">
  <div class="px-5 py-5 border-b border-slate-700"><h1 class="font-bold">📦 進銷存系統</h1></div>
  <nav class="p-3 space-y-1 text-sm flex-1">
    <router-link to="/" class="nav-link" active-class="bg-emerald-600 text-white">📊 儀表板</router-link>
    <router-link to="/products" class="nav-link" active-class="bg-emerald-600 text-white">📦 商品管理</router-link>
    <router-link to="/purchase" class="nav-link" active-class="bg-emerald-600 text-white">📥 進貨管理</router-link>
    <router-link to="/sales" class="nav-link" active-class="bg-emerald-600 text-white">📤 出貨管理</router-link>
    <router-link to="/inventory" class="nav-link" active-class="bg-emerald-600 text-white">📋 庫存查詢</router-link>
  </nav>
  <div class="p-3 border-t border-slate-700"><button @click="logout" class="w-full text-left text-xs text-slate-400 hover:text-white px-3 py-2">🚪 登出</button></div>
</aside>
<main class="flex-1"><div class="p-6"><router-view/></div></main>
</div>
</template>
<script setup lang="ts">
function logout(){localStorage.clear();window.location.href='/login'}
</script>
<style scoped>
.nav-link{display:flex;align-items:center;gap:0.75rem;padding:0.625rem 0.75rem;border-radius:0.5rem;color:#cbd5e1;transition:all 0.15s;}
.nav-link:hover{background:rgba(255,255,255,0.1);}
</style>
