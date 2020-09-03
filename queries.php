<section id="queries">
    <div class="title">
        <h2>2. 検索クエリ</h2>
        <p><?php echo $siteName ?></p>
    </div>
    <p>Google検索：上位1,000件のランディングページ（日別）</p>
<?php
echo '<p><time datetime="' . $startDate . '">' . $startDateDisplay . '</time> - <time datetime="' . $endDate . '">' . $endDateDisplay . '</time></p>';
?>
<?php
$queryChartCmd = "$pythonPath scChart.py $scKeyFileLocation $siteUrl $startDate $endDate";
$queryChartResponseRaw = shell_exec($queryChartCmd);
$queryChartResponse = json_decode($queryChartResponseRaw,true);

function queryChart($reports) {
    $rows = $reports['rows'];
    for ($index = 0; $index < count($rows); $index++) {
        $dateRaw[$index] = $rows[$index]['keys'][0];
        $date[$index] = date('n月j日',strtotime($dateRaw[$index]));
        $clicks[$index] = $rows[$index]['clicks'];
    }
    $dateJson = json_encode($date);
    $clicksJson = json_encode($clicks);

    echo <<<EOF
    <section class="mainChart">
        <canvas id="queryChart"></canvas>
        <script>
        var ctx = document.getElementById("queryChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'クリック数',
                        data: $clicksJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc7",
                        pointBackgroundColor: "#068dc7"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    align: 'start'
                }
            }
        });
        </script>
    </section>
    EOF;
}
queryChart($queryChartResponse);
?>
<?php
function queryResults($reports) {
    $rows = $reports['rows'];

    for ($index = 0; $index < count($rows); $index++) {
        $totalClicksArray[$index] = $rows[$index]['clicks'];
        $totalImpressionsArray[$index] = $rows[$index]['impressions'];
        $totalCtrArray[$index] = $rows[$index]['ctr'];
        $totalPositionArray[$index] = $rows[$index]['position'];
    }
    $totalClicksRaw = array_sum($totalClicksArray);
    $totalImpressionsRaw = array_sum($totalImpressionsArray);
    $totalCtrRaw = array_sum($totalCtrArray) / count($rows);
    $totalPositionRaw = array_sum($totalPositionArray) / count($rows);

    $totalClicks = number_format($totalClicksRaw);
    $totalImpressions = number_format($totalImpressionsRaw);
    $totalCtr = round($totalCtrRaw, 2);
    $totalPosition = round($totalPositionRaw, 2);

    if ( $totalClicksRaw == 0 ) {
        $totalClicks_percentage = 0;
    } else {
        $totalClicks_percentage = round($totalClicksRaw / $totalClicksRaw * 100, 2);
    }
    if ( $totalImpressionsRaw == 0 ) {
        $totalImpressions_percentage = 0;
    } else {
        $totalImpressions_percentage = round($totalImpressionsRaw / $totalImpressionsRaw * 100, 2);
    }
    if ( $totalCtrRaw == 0 ) {
        $totalCtr_avgPercentage = 0;
    } else {
        $totalCtr_avgPercentage = round($totalCtrRaw / $totalCtrRaw * 100 - 100, 2);
    }
    if ( $totalPositionRaw == 0 ) {
        $totalPosition_avgPercentage = 0;
    } else {
        $totalPosition_avgPercentage = round($totalPositionRaw / $totalPositionRaw * 100 - 100, 2);
    }

    echo <<<EOF
    <table>
        <colgroup>
            <col span="2">
            <col class="active">
            <col span="3">
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">検索クエリ</th>
                <th>クリック数</th>
                <th>表示回数</th>
                <th>クリック率</th>
                <th>平均掲載順位</th>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>$totalClicks<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalClicks_percentage}%<br>($totalClicks)</span></td>
                <td>$totalImpressions<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalImpressions_percentage}%<br>($totalImpressions)</span></td>
                <td>{$totalCtr}%<br><span class="small">ビューの<wbr>平均：<br>{$totalCtr}%<br>({$totalCtr_avgPercentage}%)</span></td>
                <td>$totalPosition<br><span class="small">ビューの<wbr>平均：<br>$totalPosition<br>({$totalPosition_avgPercentage}%)</span></td>
            </tr>
        </thead>
        <tbody>
    EOF;

    for ($index = 0; $index < min( count($rows), 25); $index++) {
        $rank = $index + 1;
        $title = $rows[$index]['keys'][0];

        $clicksRaw = $rows[$index]['clicks'];
        $impressionsRaw = $rows[$index]['impressions'];
        $ctrRaw = $rows[$index]['ctr'];
        $positionRaw = $rows[$index]['position'];

        $clicks = number_format($clicksRaw);
        $impressions = number_format($impressionsRaw);
        $ctr = round($ctrRaw, 2);
        $position = round($positionRaw, 2);

        if ( $totalClicksRaw == 0 ) {
            $clicks_percentage = 0;
        } else {
            $clicks_percentage = round($clicksRaw / $totalClicksRaw * 100, 2);
        }
        if ( $totalImpressionsRaw == 0 ) {
            $impressions_percentage = 0;
        } else {
            $impressions_percentage = round($impressionsRaw / $totalImpressionsRaw * 100, 2);
        }

        echo <<<EOF
        <tr>
            <td class="rank">$rank</td>
            <td class="title-col">$title</td>
            <td>$clicks<br><span class="small">({$clicks_percentage}%)</span></td>
            <td>$impressions<br><span class="small">({$impressions_percentage}%)</span></td>
            <td>{$ctr}%</td>
            <td>$position</td>
        </tr>
        EOF;
    }
    echo '</tbody></table>';
}
queryResults($queryResponse);
?>
</section>