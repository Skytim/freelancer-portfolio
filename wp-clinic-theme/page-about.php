<?php
/**
 * Template: 診所介紹
 * Template Name: 診所介紹
 */

get_header();
?>

<!-- Hero -->
<section class="gradient-hero py-20 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-cyan-600 text-sm tracking-wide">About Us</span>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 mb-4">守護中壢在地健康十五年</h1>
        <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
            從一間小診所起步，我們始終相信——好的醫療不該是冷冰冰的，而是有溫度、有信任的長期陪伴。
        </p>
    </div>
</section>

<!-- Content -->
<section class="py-20 px-6 max-w-4xl mx-auto">
    <div class="grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-2xl font-bold mb-6">關於<?php bloginfo('name'); ?></h2>
            <p class="text-gray-500 leading-relaxed mb-4">
                成立於 2011 年，以家庭醫學科為核心，為中壢地區居民提供基層醫療服務。
            </p>
            <p class="text-gray-500 leading-relaxed mb-4">
                2016 年，陳雅琪醫師（皮膚科）與張志明醫師（小兒科）加入，轉型為聯合診所，
                提供三大科別的整合照護。從此，一家人在同一間診所就能解決大部分健康問題。
            </p>
            <p class="text-gray-500 leading-relaxed">
                2026 年的現在，服務超過 15 年，累積超過 20 萬人次看診，
                Google 評價 4.8 顆星。不變的是我們對每位患者的用心。
            </p>
        </div>
        <div class="bg-gray-100 rounded-2xl aspect-[3/4] flex items-center justify-center">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', ['class' => 'rounded-2xl object-cover w-full h-full']); ?>
            <?php else : ?>
                <span class="text-gray-300">[ 診所環境照片 ]</span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Numbers -->
<section class="py-16 px-6 bg-gray-50">
    <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div><p class="text-3xl font-bold text-cyan-600">15+</p><p class="text-sm text-gray-400 mt-2">年在地服務</p></div>
        <div><p class="text-3xl font-bold text-cyan-600">3</p><p class="text-sm text-gray-400 mt-2">位專科醫師</p></div>
        <div><p class="text-3xl font-bold text-cyan-600">200,000+</p><p class="text-sm text-gray-400 mt-2">累積看診人次</p></div>
        <div><p class="text-3xl font-bold text-cyan-600">4.8 ★</p><p class="text-sm text-gray-400 mt-2">Google 評價</p></div>
    </div>
</section>

<!-- Mission -->
<section class="py-20 px-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-center mb-12">我們的理念</h2>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center p-6">
            <div class="text-3xl mb-4">🤝</div>
            <h3 class="font-bold mb-2">以人為本</h3>
            <p class="text-gray-400 text-sm leading-relaxed">不只治病，更關心你的生活習慣與預防保健。</p>
        </div>
        <div class="text-center p-6">
            <div class="text-3xl mb-4">🔬</div>
            <h3 class="font-bold mb-2">專業把關</h3>
            <p class="text-gray-400 text-sm leading-relaxed">三位專科醫師持續進修，給患者最好的醫療品質。</p>
        </div>
        <div class="text-center p-6">
            <div class="text-3xl mb-4">⏱</div>
            <h3 class="font-bold mb-2">減少等待</h3>
            <p class="text-gray-400 text-sm leading-relaxed">預約優先制 + 線上看診進度查詢。</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
