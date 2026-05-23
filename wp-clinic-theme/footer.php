<?php
/**
 * Theme Footer — footer.php
 *
 * 共用 footer + wp_footer()。
 */
?>

<footer class="bg-gray-900 text-gray-400 py-12 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-8 text-sm">
        <div>
            <h4 class="text-white font-bold mb-3"><?php bloginfo('name'); ?></h4>
            <p class="text-xs leading-relaxed">
                健保特約醫療院所<br>
                家庭醫學 · 皮膚科 · 小兒科
            </p>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3">快速連結</h4>
            <ul class="space-y-1 text-xs">
                <?php
                $footer_pages = ['首頁' => '/', '診所介紹' => '/about', '服務項目' => '/services', '醫師團隊' => '/doctors', '健康知識' => '/blog'];
                foreach ($footer_pages as $label => $path) {
                    printf(
                        '<li><a href="%s" class="hover:text-white transition-colors">%s</a></li>',
                        esc_url(home_url($path)),
                        esc_html($label)
                    );
                }
                ?>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3">聯絡資訊</h4>
            <ul class="space-y-1 text-xs">
                <li>📍 桃園市中壢區○○路</li>
                <li>📞 (03) XXX-XXXX</li>
                <li>📧 <?php echo esc_html(get_option('admin_email')); ?></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-medium mb-3">免責聲明</h4>
            <p class="text-xs leading-relaxed">
                本網站內容僅供參考，如有不適請盡速就醫。
            </p>
        </div>
    </div>
    <div class="max-w-6xl mx-auto mt-10 pt-8 border-t border-gray-800 text-center text-xs">
        <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. WordPress 架設 · SEO 與 AIEO 優化.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
