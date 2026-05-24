<template>
<div><h2 class="text-h5 font-weight-bold mb-6">📊 儀表板</h2>
<v-row><v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">本月工單</div><div class="text-h4 font-weight-bold">47</div></v-card></v-col><v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">待審核</div><div class="text-h4 font-weight-bold text-amber">3</div></v-card></v-col><v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">設備總數</div><div class="text-h4 font-weight-bold">{{equipment.length}}</div></v-card></v-col><v-col cols="6" md="3"><v-card class="pa-5"><div class="text-caption text-grey mb-1">完成率</div><div class="text-h4 font-weight-bold text-green">98%</div></v-card></v-col></v-row>
<v-row class="mt-4">
  <v-col md="6"><v-card title="設備清單"><v-list density="compact"><v-list-item v-for="eq in equipment" :key="eq.id" :title="eq.name" :subtitle="eq.location + ' · ' + eq.code" @click="$router.push('/inspect/'+eq.code)"><template #append><v-btn size="small" variant="tonal" color="blue">巡檢</v-btn></template></v-list-item></v-list></v-card></v-col>
  <v-col md="6"><v-card title="最近工單"><v-data-table :items="recentOrders" :headers="woHeaders" hide-default-footer density="compact"></v-data-table></v-card></v-col>
</v-row>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {equipmentApi,workOrderApi} from '../api';import type {Equipment,WorkOrder} from '../types';
const equipment=ref<Equipment[]>([]);const recentOrders=ref<WorkOrder[]>([]);
const woHeaders=[{title:'單號',key:'orderNo'},{title:'設備',key:'equipment.name'},{title:'人員',key:'inspector.displayName'},{title:'狀態',key:'status'}];
onMounted(async()=>{try{const[e,w]=await Promise.all([equipmentApi.list(),workOrderApi.list()]);equipment.value=e.data.data||[];recentOrders.value=(w.data.data||[]).slice(0,5)}catch(e){console.error(e)}});
</script>
