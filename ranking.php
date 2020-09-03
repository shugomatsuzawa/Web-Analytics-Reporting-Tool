<section id="ranking">
    <div class="title">
        <h2>検索キーワードランク状況</h2>
        <p><?php echo $siteName ?></p>
    </div>
    <dl class="about">
        <dt>サイト名</dt>
        <dd><?php echo $siteName ?></dd>
        <dt>サイトURL</dt>
        <dd><?php echo $siteUrl ?></dd>
        <dt>設定キーワード</dt>
        <dd><?php echo implode(", ", $siteKeyword); ?></dd>
        <dt>データ取得日</dt>
        <dd><?php echo '<time datetime="' . $startDate . '">' . $startDateDisplay . '</time> - <time datetime="' . $endDate . '">' . $endDateDisplay . '</time>'; ?></dd>
    </dl>
<?php
$queryCmd = "$pythonPath sc.py $scKeyFileLocation $siteUrl $startDate $endDate";
$queryResponseRaw = shell_exec($queryCmd);
$queryResponse = json_decode($queryResponseRaw,true);

function rankingResults($reports, $siteKeyword) {
    echo <<<EOF
    <table>
        <thead>
            <tr>
                <th>検索語</th>
                <th>Yahoo順位</th>
                <th>Yahooヒット件数</th>
                <th>Google順位</th>
                <th>Googleヒット件数</th>
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
            <td>-</td>
            <td>-</td>
            <td>$position</td>
            <td>-</td>
        </tr>
        EOF;
    }
    echo '</tbody></table>';
}
rankingResults($queryResponse, $siteKeyword);
?>
    <ul>
        <li>このページは、Google・Yahoo検索で上記キーワードにて検索した際の順位・ヒット件数を表しています。
            <ul>
                <li><strong>ヒット件数</strong>・・・検索結果ページの上部に「約○○○件」のように表示される数値です。参考情報としてご利用ください。<br>上記数値は純粋な数値を抽出しており、実際にお手持ちのPCなどで検索して表示される件数はキャッシュの影響があり この数値と多少の誤差が生じる場合がございます。</li>
            </ul>
        </li>
        <li>順位の欄に「-」が表示されている項目は、100位以下となります。</li>
        <li>お調べするキーワードなどの変更がございましたらお気軽にお申し付けください。</li>
    </ul>
</section>