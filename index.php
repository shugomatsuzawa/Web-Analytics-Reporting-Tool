<?php
// エラー出力設定
ini_set('display_errors', "On");

// Google API クライアントライブラリの読込み
require_once __DIR__ . '/vendor/autoload.php';


// Config 読込み
$configFile = 'user/config.php';

if ( file_exists($configFile) ) {
    $config = require 'user/config.php';

    $keyFileLocation = __DIR__ . '/' . $config['keyFile'];
    if( empty($config['scKeyFile']) ) {
        $scKeyFileLocation = $config['keyFile'];
    } else {
        $scKeyFileLocation = $config['scKeyFile'];
    }
    $sqlServer = $config['sqlServer'];
    $sqlUsername = $config['sqlUsername'];
    $sqlPassword = $config['sqlPassword'];
    $sqlDbName = $config['sqlDbName'];
    $pythonPath = $config['pythonPath'];
    $programName = $config['programName'];
    $publisherName = $config['publisherName'];
    $publisherLogo = $config['publisherLogo'];
    $publisherAddress = $config['publisherAddress'];
}


// メトリクス・オブジェクトを作成
// ユーザー
$users = new Google_Service_AnalyticsReporting_Metric();
$users->setExpression("ga:users");
$users->setAlias("users");
// 新規ユーザー
$newUsers = new Google_Service_AnalyticsReporting_Metric();
$newUsers->setExpression("ga:newUsers");
$newUsers->setAlias("newUsers");
// セッション
$sessions = new Google_Service_AnalyticsReporting_Metric();
$sessions->setExpression("ga:sessions");
$sessions->setAlias("sessions");
// ユーザーあたりのセッション数
$sessionsPerUser = new Google_Service_AnalyticsReporting_Metric();
$sessionsPerUser->setExpression("ga:sessionsPerUser");
$sessionsPerUser->setAlias("sessionsPerUser");
// ページビュー数
$pageviews = new Google_Service_AnalyticsReporting_Metric();
$pageviews->setExpression("ga:pageviews");
$pageviews->setAlias("pageviews");
// ページ/セッション
$pageviewsPerSession = new Google_Service_AnalyticsReporting_Metric();
$pageviewsPerSession->setExpression("ga:pageviewsPerSession");
$pageviewsPerSession->setAlias("pageviewsPerSession");
// 平均セッション時間
$avgSessionDuration = new Google_Service_AnalyticsReporting_Metric();
$avgSessionDuration->setExpression("ga:avgSessionDuration");
$avgSessionDuration->setAlias("avgSessionDuration");
// 直帰率
$bounceRate = new Google_Service_AnalyticsReporting_Metric();
$bounceRate->setExpression("ga:bounceRate");
$bounceRate->setAlias("bounceRate");

// ページ別訪問数
$uniquePageviews = new Google_Service_AnalyticsReporting_Metric();
$uniquePageviews->setExpression("ga:uniquePageviews");
$uniquePageviews->setAlias("uniquePageviews");
// 平均ページ滞在時間
$avgTimeOnPage = new Google_Service_AnalyticsReporting_Metric();
$avgTimeOnPage->setExpression("ga:avgTimeOnPage");
$avgTimeOnPage->setAlias("avgTimeOnPage");
// 閲覧開始数
$entrances = new Google_Service_AnalyticsReporting_Metric();
$entrances->setExpression("ga:entrances");
$entrances->setAlias("entrances");
// 離脱率
$exitRate = new Google_Service_AnalyticsReporting_Metric();
$exitRate->setExpression("ga:exitRate");
$exitRate->setAlias("exitRate");
// ページの価値
$pageValue = new Google_Service_AnalyticsReporting_Metric();
$pageValue->setExpression("ga:pageValue");
$pageValue->setAlias("pageValue");

// コンバージョン率
$goalConversionRate = new Google_Service_AnalyticsReporting_Metric();
$goalConversionRate->setExpression("ga:goalConversionRateAll");
$goalConversionRate->setAlias("goalConversionRate");
// 目標の完了数
$goalCompletions = new Google_Service_AnalyticsReporting_Metric();
$goalCompletions->setExpression("ga:goalCompletionsAll");
$goalCompletions->setAlias("goalCompletions");
// 目標値
$goalValue = new Google_Service_AnalyticsReporting_Metric();
$goalValue->setExpression("ga:goalValueAll");
$goalValue->setAlias("goalValue");


