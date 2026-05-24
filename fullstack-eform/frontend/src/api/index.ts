import axios from 'axios'

const api = axios.create({ baseURL: '/api' })

api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

api.interceptors.response.use(
  res => res,
  err => {
    if (err.response?.status === 401) {
      localStorage.removeItem('token')
      window.location.href = '/login'
    }
    return Promise.reject(err)
  }
)

export const authApi = {
  login: (username: string, password: string) =>
    api.post('/auth/login', { username, password })
}

export const templateApi = {
  list: () => api.get('/templates'),
  get: (key: string) => api.get(`/templates/${key}`),
  create: (data: any) => api.post('/templates', data),
  update: (id: number, data: any) => api.put(`/templates/${id}`, data)
}

export const equipmentApi = {
  list: () => api.get('/equipment'),
  get: (code: string) => api.get(`/equipment/${code}`)
}

export const workOrderApi = {
  list: () => api.get('/work-orders'),
  create: (data: any) => api.post('/work-orders', data),
  byEquipment: (equipId: number) => api.get(`/work-orders/equipment/${equipId}`)
}

export default api
