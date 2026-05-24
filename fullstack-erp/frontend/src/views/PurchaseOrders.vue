<template>
<div><div class="d-flex justify-space-between align-center mb-6"><h2 class="text-h5 font-weight-bold">📥 進貨管理</h2><v-btn color="blue-accent-4" prepend-icon="mdi-plus" @click="dialog=true">新增進貨單</v-btn></div>
<v-card><v-data-table :items="orders" :headers="headers" density="compact" hide-default-footer></v-data-table></v-card>
<v-dialog v-model="dialog" max-width="450"><v-card title="新增進貨單">
  <v-card-text><v-row dense>
    <v-col cols="7"><v-text-field v-model="f.supplier" label="供應商"></v-text-field></v-col>
    <v-col cols="5"><v-text-field v-model="f.productName" label="商品"></v-text-field></v-col>
    <v-col cols="4"><v-text-field v-model.number="f.quantity" label="數量" type="number"></v-text-field></v-col>
    <v-col cols="4"><v-text-field v-model.number="f.unitPrice" label="單價" type="number"></v-text-field></v-col>
    <v-col cols="4"><v-select v-model="f.branch" label="分店" :items="['台北','台中','高雄']"></v-select></v-col>
    <v-col cols="12"><v-textarea v-model="f.notes" label="備註" rows="2"></v-textarea></v-col>
  </v-row></v-card-text>
  <v-card-actions><v-spacer></v-spacer><v-btn @click="dialog=false">取消</v-btn><v-btn color="blue-accent-4" @click="submit">確認進貨</v-btn></v-card-actions>
</v-card></v-dialog>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {poApi} from '../api';
const orders=ref<any[]>([]);const dialog=ref(false);
const f=ref({supplier:'',productName:'',quantity:0,unitPrice:0,branch:'台北',notes:''});
const headers=[{title:'單號',key:'orderNo'},{title:'供應商',key:'supplier'},{title:'商品',key:'productName'},{title:'數量',key:'quantity'},{title:'單價',key:'unitPrice'},{title:'總額',key:'totalAmount'},{title:'狀態',key:'status'}];
async function load(){try{const r=await poApi.list();orders.value=r.data.data||[]}catch(e){console.error(e)}}
async function submit(){try{await poApi.create({...f.value,totalAmount:f.value.quantity*f.value.unitPrice});dialog.value=false;load()}catch(e){console.error(e)}}
onMounted(load);
</script>
