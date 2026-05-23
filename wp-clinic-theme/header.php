<?php
/**
 * Theme Header — header.php
 *
 * 共用 header：DOCTYPE、<head>、導覽列。
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body { font-family: 'Noto Sans TC', 'PingFang TC', 'Microsoft JhengHei', sans-serif; }
        .gradient-hero { background: linear-gradient(135deg, #e8f4f8 0%, #d4eaf0 40%, #f0f7fa 100%); }
        .card-hover { transition: all 0.25s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,100,140,0.1); }
        .trust-badge { border-left: 3px solid #0891b2; }
    </style>
</head>
<body <?php body_class('bg-white text-gray-800'); ?>>
<?php wp_body_open(); ?>

<!-- Navbar -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-cyan-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                <?php echo esc_html(mb_substr(get_bloginfo('name'), 0, 1)); ?>
            </div>
            <span class="font-bold text-lg text-gray-900"><?php bloginfo('name'); ?></span>
        </a>

        <?php if (has_nav_menu('primary')) : ?>
            <div class="hidden md:flex space-x-6 text-sm text-gray-600">
                <?php
                $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary'] ?? 0);
                if ($menu_items) {
                    $current_id = get_queried_object_id();
                    foreach ($menu_items as $item) {
                        $is_current = ($item->object_id == $current_id);
                        $active_class = $is_current
                            ? 'text-cyan-700 font-medium border-b-2 border-cyan-600 pb-1'
                            : 'hover:text-cyan-700 transition-colors';
                        printf(
                            '<a href="%s" class="%s">%s</a>',
                            esc_url($item->url),
                            esc_attr($active_class),
                            esc_html($item->title)
                        );
                    }
                }
                ?>
            </div>
        <?php endif; ?>

        <a href="<?php echo esc_url(home_url('/contact#appointment')); ?>"
           class="bg-cyan-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-cyan-700 transition-colors whitespace-nowrap">
            預約掛號
        </a>
    </div>
</nav>
