<footer>
    <div class="inner">
        <p>ご不明な点やキーワードの変更、サイト修正のご相談などございましたら<br>お気軽にお問い合わせください。</p>
<?php
if ( !empty($publisherAddress) ){
    echo '<address>' . $publisherAddress . '</address>';
}
?>
    </div>
    <small>Copyright &copy; <?php echo date('Y') . ' ' . $publisherName . '.'; ?> All Rights Reserved.</small>
</footer>