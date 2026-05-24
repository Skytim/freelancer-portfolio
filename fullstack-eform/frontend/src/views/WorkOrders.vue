<template>
<div><div class="d-flex justify-space-between align-center mb-6"><h2 class="text-h5 font-weight-bold">📋 工單紀錄</h2><v-select v-model="filter" :items="['','SUBMITTED','REVIEWED']" label="狀態" style="max-width:150px" hide-details></v-select></div>
<v-card><v-data-table :items="filtered" :headers="headers" density="compact" @click:row="selected=$event.item">
  <template #item.status="{item}"><v-chip :color="item.status==='SUBMITTED'?'blue':item.status==='REVIEWED'?'success':'grey'" size="x-small">{{item.status==='SUBMITTED'?'已提交':item.status==='REVIEWED'?'已審核':'草稿'}}</v-chip></template>
</v-data-table></v-card>
<v-dialog v-model="showDetail" max-width="500"><v-card v-if="selected" title="工單詳情">
  <v-card-text><v-list density="compact"><v-list-item title="工單編號" :subtitle="selected.orderNo"></v-list-item><v-list-item title="設備" :subtitle="selected.equipment?.name"></v-list-item><v-list-item title="人員" :subtitle="selected.inspector?.displayName"></v-list-item><v-list-item title="時間" :subtitle="new Date(selected.createdAt).toLocaleString()"></v-list-item></v-list>
  <div v-if="selected.formData" class="pa-4"><pre class="text-caption bg-grey-lighten-4 pa-3 rounded">{{JSON.stringify(JSON.parse(selected.formData),null,2)}}</pre></div></v-card-text>
  <v-card-actions><v-spacer></v-spacer><v-btn @click="showDetail=false">關閉</v-btn></v-card-actions>
</v-card></v-dialog>
</div>
</template>
<script setup lang="ts">import {ref,computed,onMounted} from 'vue';import {workOrderApi} from '../api';import type {WorkOrder} from '../types';
const orders=ref<WorkOrder[]>([]);const filter=ref('');const selected=ref<WorkOrder|null>(null);const showDetail=ref(false);
const filtered=computed(()=>filter.value?orders.value.filter(o=>o.status===filter.value):orders.value);
const headers=[{title:'單號',key:'orderNo'},{title:'設備',key:'equipment.name'},{title:'人員',key:'inspector.displayName'},{title:'時間',key:'createdAt'},{title:'狀態',key:'status'}];
onMounted(async()=>{try{const r=await workOrderApi.list();orders.value=r.data.data||[]}catch(e){console.error(e)}});
</script>
