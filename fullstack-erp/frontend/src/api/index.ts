import axios from 'axios';
const api=axios.create({baseURL:'/api'});
api.interceptors.request.use(c=>{const t=localStorage.getItem('token');if(t)c.headers.Authorization=`Bearer ${t}`;return c});
api.interceptors.response.use(r=>r,e=>{if(e.response?.status===401){localStorage.removeItem('token');window.location.href='/login'}return Promise.reject(e)});
export const productApi={list:(s?:string)=>api.get('/products',{params:s?{search:s}:{}}),create:(d:any)=>api.post('/products',d),update:(id:number,d:any)=>api.put(`/products/${id}`,d),stats:()=>api.get('/products/stats')};
export const poApi={list:()=>api.get('/purchase-orders'),create:(d:any)=>api.post('/purchase-orders',d)};
export const soApi={list:()=>api.get('/sales-orders'),create:(d:any)=>api.post('/sales-orders',d)};
export const authApi={login:(u:string,p:string)=>api.post('/auth/login',{username:u,password:p})};
export default api;
