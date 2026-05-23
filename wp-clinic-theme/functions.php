<?php
/**
 * Clinic SEO Theme — functions.php
 *
 * 主題核心設定、資源載入、SEO 模組載入。
 */

// ─── 防止直接存取 ───
if (! defined('ABSPATH')) {
    exit;
}

// ─── 載入 SEO 函式庫 ───
require_once get_template_directory() . '/includes/seo-functions.php';

// ─── 主題初始化 ───
function clinic_seo_setup()
{
    // 讓 WP 自動輸出 <title> tag
    add_theme_support('title-tag');

    // 文章縮圖
    add_theme_support('post-thumbnails');

    // 註冊選單
    register_nav_menus([
        'primary' => __('主要導覽列', 'clinic-seo'),
        'footer'  => __('頁尾連結', 'clinic-seo'),
    ]);

    // HTML5 語意標記
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
}
add_action('after_setup_theme', 'clinic_seo_setup');

// ─── 載入 CSS / JS ───
function clinic_seo_enqueue_assets()
{
    // Tailwind CSS CDN（開發用；正式環境建議改用編譯後的本地檔案）
    wp_enqueue_script(
        'tailwindcss',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&display=swap',
        [],
        null
    );

    // 自訂樣式（少量補充 Tailwind 沒有的）
    wp_enqueue_style(
        'clinic-seo-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    // 自訂 JS（少許互動用）
    wp_enqueue_script(
        'clinic-seo-script',
        get_template_directory_uri() . '/assets/scripts.js',
        [],
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'clinic_seo_enqueue_assets');

// ─── 移除 WP 內建 emoji / oEmbed 多餘輸出（效能優化） ───
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head');

// ─── llms.txt 虛擬路由 ───
function clinic_seo_llms_txt()
{
    if (! isset($_SERVER['REQUEST_URI'])) {
        return;
    }

    $request = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));

    if ('/llms.txt' === $request || '/llms' === $request) {
        header('Content-Type: text/plain; charset=utf-8');
        clinic_seo_output_llms_txt();
        exit;
    }
}
add_action('template_redirect', 'clinic_seo_llms_txt');

// ─── robots.txt 客製化 ───
function clinic_seo_robots_txt($output, $public)
{
    if ('0' === (string) $public) {
        return $output;
    }

    $custom  = "User-agent: *\n";
    $custom .= "Allow: /\n";
    $custom .= "Disallow: /wp-admin/\n";
    $custom .= "Disallow: /wp-content/plugins/\n";
    $custom .= "Disallow: /wp-includes/\n";
    $custom .= "Disallow: /xmlrpc.php\n";
    $custom .= "Disallow: /wp-login.php\n\n";

    $custom .= "User-agent: GPTBot\n";
    $custom .= "Allow: /\n";
    $custom .= "Disallow: /wp-admin/\n\n";

    $custom .= "User-agent: CCBot\n";
    $custom .= "Allow: /\n";
    $custom .= "Disallow: /wp-admin/\n\n";

    $custom .= "User-agent: anthropic-ai\n";
    $custom .= "Allow: /\n";
    $custom .= "Disallow: /wp-admin/\n\n";

    $custom .= "Sitemap: " . home_url('/sitemap_index.xml') . "\n";

    return $custom;
}
add_filter('robots_txt', 'clinic_seo_robots_txt', 10, 2);

// ─── 佈景主題啟用時建立預設頁面 ───
function clinic_seo_create_default_pages()
{
    $pages = [
        'about'    => [
            'title'   => '診所介紹',
            'content' => '關於診所的介紹內容。',
            'template' => 'page-about.php',
        ],
        'services' => [
            'title'   => '服務項目',
            'content' => '診療服務項目說明。',
            'template' => 'page-services.php',
        ],
        'doctors'  => [
            'title'   => '醫師團隊',
            'content' => '醫師學經歷與專長介紹。',
            'template' => 'page-doctors.php',
        ],
        'contact'  => [
            'title'   => '聯絡我們',
            'content' => '預約掛號與交通資訊。',
            'template' => 'page-contact.php',
        ],
    ];

    foreach ($pages as $slug => $data) {
        $existing = get_page_by_path($slug);
        if (! $existing) {
            wp_insert_post([
                'post_title'    => $data['title'],
                'post_content'  => $data['content'],
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'page_template' => $data['template'],
            ]);
        }
    }

    // 設定首頁為靜態頁面
    $front_page = get_page_by_path('home');
    if (! $front_page) {
        $home_id = wp_insert_post([
            'post_title'   => '首頁',
            'post_content' => '診所首頁內容。',
            'post_name'    => 'home',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'page_template' => 'front-page.php',
        ]);
        update_option('page_on_front', $home_id);
        update_option('show_on_front', 'page');
    }
}
add_action('after_switch_theme', 'clinic_seo_create_default_pages');
