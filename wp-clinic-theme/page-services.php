<?php
/**
 * Template: 服務項目
 * Template Name: 服務項目
 *
 * 三大科別詳細診療項目（健保 / 自費）、常見症狀。
 */

get_header();
?>

<!-- Hero -->
<section class="gradient-hero py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-cyan-600 text-sm tracking-wide">Our Services</span>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 mb-4">全方位醫療服務</h1>
        <p class="text-gray-500 max-w-2xl mx-auto">從日常保健到專科診療，三大科別滿足全家人的健康需求</p>
    </div>
</section>

<?php
$services = [
    [
        'icon' => '🩺',
        'title' => '家庭醫學科',
        'doctor' => '林文傑 醫師',
        'insured' => [
            '感冒、發燒、腸胃不適等急性病症',
            '慢性病追蹤管理（高血壓、糖尿病、高血脂、痛風）',
            '成人預防保健（40 歲以上每三年一次免費健檢）',
            '疫苗接種（流感、肺炎鏈球菌、帶狀疱疹）',
            '旅遊醫學諮詢（出國前疫苗與預防用藥建議）',
            '戒菸門診',
        ],
        'self_pay' => [
            '勞工體檢 / 駕照體檢',
            '自費疫苗（帶狀疱疹疫苗、HPV 疫苗）',
        ],
        'tags' => ['頭痛', '發燒', '喉嚨痛', '腹瀉', '血壓偏高', '血糖控制', '全身無力', '暈眩'],
    ],
    [
        'icon' => '🔬',
        'title' => '皮膚科',
        'doctor' => '陳雅琪 醫師',
        'insured' => [
            '青春痘（痤瘡）治療',
            '濕疹、異位性皮膚炎',
            '乾癬、蕁麻疹',
            '帶狀疱疹（皮蛇）診斷與治療',
            '香港腳、灰指甲等黴菌感染',
            '皮膚過敏原檢測',
        ],
        'self_pay' => [
            '冷凍治療（病毒疣、雞眼）',
            '雷射除斑 / 除痣諮詢與轉介',
        ],
        'tags' => ['皮膚癢', '紅疹', '痘痘', '脫皮', '水泡', '黑斑', '掉髮'],
    ],
    [
        'icon' => '👶',
        'title' => '小兒科',
        'doctor' => '張志明 醫師',
        'insured' => [
            '嬰幼兒健康檢查（生長發育評估）',
            '兒童常規疫苗接種（依衛生福利部時程）',
            '感冒、發燒、腸胃炎等兒科常見疾病',
            '過敏性鼻炎、氣喘照護',
            '兒童營養諮詢',
        ],
        'self_pay' => [
            '自費輪狀病毒疫苗',
            '過敏原進階檢測',
        ],
        'tags' => ['發燒', '咳嗽', '鼻塞', '腹瀉', '疫苗', '健檢'],
    ],
];

foreach ($services as $i => $svc): ?>
    <section class="py-16 px-6 max-w-5xl mx-auto <?php echo $i < count($services) - 1 ? 'border-b border-gray-100' : ''; ?>">
        <div class="grid md:grid-cols-5 gap-10 items-start">
            <div class="md:col-span-1 text-center md:text-left">
                <div class="text-4xl mb-4"><?php echo esc_html($svc['icon']); ?></div>
                <h2 class="text-xl font-bold text-gray-900"><?php echo esc_html($svc['title']); ?></h2>
                <p class="text-xs text-cyan-600 mt-1"><?php echo esc_html($svc['doctor']); ?></p>
            </div>
            <div class="md:col-span-2">
                <h3 class="font-semibold mb-3">健保診療項目</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <?php foreach ($svc['insured'] as $item): ?>
                        <li class="flex items-start gap-2"><span class="text-cyan-500 mt-1">•</span> <?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php if (! empty($svc['self_pay'])): ?>
                    <h3 class="font-semibold mt-6 mb-3">自費項目</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <?php foreach ($svc['self_pay'] as $item): ?>
                            <li class="flex items-start gap-2"><span class="text-cyan-500 mt-1">•</span> <?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="md:col-span-2 bg-gray-50 rounded-xl p-6">
                <h3 class="font-semibold mb-3 text-sm">常見看診原因</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($svc['tags'] as $tag): ?>
                        <span class="bg-white border text-xs px-3 py-1 rounded-full text-gray-500"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<?php get_footer(); ?>
