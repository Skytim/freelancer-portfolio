# Case 11: WP 診所 SEO 提案套件

一套可以直接拿去向診所業主提案的完整技術展示包。

## 目錄結構

```
11-clinic-seo-demo/
├── site/                    # 多頁面網站 demo（6 頁）
│   ├── index.html           # 首頁
│   ├── about.html           # 診所介紹
│   ├── services.html        # 服務項目（三大科別）
│   ├── doctors.html         # 醫師團隊
│   ├── blog.html            # 健康知識專欄
│   └── contact.html         # 聯絡我們 + 預約表單
├── seo/                     # SEO 技術產出物（證明技術力）
│   ├── llms.txt             # AIEO 設定，讓 AI 讀懂網站
│   ├── robots.txt           # 爬蟲規則 + sitemap 路徑
│   └── schema-examples.json # JSON-LD 結構化資料完整範例
├── seo-proposal.html        # SEO 技術審查報告書（核心提案武器）
└── README.md                # 本檔案
```

## 使用方式

### 給客戶看網站 demo
1. 用瀏覽器開 `site/index.html`
2. 導覽列可切換所有頁面，展示網站架構
3. 每個頁面都內建 SEO Meta Tags + Schema.org 結構化資料
4. 告訴客戶：「這是優化後的網站架構，WordPress 可以做到一模一樣」

### 證明 SEO 技術能力
- `seo/llms.txt` — 開給客戶看，解釋「這是新的 AI 搜尋標準，多數診所網站還沒有，我們先做就是競爭優勢」
- `seo/schema-examples.json` — 列印出來或開在編輯器裡，展示專業度
- `seo/robots.txt` — 放在 WP 網站根目錄的標準設定

### 提案簡報
1. 用 Chrome 開 `seo-proposal.html`
2. 按「列印成 PDF」
3. 選擇「另存為 PDF」
4. 把 PDF 帶去跟客戶開會，或先寄給客戶預習

## 提案建議話術

> 「多數診所網站做好就放著了，Google 搜不到，AI 也讀不懂。
> 我們的方案是做一次性的 SEO 技術設定，讓 Google 搜尋結果出現評分、營業時間、
> 科別等豐富資訊，讓病人更容易找到你們。
> 一次性費用 2 萬 5，做完效果永久有效。」

## 客製化清單

實際提案前，把以下 [xxx] 換成真實資料：
- [ ] 診所名稱（目前用「康禾聯合診所」）
- [ ] 地址、電話
- [ ] 醫師名字與學經歷
- [ ] 提案人聯絡方式（seo-proposal.html 最下方）
- [ ] 報價金額（視實際範圍調整）
- [ ] 參考網站截圖（如果有業主的現有網站）

## 技術說明

- 純 HTML + Tailwind CDN，無需 server，瀏覽器直接開
- RWD 響應式設計（手機、平板、桌面都可看）
- 每頁獨立 SEO Meta Tags
- 列印友善（seo-proposal.html 支援 A4 PDF 輸出）
