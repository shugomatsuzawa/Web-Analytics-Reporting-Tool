<section id="referrals">
    <div class="title">
<?php
if ( !empty($pythonPath) && ($enableSC == 1) ) {
    echo '<h2>5. 参照元サイト</h2>';
} else {
    echo '<h2>4. 参照元サイト</h2>';
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
function referralsUsersChart($reports) {
    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $dateRaw[$index] = $rows[$index]->getDimensions()[0];
        $date[$index] = date('n月j日' ,strtotime( substr("$dateRaw[$index]", 0, 4) . '-' . substr("$dateRaw[$index]", 4, 2) . '-' . substr("$dateRaw[$index]", 6) ));
        $users[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $usersJson = json_encode($users);

    echo <<<EOF
    <section class="mainChart">
        <canvas id="referralsUsersChart"></canvas>
        <script>
        var ctx = document.getElementById("referralsUsersChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'ユーザー',
                        data: $usersJson,
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
referralsUsersChart($usersChartResponse);
?>
<?php
$referralsMetrics = array($users, $newUsers, $sessions, $bounceRate, $pageviewsPerSession, $avgSessionDuration, $goalConversionRate, $goalCompletions, $goalValue);
$referralsDimensions = array($source);
$referralsOrder = 'ga:users';
$referralsResponse = getReport($analytics, $viewId, $startDate, $endDate, $referralsMetrics, $referralsDimensions, $referralsOrder);

function referralsResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];

    $totalUsersRaw = $totals[0];
    $totalNewUsersRaw = $totals[1];
    $totalSessionsRaw = $totals[2];
    $totalBounceRateRaw = $totals[3];
    $totalPageviewsPerSessionRaw = $totals[4];
    $totalAvgSessionDurationRaw = $totals[5];
    $totalGoalConversionRateRaw = $totals[6];
    $totalGoalCompletionsRaw = $totals[7];
    $totalGoalValueRaw = $totals[8];

    $totalUsers = number_format($totalUsersRaw);
    $totalNewUsers = number_format($totalNewUsersRaw);
    $totalSessions = number_format($totalSessionsRaw);
    $totalBounceRate = round($totalBounceRateRaw, 2);
    $totalPageviewsPerSession = round($totalPageviewsPerSessionRaw, 2);
    $totalAvgSessionDuration = gmdate("H:i:s", $totalAvgSessionDurationRaw);
    $totalGoalConversionRate = round($totalGoalConversionRateRaw, 2);
    $totalGoalCompletions = number_format($totalGoalCompletionsRaw);
    $totalGoalValue = round($totalGoalValueRaw, 2);

    if ( $totalUsersRaw == 0 ) {
        $totalUsers_percentage = 0;
    } else {
        $totalUsers_percentage = round($totalUsersRaw / $totalUsersRaw * 100, 2);
    }
    if ( $totalNewUsersRaw == 0 ) {
        $totalNewUsers_percentage = 0;
    } else {
        $totalNewUsers_percentage = round($totalNewUsersRaw / $totalNewUsersRaw * 100, 2);
    }
    if ( $totalSessionsRaw == 0 ) {
        $totalSessions_percentage = 0;
    } else {
        $totalSessions_percentage = round($totalSessionsRaw / $totalSessionsRaw * 100, 2);
    }
    if ( $totalBounceRateRaw == 0 ) {
        $totalBounceRate_avgPercentage = 0;
    } else {
        $totalBounceRate_avgPercentage = round($totalBounceRateRaw / $totalBounceRateRaw * 100 - 100, 2);
    }
    if ( $totalPageviewsPerSessionRaw == 0 ) {
        $totalPageviewsPerSession_avgPercentage = 0;
    } else {
        $totalPageviewsPerSession_avgPercentage = round($totalPageviewsPerSessionRaw / $totalPageviewsPerSessionRaw * 100 - 100, 2);
    }
    if ( $totalAvgSessionDurationRaw == 0 ) {
        $totalAvgSessionDuration_avgPercentage = 0;
    } else {
        $totalAvgSessionDuration_avgPercentage = round($totalAvgSessionDurationRaw / $totalAvgSessionDurationRaw * 100 - 100, 2);
    }
    if ( $totalGoalConversionRateRaw == 0 ) {
        $totalGoalConversionRate_avgPercentage = 0;
    } else {
        $totalGoalConversionRate_avgPercentage = round($totalGoalConversionRateRaw / $totalGoalConversionRateRaw * 100 - 100, 2);
    }
    if ( $totalGoalCompletionsRaw == 0 ) {
        $totalGoalCompletions_percentage = 0;
    } else {
        $totalGoalCompletions_percentage = round($totalGoalCompletionsRaw / $totalGoalCompletionsRaw * 100, 2);
    }
    if ( $totalGoalValueRaw == 0 ) {
        $totalGoalValue_percentage = 0;
    } else {
        $totalGoalValue_percentage = round($totalGoalValueRaw / $totalGoalValueRaw * 100, 2);
    }

    $rows = $reports->getReports()[0]->getData()->getRows();
    echo <<<EOF
    <table>
        <colgroup>
            <col span="2">
            <col class="active">
            <col span="8">
        </colgroup>
        <thead>
            <tr>
                <th colspan="2" rowspan="2">参照元</th>
                <th colspan="3">集客</th>
                <th colspan="3">行動</th>
                <th colspan="3">コンバージョン<wbr>（すべての目標）</th>
            </tr>
            <tr>
                <th>ユーザー</th>
                <th>新規<wbr>ユーザー</th>
                <th>セッション</th>
                <th>直帰率</th>
                <th>ページ/<wbr>セッション</th>
                <th>平均<wbr>セッション<wbr>時間</th>
                <th>コンバージョン<wbr>率</th>
                <th>目標の<wbr>完了数</th>
                <th>目標値</th>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>$totalUsers<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalUsers_percentage}%<br>($totalUsers)</span></td>
                <td>$totalNewUsers<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalNewUsers_percentage}%<br>($totalNewUsers)</span></td>
                <td>$totalSessions<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalSessions_percentage}%<br>($totalSessions)</span></td>
                <td>{$totalBounceRate}%<br><span class="small">ビューの<wbr>平均：<br>{$totalBounceRate}%<br>({$totalBounceRate_avgPercentage}%)</span></td>
                <td>$totalPageviewsPerSession<br><span class="small">ビューの<wbr>平均：<br>$totalPageviewsPerSession<br>({$totalPageviewsPerSession_avgPercentage}%)</span></td>
                <td>$totalAvgSessionDuration<br><span class="small">ビューの<wbr>平均：<br>$totalAvgSessionDuration<br>({$totalAvgSessionDuration_avgPercentage}%)</span></td>
                <td>{$totalGoalConversionRate}%<br><span class="small">ビューの<wbr>平均：<br>{$totalGoalConversionRate}%<br>({$totalGoalConversionRate_avgPercentage}%)</span></td>
                <td>$totalGoalCompletions<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalGoalCompletions_percentage}%<br>($totalGoalCompletions)</span></td>
                <td>$$totalGoalValue<br><span class="small">全体に<wbr>対する<wbr>割合：<br>{$totalGoalValue_percentage}%<br>($$totalGoalValue)</span></td>
            </tr>
        </thead>
        <tbody>
    EOF;
    for ($index = 0; $index < min( count($rows), 25); $index++) {
        $rank = $index + 1;
        $title = $rows[$index]->getDimensions()[0];

        $usersRaw = $rows[$index]->getMetrics()[0]->getValues()[0];
        $newUsersRaw = $rows[$index]->getMetrics()[0]->getValues()[1];
        $sessionsRaw = $rows[$index]->getMetrics()[0]->getValues()[2];
        $bounceRateRaw = $rows[$index]->getMetrics()[0]->getValues()[3];
        $pageviewsPerSessionRaw = $rows[$index]->getMetrics()[0]->getValues()[4];
        $avgSessionDurationRaw = $rows[$index]->getMetrics()[0]->getValues()[5];
        $goalConversionRateRaw = $rows[$index]->getMetrics()[0]->getValues()[6];
        $goalCompletionsRaw = $rows[$index]->getMetrics()[0]->getValues()[7];
        $goalValueRaw = $rows[$index]->getMetrics()[0]->getValues()[8];

        $users = number_format($usersRaw);
        $newUsers = number_format($newUsersRaw);
        $sessions = number_format($sessionsRaw);
        $bounceRate = round($bounceRateRaw, 2);
        $pageviewsPerSession = round($pageviewsPerSessionRaw, 2);
        $avgSessionDuration = gmdate("H:i:s", $avgSessionDurationRaw);
        $goalConversionRate = round($goalConversionRateRaw, 2);
        $goalCompletions = number_format($goalCompletionsRaw);
        $goalValue = round($goalValueRaw, 2);

        if ( $totalUsersRaw == 0 ) {
            $users_percentage = 0;
        } else {
            $users_percentage = round($usersRaw / $totalUsersRaw * 100, 2);
        }
        if ( $totalNewUsersRaw == 0 ) {
            $newUsers_percentage = 0;
        } else {
            $newUsers_percentage = round($newUsersRaw / $totalNewUsersRaw * 100, 2);
        }
        if ( $totalSessionsRaw == 0 ) {
            $sessions_percentage = 0;
        } else {
            $sessions_percentage = round($sessionsRaw / $totalSessionsRaw * 100, 2);
        }
        if ( $totalGoalCompletionsRaw == 0 ) {
            $goalCompletions_percentage = 0;
        } else {
            $goalCompletions_percentage = round($goalCompletionsRaw / $totalGoalCompletionsRaw * 100, 2);
        }
        if ( $totalGoalValueRaw == 0 ) {
            $goalValue_percentage = 0;
        } else {
            $goalValue_percentage = round($goalValueRaw / $totalGoalValueRaw * 100, 2);
        }

        echo <<<EOF
            <tr>
                <td class="rank">$rank</td>
                <td class="title-col">$title</td>
                <td>$users<br><span class="small">({$users_percentage}%)</span></td>
                <td>$newUsers<br><span class="small">({$newUsers_percentage}%)</span></td>
                <td>$sessions<br><span class="small">({$sessions_percentage}%)</span></td>
                <td>{$bounceRate}%</td>
                <td>$pageviewsPerSession</td>
                <td>$avgSessionDuration</td>
                <td>{$goalConversionRate}%</td>
                <td>$goalCompletions<br><span class="small">({$goalCompletions_percentage}%)</span></td>
                <td>$$goalValue<br><span class="small">({$goalValue_percentage}%)</span></td>
            </tr>
        EOF;
    }
    echo "</tbody></table>";
}
referralsResults($referralsResponse);
?>
</section>