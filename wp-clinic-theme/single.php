<?php
/**
 * Single Post Template — single.php
 *
 * 部落格文章詳細頁面，含 Schema.org BlogPosting 結構化資料。
 */

get_header();
?>

<article class="py-12 px-6 max-w-3xl mx-auto">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <!-- Breadcrumb -->
        <nav class="text-xs text-gray-400 mb-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-cyan-600 transition-colors">首頁</a>
            <span class="mx-2">›</span>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="hover:text-cyan-600 transition-colors">健康知識</a>
            <span class="mx-2">›</span>
            <span class="text-gray-500"><?php the_title(); ?></span>
        </nav>

        <!-- Category -->
        <div class="flex items-center gap-3 mb-4">
            <?php
            $categories = get_the_category();
            if ($categories) {
                foreach ($categories as $cat) {
                    echo '<span class="text-xs bg-cyan-50 text-cyan-600 px-2 py-0.5 rounded">' . esc_html($cat->name) . '</span>';
                }
            }
            ?>
            <span class="text-xs text-gray-400"><?php echo esc_html(get_the_date('Y-m-d')); ?></span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight"><?php the_title(); ?></h1>

        <!-- Author -->
        <div class="flex items-center gap-3 mb-8 text-sm text-gray-500">
            <span>✍️ <?php the_author(); ?></span>
            <span>·</span>
            <span><?php echo esc_html(clinic_seo_reading_time(get_the_content())); ?> 分鐘閱讀</span>
        </div>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="rounded-xl overflow-hidden mb-10">
                <?php the_post_thumbnail('large', ['class' => 'w-full']); ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php $tags = get_the_tags();
        if ($tags) : ?>
            <div class="mt-10 pt-8 border-t border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">文章標籤</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                           class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full hover:bg-cyan-50 hover:text-cyan-600 transition-colors">
                            #<?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Author Box -->
        <div class="mt-10 p-6 bg-gray-50 rounded-xl flex items-start gap-4">
            <div class="w-14 h-14 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center">
                <span class="text-gray-400 text-xs">[照片]</span>
            </div>
            <div>
                <h4 class="font-bold text-gray-900"><?php the_author(); ?> 醫師</h4>
                <p class="text-xs text-gray-400 mt-1"><?php bloginfo('name'); ?></p>
                <p class="text-sm text-gray-500 mt-2">本文章由執業醫師撰寫，內容經過專業審查。如有個人健康問題，請親自至門診諮詢。</p>
            </div>
        </div>

    <?php endwhile; endif; ?>
</article>

<!-- Related Posts -->
<?php
$related = get_posts([
    'numberposts'      => 3,
    'category__in'     => wp_get_post_categories(get_the_ID()),
    'exclude'          => [get_the_ID()],
    'post_status'      => 'publish',
]);
if ($related) : ?>
    <section class="py-16 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-10">相關文章</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($related as $post) : setup_postdata($post); ?>
                    <article class="bg-white rounded-xl overflow-hidden card-hover cursor-pointer"
                             onclick="location.href='<?php the_permalink(); ?>'">
                        <div class="bg-gray-100 h-40 flex items-center justify-center">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                            <?php else : ?>
                                <span class="text-gray-300 text-sm">[ 文章縮圖 ]</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <span class="text-xs text-cyan-600"><?php $cats = get_the_category(); echo $cats ? esc_html($cats[0]->name) : ''; ?></span>
                            <h3 class="font-bold mt-1 mb-2"><?php the_title(); ?></h3>
                            <p class="text-xs text-gray-400"><?php echo get_the_date('Y-m-d'); ?></p>
                        </div>
                    </article>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>
