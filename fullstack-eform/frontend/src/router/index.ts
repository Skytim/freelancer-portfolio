import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/',
      component: () => import('../views/Layout.vue'),
      children: [
        { path: '', name: 'Dashboard', component: () => import('../views/Dashboard.vue') },
        { path: 'inspect', name: 'Inspect', component: () => import('../views/InspectionForm.vue') },
        { path: 'inspect/:equipCode', name: 'InspectEquip', component: () => import('../views/InspectionForm.vue') },
        { path: 'templates', name: 'Templates', component: () => import('../views/FormTemplates.vue') },
        { path: 'orders', name: 'Orders', component: () => import('../views/WorkOrders.vue') }
      ]
    }
  ]
})

router.beforeEach((to) => {
  const token = localStorage.getItem('token')
  if (to.path !== '/login' && !token) return '/login'
  if (to.path === '/login' && token) return '/'
})

export default router
