<?php
/**
 * Main Index / Blog Archive — index.php
 *
 * 健康知識文章列表（部落格首頁）。
 */

get_header();
?>

<!-- Hero -->
<section class="gradient-hero py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-cyan-600 text-sm tracking-wide">Health Blog</span>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 mb-4">健康知識專欄</h1>
        <p class="text-gray-500">由醫師群撰寫的專業衛教文章，用淺顯易懂的方式分享正確的健康資訊</p>
    </div>
</section>

<!-- Category Filter -->
<section class="py-10 px-6 max-w-6xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo esc_url(home_url('/blog')); ?>"
               class="<?php echo ! is_category() ? 'bg-cyan-600 text-white' : 'border border-gray-200 text-gray-500 hover:border-cyan-300 hover:text-cyan-600'; ?> text-sm px-4 py-2 rounded-full transition-colors">
                全部文章
            </a>
            <?php
            $cats = get_categories();
            foreach ($cats as $cat) :
                $is_current = is_category($cat->term_id);
                ?>
                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                   class="<?php echo $is_current ? 'bg-cyan-600 text-white' : 'border border-gray-200 text-gray-500 hover:border-cyan-300 hover:text-cyan-600'; ?> text-sm px-4 py-2 rounded-full transition-colors">
                    <?php echo esc_html($cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
            <input type="text" name="s" placeholder="搜尋文章..." class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-48 focus:outline-none focus:border-cyan-300">
        </form>
    </div>
</section>

<!-- Posts Grid -->
<section class="pb-20 px-6 max-w-6xl mx-auto">
    <?php if (have_posts()) : ?>
        <div class="grid md:grid-cols-3 gap-8">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white border border-gray-100 rounded-xl overflow-hidden card-hover cursor-pointer"
                         onclick="location.href='<?php the_permalink(); ?>'">
                    <div class="bg-gray-100 h-48 flex items-center justify-center">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                        <?php else : ?>
                            <span class="text-gray-300 text-sm">[ 文章縮圖 ]</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <?php
                            $cats = get_the_category();
                            if ($cats) {
                                echo '<span class="text-xs bg-cyan-50 text-cyan-600 px-2 py-0.5 rounded">' . esc_html($cats[0]->name) . '</span>';
                            }
                            ?>
                            <span class="text-xs text-gray-400"><?php echo get_the_date('Y-m-d'); ?></span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2 leading-snug"><?php the_title(); ?></h3>
                        <p class="text-gray-400 text-sm leading-relaxed mb-3"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <span><?php the_author(); ?></span>
                            <span>·</span>
                            <span><?php echo esc_html(clinic_seo_reading_time(get_the_content())); ?> 分鐘閱讀</span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-12 gap-2">
            <?php
            echo paginate_links([
                'prev_text' => '← 上一頁',
                'next_text' => '下一頁 →',
                'type'      => 'list',
            ]);
            ?>
        </div>
    <?php else : ?>
        <p class="text-center text-gray-400 py-20">尚無文章。醫師正在撰寫專業衛教內容，敬請期待。</p>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