// ディメンションを作成
// 日付
$date = new Google_Service_AnalyticsReporting_Dimension();
$date->setName('ga:date');
// ページタイトル
$pageTitle = new Google_Service_AnalyticsReporting_Dimension();
$pageTitle->setName('ga:pageTitle');
// ページ
$pagePath = new Google_Service_AnalyticsReporting_Dimension();
$pagePath->setName('ga:pagePath');
// ユーザータイプ
$userType = new Google_Service_AnalyticsReporting_Dimension();
$userType->setName('ga:userType');
// オペレーティングシステム
$operatingSystem = new Google_Service_AnalyticsReporting_Dimension();
$operatingSystem->setName('ga:operatingSystem');

// キーワード
$keyword = new Google_Service_AnalyticsReporting_Dimension();
$keyword->setName('ga:keyword');

// 参照元
$source = new Google_Service_AnalyticsReporting_Dimension();
$source->setName('ga:source');

// 市区町村
$city = new Google_Service_AnalyticsReporting_Dimension();
$city->setName('ga:city');


// オーダー
$noOrder = '';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta name="format-detection" content="telephone=no">
<meta name="color-scheme" content="light">
<?php
if ( empty($programName) ) {
    echo '<title>アクセス解析レポート作成ツール</title>';
} else {
    echo '<title>' . $programName . '</title>';
}
?>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
//ローディング表示
$(function() {
    $('#loader').css('display','flex');
});
$(window).on('load', function(){
    $('#loader').delay(600).fadeOut(300);
});
//10秒たったら強制的にロード画面を非表示
$(function(){
    setTimeout('stopload()',10000);
});
function stopload(){
    $('#loader').delay(600).fadeOut(300);
}
</script>
</head>

<body>
<aside id="toolbar">
    <div id="loader">
        <i class="fas fa-circle-notch"></i>
    </div>
<?php
if ( empty($programName) ) {
    echo '<h1>アクセス解析レポート作成ツール</h1>';
} else {
    echo '<h1>' . $programName . '</h1>';
}
?>
    <a href="settings.php" title="設定"><i class="fas fa-cog" aria-label="設定"></i></a>
<?php
if ( !file_exists($configFile) || empty($keyFileLocation) || empty($sqlServer) || empty($sqlUsername) || empty($sqlPassword) || empty($sqlDbName) || empty($publisherName) ): // Config チェック（エラー）
    echo <<<EOF
        </aside>
        <p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>設定ファイルにエラーが見つかりました。<br>
            <a href="settings.php">設定</a>から初期設定を行ってください。</p>
    EOF;

