/**
 * Clinic SEO Theme — assets/scripts.js
 *
 * 前端互動。
 */

document.addEventListener('DOMContentLoaded', function () {

    // 行動版選單（未來擴充用）
    // ...

    // 表單時段按鈕互動
    const timeSlots = document.querySelectorAll('input[name="time_slot"]');
    timeSlots.forEach(function (radio) {
        radio.addEventListener('change', function () {
            // 移除所有 label 的選中樣式
            document.querySelectorAll('input[name="time_slot"]').forEach(function (r) {
                r.closest('label').classList.remove('bg-cyan-50', 'border-cyan-400', 'text-cyan-700');
                r.closest('label').classList.add('border-gray-200');
            });
            // 加入選中樣式
            if (this.checked) {
                var label = this.closest('label');
                label.classList.add('bg-cyan-50', 'border-cyan-400', 'text-cyan-700');
                label.classList.remove('border-gray-200');
            }
        });
    });
});
