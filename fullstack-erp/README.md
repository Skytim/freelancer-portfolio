# 進銷存管理系統 — Full Stack Sample

Spring Boot 3.2 + Vue 3 (Vite + TypeScript + Pinia)

## 啟動

```bash
# 後端 (Java 17+)
cd backend && mvn spring-boot:run    # → http://localhost:8080

# 前端 (Node 18+)
cd frontend && npm install && npm run dev  # → http://localhost:5174
```

## Demo 帳號

任意帳號 + 密碼 `123456` 即可登入

## API

| Method | Path | 說明 |
|---|---|---|
| POST | /api/auth/login | 登入 |
| GET/POST | /api/products | 商品列表/新增 |
| PUT | /api/products/{id} | 修改商品 |
| GET | /api/products/stats | 庫存統計 |
| GET/POST | /api/purchase-orders | 進貨單 |
| GET/POST | /api/sales-orders | 出貨單 |
