<?php
/**
 * Template: 首頁
 * Template Name: 診所首頁
 *
 * 包含：Hero、三大科別簡介、醫師預覽、門診時間、健康文章、AIEO 展示區、CTA
 */

get_header();
?>

<!-- Hero -->
<section class="gradient-hero pt-32 pb-24 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block bg-white/70 text-cyan-700 text-xs px-3 py-1 rounded-full mb-4 tracking-wide">
                中壢區 · 在地服務 15 年
            </span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
                專業、溫暖的<br><span class="text-cyan-700">家庭醫療照護</span>
            </h1>
            <p class="text-gray-500 leading-relaxed mb-8 max-w-lg">
                三位專科醫師駐診，涵蓋家庭醫學、皮膚科與小兒科。
                採預約優先制，減少您候診時間。健保給付，提供自費進階療程諮詢。
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo esc_url(home_url('/contact#appointment')); ?>"
                   class="bg-cyan-600 text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-cyan-700 transition-colors shadow-md">
                   立即網路預約
                </a>
                <a href="<?php echo esc_url(home_url('/about')); ?>"
                   class="border border-cyan-300 text-cyan-700 px-6 py-3 rounded-lg text-sm font-medium hover:bg-cyan-50 transition-colors">
                   認識診所
                </a>
            </div>
            <div class="flex gap-6 mt-8 text-xs text-gray-400">
                <span>🏥 健保特約</span>
                <span>⏱ 預約優先制</span>
                <span>📋 線上看診進度</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-8 aspect-[4/3] flex items-center justify-center">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', ['class' => 'rounded-xl object-cover w-full h-full']); ?>
            <?php else : ?>
                <p class="text-gray-300 text-lg">[ 診所實景照片 ]</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="bg-white border-b py-6 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
        <div><p class="text-cyan-600 text-lg font-bold">15+</p><p class="text-xs text-gray-400">年在地服務</p></div>
        <div><p class="text-cyan-600 text-lg font-bold">3</p><p class="text-xs text-gray-400">位專科醫師</p></div>
        <div><p class="text-cyan-600 text-lg font-bold">3</p><p class="text-xs text-gray-400">大診療科別</p></div>
        <div><p class="text-cyan-600 text-lg font-bold">4.8 ★</p><p class="text-xs text-gray-400">Google 評價</p></div>
    </div>
</section>

<!-- Services Preview -->
<section class="py-20 px-6 max-w-6xl mx-auto">
    <h2 class="text-center text-2xl md:text-3xl font-bold mb-3">醫療服務項目</h2>
    <p class="text-center text-gray-400 text-sm mb-12">全方位守護您與家人的健康</p>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white border border-gray-100 rounded-2xl p-8 card-hover trust-badge pl-6">
            <div class="text-3xl mb-4">🩺</div>
            <h3 class="font-bold text-lg mb-2">家庭醫學</h3>
            <p class="text-gray-400 text-sm leading-relaxed">感冒、腸胃不適、慢性病追蹤、成人健檢、疫苗接種、旅遊醫學諮詢。</p>
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="inline-block mt-4 text-xs text-cyan-600 hover:underline">了解更多 →</a>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-8 card-hover trust-badge pl-6 border-l-cyan-500">
            <div class="text-3xl mb-4">🔬</div>
            <h3 class="font-bold text-lg mb-2">皮膚科</h3>
            <p class="text-gray-400 text-sm leading-relaxed">青春痘、濕疹、乾癬、蕁麻疹、帶狀疱疹、皮膚過敏原檢測、冷凍治療。</p>
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="inline-block mt-4 text-xs text-cyan-600 hover:underline">了解更多 →</a>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-8 card-hover trust-badge pl-6">
            <div class="text-3xl mb-4">👶</div>
            <h3 class="font-bold text-lg mb-2">小兒科</h3>
            <p class="text-gray-400 text-sm leading-relaxed">嬰幼兒健檢、預防接種、生長評估、過敏氣喘照護、兒童常見疾病診療。</p>
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="inline-block mt-4 text-xs text-cyan-600 hover:underline">了解更多 →</a>
        </div>
    </div>
</section>

<!-- Opening Hours -->
<section class="py-20 px-6 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-center text-2xl md:text-3xl font-bold mb-12">門診時間</h2>
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
            <table class="w-full text-sm">
                <thead class="bg-cyan-50 text-cyan-800">
                    <tr>
                        <th class="py-3 px-4 text-left">時段</th>
                        <th class="py-3 px-4 text-center">週一～五</th>
                        <th class="py-3 px-4 text-center">週六</th>
                        <th class="py-3 px-4 text-center">週日</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr>
                        <td class="py-3 px-4 font-medium">上午 08:30-12:00</td>
                        <td class="py-3 px-4 text-center text-green-600">●</td>
                        <td class="py-3 px-4 text-center text-green-600">●</td>
                        <td class="py-3 px-4 text-center text-gray-300">休</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-medium">下午 14:00-17:30</td>
                        <td class="py-3 px-4 text-center text-green-600">●</td>
                        <td class="py-3 px-4 text-center text-gray-300">休</td>
                        <td class="py-3 px-4 text-center text-gray-300">休</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-medium">晚間 18:00-21:00</td>
                        <td class="py-3 px-4 text-center text-green-600">●</td>
                        <td class="py-3 px-4 text-center text-gray-300">休</td>
                        <td class="py-3 px-4 text-center text-gray-300">休</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3 text-center">※ 國定假日另行公告 · 最後掛號為休診前 30 分鐘</p>
    </div>
