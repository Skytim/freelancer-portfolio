<template>
<div><div class="flex justify-between items-center mb-6"><h2 class="text-xl font-bold text-gray-900">📋 庫存查詢</h2><select v-model="branch" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm bg-white"><option value="">全部分店</option><option>台北</option><option>台中</option><option>高雄</option></select></div>
<div class="bg-white rounded-xl overflow-hidden shadow-sm"><table class="w-full text-sm"><thead class="bg-gray-50 text-gray-500 text-xs"><tr><th class="text-left py-3 px-4">SKU</th><th class="text-left py-3 px-4">商品</th><th class="text-left py-3 px-4">分店</th><th class="text-right py-3 px-4">現有庫存</th><th class="text-right py-3 px-4">安全庫存</th><th class="text-center py-3 px-4">狀態</th></tr></thead>
<tbody class="divide-y divide-gray-50"><tr v-for="p in filtered" :key="p.id"><td class="py-3 px-4 font-mono text-xs">{{p.sku}}</td><td class="py-3 px-4">{{p.name}}</td><td class="py-3 px-4 text-gray-400">{{p.branch}}</td><td class="py-3 px-4 text-right" :class="p.stockQty < p.safetyStock ? 'text-red-500 font-bold' : ''">{{p.stockQty}}</td><td class="py-3 px-4 text-right text-gray-400">{{p.safetyStock}}</td><td class="py-3 px-4 text-center"><span v-if="p.stockQty === 0" class="text-xs bg-red-50 text-red-600 px-2 py-0.5 rounded">缺貨</span><span v-else-if="p.stockQty < p.safetyStock" class="text-xs bg-amber-50 text-amber-600 px-2 py-0.5 rounded">⚠ 低庫存</span><span v-else class="text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded">正常</span></td></tr></tbody></table></div>
</div>
</template>
<script setup lang="ts">
import {ref,computed,onMounted} from 'vue'; import {productApi} from '../api';
const products=ref<any[]>([]); const branch=ref('');
const filtered=computed(()=>branch.value?products.value.filter((p:any)=>p.branch===branch.value):products.value);
onMounted(async()=>{try{const r=await productApi.list();products.value=r.data.data||[]}catch(e){console.error(e)}});
</script>
