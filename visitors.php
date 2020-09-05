<section id="visitors">
    <div class="title">
        <h2>1. ユーザーサマリー</h2>
<?php
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
function visitorsChart($reports) {
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
        <canvas id="visitorsChart"></canvas>
        <script>
        var ctx = document.getElementById("visitorsChart");
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
visitorsChart($usersChartResponse);
?>
    <section class="summaryChart">
        <section class="miniChart">
<?php
function visitorsUsersResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalUsers = number_format($totals[0]);
    echo <<<EOF
    <section>
        <h3>ユーザー</h3>
        <p>$totalUsers</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $users[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $usersJson = json_encode($users);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsUsersChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsUsersChart");
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
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsUsersResults($usersChartResponse);


$visitorsNewUsersMetrics = array($newUsers);
$visitorsNewUsersDimensions = array($date);
$visitorsNewUsersResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsNewUsersMetrics, $visitorsNewUsersDimensions, $noOrder);

function visitorsNewUsersResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalNewUsers = number_format($totals[0]);
    echo <<<EOF
    <section>
        <h3>新規ユーザー</h3>
        <p>$totalNewUsers</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $newUsers[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $newUsersJson = json_encode($newUsers);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsNewUsersChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsNewUsersChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: '新規ユーザー',
                        data: $newUsersJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsNewUsersResults($visitorsNewUsersResponse);


$visitorsSessionsMetrics = array($sessions);
$visitorsSessionsDimensions = array($date);
$visitorsSessionsResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsSessionsMetrics, $visitorsSessionsDimensions, $noOrder);

function visitorsSessionsResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalSessions = number_format($totals[0]);
    echo <<<EOF
    <section>
        <h3>セッション</h3>
        <p>$totalSessions</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $sessions[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $sessionsJson = json_encode($sessions);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsSessionsChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsSessionsChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'セッション',
                        data: $sessionsJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsSessionsResults($visitorsSessionsResponse);


$visitorsSessionsPerUserMetrics = array($sessionsPerUser);
$visitorsSessionsPerUserDimensions = array($date);
$visitorsSessionsPerUserResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsSessionsPerUserMetrics, $visitorsSessionsPerUserDimensions, $noOrder);

function visitorsSessionsPerUserResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalSessionsPerUser = round($totals[0], 2);
    echo <<<EOF
    <section>
        <h3>ユーザーあたりのセッション数</h3>
        <p>$totalSessionsPerUser</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $sessionsPerUser[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $sessionsPerUserJson = json_encode($sessionsPerUser);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsSessionsPerUserChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsSessionsPerUserChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'ユーザーあたりのセッション数',
                        data: $sessionsPerUserJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsSessionsPerUserResults($visitorsSessionsPerUserResponse);


$visitorsPageviewsMetrics = array($pageviews);
$visitorsPageviewsDimensions = array($date);
$visitorsPageviewsResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsPageviewsMetrics, $visitorsPageviewsDimensions, $noOrder);

function visitorsPageviewsResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalPageviews = number_format($totals[0]);
    echo <<<EOF
    <section>
        <h3>ページビュー数</h3>
        <p>$totalPageviews</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $pageviews[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $pageviewsJson = json_encode($pageviews);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsPageviewsChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsPageviewsChart");
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
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsPageviewsResults($visitorsPageviewsResponse);


$visitorsPageviewsPerSessionMetrics = array($pageviewsPerSession);
$visitorsPageviewsPerSessionDimensions = array($date);
$visitorsPageviewsPerSessionResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsPageviewsPerSessionMetrics, $visitorsPageviewsPerSessionDimensions, $noOrder);

function visitorsPageviewsPerSessionResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalPageviewsPerSession = round($totals[0], 2);
    echo <<<EOF
    <section>
        <h3>ページ/セッション</h3>
        <p>$totalPageviewsPerSession</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $pageviewsPerSession[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $pageviewsPerSessionJson = json_encode($pageviewsPerSession);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsPageviewsPerSessionChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsPageviewsPerSessionChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: 'ページ/セッション',
                        data: $pageviewsPerSessionJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsPageviewsPerSessionResults($visitorsPageviewsPerSessionResponse);


$visitorsAvgSessionDurationMetrics = array($avgSessionDuration);
$visitorsAvgSessionDurationDimensions = array($date);
$visitorsAvgSessionDurationResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsAvgSessionDurationMetrics, $visitorsAvgSessionDurationDimensions, $noOrder);

function visitorsAvgSessionDurationResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalAvgSessionDuration = gmdate("H:i:s", $totals[0]);
    echo <<<EOF
    <section>
        <h3>平均セッション時間</h3>
        <p>$totalAvgSessionDuration</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $avgSessionDuration[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $avgSessionDurationJson = json_encode($avgSessionDuration);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsAvgSessionDurationChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsAvgSessionDurationChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: '平均セッション時間',
                        data: $avgSessionDurationJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsAvgSessionDurationResults($visitorsAvgSessionDurationResponse);


$visitorsBounceRateMetrics = array($bounceRate);
$visitorsBounceRateDimensions = array($date);
$visitorsBounceRateResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsBounceRateMetrics, $visitorsBounceRateDimensions, $noOrder);

function visitorsBounceRateResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalBounceRate = round($totals[0], 2);
    echo <<<EOF
    <section>
        <h3>直帰率</h3>
        <p>{$totalBounceRate}%</p>
    EOF;

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $date[$index] = $rows[$index]->getDimensions()[0];
        $bounceRate[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
    }
    $dateJson = json_encode($date);
    $bounceRateJson = json_encode($bounceRate);

    echo <<<EOF
        <div class="miniChartWrapper">
            <canvas id="visitorsBounceRateChart"></canvas>
        </div>
        <script>
        var ctx = document.getElementById("visitorsBounceRateChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $dateJson,
                datasets: [
                    {
                        label: '直帰率',
                        data: $bounceRateJson,
                        borderColor: "#068dc7",
                        backgroundColor: "#068dc722",
                        pointBorderColor: "#068dc700",
                        pointBackgroundColor: "#068dc700"
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
        </script>
    </section>
    EOF;
}
visitorsBounceRateResults($visitorsBounceRateResponse);
?>
        </section>
<?php
$visitorsUserTypeMetrics = array($users);
$visitorsUserTypeDimensions = array($userType);
$visitorsUserTypeResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsUserTypeMetrics, $visitorsUserTypeDimensions, $noOrder);

function visitorsUserTypeResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalUsers = $totals[0];

    $rows = $reports->getReports()[0]->getData()->getRows();
    for ($index = 0; $index < count($rows); $index++) {
        $userType[$index] = $rows[$index]->getDimensions()[0];
        $users[$index] = $rows[$index]->getMetrics()[0]->getValues()[0];
        $usersRate[$index] = $users[$index] / $totalUsers * 100;
    }
    $userTypeJson = json_encode($userType);
    $usersRateJson = json_encode($usersRate);

    echo <<<EOF
    <section>
        <canvas id="visitorsUserTypeChart"></canvas>
        <script>
        var ctx = document.getElementById("visitorsUserTypeChart");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: $userTypeJson,
                datasets: [
                    {
                        data: $usersRateJson,
                        backgroundColor: ["#058dc7", "#50b432"]
                    }
                ]
            },
            options: {
                aspectRatio: 1
            }
        });
        </script>
    </section>
    EOF;
}
visitorsUserTypeResults($visitorsUserTypeResponse);
?>
    </section>
