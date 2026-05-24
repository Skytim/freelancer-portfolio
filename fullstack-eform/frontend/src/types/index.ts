export interface User {
  username: string
  displayName: string
  role: 'ENGINEER' | 'PM' | 'ADMIN'
}

export interface Equipment {
  id: number
  code: string
  name: string
  location: string
  type: string
  qrCode: string
}

export interface FormField {
  key: string
  label: string
  type: 'number' | 'select' | 'checkbox' | 'text'
  unit?: string
  required?: boolean
  options?: string[]
  items?: string[]
}

export interface FormTemplate {
  id: number
  templateKey: string
  name: string
  equipmentType: string
  fieldsJson: string
  parsedFields?: FormField[]
}

export interface WorkOrder {
  id: number
  orderNo: string
  equipment: Equipment
  template: FormTemplate
  inspector: User
  formData: string
  notes: string
  photoUrls: string[]
  status: 'DRAFT' | 'SUBMITTED' | 'REVIEWED'
  createdAt: string
}
