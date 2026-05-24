<template>
<div><h2 class="text-h5 font-weight-bold mb-6">📊 儀表板</h2>
<v-row>
  <v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">商品總數</div><div class="text-h4 font-weight-bold">{{stats.totalProducts}}</div></v-card></v-col>
  <v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">庫存總量</div><div class="text-h4 font-weight-bold">{{stats.totalItems}}</div></v-card></v-col>
  <v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">低庫存警示</div><div class="text-h4 font-weight-bold text-red-accent-4">{{stats.lowStock}}</div></v-card></v-col>
  <v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">本月交易</div><div class="text-h4 font-weight-bold">{{purchaseOrders.length+salesOrders.length}}</div></v-card></v-col>
</v-row>
<v-row class="mt-4">
  <v-col md="6"><v-card title="📥 最近進貨"><v-data-table :items="purchaseOrders.slice(0,5)" :headers="poHeaders" hide-default-footer density="compact"></v-data-table></v-card></v-col>
  <v-col md="6"><v-card title="📤 最近出貨"><v-data-table :items="salesOrders.slice(0,5)" :headers="soHeaders" hide-default-footer density="compact"></v-data-table></v-card></v-col>
</v-row>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {productApi,poApi,soApi} from '../api';
const stats=ref({totalProducts:0,totalItems:0,lowStock:0});
const purchaseOrders=ref<any[]>([]);const salesOrders=ref<any[]>([]);
const poHeaders=[{title:'單號',key:'orderNo'},{title:'商品',key:'productName'},{title:'數量',key:'quantity'},{title:'總額',key:'totalAmount'}];
const soHeaders=[{title:'單號',key:'orderNo'},{title:'客戶',key:'customer'},{title:'商品',key:'productName'},{title:'總額',key:'totalAmount'}];
onMounted(async()=>{try{const[s,p,so]=await Promise.all([productApi.stats(),poApi.list(),soApi.list()]);stats.value=s.data.data;purchaseOrders.value=p.data.data||[];salesOrders.value=so.data.data||[]}catch(e){console.error(e)}});
</script>
