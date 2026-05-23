# Clinic SEO — WordPress 診所網站主題

內建 Schema.org 結構化資料、AIEO (llms.txt)、SEO 優化的 WordPress 主題。
適合中小型診所快速建站，用技術提案取代設計提案。

## 快速開始

### 前端展示（不需要 PHP）

直接用瀏覽器開 `site/*.html` 即可查看所有頁面效果（靜態 demo，不需 WP）。

### 安裝為 WordPress 主題

**方法 A：Local by Flywheel（推薦，最簡單）**

1. 下載安裝 [Local](https://localwp.com)（免費）
2. 建立一個新站台（一鍵完成 PHP + MySQL + WP）
3. 把 `wp-clinic-theme/` 整個目錄複製到：
   ```
   ~/Local Sites/你的站名/app/public/wp-content/themes/clinic-seo/
   ```
4. WP 後台 → 外觀 → 佈景主題 → 啟用「Clinic SEO」
5. 啟用後會自動建立：首頁、診所介紹、服務項目、醫師團隊、聯絡我們

**方法 B：手動安裝**

```bash
# 在 WP 主機上
cd wp-content/themes/
cp -r /path/to/wp-clinic-theme ./clinic-seo
```

WP 後台 → 外觀 → 佈景主題 → 啟用。

### 建置選單

1. WP 後台 → 外觀 → 選單
2. 建立一個選單，加入頁面：首頁、診所介紹、服務項目、醫師團隊、健康知識、聯絡我們
3. 勾選「主要導覽列」位置 → 儲存

## 目錄結構

```
wp-clinic-theme/
├── style.css                    # WP Theme 宣告
├── functions.php                # 主題設定、資源載入、SEO hooks、自動建頁
├── header.php                   # 共用 <head> + 導覽列
├── footer.php                   # 共用 footer
├── front-page.php               # 首頁模板
├── page-about.php               # 診所介紹模板
├── page-services.php            # 服務項目模板
├── page-doctors.php             # 醫師團隊模板
├── page-contact.php             # 聯絡我們 + 預約表單模板
├── single.php                   # 單篇部落格文章模板
├── index.php                    # 部落格列表（健康知識）
├── 404.php                      # 404 頁面
├── includes/
│   └── seo-functions.php        # SEO 核心：JSON-LD 輸出、Meta、llms.txt
├── assets/
│   └── scripts.js               # 前端互動
├── llms.txt                     # AIEO 設定（由 functions.php 虛擬路由輸出）
├── site/                        # 靜態 demo 檔（給客戶預覽用，非 WP 的一部分）
│   ├── index.html
│   ├── about.html
│   ├── services.html
│   ├── doctors.html
│   ├── blog.html
│   └── contact.html
└── README.md                    # 本檔案
```

## SEO 功能說明

### 自動輸出內容（不需手動設定）

| 頁面 | 自動輸出的 SEO 標記 |
|---|---|
| 首頁 | MedicalClinic Schema + Meta Tags + OG |
| 文章 | BlogPosting Schema + 作者 + 發布日期 |
| 全站 | robots.txt 客製化 + llms.txt 虛擬路由 |

### 驗證方法

1. 安裝主題後，打開 `https://你的網域/llms.txt` → 應出現 AI 友善設定
2. 打開 `https://你的網域/robots.txt` → 應出現客製化規則
3. 用 [Google Rich Results Test](https://search.google.com/test/rich-results) 測試首頁 → 應偵測到 MedicalClinic
4. Chrome DevTools → Lighthouse → SEO 評分應為 100

## 建議搭配的 WP Plugin

| Plugin | 用途 | 必裝？ |
|---|---|---|
| Yoast SEO / Rank Math | 進階 SEO 管理（sitemap、breadcrumb）| 建議 |
| WP Super Cache / W3 Total Cache | 快取加速 | 建議 |
| Smush / ShortPixel | 圖片壓縮 | 建議 |
| Contact Form 7 / WPForms | 預約表單後端處理 | 選用 |
| Really Simple SSL | 強制 HTTPS | 視主機 |

## 客製化清單（提案前）

- [ ] style.css：把 Author / Author URI 換成你的
- [ ] functions.php：把診所地址、電話換成客戶的真實資料
- [ ] header.php：確認導覽列連結正確
- [ ] footer.php：確認地址電話正確
- [ ] front-page.php：把虛構數字（15 年、20 萬人次）換成真實資料
- [ ] page-contact.php：嵌入真實 Google Maps iframe

## 技術棧

- PHP 7.4+ / WordPress 6.x
- Tailwind CSS CDN（開發用，正式環境建議改用編譯版本）
- Schema.org JSON-LD 結構化資料
- AIEO llms.txt 標準
