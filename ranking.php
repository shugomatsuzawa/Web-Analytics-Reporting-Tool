<section id="ranking">
    <div class="title">
        <h2>検索キーワードランク状況</h2>
<?php
if ( empty($siteName) ) {
    echo '<p>' . $clientName . '</p>';
} else {
    echo '<p>' . $siteName . '（' . $clientName . '）</p>';
}
?>
    </div>
    <dl class="about">
        <dt>サイト名</dt>
<?php
if ( empty($siteName) ) {
    echo '<dd>' . $clientName . '</dd>';
} else {
    echo '<dd>' . $siteName . '</dd>';
}
?>
        <dt>サイトURL</dt>
        <dd><?php echo $siteUrl ?></dd>
        <dt>設定キーワード</dt>
        <dd><?php echo implode(", ", $siteKeyword); ?></dd>
        <dt>データ取得日</dt>
        <dd><?php echo '<time datetime="' . $startDate . '">' . $startDateDisplay . '</time> - <time datetime="' . $endDate . '">' . $endDateDisplay . '</time>'; ?></dd>
    </dl>
<?php
$rankingDimensions = array('query');
$rankingResponse = getSc($searchConsole, $siteUrl, $startDate, $endDate, $queryDimensions);

function rankingResults($reports, $siteKeyword) {
    echo <<<EOF
    <table>
        <thead>
            <tr>
                <th>検索語</th>
                <th>Google順位</th>
            </tr>
        </thead>
        <tbody>
    EOF;
    
    $reportsRows = $reports['rows'];
    for ($index = 0; $index < count($siteKeyword); $index++) {
        $title = $siteKeyword[$index];

        $titleSearch = false;
        foreach ($reportsRows as $titleSearch => $child) {
            if ($child['keys'][0] === $title) {
                break;
            }
            $titleSearch = false;
        }

        $positionRaw = $reportsRows[$titleSearch]['position'];
        if( !empty($positionRaw) ){
            $position = round($positionRaw, 2);
        } else {
            $position = '-';
        }
        echo <<<EOF
        <tr>
            <td>$title</td>
            <td>$position</td>
        </tr>
        EOF;
    }
    echo '</tbody></table>';
}
rankingResults($rankingResponse, $siteKeyword);
?>
    <ul>
        <li>このページは、Google検索で上記キーワードにて検索した際の順位を表しています。</li>
        <li>順位の欄に「-」が表示されている項目は、100位以下となります。</li>
        <li>お調べするキーワードなどの変更がございましたらお気軽にお申し付けください。</li>
    </ul>
</section>