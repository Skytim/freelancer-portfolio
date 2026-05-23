<?php
/**
 * 404 Template — 404.php
 */

get_header();
?>

<section class="py-32 px-6 text-center">
    <div class="max-w-md mx-auto">
        <p class="text-6xl mb-6">🔍</p>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">頁面不存在</h1>
        <p class="text-gray-500 mb-8">您搜尋的頁面可能已經移除或不存在。若您是從舊連結點入，請使用下方搜尋。</p>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
            <input type="text" name="s" placeholder="搜尋關鍵字..." class="flex-1 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400">
            <button type="submit" class="bg-cyan-600 text-white px-6 py-3 rounded-lg text-sm hover:bg-cyan-700 transition-colors">搜尋</button>
        </form>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block mt-6 text-cyan-600 text-sm hover:underline">← 回首頁</a>
    </div>
</section>

<?php get_footer(); ?>
