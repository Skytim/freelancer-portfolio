<template>
  <div>
    <h2 class="text-xl font-bold text-gray-900 mb-6">📝 填寫巡檢表單</h2>

    <!-- QR Scan Section -->
    <div v-if="!selectedEquip" class="bg-blue-50 rounded-xl p-6 mb-6 text-center cursor-pointer"
         @click="showQrHint = !showQrHint">
      <div class="text-3xl mb-2">📷</div>
      <p class="font-medium text-blue-800">點擊掃描設備 QR Code</p>
      <p class="text-xs text-blue-500 mt-1">或從下方選擇設備</p>
      <div v-if="showQrHint" class="mt-4 p-4 bg-white rounded-lg text-sm text-gray-500">
        <p>🔍 實際環境將呼叫平板相機掃描 QR Code</p>
        <p class="mt-1">掃描後自動帶入設備資料與歷史巡檢紀錄</p>
        <button @click.stop="simulateScan" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg text-xs">模擬掃描完成</button>
      </div>
    </div>

    <!-- Equipment Selection -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
      <button v-for="eq in equipment" :key="eq.id"
        @click="selectEquipment(eq)"
        :class="selectedEquip?.id === eq.id
          ? 'bg-blue-600 text-white border-blue-600'
          : 'bg-white border-gray-200 text-gray-700 hover:border-blue-300'"
        class="border-2 rounded-xl p-4 text-sm font-medium transition-colors">
        {{ eq.name }}
        <span class="block text-xs mt-1 opacity-70">{{ eq.location }}</span>
      </button>
    </div>

    <!-- After Equipment Selected -->
    <template v-if="selectedEquip">
      <!-- Equipment Info -->
      <div class="bg-white rounded-xl p-5 shadow-sm mb-6 flex items-center gap-4">
        <div class="bg-green-100 text-green-700 w-12 h-12 rounded-lg flex items-center justify-center text-xl">🖥️</div>
        <div class="flex-1">
          <p class="font-semibold">{{ selectedEquip.code }}</p>
          <p class="text-sm text-gray-400">{{ selectedEquip.name }} · {{ selectedEquip.location }}</p>
        </div>
        <div class="text-right text-xs text-gray-400">
          <p v-if="historyCount > 0">歷史巡檢 {{ historyCount }} 次</p>
          <p v-else>尚無巡檢紀錄</p>
        </div>
      </div>

      <!-- Template Selection -->
      <div v-if="!selectedTemplate" class="bg-white rounded-xl p-5 shadow-sm mb-6">
        <p class="text-sm font-medium mb-3">選擇表單模板</p>
        <div class="space-y-2">
          <button v-for="tpl in templates" :key="tpl.id"
            @click="selectTemplate(tpl)"
            :class="tpl.equipmentType === selectedEquip.type ? 'border-blue-400 bg-blue-50' : 'opacity-50'"
            class="w-full text-left border rounded-lg p-3 text-sm hover:border-blue-300 transition-colors">
            {{ tpl.name }}
            <span v-if="tpl.equipmentType !== selectedEquip.type" class="text-xs text-amber-500 ml-2">(類型不符)</span>
          </button>
        </div>
      </div>

      <!-- Dynamic Form -->
      <div v-if="selectedTemplate && formFields.length" class="bg-white rounded-xl p-6 shadow-sm mb-6">
        <h3 class="font-semibold mb-4">{{ selectedTemplate.name }}</h3>
        <DynamicForm :fields="formFields" @update:data="onFormData" />
      </div>

      <!-- Photo Upload -->
      <div v-if="selectedTemplate" class="bg-white rounded-xl p-5 shadow-sm mb-6">
        <p class="text-sm font-medium mb-3">📸 現場照片</p>
        <div class="flex gap-3">
          <div v-for="i in 3" :key="i"
            @click="photos.push(`photo_${Date.now()}_${i}.jpg`)"
            class="w-20 h-20 border-2 border-dashed border-gray-200 rounded-lg flex items-center justify-center cursor-pointer hover:border-blue-400 transition-colors text-2xl text-gray-300">
            {{ photos[i-1] ? '✅' : '+' }}
          </div>
        </div>
      </div>

      <!-- Submit -->
      <div v-if="selectedTemplate" class="flex gap-3">
        <button @click="saveDraft" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-lg font-medium text-sm hover:bg-gray-200">
          💾 暫存草稿
        </button>
        <button @click="submitOrder" :disabled="submitting"
          class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-medium text-sm hover:bg-blue-700 shadow-md disabled:opacity-50">
          {{ submitting ? '提交中...' : '📄 送出工單' }}
        </button>
      </div>

      <p v-if="submitResult" :class="submitResult.success ? 'text-green-500' : 'text-red-500'" class="text-sm mt-3">
        {{ submitResult.message }}
      </p>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watchEffect } from 'vue'
