<template>
  <div>
    <div class="flex justify-between mb-6">
      <h2 class="text-xl font-bold text-gray-900">🔧 表單模板管理</h2>
      <button @click="showCreate = true" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">＋ 新增模板</button>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div v-for="tpl in templates" :key="tpl.id" class="bg-white rounded-xl p-5 shadow-sm">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h3 class="font-semibold">{{ tpl.name }}</h3>
            <p class="text-xs text-gray-400 font-mono">{{ tpl.templateKey }}</p>
          </div>
          <span class="text-xs bg-gray-100 px-2 py-0.5 rounded">{{ tpl.equipmentType }}</span>
        </div>
        <div class="text-xs text-gray-500 space-y-1">
          <p>欄位數：{{ parseFieldCount(tpl.fieldsJson) }} 個</p>
          <p class="font-mono text-gray-300 truncate">{{ tpl.fieldsJson?.substring(0, 80) }}...</p>
        </div>
        <div class="flex gap-2 mt-4">
          <button @click="editTemplate(tpl)" class="text-xs text-blue-500 hover:underline">✏️ 編輯</button>
        </div>
      </div>
    </div>

    <!-- Create Modal -->
    <div v-if="showCreate" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" @click="showCreate=false">
      <div class="bg-white rounded-xl p-6 max-w-md w-full" @click.stop>
        <h3 class="font-bold text-lg mb-4">新增表單模板</h3>
        <div class="space-y-3 text-sm">
          <div><label class="block mb-1">Template Key</label><input v-model="newTpl.templateKey" class="w-full border rounded px-3 py-2" placeholder="ups_inspection"></div>
          <div><label class="block mb-1">名稱</label><input v-model="newTpl.name" class="w-full border rounded px-3 py-2" placeholder="UPS 巡檢表"></div>
          <div><label class="block mb-1">設備類型</label><select v-model="newTpl.equipmentType" class="w-full border rounded px-3 py-2 bg-white"><option>UPS</option><option>INROW_AC</option><option>FIRE</option><option>ENV</option><option>CABINET</option></select></div>
          <div><label class="block mb-1">Fields JSON</label><textarea v-model="newTpl.fieldsJson" rows="6" class="w-full border rounded px-3 py-2 font-mono text-xs" placeholder='{"fields": [...]}'></textarea></div>
        </div>
        <div class="flex gap-3 mt-6">
          <button @click="createTemplate" class="flex-1 bg-blue-600 text-white py-2 rounded text-sm">建立</button>
          <button @click="showCreate=false" class="flex-1 border py-2 rounded text-sm">取消</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { templateApi } from '../api'
import type { FormTemplate } from '../types'

const templates = ref<FormTemplate[]>([])
const showCreate = ref(false)
const newTpl = ref({ templateKey: '', name: '', equipmentType: 'UPS', fieldsJson: '{"fields":[]}' })

onMounted(async () => {
  try {
    const res = await templateApi.list()
    templates.value = res.data.data || []
  } catch (e) { console.error(e) }
})

function parseFieldCount(json: string) {
  try { return JSON.parse(json).fields?.length || 0 } catch { return 0 }
}

async function createTemplate() {
  try {
    await templateApi.create(newTpl.value)
    showCreate.value = false
    const res = await templateApi.list()
    templates.value = res.data.data || []
  } catch (e) { console.error(e) }
}

function editTemplate(tpl: FormTemplate) {
  newTpl.value = { templateKey: tpl.templateKey, name: tpl.name, equipmentType: tpl.equipmentType, fieldsJson: tpl.fieldsJson }
  showCreate.value = true
}
</script>