else: // Config チェック（正常）

    // mysqliクラスのオブジェクトを作成
    $mysqli = new mysqli($sqlServer, $sqlUsername, $sqlPassword, $sqlDbName);

    if ($mysqli->connect_error): // DB接続チェック（エラー）
        $sqlConnectError = $mysqli->connect_error;
        echo <<<EOF
            </aside>
            <p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>エラー<br>
                $sqlConnectError</p>
        EOF;

    else: // DB接続チェック（正常）
        $mysqli->set_charset("utf8");

        // 選択フォーム
        $sqlTableResult = $mysqli->query("SHOW TABLES FROM $sqlDbName");

        if (!$sqlTableResult): // テーブルチェック（エラー）
            $sqlTableError = $mysqli->error;
            echo <<<EOF
                </aside>
                <p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>エラー<br>
                    $sqlTableError</p>
            EOF;

        elseif ( ($sqlTableResult->num_rows) == 0 ): // テーブルチェック（テーブルなし）
            echo <<<EOF
                </aside>
                <p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>テーブルが見つかりませんでした。</p>
            EOF;

        else: // テーブルチェック（正常）
            echo <<<EOF
            <form action="index.php" method="get">
                <label for="view">ビュー：</label>
                <select name="view" id="view" required>
                    <option value="" disabled>-- ビューを選択してください --</option>
            EOF;
            while ( $sqlTable = $sqlTableResult->fetch_object() ) {
                $sqlTablesIn = 'Tables_in_' . $sqlDbName;
                $sqlTableName = $sqlTable->$sqlTablesIn;
                echo '<optgroup label="' . $sqlTableName . '">' . "\n";
                $sqlListResult = $mysqli->query("SELECT * FROM $sqlTableName");
                if (!$sqlListResult) {
                    $sqlListError = $mysqli->error;
                    echo '<option value="" disabled>エラー - ' . $sqlListError . "</option>\n";
                } elseif ( ($sqlListResult->num_rows) == 0 ) {
                    echo '<option value="" disabled>ビューがありません</option>' . "\n";
                } else {
                    while( $sqlList = $sqlListResult->fetch_object() ) {
                        if ( empty($sqlList->siteName) ) {
                            echo '<option value="' . $sqlList->viewId . '_in_' . $sqlTableName . '">' . $sqlList->name . "</option>\n";
                        } else {
                            echo '<option value="' . $sqlList->viewId . '_in_' . $sqlTableName . '">' . $sqlList->siteName . '（' . $sqlList->name . "）</option>\n";
                        }
                    }
                }
                echo "</optgroup>\n";
            }
            echo <<<EOF
                </select>
                <label for="startDate">期間の開始日：</label>
            EOF;
            echo '<input type="date" name="startDate" id="startDate" placeholder="YYYY-MM-DD" value="' . $_GET['startDate'] . '" required>' . "\n";
            echo '<label for="endDate">期間の終了日：</label>' . "\n";
            echo '<input type="date" name="endDate" id="endDate" placeholder="YYYY-MM-DD" value="' . $_GET['endDate'] . '" required>' . "\n";
            echo <<<EOF
                <input type="submit" value="適用">
            </form>
            EOF;
