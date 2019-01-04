<?php
/**
 * liveinternet.php
 *
 * Счетчик LiveInternet
 *
 * Created by PhpStorm.
 * @date 04.01.19
 * @time 11:57
 * @since 1.1.0
 */
?>

<!--LiveInternet counter-->
<script type="text/javascript">
    document.write("<a href='//www.liveinternet.ru/click' " +
        "target=_blank><img src='//counter.yadro.ru/hit?t14.6;r" +
        escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
            screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
        ";h" + escape(document.title.substring(0, 150)) + ";" + Math.random() +
        "' alt='' title='LiveInternet: показано число просмотров за 24" +
        " часа, посетителей за 24 часа и за сегодня' " +
        "border='0' height='20'><\/a>")
</script>
<!--/LiveInternet-->
