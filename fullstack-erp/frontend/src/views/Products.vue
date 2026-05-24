<template>
<div><div class="flex justify-between items-center mb-6"><h2 class="text-xl font-bold text-gray-900">📦 商品管理</h2><button @click="showForm=true;editing=null" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm">＋ 新增商品</button></div>
<div class="bg-white rounded-xl overflow-hidden shadow-sm">
  <div class="px-5 py-3 border-b"><input v-model="search" @input="load" placeholder="🔍 搜尋商品名稱或 SKU..." class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm w-56"></div>
  <table class="w-full text-sm"><thead class="bg-gray-50 text-gray-500 text-xs"><tr><th class="text-left py-3 px-4">SKU</th><th class="text-left py-3 px-4">商品名稱</th><th class="text-left py-3 px-4">分類</th><th class="text-right py-3 px-4">成本</th><th class="text-right py-3 px-4">售價</th><th class="text-right py-3 px-4">庫存</th><th class="text-center py-3 px-4">操作</th></tr></thead>
  <tbody class="divide-y divide-gray-50">
    <tr v-for="p in products" :key="p.id" class="hover:bg-gray-50">
      <td class="py-3 px-4 font-mono text-xs">{{p.sku}}</td><td class="py-3 px-4 font-medium">{{p.name}}</td><td class="py-3 px-4 text-xs text-gray-400">{{p.category}}</td>
      <td class="py-3 px-4 text-right text-gray-500">${{p.costPrice}}</td><td class="py-3 px-4 text-right font-medium">${{p.sellPrice}}</td>
      <td class="py-3 px-4 text-right" :class="p.stockQty < p.safetyStock ? 'text-red-500 font-bold' : ''">{{p.stockQty}}<span class="text-xs text-gray-400">/{{p.safetyStock}}</span></td>
      <td class="py-3 px-4 text-center"><button @click="edit(p)" class="text-xs text-blue-500">編輯</button></td>
    </tr>
  </tbody></table>
</div>
<!-- Form Modal -->
<div v-if="showForm" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" @click="showForm=false"><div class="bg-white rounded-xl p-6 max-w-md w-full" @click.stop>
  <h3 class="font-bold text-lg mb-4">{{editing?'編輯':'新增'}}商品</h3>
  <div class="grid grid-cols-2 gap-3 text-sm">
    <div><label class="block mb-1">SKU</label><input v-model="form.sku" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">名稱</label><input v-model="form.name" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">分類</label><input v-model="form.category" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">單位</label><input v-model="form.unit" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">成本</label><input v-model.number="form.costPrice" type="number" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">售價</label><input v-model.number="form.sellPrice" type="number" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">庫存量</label><input v-model.number="form.stockQty" type="number" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">安全庫存</label><input v-model.number="form.safetyStock" type="number" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block mb-1">分店</label><select v-model="form.branch" class="w-full border rounded px-3 py-2 bg-white"><option>台北</option><option>台中</option><option>高雄</option></select></div>
  </div>
  <div class="flex gap-3 mt-6"><button @click="save" class="flex-1 bg-emerald-600 text-white py-2 rounded text-sm">儲存</button><button @click="showForm=false" class="flex-1 border py-2 rounded text-sm">取消</button></div>
</div></div>
</div>
</template>
<script setup lang="ts">
import {ref,onMounted} from 'vue'; import {productApi} from '../api';
const products=ref<any[]>([]); const search=ref(''); const showForm=ref(false); const editing=ref<any>(null);
const form=ref({sku:'',name:'',category:'',unit:'件',costPrice:0,sellPrice:0,stockQty:0,safetyStock:10,branch:'台北'});
async function load(){try{const r=await productApi.list(search.value||undefined);products.value=r.data.data||[]}catch(e){console.error(e)}}
function edit(p:any){editing.value=p;form.value={...p};showForm.value=true}
async function save(){try{if(editing.value){await productApi.update(editing.value.id,form.value)}else{await productApi.create(form.value)}showForm.value=false;editing.value=null;load()}catch(e){console.error(e)}}
onMounted(load);
</script>