</section>

<!-- Doctors Preview -->
<section class="py-20 px-6 max-w-6xl mx-auto">
    <h2 class="text-center text-2xl md:text-3xl font-bold mb-3">醫師團隊</h2>
    <p class="text-center text-gray-400 text-sm mb-12">專業認證 · 豐富臨床經驗</p>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="w-28 h-28 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center"><span class="text-gray-400 text-xs">[照片]</span></div>
            <h3 class="font-bold">林文傑 醫師</h3><p class="text-xs text-cyan-600 mt-1 mb-2">家庭醫學專科</p>
            <p class="text-xs text-gray-400">台大醫院訓練 · 15 年經驗</p>
        </div>
        <div class="text-center">
            <div class="w-28 h-28 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center"><span class="text-gray-400 text-xs">[照片]</span></div>
            <h3 class="font-bold">陳雅琪 醫師</h3><p class="text-xs text-cyan-600 mt-1 mb-2">皮膚科專科</p>
            <p class="text-xs text-gray-400">長庚主治 · 10 年經驗</p>
        </div>
        <div class="text-center">
            <div class="w-28 h-28 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center"><span class="text-gray-400 text-xs">[照片]</span></div>
            <h3 class="font-bold">張志明 醫師</h3><p class="text-xs text-cyan-600 mt-1 mb-2">小兒科專科</p>
            <p class="text-xs text-gray-400">馬偕訓練 · 兒童急診認證</p>
        </div>
    </div>
    <div class="text-center mt-8">
        <a href="<?php echo esc_url(home_url('/doctors')); ?>" class="text-cyan-600 text-sm hover:underline">查看完整學經歷 →</a>
    </div>
</section>

<!-- Blog Preview -->
<section class="py-20 px-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-center text-2xl md:text-3xl font-bold mb-12">健康知識分享</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <?php
            $recent_posts = wp_get_recent_posts(['numberposts' => 3, 'post_status' => 'publish']);
            if ($recent_posts) :
                foreach ($recent_posts as $post) : ?>
                    <article class="bg-white rounded-xl overflow-hidden card-hover cursor-pointer"
                             onclick="location.href='<?php echo esc_url(get_permalink($post['ID'])); ?>'">
                        <div class="bg-gray-100 h-40 flex items-center justify-center">
                            <?php if (has_post_thumbnail($post['ID'])) : ?>
                                <?php echo get_the_post_thumbnail($post['ID'], 'medium', ['class' => 'w-full h-full object-cover']); ?>
                            <?php else : ?>
                                <span class="text-gray-300 text-sm">[ 文章縮圖 ]</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <span class="text-xs text-cyan-600">
                                <?php
                                $cats = get_the_category($post['ID']);
                                echo $cats ? esc_html($cats[0]->name) : '健康知識';
                                ?>
                            </span>
                            <h3 class="font-bold mt-1 mb-2 leading-snug"><?php echo esc_html($post['post_title']); ?></h3>
                            <p class="text-xs text-gray-400"><?php echo esc_html(get_the_date('Y-m-d', $post['ID'])); ?></p>
                        </div>
                    </article>
                <?php endforeach;
            else : ?>
                <p class="col-span-3 text-center text-gray-400">尚無文章，敬請期待醫師撰寫的健康衛教內容。</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- AIEO Showcase -->
<section class="py-16 px-6 max-w-6xl mx-auto">
    <div class="bg-gray-900 text-gray-300 rounded-2xl p-8 md:p-12">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-cyan-500 text-white text-xs px-2 py-1 rounded font-mono">AIEO</span>
            <span class="text-white font-bold">AI Engine Optimization 已導入</span>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-white font-semibold mb-3">本網站已部署 AI 友善標記</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><span class="text-green-400">✓</span> llms.txt 已設定</li>
                    <li class="flex items-center gap-2"><span class="text-green-400">✓</span> Schema.org MedicalClinic 結構化資料</li>
                    <li class="flex items-center gap-2"><span class="text-green-400">✓</span> Open Graph / Meta 標籤優化</li>
                    <li class="flex items-center gap-2"><span class="text-green-400">✓</span> Google Lighthouse SEO 評分 100</li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-3">llms.txt 預覽</h3>
                <pre class="bg-gray-800 text-green-400 text-xs p-4 rounded-lg overflow-x-auto">
# <?php bloginfo('name'); ?>
> <?php bloginfo('description'); ?>

- /about: 診所簡介與醫師團隊
- /services: 診療項目說明
- /blog: 醫師衛教文章</pre>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 px-6 text-center gradient-hero">
    <h2 class="text-2xl md:text-3xl font-bold mb-4">守護您與家人的健康</h2>
    <p class="text-gray-500 mb-8 max-w-md mx-auto">立即預約，由專業團隊為您提供最合適的醫療建議。</p>
    <div class="flex justify-center gap-4">
        <a href="<?php echo esc_url(home_url('/contact#appointment')); ?>"
           class="bg-cyan-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-cyan-700 transition-colors shadow-md">
           線上預約掛號
        </a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>"
           class="bg-white border border-gray-200 px-8 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
           LINE 即時諮詢
        </a>
    </div>
</section>

<?php get_footer(); ?>
