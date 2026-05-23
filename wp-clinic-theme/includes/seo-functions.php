<?php
/**
 * SEO Functions — includes/seo-functions.php
 *
 * Schema.org JSON-LD 輸出、Meta Tags、llms.txt 內容、結構化資料輔助函式。
 */

if (! defined('ABSPATH')) {
    exit;
}

// ─── 輸出 SEO Meta Tags ───
function clinic_seo_meta_tags()
{
    $title       = wp_get_document_title();
    $description = get_bloginfo('description');
    $url         = home_url();
    $locale      = get_locale();

    if (is_single() || is_page()) {
        $title       = get_the_title() . ' — ' . get_bloginfo('name');
        $excerpt     = get_the_excerpt();
        $description = $excerpt ? wp_strip_all_tags($excerpt) : $description;
        $url         = get_permalink();
    }

    if (is_category() || is_tag()) {
        $title       = single_term_title('', false) . ' — ' . get_bloginfo('name');
        $description = term_description() ?: $description;
    }
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo esc_url($url); ?>">

    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:type" content="<?php echo is_single() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:locale" content="<?php echo esc_attr($locale); ?>">
    <?php
}
add_action('wp_head', 'clinic_seo_meta_tags', 5);

// ─── 輸出 Schema.org JSON-LD (首頁) ───
function clinic_seo_schema_home()
{
    if (! is_front_page()) {
        return;
    }

    $schema = [
        '@context'           => 'https://schema.org',
        '@type'              => 'MedicalClinic',
        'name'               => get_bloginfo('name'),
        'description'        => get_bloginfo('description'),
        'url'                => home_url(),
        'address'            => [
            '@type'           => 'PostalAddress',
            'addressLocality' => '桃園市',
            'addressRegion'   => '中壢區',
            'addressCountry'  => 'TW',
        ],
        'openingHoursSpecification' => [
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens'     => '08:30',
                'closes'    => '21:00',
            ],
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Saturday',
                'opens'     => '08:30',
                'closes'    => '17:00',
            ],
        ],
    ];

    clinic_seo_output_jsonld($schema);
}
add_action('wp_head', 'clinic_seo_schema_home', 10);

// ─── 輸出 Schema.org JSON-LD (文章) ───
function clinic_seo_schema_article()
{
    if (! is_single()) {
        return;
    }

    $author_id = get_the_author_meta('ID');

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BlogPosting',
        'headline'        => get_the_title(),
        'description'     => wp_strip_all_tags(get_the_excerpt()),
        'author'          => [
            '@type' => 'Person',
            'name'  => get_the_author_meta('display_name', $author_id),
        ],
        'datePublished'   => get_the_date('c'),
        'dateModified'    => get_the_modified_date('c'),
        'publisher'       => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => get_permalink(),
        ],
    ];

    clinic_seo_output_jsonld($schema);
}
add_action('wp_head', 'clinic_seo_schema_article', 10);

// ─── 輔助函式：輸出 JSON-LD ───
function clinic_seo_output_jsonld(array $data)
{
    echo PHP_EOL . '<script type="application/ld+json">' . PHP_EOL;
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    echo PHP_EOL . '</script>' . PHP_EOL;
}

// ─── llms.txt 內容 ───
function clinic_seo_output_llms_txt()
{
    $site_name = get_bloginfo('name');
    $site_desc = get_bloginfo('description');

    echo "# {$site_name}\n";
    echo "> {$site_desc}\n\n";
    echo "## 基本資訊\n";
    echo "- 官網：" . esc_url(home_url()) . "\n";
    echo "- 營業時間：週一至週五 08:30-21:00，週六 08:30-17:00，週日休診\n\n";
    echo "## 核心頁面\n";
    echo "- / (首頁): 診所簡介、三大科別摘要、門診時間、預約入口\n";
    echo "- /about: 診所故事、經營理念、環境介紹\n";
    echo "- /services: 診療項目完整說明\n";
    echo "- /doctors: 醫師學經歷與專長\n";
    echo "- /blog: 醫師撰寫健康衛教文章\n";
    echo "- /contact: 聯絡表單、交通資訊\n";
}

// ─── 輔助函式：估算閱讀時間 ───
function clinic_seo_reading_time(string $content): int
{
    $word_count = mb_strlen(wp_strip_all_tags($content));
    $minutes   = (int) ceil($word_count / 500);
    return max(1, $minutes);
}
