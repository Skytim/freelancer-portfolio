<template>
<div><h2 class="text-h5 font-weight-bold mb-6">📝 填寫巡檢表單</h2>
  <v-card v-if="!selectedEquip" class="pa-6 text-center cursor-pointer bg-blue-lighten-5" @click="simulateScan">
    <v-icon size="48" color="blue">mdi-qrcode-scan</v-icon>
    <p class="text-h6 mt-2">點擊掃描設備 QR Code</p>
    <p class="text-caption text-grey">或從下方選擇設備</p>
  </v-card>
  <v-row v-if="!selectedEquip"><v-col v-for="eq in equipment" :key="eq.id" cols="6" md="3"><v-card class="pa-4 text-center cursor-pointer" @click="selectEquipment(eq)" variant="outlined"><div class="text-h6">{{eq.name}}</div><div class="text-caption text-grey">{{eq.location}}</div></v-card></v-col></v-row>
  <template v-if="selectedEquip">
    <v-card class="pa-4 mb-4 bg-green-lighten-5"><div class="d-flex align-center gap-3"><v-icon color="green" size="32">mdi-server</v-icon><div><p class="font-weight-bold">{{selectedEquip.code}}</p><p class="text-caption">{{selectedEquip.name}} · {{selectedEquip.location}}</p></div></div></v-card>
    <v-card v-if="!selectedTemplate" title="選擇表單模板" class="mb-4"><v-list density="compact"><v-list-item v-for="tpl in templates" :key="tpl.id" :title="tpl.name" :subtitle="tpl.equipmentType" @click="selectTemplate(tpl)"></v-list-item></v-list></v-card>
    <v-card v-if="selectedTemplate" title="表單內容" class="mb-4 pa-4"><DynamicForm :fields="formFields" @update:data="onFormData"/></v-card>
    <v-card v-if="selectedTemplate" title="📸 現場照片" class="mb-4 pa-4"><div class="d-flex gap-2"><v-btn v-for="i in 3" :key="i" variant="outlined" size="large" icon @click="photos.push('photo_'+Date.now()+'_'+i+'.jpg')">{{photos[i-1]?'✅':'+'}}</v-btn></div></v-card>
    <div class="d-flex gap-2" v-if="selectedTemplate"><v-btn block size="large" @click="submitResult={success:true,message:'💾 草稿已儲存'}">💾 暫存草稿</v-btn><v-btn block size="large" color="blue-accent-4" @click="submitOrder" :loading="submitting">📄 送出工單</v-btn></div>
    <v-alert v-if="submitResult" :type="submitResult.success?'success':'error'" class="mt-3">{{submitResult.message}}</v-alert>
  </template>
</div>
</template>
<script setup lang="ts">import {ref,onMounted} from 'vue';import {useRoute} from 'vue-router';import {equipmentApi,templateApi,workOrderApi} from '../api';import DynamicForm from '../components/DynamicForm.vue';import type {Equipment,FormTemplate,FormField} from '../types';
const route=useRoute();const equipment=ref<Equipment[]>([]);const templates=ref<FormTemplate[]>([]);const selectedEquip=ref<Equipment|null>(null);const selectedTemplate=ref<FormTemplate|null>(null);const formFields=ref<FormField[]>([]);const formData=ref<Record<string,any>>({});const photos=ref<string[]>([]);const submitting=ref(false);const submitResult=ref<{success:boolean;message:string}|null>(null);
onMounted(async()=>{try{const[e,t]=await Promise.all([equipmentApi.list(),templateApi.list()]);equipment.value=e.data.data||[];templates.value=t.data.data||[];const code=route.params.equipCode as string;if(code){const eq=equipment.value.find(e=>e.code===code);if(eq)selectEquipment(eq)}}catch(e){console.error(e)}});
function selectEquipment(eq:Equipment){selectedEquip.value=eq;selectedTemplate.value=null;formFields.value=[];const tpl=templates.value.find(t=>t.equipmentType===eq.type);if(tpl)selectTemplate(tpl)}
function selectTemplate(tpl:FormTemplate){selectedTemplate.value=tpl;try{formFields.value=JSON.parse(tpl.fieldsJson).fields||[]}catch{formFields.value=[]}formData.value={};photos.value=[]}
function onFormData(data:Record<string,any>){formData.value=data}
function simulateScan(){if(equipment.value.length)selectEquipment(equipment.value[0])}
async function submitOrder(){if(!selectedEquip.value||!selectedTemplate.value)return;submitting.value=true;try{const r=await workOrderApi.create({equipmentCode:selectedEquip.value.code,templateKey:selectedTemplate.value.templateKey,formData:JSON.stringify(formData.value),photoUrls:photos.value});submitResult.value={success:r.data.success,message:r.data.success?`✅ 工單 ${r.data.data.orderNo} 已建立！`:'提交失敗'}}catch(e:any){submitResult.value={success:false,message:e.message||'失敗'}}finally{submitting.value=false}}
</script>
