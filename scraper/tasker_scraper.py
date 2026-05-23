#!/usr/bin/env python3
"""
Tasker 接案爬蟲 — Playwright 渲染 + 精準解析

使用方式：
  python3 tasker_scraper.py              # 爬 1-14 頁，輸出 CSV
  python3 tasker_scraper.py --page 1      # 只爬第 1 頁
  python3 tasker_scraper.py --watch       # 持續監控新案件（每 30 分鐘）
"""

import csv
import re
import sys
import time
import json
from datetime import datetime
from collections import OrderedDict

from playwright.sync_api import sync_playwright

BASE_URL = "https://www.tasker.com.tw"
CATEGORIES = "110,101001"
MAX_PAGES = 14

# ─── 關鍵字過濾 ───
INCLUDE_KW = [
    "爬蟲", "Python", "React", "Vue", "Node", "API", "後端", "前端",
    "全端", "WordPress", "WP", "自動化", "AI", "LLM", "資料庫",
    "網站", "APP", "程式", "開發", "系統", "SEO", "ERP",
    "PWA", "表單", "後台", "DevOps", "Docker", "雲端",
    "Web", "JavaScript", "TypeScript", "PHP", "Laravel",
    "Flutter", "SQL", "NoSQL", "REST", "GraphQL", "OCR",
    "QR", "進銷存", "內網", "代理", "Agent",
]
EXCLUDE_KW = ["代寫", "作業", "論文", "考試", "助教"]


def scrape_page(page_num: int):
    """Playwright 渲染後抓取"""
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(viewport={"width": 1280, "height": 900})
        page.goto(
            f"{BASE_URL}/cases?selected_categories={CATEGORIES}&page={page_num}",
            wait_until="networkidle", timeout=30000
        )
        time.sleep(2.5)
        html = page.content()
        browser.close()

    # ─── 從 JSON-LD 取得標題↔網址對照 ───
    jsonld_title = {}
    m = re.search(r'"@type"\s*:\s*"ItemList".*?"itemListElement"\s*:\s*(\[.*?\])', html, re.DOTALL)
    if m:
        items = json.loads(m.group(1))
        for item in items:
            it = item.get("item", {})
            jsonld_title[it.get("url", "")] = it.get("name", "")

    jobs = []
    seen = set()

    # ─── 逐一解析卡片 ───
    # 每張卡片以 <a href="/cases/TK..."> 開頭
    for m in re.finditer(r'<a[^>]*href="(/cases/TK\d+[^"]*)"([^>]*)>(.*?)</a>', html, re.DOTALL):
        link = BASE_URL + m.group(1)
        if link in seen:
            continue
        seen.add(link)

        card = m.group(3)

        # 標題：h2.li-title > span.line-clamp-1
        title_m = re.search(r'<h2[^>]*class="[^"]*li-title[^"]*"[^>]*>.*?<span[^>]*>([^<]+)</span>', card, re.DOTALL)
        title = title_m.group(1).strip() if title_m else ""
        if not title:
            title = jsonld_title.get(link, "")
        if not title or len(title) < 2:
            continue

        # 時間：在 header 區塊的 <p> 中
        time_m = re.search(r'<p[^>]*class="[^"]*f-caption1[^"]*"[^>]*>([^<]+)</p>', card)
        posted = time_m.group(1).strip() if time_m else ""

        # 預算：text-primary-500 或 f-title-m class 的 <p>
        budget_m = re.search(
            r'<p[^>]*class="[^"]*(?:text-primary-500|f-title-m)[^"]*"[^>]*>([^<]+)</p>',
            card
        )
        budget = budget_m.group(1).strip() if budget_m else ""

        # 地點：預算後面找台灣縣市名或「可遠端」
        loc_m = re.search(
            r'(台北市|新北市|桃園市|台中市|台南市|高雄市|新竹[縣市]|基隆市|彰化[縣市]|雲林縣|嘉義[縣市]|屏東縣|宜蘭縣|花蓮縣|台東縣|澎湖縣|可遠端)',
            card
        )
        location = loc_m.group(1) if loc_m else ""

        if not location:
            # 試著從 <p> 文字中找地點（預算段落後）
            loc_m2 = re.search(r'<p[^>]*>([一-鿿]{2,4}(?:市|縣|區))</p>', card)
            location = loc_m2.group(1) if loc_m2 else ""

        # 提案數
        prop_m = re.search(r'(\d+)\s*人提案', card)
        proposals = prop_m.group(1) if prop_m else ""

        # 描述：尋找文字段落（排除已匹配的）
        desc_m = re.search(r'<p[^>]*class="[^"]*(?:desc|content|summary|text)[^"]*"[^>]*>([^<]{10,200})</p>', card)
        if not desc_m:
            desc_m = re.search(r'<p[^>]*>([^<]{15,150})</p>', card)
        desc = desc_m.group(1).strip() if desc_m else ""

        # badges
        badges = []
        if "急件" in card:
            badges.append("急件")
        if "長期" in card:
            badges.append("長期")
        if "發票" in card:
            badges.append("需發票")

        jobs.append(OrderedDict([
            ("title", title),
            ("budget", budget),
            ("location", location),
            ("posted", posted),
            ("proposals", proposals),
            ("badges", ", ".join(badges)),
            ("description", desc[:150]),
            ("link", link),
        ]))

    return jobs


