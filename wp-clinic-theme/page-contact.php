<?php
/**
 * Template: 聯絡我們
 * Template Name: 聯絡我們
 *
 * 預約表單 + 地圖區 + 交通資訊 + LINE QR。
 */

get_header();
?>

<!-- Hero -->
<section class="gradient-hero py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">聯絡我們</h1>
        <p class="text-gray-500">守護您與家人的健康，就從這裡開始</p>
    </div>
</section>

<section class="py-16 px-6 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-16">

        <!-- Left: Map + Info -->
        <div>
            <h2 class="text-xl font-bold mb-6">診所位置</h2>
            <div class="bg-gray-100 rounded-xl aspect-video flex items-center justify-center mb-6">
                <span class="text-gray-300">[ Google Maps 嵌入 ]</span>
            </div>
            <div class="space-y-4 text-sm">
                <div class="flex items-start gap-3">
                    <span class="text-cyan-600 text-lg">📍</span>
                    <div><p class="font-medium text-gray-900">地址</p><p class="text-gray-500">桃園市中壢區○○路○○號</p></div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-cyan-600 text-lg">📞</span>
                    <div><p class="font-medium text-gray-900">電話</p><p class="text-gray-500">(03) XXX-XXXX</p></div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-cyan-600 text-lg">📧</span>
                    <div><p class="font-medium text-gray-900">電子郵件</p><p class="text-gray-500"><?php echo esc_html(get_option('admin_email')); ?></p></div>
                </div>
            </div>

            <div class="mt-8 p-6 bg-gray-50 rounded-xl">
                <h3 class="font-semibold mb-4">交通資訊</h3>
                <div class="space-y-3 text-sm text-gray-500">
                    <div class="flex items-start gap-2"><span class="font-medium text-gray-700 min-w-[3rem]">🚗 開車</span><span>診所對面設有收費停車場，步行 1 分鐘</span></div>
                    <div class="flex items-start gap-2"><span class="font-medium text-gray-700 min-w-[3rem]">🚌 公車</span><span>搭乘 ○○ 路至「○○站」下車，步行 3 分鐘</span></div>
                    <div class="flex items-start gap-2"><span class="font-medium text-gray-700 min-w-[3rem]">🚆 火車</span><span>中壢火車站下車，轉乘公車約 10 分鐘</span></div>
                </div>
            </div>

            <div class="mt-8 p-6 bg-green-50 rounded-xl border border-green-100">
                <h3 class="font-semibold mb-3 flex items-center gap-2"><span class="text-green-600 text-lg">💬</span> LINE 官方帳號</h3>
                <p class="text-sm text-gray-500 mb-3">加入 LINE 好友，即可線上預約掛號、查詢看診進度、接收健康資訊推播。</p>
                <div class="bg-white w-32 h-32 mx-auto rounded-lg flex items-center justify-center border"><span class="text-gray-300 text-xs">[ LINE QR Code ]</span></div>
            </div>
        </div>

        <!-- Right: Form -->
        <div id="appointment">
            <h2 class="text-xl font-bold mb-6">線上預約掛號</h2>

            <div class="grid grid-cols-3 gap-3 mb-8">
                <button class="border-2 border-cyan-200 rounded-lg py-3 text-sm font-medium text-cyan-700 hover:bg-cyan-50 transition-colors bg-cyan-50">網路預約</button>
                <button class="border-2 border-gray-200 rounded-lg py-3 text-sm text-gray-500 hover:border-cyan-200 transition-colors">電話預約</button>
                <button class="border-2 border-gray-200 rounded-lg py-3 text-sm text-gray-500 hover:border-green-200 transition-colors">LINE 預約</button>
            </div>

            <form class="space-y-5" method="post" action="">
                <?php wp_nonce_field('clinic_appointment', '_clinic_nonce'); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">姓名</label>
                    <input type="text" name="patient_name" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="請輸入您的姓名" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">聯絡電話</label>
                    <input type="tel" name="patient_phone" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="範例：0912-345-678" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">看診科別</label>
                        <select name="department" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400 transition-colors bg-white">
                            <option value="">請選擇科別</option>
                            <option value="family">家庭醫學科</option>
                            <option value="dermatology">皮膚科</option>
                            <option value="pediatrics">小兒科</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">偏好日期</label>
                        <input type="date" name="preferred_date" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">偏好時段</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="border border-gray-200 rounded-lg py-2 text-sm text-center cursor-pointer hover:border-cyan-300 transition-colors">
                            <input type="radio" name="time_slot" value="morning" class="sr-only"> 上午
                        </label>
                        <label class="border border-gray-200 rounded-lg py-2 text-sm text-center cursor-pointer hover:border-cyan-300 transition-colors">
                            <input type="radio" name="time_slot" value="afternoon" class="sr-only"> 下午
                        </label>
                        <label class="border border-gray-200 rounded-lg py-2 text-sm text-center cursor-pointer hover:border-cyan-300 transition-colors">
                            <input type="radio" name="time_slot" value="evening" class="sr-only"> 晚間
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">備註（選填）</label>
                    <textarea name="note" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="如有特殊需求或想指定醫師，請在此說明"></textarea>
                </div>
                <button type="submit" class="w-full bg-cyan-600 text-white py-3 rounded-lg font-medium hover:bg-cyan-700 transition-colors shadow-sm">送出預約</button>
            </form>

            <p class="text-xs text-gray-400 mt-4 text-center">提交預約後，診所人員將於營業時間內致電確認。若有緊急狀況，請直接來電。</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
