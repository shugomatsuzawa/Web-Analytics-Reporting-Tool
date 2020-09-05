<section id="pages">
    <div class="title">
<?php
if ( !empty($pythonPath) && ($enableSC == 1) ) {
    echo '<h2>4. 参照ページ</h2>';
} else {
    echo '<h2>3. 参照ページ</h2>';
}

if ( empty($siteName) ) {
    echo '<p>' . $clientName . '</p>';
} else {
    echo '<p>' . $siteName . '（' . $clientName . '）</p>';
}
?>
    </div>
<?php
echo '<p><time datetime="' . $startDate . '">' . $startDateDisplay . '</time> - <time datetime="' . $endDate . '">' . $endDateDisplay . '</time></p>';
?>
<?php
function pagesChart($reports) {
    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $dateRaw[$index] = $rows[$index]->getDimensions()[0];
        $date[$index] = date('n月j日' ,strtotime( substr("$dateRaw[$index]", 0, 4) . '-' . substr("$dateRaw[$index]", 4, 2) . '-' . substr("$dateRaw[$index]", 6) ));
        $pageviews[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $pageviewsJson = json_encode($pageviews);

    echo <<<EOF
    <section class="mainChart">
        <canvas id="pagesChart"></canvas>
        <script>
        var ctx = document.getElementById("pagesChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'ページビュー数',
                        data: $pageviewsJson,
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
pagesChart($pageviewsChartResponse);
?>
<?php
$pagesMetrics = array($pageviews, $uniquePageviews, $avgTimeOnPage, $entrances, $bounceRate, $exitRate, $pageValue);
$pagesDimensions = array($pageTitle, $pagePath);
$pagesOrder = 'ga:pageviews';
$pagesResponse = getReport($analytics, $viewId, $startDate, $endDate, $pagesMetrics, $pagesDimensions, $pagesOrder);

function pagesResults($reports, $siteUrl) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];

    $totalPageviewsRaw = $totals[0];
    $totalUniquePageviewsRaw = $totals[1];
    $totalAvgTimeOnPageRaw = $totals[2];
    $totalEntrancesRaw = $totals[3];
    $totalBounceRateRaw = $totals[4];
    $totalExitRateRaw = $totals[5];
    $totalPageValueRaw = $totals[6];

    $totalPageviews = number_format($totalPageviewsRaw);
    $totalUniquePageviews = number_format($totalUniquePageviewsRaw);
    $totalAvgTimeOnPage = gmdate("H:i:s", $totalAvgTimeOnPageRaw);
    $totalEntrances = number_format($totalEntrancesRaw);
    $totalBounceRate = round($totalBounceRateRaw, 2);
    $totalExitRate = round($totalExitRateRaw, 2);
    $totalPageValue = round($totalPageValueRaw, 2);

    if ( $totalPageviewsRaw == 0 ) {
        $totalPageviews_percentage = 0;
    } else {
        $totalPageviews_percentage = round($totalPageviewsRaw / $totalPageviewsRaw * 100, 2);
    }
    if ( $totalUniquePageviewsRaw == 0 ) {
        $totalUniquePageviews_percentage = 0;
    } else {
        $totalUniquePageviews_percentage = round($totalUniquePageviewsRaw / $totalUniquePageviewsRaw * 100, 2);
    }
    if ( $totalAvgTimeOnPageRaw == 0 ) {
        $totalAvgTimeOnPage_avgPercentage = 0;
    } else {
        $totalAvgTimeOnPage_avgPercentage = round($totalAvgTimeOnPageRaw / $totalAvgTimeOnPageRaw * 100 - 100, 2);
    }
    if ( $totalEntrancesRaw == 0 ) {
        $totalEntrances_percentage = 0;
    } else {
        $totalEntrances_percentage = round($totalEntrancesRaw / $totalEntrancesRaw * 100, 2);
    }
    if ( $totalBounceRateRaw == 0 ) {
        $totalBounceRate_avgPercentage = 0;
    } else {
        $totalBounceRate_avgPercentage = round($totalBounceRateRaw / $totalBounceRateRaw * 100 - 100, 2);
    }
    if ( $totalExitRateRaw == 0 ) {
        $totalExitRate_avgPercentage = 0;
    } else {
        $totalExitRate_avgPercentage = round($totalExitRateRaw / $totalExitRateRaw * 100 - 100, 2);
    }
    if ( $totalPageValueRaw == 0 ) {
        $totalPageValue_percentage = 0;
    } else {
        $totalPageValue_percentage = round($totalPageValueRaw / $totalPageValueRaw * 100, 2);
    }

    $rows = $reports->getReports()[0]->getData()->getRows();
    echo <<<EOF
    <table>
        <colgroup>
            <col span="2">
            <col class="active">
            <col span="6">
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">ページ<wbr>タイトル</th>
                <th>ページ<wbr>ビュー<wbr>数</th>
                <th>ページ別<wbr>訪問数</th>
                <th>平均ページ<wbr>滞在時間</th>
                <th>閲覧<wbr>開始数</th>
                <th>直帰率</th>
                <th>離脱率</th>
                <th>ページの<wbr>価値</th>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>$totalPageviews<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalPageviews_percentage}%<br>($totalPageviews)</span></td>
                <td>$totalUniquePageviews<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalUniquePageviews_percentage}%<br>($totalUniquePageviews)</span></td>
                <td>$totalAvgTimeOnPage<br><span class="small">ビューの<wbr>平均：<br>$totalAvgTimeOnPage<br>({$totalAvgTimeOnPage_avgPercentage}%)</span></td>
                <td>$totalEntrances<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalEntrances_percentage}%<br>($totalEntrances)</span></td>
                <td>{$totalBounceRate}%<br><span class="small">ビューの<wbr>平均：<br>{$totalBounceRate}%<br>({$totalBounceRate_avgPercentage}%)</span></td>
                <td>{$totalExitRate}%<br><span class="small">ビューの<wbr>平均：<br>{$totalExitRate}%<br>({$totalExitRate_avgPercentage}%)</span></td>
                <td>$$totalPageValue<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalPageValue_percentage}%<br>($$totalPageValue)</span></td>
            </tr>
        </thead>
        <tbody>
    EOF;
    for ($index = 0; $index < min( count($rows), 25); $index++) {
        $rank = $index + 1;
        $title = $rows[$index]->getDimensions()[0];
        $path = $rows[$index]->getDimensions()[1];

        $pageviewsRaw = $rows[$index]->getMetrics()[0]->getValues()[0];
        $uniquePageviewsRaw = $rows[$index]->getMetrics()[0]->getValues()[1];
        $avgTimeOnPageRaw = $rows[$index]->getMetrics()[0]->getValues()[2];
        $entrancesRaw = $rows[$index]->getMetrics()[0]->getValues()[3];
        $bounceRateRaw = $rows[$index]->getMetrics()[0]->getValues()[4];
        $exitRateRaw = $rows[$index]->getMetrics()[0]->getValues()[5];
        $pageValueRaw = $rows[$index]->getMetrics()[0]->getValues()[6];

        $pageviews = number_format($pageviewsRaw);
        $uniquePageviews = number_format($uniquePageviewsRaw);
        $avgTimeOnPage = gmdate("H:i:s", $avgTimeOnPageRaw);
        $entrances = number_format($entrancesRaw);
        $bounceRate = round($bounceRateRaw, 2);
        $exitRate = round($exitRateRaw, 2);
        $pageValue = round($pageValueRaw, 2);

        if ( $totalPageviewsRaw == 0 ) {
            $pageviews_percentage = 0;
        } else {
            $pageviews_percentage = round($pageviewsRaw / $totalPageviewsRaw * 100, 2);
        }
        if ( $totalUniquePageviewsRaw == 0 ) {
            $uniquePageviews_percentage = 0;
        } else {
            $uniquePageviews_percentage = round($uniquePageviewsRaw / $totalUniquePageviewsRaw * 100, 2);
        }
        if ( $totalEntrancesRaw == 0 ) {
            $entrances_percentage = 0;
        } else {
            $entrances_percentage = round($entrancesRaw / $totalEntrancesRaw * 100, 2);
        }
        if ( $totalPageValueRaw == 0 ) {
            $pageValue_percentage = 0;
        } else {
            $pageValue_percentage = round($pageValueRaw / $totalPageValueRaw * 100, 2);
        }

        echo <<<EOF
            <tr>
                <td class="rank">$rank</td>
                <td class="title-col"><a href="{$siteUrl}{$path}" target="_blank">$title</a></td>
                <td>$pageviews<br><span class="small">({$pageviews_percentage}%)</span></td>
                <td>$uniquePageviews<br><span class="small">({$uniquePageviews_percentage}%)</span></td>
                <td>$avgTimeOnPage</td>
                <td>$entrances<br><span class="small">({$entrances_percentage}%)</span></td>
                <td>{$bounceRate}%</td>
                <td>{$exitRate}%</td>
                <td>$$pageValue<br><span class="small">({$pageValue_percentage}%)</span></td>
            </tr>
        EOF;
    }
    echo "</tbody></table>";
}
pagesResults($pagesResponse, $siteUrl);
?>
</section>