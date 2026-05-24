<template>
<div><div class="d-flex justify-space-between align-center mb-6"><h2 class="text-h5 font-weight-bold">🔧 表單模板管理</h2><v-btn color="blue-accent-4" prepend-icon="mdi-plus" @click="openCreate">新增模板</v-btn></div>
<v-row><v-col v-for="tpl in templates" :key="tpl.id" md="6"><v-card class="pa-4"><div class="d-flex justify-space-between"><div><p class="font-weight-bold">{{tpl.name}}</p><p class="text-caption text-grey font-monospace">{{tpl.templateKey}}</p></div><v-chip size="x-small">{{tpl.equipmentType}}</v-chip></div><p class="text-caption text-grey mt-2">欄位數：{{parseCount(tpl.fieldsJson)}} 個</p><v-btn size="small" variant="text" color="blue" class="mt-2" @click="editTemplate(tpl)">編輯</v-btn></v-card></v-col></v-row>
<v-dialog v-model="dialog" max-width="500"><v-card :title="editing?'編輯模板':'新增模板'">
  <v-card-text><v-row dense><v-col cols="12"><v-text-field v-model="f.templateKey" label="Template Key"></v-text-field></v-col><v-col cols="6"><v-text-field v-model="f.name" label="名稱"></v-text-field></v-col><v-col cols="6"><v-select v-model="f.equipmentType" label="設備類型" :items="['UPS','INROW_AC','FIRE','ENV','CABINET']"></v-select></v-col><v-col cols="12"><v-textarea v-model="f.fieldsJson" label="Fields JSON" rows="8"></v-textarea></v-col></v-row></v-card-text>
  <v-card-actions><v-spacer></v-spacer><v-btn @click="dialog=false">取消</v-btn><v-btn color="blue-accent-4" @click="save">儲存</v-btn></v-card-actions>
</v-card></v-dialog>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {templateApi} from '../api';import type {FormTemplate} from '../types';
const templates=ref<FormTemplate[]>([]);const dialog=ref(false);const editing=ref(false);const editId=ref<number|null>(null);
const f=ref({templateKey:'',name:'',equipmentType:'UPS',fieldsJson:'{"fields":[]}'});
function parseCount(json:string){try{return JSON.parse(json).fields?.length||0}catch{return 0}}
function openCreate(){editing.value=false;editId.value=null;f.value={templateKey:'',name:'',equipmentType:'UPS',fieldsJson:'{"fields":[]}'};dialog.value=true}
function editTemplate(tpl:FormTemplate){editing.value=true;editId.value=tpl.id;f.value={templateKey:tpl.templateKey,name:tpl.name,equipmentType:tpl.equipmentType,fieldsJson:tpl.fieldsJson};dialog.value=true}
async function save(){try{if(editing.value&&editId.value){await templateApi.update(editId.value,f.value)}else{await templateApi.create(f.value)}dialog.value=false;const r=await templateApi.list();templates.value=r.data.data||[]}catch(e){console.error(e)}}
async function load(){try{const r=await templateApi.list();templates.value=r.data.data||[]}catch(e){console.error(e)}}
onMounted(load);
</script>
