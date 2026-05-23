<?php
/**
 * Template: 醫師團隊
 * Template Name: 醫師團隊
 *
 * 三位醫師完整學經歷、專長、門診時段。
 */

get_header();

$doctors = [
    [
        'name'     => '林文傑',
        'title'    => '家庭醫學專科',
        'role'     => '院長 / 創辦人',
        'edu'      => ['台大醫院家庭醫學部住院醫師 / 總醫師', '糖尿病照護網認證醫師', '國民健康署戒菸治療認證醫師', '台灣家庭醫學醫學會會員', '15 年以上基層醫療經驗'],
        'skills'   => ['慢性病管理', '成人健檢', '疫苗諮詢', '旅遊醫學', '戒菸治療'],
        'schedule' => '週一～週五 上午、下午、晚間｜週六 上午',
    ],
    [
        'name'     => '陳雅琪',
        'title'    => '皮膚科專科',
        'role'     => '',
        'edu'      => ['長庚紀念醫院皮膚科主治醫師', '台灣皮膚科醫學會專科醫師', '中華民國醫用雷射光電學會會員', '醫學中心 10 年以上皮膚科診療經驗'],
        'skills'   => ['青春痘治療', '濕疹', '乾癬', '過敏原檢測', '冷凍治療'],
        'schedule' => '週二～週五 上午、下午｜週六 上午（隔週）',
    ],
    [
        'name'     => '張志明',
        'title'    => '小兒科專科',
        'role'     => '',
        'edu'      => ['馬偕兒童醫院小兒科住院醫師 / 總醫師', '台灣兒科醫學會專科醫師', '兒童急診醫學認證', '兒童過敏氣喘免疫學會會員'],
        'skills'   => ['嬰幼兒健檢', '預防接種', '過敏氣喘', '生長評估', '兒童營養'],
        'schedule' => '週一、三、五 上午、下午｜週六 上午',
    ],
];
?>

<!-- Hero -->
<section class="gradient-hero py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-cyan-600 text-sm tracking-wide">Medical Team</span>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 mb-4">專業醫師團隊</h1>
        <p class="text-gray-500 max-w-2xl mx-auto">三位專科醫師，豐富臨床經驗，為您提供最合適的醫療建議</p>
    </div>
</section>

<?php foreach ($doctors as $i => $doc): ?>
    <section class="py-16 px-6 max-w-4xl mx-auto <?php echo $i > 0 ? 'border-t border-gray-100' : ''; ?>">
        <div class="grid md:grid-cols-3 gap-10 items-start">
            <div class="text-center">
                <div class="w-36 h-36 bg-gray-200 rounded-full mx-auto mb-5 flex items-center justify-center">
                    <span class="text-gray-400 text-xs">[ 醫師照片 ]</span>
                </div>
                <h2 class="text-xl font-bold text-gray-900"><?php echo esc_html($doc['name']); ?> 醫師</h2>
                <p class="text-cyan-600 text-sm mt-1"><?php echo esc_html($doc['title']); ?></p>
                <?php if ($doc['role']): ?>
                    <p class="text-xs text-gray-400 mt-1"><?php echo esc_html($doc['role']); ?></p>
                <?php endif; ?>
            </div>
            <div class="md:col-span-2">
                <h3 class="font-semibold mb-4">學經歷</h3>
                <ul class="space-y-2 text-sm text-gray-500 mb-6">
                    <?php foreach ($doc['edu'] as $item): ?>
                        <li>• <?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <h3 class="font-semibold mb-4">專長</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach ($doc['skills'] as $skill): ?>
                        <span class="bg-cyan-50 text-cyan-700 text-xs px-3 py-1 rounded-full"><?php echo esc_html($skill); ?></span>
                    <?php endforeach; ?>
                </div>
                <h3 class="font-semibold mb-2">門診時段</h3>
                <p class="text-sm text-gray-500"><?php echo esc_html($doc['schedule']); ?></p>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<?php get_footer(); ?>