<?php
$visitorsMetrics = array($users, $newUsers);
$visitorsDimensions = array($operatingSystem);
$visitorsOrder = 'ga:users';
$visitorsResponse = getReport($analytics, $viewId, $startDate, $endDate, $visitorsMetrics, $visitorsDimensions, $visitorsOrder);

function visitorsOsResults($reports) {
    $totals = $reports->getReports()[0]->getData()->getTotals()[0]['values'];
    $totalUsersRaw = $totals[0];

    $rows = $reports->getReports()[0]->getData()->getRows();
    echo <<<EOF
    <table>
        <thead>
            <tr>
                <th></th>
                <th>オペレーティングシステム</th>
                <th>ユーザー</th>
                <th>ユーザー（%）</th>
            </tr>
        </thead>
        <tbody>
    EOF;
    for ($index = 0; $index < min( count($rows), 25); $index++) {
        $rank = $index + 1;
        $operatingSystem = $rows[$index]->getDimensions()[0];

        $usersRaw = $rows[$index]->getMetrics()[0]->getValues()[0];
        $usersRateRaw = $usersRaw / $totalUsersRaw * 100;

        $users = number_format($usersRaw);
        $usersRate = round($usersRateRaw, 2);
        echo <<<EOF
        <tr>
            <td class="rank">$rank</td>
            <td>$operatingSystem</td>
            <td>$users</td>
            <td style="background: linear-gradient(to right, #068dc722 {$usersRateRaw}%, #fff {$usersRateRaw}%);">{$usersRate}%</td>
        </tr>
        EOF;
    }
    echo "</tbody></table>";
}
visitorsOsResults($visitorsResponse);
?>
</section>