?>
</aside>
<?php
            if (!isset($_GET['view']) || !isset($_GET['startDate']) || !isset($_GET['endDate'])): // 選択フォーム入力判定（未入力）

                echo '<p class="notice"><i class="fas fa-info-circle" aria-label="情報"></i>ビュー未選択</p>';

                // DB接続を閉じる
                $mysqli->close();

            elseif (strtotime($_GET['startDate']) > strtotime($_GET['endDate'])): // 選択フォーム入力判定（日付無効）

                echo '<p class="notice"><i class="fas fa-info-circle" aria-label="情報"></i>日付が無効です</p>';

                // DB接続を閉じる
                $mysqli->close();

            else: // 選択フォーム入力判定（入力あり）

                $viewSelect = explode("_in_", $_GET['view']);

                // DB検索
                $sqlSearchResult = $mysqli->query("SELECT * FROM $viewSelect[1] WHERE viewId = $viewSelect[0]");
                if (!$sqlSearchResult) {
                    $sqlSearchError = $mysqli->error;
                    echo <<<EOF
                        <p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>エラー<br>
                            $sqlSearchError</p>
                    EOF;
                } else {
                    $sqlSearch = $sqlSearchResult->fetch_object();

                    $viewId = $sqlSearch->viewId;
                    $clientName = $sqlSearch->name;
                    $siteName = $sqlSearch->siteName;
                    $siteUrl = $sqlSearch->url;
                    $enableSC = $sqlSearch->searchConsole;
                    if ( !empty($sqlSearch->keyword) ) {
                        $siteKeyword = explode(",", $sqlSearch->keyword);
                    }
                }

                // DB接続を閉じる
                $mysqli->close();

                $startDate = $_GET['startDate'];
                $endDate = $_GET['endDate'];

                if ( empty($viewId) || empty($clientName) || empty($siteUrl) ): // 入力内容チェック（データエラー）
                    echo '<p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>正しくないデータベース形式</p>';

                elseif ( !strptime($startDate, '%Y-%m-%d') || !strptime($endDate, '%Y-%m-%d') ): // 入力内容チェック（日付エラー）
                    echo '<p class="notice"><i class="fas fa-exclamation-triangle" aria-label="警告"></i>正しくない日付形式</p>';
                
                else: // 入力内容チェック（正常）
                    $startDateDisplay = date('Y/m/d',strtotime($startDate));
                    $endDateDisplay = date('Y/m/d',strtotime($endDate));

                    // Analytics Reporting API V4サービスオブジェクトを初期化します。
                    function initializeAnalytics($KEY_FILE_LOCATION)
                    {
                        // Create and configure a new client object.
                        $client = new Google_Client();
                        $client->setApplicationName("Hello Analytics Reporting");
                        $client->setAuthConfig($KEY_FILE_LOCATION);
                        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
                        $analytics = new Google_Service_AnalyticsReporting($client);

                        return $analytics;
                    }

                    // Analytics Reporting API V4をクエリします。
                    $analytics = initializeAnalytics($keyFileLocation);
                    function getReport($analytics, $VIEW_ID, $startDate, $endDate, $metrics, $dimensions, $orderName) {
                        // DateRangeオブジェクトを作成します。
                        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
                        $dateRange->setStartDate($startDate);
                        $dateRange->setEndDate($endDate);

                        // Create sort order
                        $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
                        $orderBy->setFieldName($orderName);
                        $orderBy->setSortOrder('DESCENDING');

                        // ReportRequestオブジェクトを作成します。
                        $request = new Google_Service_AnalyticsReporting_ReportRequest();
                        $request->setViewId($VIEW_ID);
                        $request->setDateRanges($dateRange);
                        $request->setDimensions($dimensions);
                        $request->setMetrics($metrics);
                        if ( !empty($orderName) ) { $request->setOrderBys($orderBy); }

                        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
                        $body->setReportRequests( array( $request) );
                        return $analytics->reports->batchGet( $body );
                    }


                    // グラフ共通
                    // ユーザー
                    $usersChartMetrics = array($users);
                    $usersChartDimensions = array($date);
                    $usersChartResponse = getReport($analytics, $viewId, $startDate, $endDate, $usersChartMetrics, $usersChartDimensions, $noOrder);

                    // ページビュー数
                    $pageviewsChartMetrics = array($pageviews);
                    $pageviewsChartDimensions = array($date);
                    $pageviewsChartResponse = getReport($analytics, $viewId, $startDate, $endDate, $pageviewsChartMetrics, $pageviewsChartDimensions, $noOrder);

                    //SC共通
                    $queryCmd = "$pythonPath sc.py $scKeyFileLocation $siteUrl $startDate $endDate";
                    $queryResponseRaw = shell_exec($queryCmd);
                    $queryResponse = json_decode($queryResponseRaw,true);
?>
<?php include('firstPage.php'); ?>
<main class="home">
<?php
                    if ( !empty($pythonPath) && ($enableSC == 1) && !empty($siteKeyword) ) {
                        include('ranking.php');
                    }
                    include('toc.php');
                    include('visitors.php');
                    if ( !empty($pythonPath) && ($enableSC == 1) ) {
                        include('queries.php');
                    }
                    include('organic.php');
                    include('pages.php');
                    include('referrals.php');
                    include('geo.php');
?>
</main>
<?php
                    include('lastPage.php');
                endif; // 入力内容チェック
            endif; // 選択フォーム入力判定
        endif; // テーブルチェック
    endif; // DB接続チェック
endif; // Config チェック
?>
<aside id="legal-footer">
    <p>
        <a href="ThirdPartySoftwareLicense.txt" target="_blank" rel="noopener">サードパーティに関する通知 <i class="fas fa-external-link-alt" aria-label="新しいタブで開く"></i></a>&nbsp;|&nbsp;
        <a href="https://github.com/shugomatsuzawa/Web-Analytics-Reporting-Tool" target="_blank" rel="noopener">アクセス解析レポート作成ツールについて <i class="fas fa-external-link-alt" aria-label="新しいタブで開く"></i></a>&nbsp;|&nbsp;
        <small>バージョン 1.1 beta 1</small>
    </p>
</aside>
</body>
</html>