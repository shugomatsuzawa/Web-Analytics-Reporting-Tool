
<header>
    <div class="inner">
        <section>
            <h1>Webサイト<br>アクセス解析レポート</h1>
<?php
if ( empty($siteName) ) {
    echo <<<EOF
        <h2>$clientName 御中</h2>
        <p>$siteUrl</p>
    EOF;
} else {
    echo <<<EOF
        <h2>$clientName 御中</h2>
        <h3>【{$siteName}】</h3>
        <p>$siteUrl</p>
    EOF;
}
?>
        </section>
        <?php echo $companyLogo; ?>
    </div>
    <small>Copyright &copy; <?php echo date('Y') . ' ' . $companyName . '.'; ?> All Rights Reserved.</small>
</header>