import { useRoute } from 'vue-router'
import { equipmentApi, templateApi, workOrderApi } from '../api'
import DynamicForm from '../components/DynamicForm.vue'
import type { Equipment, FormTemplate, FormField } from '../types'

const route = useRoute()
const equipment = ref<Equipment[]>([])
const templates = ref<FormTemplate[]>([])
const selectedEquip = ref<Equipment | null>(null)
const selectedTemplate = ref<FormTemplate | null>(null)
const formFields = ref<FormField[]>([])
const formData = ref<Record<string, any>>({})
const photos = ref<string[]>([])
const showQrHint = ref(false)
const submitting = ref(false)
const submitResult = ref<{ success: boolean; message: string } | null>(null)
const historyCount = ref(0)

onMounted(async () => {
  try {
    const [eRes, tRes] = await Promise.all([equipmentApi.list(), templateApi.list()])
    equipment.value = eRes.data.data || []
    templates.value = tRes.data.data || []
    // Auto-select if equip code in URL
    const code = route.params.equipCode as string
    if (code) {
      const eq = equipment.value.find(e => e.code === code)
      if (eq) selectEquipment(eq)
    }
  } catch (e) { console.error(e) }
})

function selectEquipment(eq: Equipment) {
  selectedEquip.value = eq
  selectedTemplate.value = null
  formFields.value = []
  // Auto-select matching template
  const tpl = templates.value.find(t => t.equipmentType === eq.type)
  if (tpl) selectTemplate(tpl)
  // Load history count
  workOrderApi.byEquipment(eq.id).then(res => {
    historyCount.value = (res.data.data || []).length
  }).catch(() => {})
}

function selectTemplate(tpl: FormTemplate) {
  selectedTemplate.value = tpl
  try {
    const parsed = JSON.parse(tpl.fieldsJson)
    formFields.value = parsed.fields || []
  } catch { formFields.value = [] }
  formData.value = {}
  photos.value = []
}

function onFormData(data: Record<string, any>) {
  formData.value = data
}

function simulateScan() {
  showQrHint.value = false
  if (equipment.value.length) selectEquipment(equipment.value[0])
}

async function submitOrder() {
  if (!selectedEquip.value || !selectedTemplate.value) return
  submitting.value = true
  try {
    const res = await workOrderApi.create({
      equipmentCode: selectedEquip.value.code,
      templateKey: selectedTemplate.value.templateKey,
      formData: JSON.stringify(formData.value),
      photoUrls: photos.value
    })
    submitResult.value = { success: res.data.success, message: res.data.success ? `✅ 工單 ${res.data.data.orderNo} 已建立！` : '提交失敗' }
  } catch (e: any) {
    submitResult.value = { success: false, message: e.message || '提交失敗' }
  } finally { submitting.value = false }
}

function saveDraft() {
  submitResult.value = { success: true, message: '💾 已儲存為草稿（Demo 模式）' }
}
</script>
