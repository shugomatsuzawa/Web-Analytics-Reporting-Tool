<?php
// エラーを出力する
ini_set('display_errors', "On");


// Config パス
$configFile = 'user/config.php';

if ( isset($_POST['keyFile']) && isset($_POST['sqlServer']) && isset($_POST['sqlUsername']) && isset($_POST['sqlPassword']) && isset($_POST['sqlDbName']) && isset($_POST['publisherName']) ) {
    // config作成
    $config['keyFile'] = $_POST['keyFile'];
    $config['scKeyFile'] = $_POST['scKeyFile'];

    $config['sqlServer'] = $_POST['sqlServer'];
    $config['sqlUsername'] = $_POST['sqlUsername'];
    $config['sqlPassword'] = $_POST['sqlPassword'];
    $config['sqlDbName'] = $_POST['sqlDbName'];

    $config['pythonPath'] = $_POST['pythonPath'];

    $config['programName'] = $_POST['programName'];
    $config['publisherName'] = $_POST['publisherName'];
    $config['publisherLogo'] = $_POST['publisherLogo'];
    $publisherAddressRaw = $_POST['publisherAddress'];
    $config['publisherAddress'] = str_replace('\n', '', $publisherAddressRaw);

    // configファイル上書き保存
    $configFile = 'user/config.php';
    file_put_contents($configFile, '<?php return ' . var_export($config, true) . ';');
}

// Config 読込み
if ( file_exists($configFile) ) {
    $config = require $configFile;
}

?>
<!DOCTYPE html>
<html>
<head>
<?php
if ( empty($config['programName']) ) {
    echo '<title>設定 - アクセス解析レポート作成ツール</title>';
} else {
    echo '<title>設定 - ' . $config['programName'] . '</title>';
}
?>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta name="robots" content="noindex,nofollow">
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
    <h1>設定</h1>
    <a href="index.php" title="ホームに戻る"><i class="fas fa-home" aria-label="ホームに戻る"></i></a>
