<template>
  <div>
    <h2 class="text-xl font-bold text-gray-900 mb-6">儀表板</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-white rounded-xl p-5 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">本月工單</p>
        <p class="text-2xl font-bold text-gray-900">47</p>
        <p class="text-xs text-green-500 mt-1">↑ 12%</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">待審核</p>
        <p class="text-2xl font-bold text-gray-900">3</p>
        <p class="text-xs text-amber-500 mt-1">⚠ 需處理</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">設備總數</p>
        <p class="text-2xl font-bold text-gray-900">{{ equipment.length }}</p>
        <p class="text-xs text-gray-400 mt-1">5 種類型</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">完成率</p>
        <p class="text-2xl font-bold text-gray-900">98.2%</p>
        <p class="text-xs text-green-500 mt-1">↑ 1.5%</p>
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
      <!-- Equipment List -->
      <div class="bg-white rounded-xl overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b font-semibold text-sm">設備清單</div>
        <div class="divide-y divide-gray-50">
          <div v-for="eq in equipment" :key="eq.id"
               class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 cursor-pointer"
               @click="$router.push(`/inspect/${eq.code}`)">
            <div>
              <p class="text-sm font-medium">{{ eq.name }}</p>
              <p class="text-xs text-gray-400">{{ eq.location }} · {{ eq.code }}</p>
            </div>
            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">巡檢</span>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white rounded-xl overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b font-semibold text-sm">最近工單</div>
        <div class="divide-y divide-gray-50">
          <div v-for="wo in recentOrders" :key="wo.id" class="px-5 py-3 text-sm flex justify-between">
            <div>
              <p class="font-medium">{{ wo.orderNo }}</p>
              <p class="text-xs text-gray-400">{{ wo.equipment?.name }} · {{ wo.inspector?.displayName }}</p>
            </div>
            <span :class="statusClass(wo.status)">{{ statusLabel(wo.status) }}</span>
          </div>
          <div v-if="!recentOrders.length" class="px-5 py-8 text-center text-gray-400 text-sm">
            尚無工單紀錄
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { equipmentApi, workOrderApi } from '../api'
import type { Equipment, WorkOrder } from '../types'

const equipment = ref<Equipment[]>([])
const recentOrders = ref<WorkOrder[]>([])

onMounted(async () => {
  try {
    const [eRes, wRes] = await Promise.all([equipmentApi.list(), workOrderApi.list()])
    equipment.value = eRes.data.data || []
    recentOrders.value = (wRes.data.data || []).slice(0, 5)
  } catch (e) { console.error(e) }
})

function statusClass(s: string) {
  return s === 'SUBMITTED' ? 'text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded' :
         s === 'REVIEWED' ? 'text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded' :
         'text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded'
}
function statusLabel(s: string) {
  return { DRAFT: '草稿', SUBMITTED: '已提交', REVIEWED: '已審核' }[s] || s
}
</script>
