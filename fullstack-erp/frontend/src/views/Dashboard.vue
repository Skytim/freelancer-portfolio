<template>
<div><h2 class="text-xl font-bold text-gray-900 mb-6">📊 儀表板</h2>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
  <div class="bg-white rounded-xl p-5 shadow-sm"><p class="text-xs text-gray-400 mb-1">商品總數</p><p class="text-2xl font-bold">{{stats.totalProducts}}</p></div>
  <div class="bg-white rounded-xl p-5 shadow-sm"><p class="text-xs text-gray-400 mb-1">庫存總量</p><p class="text-2xl font-bold">{{stats.totalItems}}</p></div>
  <div class="bg-white rounded-xl p-5 shadow-sm"><p class="text-xs text-gray-400 mb-1">低庫存警示</p><p class="text-2xl font-bold text-red-500">{{stats.lowStock}}</p></div>
  <div class="bg-white rounded-xl p-5 shadow-sm"><p class="text-xs text-gray-400 mb-1">本月交易</p><p class="text-2xl font-bold">{{purchaseOrders.length + salesOrders.length}}</p></div>
</div>
<div class="grid md:grid-cols-2 gap-6">
  <div class="bg-white rounded-xl overflow-hidden shadow-sm"><div class="px-5 py-3 border-b font-semibold text-sm">📥 最近進貨</div>
    <table class="w-full text-sm"><tbody class="divide-y divide-gray-50"><tr v-for="po in purchaseOrders.slice(0,5)" :key="po.id" class="hover:bg-gray-50"><td class="py-2 px-4 font-mono text-xs">{{po.orderNo}}</td><td class="py-2 px-4">{{po.productName}}</td><td class="py-2 px-4 text-right">x{{po.quantity}}</td><td class="py-2 px-4 text-right font-medium">${{po.totalAmount?.toLocaleString()}}</td></tr></tbody></table>
  </div>
  <div class="bg-white rounded-xl overflow-hidden shadow-sm"><div class="px-5 py-3 border-b font-semibold text-sm">📤 最近出貨</div>
    <table class="w-full text-sm"><tbody class="divide-y divide-gray-50"><tr v-for="so in salesOrders.slice(0,5)" :key="so.id" class="hover:bg-gray-50"><td class="py-2 px-4 font-mono text-xs">{{so.orderNo}}</td><td class="py-2 px-4">{{so.productName}}</td><td class="py-2 px-4 text-right">x{{so.quantity}}</td><td class="py-2 px-4 text-right font-medium">${{so.totalAmount?.toLocaleString()}}</td></tr></tbody></table>
  </div>
</div>
</div>
</template>
<script setup lang="ts">
import {ref,onMounted} from 'vue'; import {productApi,poApi,soApi} from '../api';
const stats=ref({totalProducts:0,totalItems:0,lowStock:0});
const purchaseOrders=ref<any[]>([]); const salesOrders=ref<any[]>([]);
onMounted(async()=>{
  try{const[s,p,so]=await Promise.all([productApi.stats(),poApi.list(),soApi.list()]);
  stats.value=s.data.data; purchaseOrders.value=p.data.data||[]; salesOrders.value=so.data.data||[]}catch(e){console.error(e)}
});
</script>