</aside>
<main class="settings">
<form action="settings.php" method="post">
    <fieldset>
        <legend>Googleアナリティクス・サーチコンソールの設定</legend>
        <p><a href="https://console.developers.google.com/apis/" target="_blank" rel="noopener">Google API コンソール <i class="fas fa-external-link-alt" aria-label="新しいタブで開く"></i></a>にアクセスし、次のAPIを有効にします。</p>
        <ul>
            <li>Analytics Reporting API</li>
            <li>Google Search Console API</li>
        </ul>
        <p>サービスアカウントを取得し、使用するアナリティクス・サーチコンソールアカウントに登録します。</p>
        <p>JSONキーファイルをサーバーにサップロードし、ファイルの場所を下記に記入します。</p>
        <label for="keyFile">Googleアナリティクス キーファイルへの相対パス：</label>
        <input type="text" name="keyFile" id="keyFile" inputmode="url" placeholder="user/key-files/my-project.json" value="<?php echo $config['keyFile']; ?>" required>
        <label for="scKeyFile">Googleサーチコンソール キーファイルへの相対パス（アナリティクスと共通の場合は空欄）：</label>
        <input type="text" name="scKeyFile" id="scKeyFile" inputmode="url" placeholder="user/key-files/my-project-sc.json" value="<?php echo $config['scKeyFile']; ?>">
    </fieldset>
    <fieldset>
        <legend>データベースの設定</legend>
        <p>このプログラム専有のMySQLデータベースが必要です。<br>複数のテーブルを登録可能です。<br>カラムの例は次の通りです。</p>
        <table>
            <thead>
                <tr><th>Field</th><th>Type</th><th>Key</th><th>説明</th><th>例</th></tr>
            </thead>
            <tbody>
                <tr><td>viewId</td><td>int</td><td>PRI</td><td>Google アナリティクスのビューID</td><td>123456789</td></tr>
                <tr><td>name</td><td>varchar</td><td></td><td>顧客名</td><td>〇〇株式会社</td></tr>
                <tr><td>siteName</td><td>varchar</td><td></td><td>サイト名（マルチサイトの場合に必要）</td><td>通販サイト</td></tr>
                <tr><td>url</td><td>varchar</td><td></td><td>サイトのURL</td><td>https://example.com</td></tr>
                <tr><td>searchConsole</td><td>tinyint(1)</td><td></td><td>サーチコンソールの使用（使用する場合は 1）</td><td>1</td></tr>
                <tr><td>keyword</td><td>text</td><td></td><td>ランキングの設定キーワード（カンマ区切り）</td><td>キーワード,キーワード,キーワード,キーワード,キーワード</td></tr>
            </tbody>
        </table>
        <label for="sqlServer">サーバーアドレス：</label>
        <input type="text" name="sqlServer" id="sqlServer" inputmode="url" placeholder="mysql.example.com" value="<?php echo $config['sqlServer']; ?>" required>
        <label for="sqlUsername">ユーザー名：</label>
        <input type="text" name="sqlUsername" id="sqlUsername" placeholder="username" value="<?php echo $config['sqlUsername']; ?>" required>
        <label for="sqlPassword">パスワード：</label>
        <input type="password" name="sqlPassword" placeholder="Password" value="<?php echo $config['sqlPassword']; ?>" id="sqlPassword" required>
        <label for="sqlDbName">データベース名：</label>
        <input type="text" name="sqlDbName" id="sqlDbName" placeholder="analytics_report" value="<?php echo $config['sqlDbName']; ?>" required>
    </fieldset>
    <fieldset>
        <legend>プログラムの設定</legend>
        <label for="pythonPath">Pythonのパス（サーチコンソールを使用する場合必要）：</label>
        <p>サーチコンソールを使用するには、Pythonが必要です。Python 3.8.x系に対応。<br>先にSSHでプログラムのディレクトリに移動し、requirements.txt の内容をインストールしてください。</p>
        <code>pip install -r requirements.txt</code>
        <p>サーバー上のPythonへの相対パスを記入します。</p>
        <input type="text" name="pythonPath" id="pythonPath" inputmode="url" placeholder="../../.pyenv/versions/3.8.5/bin/python" value="<?php echo $config['pythonPath']; ?>">
    </fieldset>
    <fieldset>
        <legend>発行者情報（会社情報）</legend>
        <label for="programName">プログラム名（任意）:</label>
        <input type="text" name="programName" id="programName" placeholder="アクセス解析レポート作成ツール" value="<?php echo $config['programName']; ?>">
        <label for="publisherName">発行者名:</label>
        <input type="text" name="publisherName" id="publisherName" placeholder="○○ Co., Ltd." value="<?php echo $config['publisherName']; ?>" required>
        <label for="publisherName">発行者ロゴ&lt;img&gt;タグ（任意）:</label>
        <input type="text" name="publisherLogo" id="publisherLogo" placeholder='<img src="user/images/logo.svg" alt="○○ Co., Ltd." width="300" height="64">' value='<?php echo $config["publisherLogo"]; ?>'>
        <label for="publisherAddress">発行者連絡先（任意）:</label>
        <p>レポート最終ページの、&lt;address&gt;HTML要素内に表示されます。HTMLタグを入力できます。</p>
        <textarea name="publisherAddress" id="publisherAddress" placeholder='<strong>株式会社○○</strong><br>〒000-0000 住所が入ります<br>TEL:(03)1234-5678 FAX:(03)1234-5679<br>E-Mail:info@example.com<br>URL:https://example.com'><?php echo $config['publisherAddress']; ?></textarea>
    </fieldset>
    <input type="submit" value="保存">
</form>
</main>
<aside id="legal-footer">
    <p>
        <a href="ThirdPartySoftwareLicense.txt" target="_blank" rel="noopener">サードパーティに関する通知 <i class="fas fa-external-link-alt"></i></a>&nbsp;|&nbsp;
        <a href="https://github.com/shugomatsuzawa/Web-Analytics-Reporting-Tool" target="_blank" rel="noopener">Webサイト アクセス解析レポートについて <i class="fas fa-external-link-alt"></i></a>&nbsp;|&nbsp;
        <small>バージョン 1.0 beta 1</small>
    </p>
</aside>
</body>
</html>