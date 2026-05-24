# 機房巡檢電子表單系統 — Full Stack Sample

Spring Boot 3.2 + Vue 3 (Vite + TypeScript + Pinia) 全端應用。

## 專案結構

```
fullstack-eform/
├── backend/                          # Spring Boot 3.2 後端
│   ├── pom.xml
│   └── src/main/java/com/eform/
│       ├── EformApplication.java     # 啟動入口
│       ├── config/                   # Security + JWT + CORS
│       │   ├── SecurityConfig.java
│       │   ├── JwtUtil.java
│       │   └── JwtAuthFilter.java
│       ├── model/                    # JPA Entity
│       │   ├── User.java             # 使用者 (ENGINEER/PM/ADMIN)
│       │   ├── Equipment.java        # 設備
│       │   ├── FormTemplate.java     # 表單模板 (JSON Schema)
│       │   └── WorkOrder.java        # 工單
│       ├── repository/               # Spring Data JPA
│       ├── service/
│       │   └── WorkOrderService.java
│       ├── controller/               # REST API
│       │   ├── AuthController.java   # POST /api/auth/login
│       │   ├── EquipmentController.java
│       │   ├── FormTemplateController.java
│       │   └── WorkOrderController.java
│       └── dto/
│           ├── AuthRequest.java / AuthResponse.java
│           ├── WorkOrderRequest.java
│           └── ApiResponse.java      # 統一回應格式
│   └── src/main/resources/
│       ├── application.yml
│       └── data.sql                  # 種子資料
│
└── frontend/                         # Vue 3 前端
    ├── package.json
    ├── vite.config.ts
    └── src/
        ├── main.ts
        ├── App.vue
        ├── api/index.ts              # Axios + JWT interceptor
        ├── router/index.ts           # Vue Router
        ├── stores/auth.ts            # Pinia 登入狀態
        ├── types/index.ts            # TypeScript 型別
        ├── components/
        │   └── DynamicForm.vue       # 動態表單渲染引擎
        └── views/
            ├── Login.vue             # 登入頁
            ├── Layout.vue            # 主版面 (sidebar + header)
            ├── Dashboard.vue         # 儀表板
            ├── InspectionForm.vue    # 填寫巡檢表 (核心)
            ├── WorkOrders.vue        # 工單紀錄
            └── FormTemplates.vue     # 表單模板管理 (Admin)
```

## 啟動方式

### 後端 (需要 Java 17+)

```bash
cd backend
./mvnw spring-boot:run
# 或: mvn spring-boot:run
# 啟動後: http://localhost:8080
# H2 Console: http://localhost:8080/h2-console
```

### 前端 (需要 Node 18+)

```bash
cd frontend
npm install
npm run dev
# 啟動後: http://localhost:5173
```

### Demo 帳號 (密碼皆為 123456)

| 帳號 | 角色 | 說明 |
|---|---|---|
| engineer1 | ENGINEER | 可填表、查看自己的工單 |
| engineer2 | ENGINEER | 同上 |
| pm1 | PM | 可查看所有工單 |
| admin1 | ADMIN | 完整權限 + 表單模板管理 |

## API 端點

| Method | Path | Auth | 說明 |
|---|---|---|---|
| POST | /api/auth/login | - | 登入，取得 JWT |
| GET | /api/equipment | 需要 | 設備清單 |
| GET | /api/equipment/{code} | 需要 | 依編號查設備 |
| GET | /api/templates | 需要 | 表單模板清單 |
| POST | /api/templates | ADMIN | 新增模板 |
| PUT | /api/templates/{id} | ADMIN | 修改模板 |
| POST | /api/work-orders | 需要 | 建立工單 |
| GET | /api/work-orders | 需要 | 我的工單列表 |
| GET | /api/work-orders/equipment/{id} | 需要 | 設備歷史工單 |

## 核心技術特點

- **動態表單引擎**: 後台 JSON Schema 定義表單 → 前端 DynamicForm 元件自動渲染
- **JWT 認證 + RBAC**: 三層權限 (工程師/PM/管理員)
- **RESTful API**: 統一 ApiResponse<T> 回應格式
- **H2 內嵌資料庫**: 啟動即用，附種子資料
