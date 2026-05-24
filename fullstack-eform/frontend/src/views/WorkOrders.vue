<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold text-gray-900">📋 工單紀錄</h2>
      <select v-model="filter" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm bg-white">
        <option value="">全部</option>
        <option value="SUBMITTED">已提交</option>
        <option value="REVIEWED">已審核</option>
      </select>
    </div>

    <div class="bg-white rounded-xl overflow-hidden shadow-sm">
      <table class="w-full text-sm" v-if="filteredOrders.length">
        <thead class="bg-gray-50 text-gray-500 text-xs">
          <tr>
            <th class="text-left py-3 px-4">工單編號</th>
            <th class="text-left py-3 px-4">設備</th>
            <th class="text-left py-3 px-4">巡檢人員</th>
            <th class="text-left py-3 px-4">時間</th>
            <th class="text-center py-3 px-4">狀態</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-for="wo in filteredOrders" :key="wo.id" class="hover:bg-gray-50 cursor-pointer"
              @click="selected = wo">
            <td class="py-3 px-4 font-mono text-xs">{{ wo.orderNo }}</td>
            <td class="py-3 px-4">{{ wo.equipment?.name }}</td>
            <td class="py-3 px-4 text-gray-400">{{ wo.inspector?.displayName }}</td>
            <td class="py-3 px-4 text-gray-400 text-xs">{{ formatDate(wo.createdAt) }}</td>
            <td class="py-3 px-4 text-center">
              <span :class="statusBadge(wo.status)">{{ statusText(wo.status) }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else class="px-5 py-12 text-center text-gray-400">尚無工單紀錄</div>
    </div>

    <!-- Detail Modal -->
    <div v-if="selected" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click="selected = null">
      <div class="bg-white rounded-xl p-6 max-w-md w-full" @click.stop>
        <div class="flex justify-between mb-4">
          <h3 class="font-bold text-lg">{{ selected.orderNo }}</h3>
          <button @click="selected = null" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between"><span class="text-gray-400">設備</span><span>{{ selected.equipment?.name }}</span></div>
          <div class="flex justify-between"><span class="text-gray-400">人員</span><span>{{ selected.inspector?.displayName }}</span></div>
          <div class="flex justify-between"><span class="text-gray-400">時間</span><span>{{ formatDate(selected.createdAt) }}</span></div>
          <div class="flex justify-between"><span class="text-gray-400">狀態</span><span :class="statusBadge(selected.status)">{{ statusText(selected.status) }}</span></div>
          <div v-if="selected.notes" class="flex justify-between"><span class="text-gray-400">備註</span><span>{{ selected.notes }}</span></div>
        </div>
        <div v-if="selected.formData" class="mt-4 bg-gray-50 rounded-lg p-3">
          <p class="text-xs font-medium mb-2">📝 巡檢資料</p>
          <pre class="text-xs text-gray-500 whitespace-pre-wrap">{{ JSON.stringify(JSON.parse(selected.formData), null, 2) }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { workOrderApi } from '../api'
import type { WorkOrder } from '../types'

const orders = ref<WorkOrder[]>([])
const filter = ref('')
const selected = ref<WorkOrder | null>(null)

onMounted(async () => {
  try {
    const res = await workOrderApi.list()
    orders.value = res.data.data || []
  } catch (e) { console.error(e) }
})

const filteredOrders = computed(() => {
  if (!filter.value) return orders.value
  return orders.value.filter(o => o.status === filter.value)
})

function formatDate(d: string) {
  return d ? new Date(d).toLocaleString('zh-TW') : ''
}
function statusBadge(s: string) {
  return s === 'SUBMITTED' ? 'text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded' :
         s === 'REVIEWED' ? 'text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded' :
         'text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded'
}
function statusText(s: string) {
  return { DRAFT: '草稿', SUBMITTED: '已提交', REVIEWED: '已審核' }[s] || s
}
</script>
