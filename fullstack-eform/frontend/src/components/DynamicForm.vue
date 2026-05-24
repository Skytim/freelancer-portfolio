<template>
<div>
  <div v-for="(field,idx) in fields" :key="field.key" class="mb-4">
    <v-label class="mb-2">{{idx+1}}. {{field.label}}<span v-if="field.unit" class="text-caption text-grey">({{field.unit}})</span><span v-if="field.required" class="text-red ml-1">*</span></v-label>
    <v-text-field v-if="field.type==='number'" v-model="values[field.key]" :placeholder="field.label" type="number"></v-text-field>
    <v-select v-else-if="field.type==='select'" v-model="values[field.key]" :items="field.options||[]" :placeholder="field.label"></v-select>
    <div v-else-if="field.type==='checkbox'"><v-checkbox v-for="item in field.items" :key="item" :label="item" :value="item" v-model="checkboxValues[field.key]" hide-details density="compact"></v-checkbox></div>
    <v-text-field v-else v-model="values[field.key]" :placeholder="field.label"></v-text-field>
  </div>
</div>
</template>
<script setup lang="ts">import {reactive,watch} from 'vue';import type {FormField} from '../types';
const props=defineProps<{fields:FormField[]}>();
const emit=defineEmits<{'update:data':[data:Record<string,any>]}>();
const values=reactive<Record<string,string>>({});const checkboxValues=reactive<Record<string,string[]>>({});
watch([values,checkboxValues],()=>{emit('update:data',{...values,...checkboxValues})},{deep:true});
</script>