def scrape_detail(link: str) -> dict:
    """爬取案件詳細頁：預算、地點、接案身份、需求說明"""
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(viewport={"width": 1280, "height": 900})
        page.goto(link, wait_until="networkidle", timeout=30000)
        import time
        time.sleep(1.5)
        html = page.content()
        browser.close()

    detail = {}

    # 方法 1：從 og:description meta 抽取（最可靠，SSR）
    og_m = re.search(r'<meta[^>]*property="og:description"[^>]*content="([^"]+)"', html)
    if og_m:
        og_text = og_m.group(1)
        # 解析 「地點：xxx｜預算：$xxx｜需求摘要」
        loc_m = re.search(r'地點[：:]\s*([^｜|]+)', og_text)
        if loc_m:
            detail["location"] = loc_m.group(1).strip()
        budget_m = re.search(r'預算[：:]\s*([^｜|]+)', og_text)
        if budget_m:
            detail["budget"] = budget_m.group(1).strip()
        # 摘要（預算後面的文字）
        desc_m = re.search(r'預算[：:][^｜|]*[｜|](.*)', og_text)
        if desc_m:
            detail["description"] = desc_m.group(1).strip()[:500]
            # 清除網站廣告詞
            detail["description"] = re.sub(r'[｜|]在出任務\s*Tasker\s*接案平台立即提案。?\s*$', '', detail["description"]).strip()

    # 方法 2：從 HTML 區塊抽（更精準）
    fields_map = {
        "預算金額": "budget",
        "執行地點": "location",
        "接案身份": "identity",
        "需求說明": "description",
        "案件編號": "case_id",
        "更新日期": "updated",
    }
    for label, key in fields_map.items():
        pattern = rf'<h2[^>]*>{label}</h2>\s*<p[^>]*>([^<]+(?:<[^/][^>]*>[^<]*</[^>]>)?[^<]*)</p>'
        m = re.search(pattern, html)
        if m:
            val = re.sub(r'<[^>]+>', '', m.group(1)).strip()
            if key == "description":
                val = val[:800]  # 截取前 800 字
            if key not in detail or not detail[key]:
                detail[key] = val

    # 需求說明長版（多行，line-clamp 展開後的完整內容）
    if not detail.get("description"):
        desc_m2 = re.search(r'需求說明</h2>\s*<p[^>]*class="[^"]*"[^>]*>((?:.|\n)*?)</p>', html)
        if desc_m2:
            detail["description"] = re.sub(r'<[^>]+>', '', desc_m2.group(1)).strip()[:800]

    return detail


def filter_and_score(jobs: list[dict]) -> list[dict]:
    scored = []
    for job in jobs:
        text = job["title"] + " " + job.get("description", "")
        if any(kw in text for kw in EXCLUDE_KW):
            continue
        score = sum(1 for kw in INCLUDE_KW if kw.lower() in text.lower())
        if score > 0:
            job["score"] = score
            scored.append(job)
    scored.sort(key=lambda j: j.get("score", 0), reverse=True)
    return scored


