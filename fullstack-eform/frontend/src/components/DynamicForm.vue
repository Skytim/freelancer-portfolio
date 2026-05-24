<template>
  <div class="space-y-4">
    <div v-for="(field, idx) in fields" :key="field.key" class="bg-gray-50 rounded-lg p-4">
      <label class="text-sm font-medium text-gray-700 mb-2 block">
        {{ idx + 1 }}. {{ field.label }}
        <span v-if="field.unit" class="text-xs text-gray-400">({{ field.unit }})</span>
        <span v-if="field.required" class="text-red-400 ml-1">*</span>
      </label>

      <!-- Number input -->
      <input v-if="field.type === 'number'"
        :value="values[field.key] || ''"
        @input="updateValue(field.key, ($event.target as HTMLInputElement).value)"
        type="number" :placeholder="'請輸入' + field.label"
        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 bg-white" />

      <!-- Select -->
      <select v-else-if="field.type === 'select'"
        :value="values[field.key] || ''"
        @change="updateValue(field.key, ($event.target as HTMLSelectElement).value)"
        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 bg-white">
        <option value="">請選擇</option>
        <option v-for="opt in field.options" :key="opt" :value="opt">{{ opt }}</option>
      </select>

      <!-- Checkbox -->
      <div v-else-if="field.type === 'checkbox'" class="space-y-1.5">
        <label v-for="item in field.items" :key="item" class="flex items-center gap-2 text-sm cursor-pointer">
          <input type="checkbox" :checked="checkboxValues[field.key]?.includes(item)"
            @change="toggleCheckbox(field.key, item)"
            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
          {{ item }}
        </label>
      </div>

      <!-- Text -->
      <input v-else
        :value="values[field.key] || ''"
        @input="updateValue(field.key, ($event.target as HTMLInputElement).value)"
        type="text" :placeholder="'請輸入' + field.label"
        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 bg-white" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'
import type { FormField } from '../types'

const props = defineProps<{ fields: FormField[] }>()
const emit = defineEmits<{ 'update:data': [data: Record<string, any>] }>()

const values = reactive<Record<string, string>>({})
const checkboxValues = reactive<Record<string, string[]>>({})

function updateValue(key: string, val: string) {
  values[key] = val
  emitData()
}

function toggleCheckbox(key: string, item: string) {
  if (!checkboxValues[key]) checkboxValues[key] = []
  const idx = checkboxValues[key].indexOf(item)
  if (idx >= 0) checkboxValues[key].splice(idx, 1)
  else checkboxValues[key].push(item)
  emitData()
}

function emitData() {
  emit('update:data', { ...values, ...checkboxValues })
}
</script>
