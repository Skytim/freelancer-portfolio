<template>
<div>
  <div class="d-flex justify-space-between align-center mb-6"><h2 class="text-h5 font-weight-bold">📦 商品管理</h2><v-btn color="blue-accent-4" prepend-icon="mdi-plus" @click="openCreate">新增商品</v-btn></div>
  <v-card>
    <v-card-text><v-text-field v-model="search" @update:model-value="load" prepend-inner-icon="mdi-magnify" label="搜尋商品名稱或 SKU..." density="compact" hide-details class="mb-4"></v-text-field></v-card-text>
    <v-data-table :items="products" :headers="headers" :search="search" density="compact" hide-default-footer>
      <template #item.stockQty="{item}"><span :class="item.stockQty < item.safetyStock ? 'text-red font-weight-bold' : ''">{{item.stockQty}} <span class="text-caption text-grey">/{{item.safetyStock}}</span></span></template>
      <template #item.actions="{item}"><v-btn size="small" variant="text" color="blue" @click="editItem(item)">編輯</v-btn></template>
    </v-data-table>
  </v-card>
  <!-- Dialog -->
  <v-dialog v-model="dialog" max-width="500"><v-card :title="editing?'編輯商品':'新增商品'">
    <v-card-text><v-row dense>
      <v-col cols="6"><v-text-field v-model="form.sku" label="SKU"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model="form.name" label="名稱"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model="form.category" label="分類"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model="form.unit" label="單位"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model.number="form.costPrice" label="成本" type="number"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model.number="form.sellPrice" label="售價" type="number"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model.number="form.stockQty" label="庫存量" type="number"></v-text-field></v-col>
      <v-col cols="6"><v-text-field v-model.number="form.safetyStock" label="安全庫存" type="number"></v-text-field></v-col>
      <v-col cols="6"><v-select v-model="form.branch" label="分店" :items="['台北','台中','高雄']"></v-select></v-col>
    </v-row></v-card-text>
    <v-card-actions><v-spacer></v-spacer><v-btn @click="dialog=false">取消</v-btn><v-btn color="blue-accent-4" @click="save">儲存</v-btn></v-card-actions>
  </v-card></v-dialog>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {productApi} from '../api';
const products=ref<any[]>([]);const search=ref('');const dialog=ref(false);const editing=ref(false);
const form=ref({sku:'',name:'',category:'',unit:'件',costPrice:0,sellPrice:0,stockQty:0,safetyStock:10,branch:'台北'});
const editId=ref<number|null>(null);
const headers=[{title:'SKU',key:'sku'},{title:'商品名稱',key:'name'},{title:'分類',key:'category'},{title:'成本',key:'costPrice'},{title:'售價',key:'sellPrice'},{title:'庫存',key:'stockQty'},{title:'操作',key:'actions',sortable:false}];
async function load(){try{const r=await productApi.list(search.value||undefined);products.value=r.data.data||[]}catch(e){console.error(e)}}
function openCreate(){editing.value=false;editId.value=null;form.value={sku:'',name:'',category:'',unit:'件',costPrice:0,sellPrice:0,stockQty:0,safetyStock:10,branch:'台北'};dialog.value=true}
function editItem(p:any){editing.value=true;editId.value=p.id;Object.assign(form.value,p);dialog.value=true}
async function save(){try{if(editing.value&&editId.value){await productApi.update(editId.value,form.value)}else{await productApi.create(form.value)}dialog.value=false;load()}catch(e){console.error(e)}}
onMounted(load);
</script>
