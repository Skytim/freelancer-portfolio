import { createRouter, createWebHistory } from 'vue-router';
const router=createRouter({history:createWebHistory(),routes:[
  {path:'/login',name:'Login',component:()=>import('../views/Login.vue')},
  {path:'/',component:()=>import('../views/Layout.vue'),children:[
    {path:'',name:'Dashboard',component:()=>import('../views/Dashboard.vue')},
    {path:'products',name:'Products',component:()=>import('../views/Products.vue')},
    {path:'purchase',name:'Purchase',component:()=>import('../views/PurchaseOrders.vue')},
    {path:'sales',name:'Sales',component:()=>import('../views/SalesOrders.vue')},
    {path:'inventory',name:'Inventory',component:()=>import('../views/Inventory.vue')},
  ]}
]});
router.beforeEach(t=>{const token=localStorage.getItem('token');if(t.path!=='/login'&&!token)return'/login';if(t.path==='/login'&&token)return'/'});
export default router;