def print_jobs(jobs: list[dict]):
    print(f"\n{'='*80}")
    print(f"📋 適合軟體工程師的案件（共 {len(jobs)} 筆）")
    print(f"{'='*80}\n")
    for i, job in enumerate(jobs, 1):
        b = f" [{job['badges']}]" if job.get("badges") else ""
        print(f"{i:2}. {job['title']}{b}")
        meta = [job[k] for k in ("budget", "location", "identity", "posted", "proposals") if job.get(k)]
        print(f"    {' | '.join(meta)}")
        if job.get("description"):
            desc = job["description"][:120]
            print(f"    📝 {desc}...")
        print(f"    🔗 {job['link']}")
        print()


def save_csv(jobs: list[dict], filename: str = ""):
    if not filename:
        timestamp = datetime.now().strftime("%Y%m%d_%H%M")
        filename = f"tasker_jobs_{timestamp}.csv"
    with open(filename, "w", newline="", encoding="utf-8-sig") as f:
        writer = csv.DictWriter(f, fieldnames=list(jobs[0].keys()))
        writer.writeheader()
        writer.writerows(jobs)
    print(f"💾 已儲存 {len(jobs)} 筆到 {filename}")


def watch_mode(interval_minutes: int = 30):
    """持續監控新案件"""
    print(f"👀 監控模式：每 {interval_minutes} 分鐘檢查前 3 頁新案件\n")
    seen_links = set()
    while True:
        all_jobs = []
        for p in range(1, 4):
            try:
                all_jobs.extend(scrape_page(p))
                time.sleep(1.5)
            except Exception as e:
                print(f"  ⚠️ 第 {p} 頁失敗: {e}")
        relevant = filter_and_score(all_jobs)
        new_jobs = [j for j in relevant if j["link"] not in seen_links]
        for j in relevant:
            seen_links.add(j["link"])

        if new_jobs:
            print(f"\n🆕 {datetime.now().strftime('%H:%M')} 新案件 {len(new_jobs)} 筆：")
            print_jobs(new_jobs)
        else:
            print(f"  [{datetime.now().strftime('%H:%M')}] 無新案件（已追蹤 {len(seen_links)} 筆）")
        time.sleep(interval_minutes * 60)


def main():
    args = sys.argv[1:]
    watch = "--watch" in args
    no_detail = "--no-detail" in args
    single_page = None
    for i, arg in enumerate(args):
        if arg == "--page" and i + 1 < len(args):
            single_page = int(args[i + 1])

    if watch:
        watch_mode()
        return

    pages = [single_page] if single_page else range(1, MAX_PAGES + 1)
    all_jobs = []

    print(f"🔍 掃描 Tasker... (AI應用 + 軟體開發，共 {len(pages)} 頁)\n")

    for page_num in pages:
        try:
            print(f"  第 {page_num} 頁...", end=" ", flush=True)
            jobs = scrape_page(page_num)
            relevant = filter_and_score(jobs)
            all_jobs.extend(relevant)
            print(f"共 {len(jobs)} 筆，相關 {len(relevant)} 筆")
        except Exception as e:
            print(f"❌ {e}")

    # 去重 + 排序
    seen = OrderedDict()
    for job in sorted(all_jobs, key=lambda j: j.get("score", 0), reverse=True):
        seen.setdefault(job["link"], job)
    unique = list(seen.values())

    # ─── 深入抓取每個案件的詳細頁 ───
    if not no_detail and unique:
        print(f"\n🔎 深入抓取 {len(unique)} 筆案件詳細資訊...\n")
        for i, job in enumerate(unique, 1):
            try:
                print(f"  [{i}/{len(unique)}] {job['title'][:40]}...", end=" ", flush=True)
                detail = scrape_detail(job["link"])
                # 合併（詳細頁優先）
                for key in ("budget", "location", "description"):
                    if detail.get(key):
                        job[key] = detail[key]
                if detail.get("identity"):
                    job["identity"] = detail["identity"]
                if detail.get("case_id"):
                    job["case_id"] = detail["case_id"]
                print("✅")
                time.sleep(0.8)  # 禮貌間隔
            except Exception as e:
                print(f"⚠️ {e}")

    print_jobs(unique)
    if unique:
        save_csv(unique)


if __name__ == "__main__":
    main()
