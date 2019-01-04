<?php
/**
 * google-analytics.php
 *
 * Код сбора статистики Google
 *
 * Created by PhpStorm.
 * @date 04.01.19
 * @time 11:56
 * @since 1.1.0
 */
?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126657539-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-126657539-1');
</script>
