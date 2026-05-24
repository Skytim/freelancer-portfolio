<template>
<div><div class="flex justify-between items-center mb-6"><h2 class="text-xl font-bold text-gray-900">📤 出貨管理</h2><button @click="showForm=true" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm">＋ 新增出貨單</button></div>
<div class="bg-white rounded-xl overflow-hidden shadow-sm"><table class="w-full text-sm"><thead class="bg-gray-50 text-gray-500 text-xs"><tr><th class="text-left py-3 px-4">單號</th><th class="text-left py-3 px-4">客戶</th><th class="text-left py-3 px-4">商品</th><th class="text-right py-3 px-4">數量</th><th class="text-right py-3 px-4">單價</th><th class="text-right py-3 px-4">總額</th><th class="text-center py-3 px-4">狀態</th></tr></thead>
<tbody class="divide-y divide-gray-50"><tr v-for="so in orders" :key="so.id" class="hover:bg-gray-50"><td class="py-3 px-4 font-mono text-xs">{{so.orderNo}}</td><td class="py-3 px-4">{{so.customer}}</td><td class="py-3 px-4">{{so.productName}}</td><td class="py-3 px-4 text-right">{{so.quantity}}</td><td class="py-3 px-4 text-right">${{so.unitPrice}}</td><td class="py-3 px-4 text-right font-medium">${{so.totalAmount?.toLocaleString()}}</td><td class="py-3 px-4 text-center"><span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">{{so.status==='SHIPPED'?'已出貨':so.status}}</span></td></tr></tbody></table></div>
<!-- Form Modal -->
<div v-if="showForm" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" @click="showForm=false"><div class="bg-white rounded-xl p-6 max-w-md w-full" @click.stop>
  <h3 class="font-bold text-lg mb-4">新增出貨單</h3>
  <div class="space-y-3 text-sm">
    <div class="grid grid-cols-2 gap-3"><div><label class="block mb-1">客戶</label><input v-model="f.customer" class="w-full border rounded px-3 py-2"></div><div><label class="block mb-1">商品名稱</label><input v-model="f.productName" class="w-full border rounded px-3 py-2"></div></div>
    <div class="grid grid-cols-3 gap-3"><div><label class="block mb-1">數量</label><input v-model.number="f.quantity" type="number" class="w-full border rounded px-3 py-2"></div><div><label class="block mb-1">單價</label><input v-model.number="f.unitPrice" type="number" class="w-full border rounded px-3 py-2"></div><div><label class="block mb-1">分店</label><select v-model="f.branch" class="w-full border rounded px-3 py-2 bg-white"><option>台北</option><option>台中</option><option>高雄</option></select></div></div>
    <div><label class="block mb-1">備註</label><textarea v-model="f.notes" class="w-full border rounded px-3 py-2" rows="2"></textarea></div>
  </div>
  <div class="flex gap-3 mt-6"><button @click="submit" class="flex-1 bg-emerald-600 text-white py-2 rounded text-sm">確認出貨</button><button @click="showForm=false" class="flex-1 border py-2 rounded text-sm">取消</button></div>
</div></div>
</div>
</template>
<script setup lang="ts">
import {ref,onMounted} from 'vue'; import {soApi} from '../api';
const orders=ref<any[]>([]); const showForm=ref(false);
const f=ref({customer:'',productName:'',quantity:0,unitPrice:0,branch:'台北',notes:''});
async function load(){try{const r=await soApi.list();orders.value=r.data.data||[]}catch(e){console.error(e)}}
async function submit(){try{f.value.totalAmount=f.value.quantity*f.value.unitPrice;await soApi.create(f.value);showForm.value=false;load()}catch(e){console.error(e)}}
onMounted(load);
</script>
