<template>
<div><div class="d-flex justify-space-between align-center mb-6"><h2 class="text-h5 font-weight-bold">📋 庫存查詢</h2><v-select v-model="branch" :items="['','台北','台中','高雄']" label="分店篩選" style="max-width:180px" hide-details></v-select></div>
<v-card><v-data-table :items="filtered" :headers="headers" density="compact" hide-default-footer>
  <template #item.stockQty="{item}"><span :class="item.stockQty===0?'text-red':item.stockQty<item.safetyStock?'text-amber':''" class="font-weight-bold">{{item.stockQty}}</span></template>
  <template #item.status="{item}">
    <v-chip v-if="item.stockQty===0" color="red" size="x-small">缺貨</v-chip>
    <v-chip v-else-if="item.stockQty<item.safetyStock" color="warning" size="x-small">低庫存</v-chip>
    <v-chip v-else color="success" size="x-small">正常</v-chip>
  </template>
</v-data-table></v-card>
</div>
</template>
<script setup lang="ts">import {ref,computed,onMounted} from 'vue';import {productApi} from '../api';
const products=ref<any[]>([]);const branch=ref('');
const filtered=computed(()=>branch.value?products.value.filter((p:any)=>p.branch===branch.value):products.value);
const headers=[{title:'SKU',key:'sku'},{title:'商品',key:'name'},{title:'分店',key:'branch'},{title:'現有庫存',key:'stockQty'},{title:'安全庫存',key:'safetyStock'},{title:'狀態',key:'status'}];
onMounted(async()=>{try{const r=await productApi.list();products.value=r.data.data||[]}catch(e){console.error(e)}});
</script>
