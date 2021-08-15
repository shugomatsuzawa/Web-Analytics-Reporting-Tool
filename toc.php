<section id="toc">
    <div class="title">
        <h2>アクセス解析 レポート（目次）</h2>
<?php
if ( empty($siteName) ) {
    echo '<p>' . $clientName . '</p>';
} else {
    echo '<p>' . $siteName . '（' . $clientName . '）</p>';
}
?>
    </div>
    <p>1ヶ月間に御社のWebサイトを閲覧したユーザー数・行動などをレポートしたものです。レポートの掲載内容は下記のとおりです。</p>
    <section>
        <h3>1.ユーザーサマリー</h3>
        <p>サイトアクセスの全体像です。</p>
        <table>
            <thead>
                <tr>
                    <th>表示項目</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>セッション・ユーザー</td>
                    <td>サイトに訪れた回数・人数</td>
                </tr>
                <tr>
                    <td>ページビュー数</td>
                    <td>総表示ページ数</td>
                </tr>
                <tr>
                    <td>ページ/セッション</td>
                    <td>サイトに訪れた方が見た平均ページ数</td>
                </tr>
                <tr>
                    <td>平均セッション時間</td>
                    <td>サイトに訪れた方の平均滞在時間</td>
                </tr>
                <tr>
                    <td>直帰率</td>
                    <td>最初の1ページを見てサイトを離れた割合（新規客）</td>
                </tr>
                <tr>
                    <td>オペレーティングシステム</td>
                    <td>パソコン端末または、モバイル端末からの閲覧</td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php if ( $enableSC == 1 ): ?>
    <section>
        <h3>2.検索クエリ</h3>
        <p>ユーザーが Google で検索したクエリ文字列（キーワード）の検索結果の一覧です。</p>
        <table>
            <thead>
                <tr>
                    <th>表示項目</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>検索クエリ</td>
                    <td>検索で当サイトが表示された時のキーワード</td>
                </tr>
                <tr>
                    <td>クリック数</td>
                    <td>検索クエリで表示され、クリックされた回数</td>
                </tr>
                <tr>
                    <td>表示回数</td>
                    <td>検索クエリで表示された回数</td>
                </tr>
                <tr>
                    <td>クリック率</td>
                    <td>表示回数に対するクリック数の割合</td>
                </tr>
                <tr>
                    <td>平均掲載順位</td>
                    <td>検索クエリで表示された平均掲載順位</td>
                </tr>
            </tbody>
        </table>
    </section>
    <?php endif; ?>
    <section>
        <h3><?php if ( $enableSC == 1 ) { echo '3'; } else { echo '2'; } ?>.検索キーワード</h3>
        <p>当サイトのアクセスにおいて、参照元（検索エンジン、ブックマーク、SNS、参照サイト等）で使われたキーワードの一覧です。</p>
        <table>
            <thead>
                <tr>
                    <th>表示項目</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>新規ユーザー</td>
                    <td>新規に訪れた方の人数</td>
                </tr>
                <tr>
                    <td>セッション</td>
                    <td>サイトに訪れた回数</td>
                </tr>
                <tr>
                    <td>直帰率</td>
                    <td>最初の1ページだけ見てサイトを離た割合（新規客）</td>
                </tr>
                <tr>
                    <td>ページ/セッション</td>
                    <td>サイトに訪れた方が見た平均ページ数</td>
                </tr>
                <tr>
                    <td>平均セッション時間</td>
                    <td>サイトに訪れた方の平均滞在時間</td>
                </tr>
                <tr>
                    <td>コンバージョン※</td>
                    <td>ユーザの重要な操作が完了すること。例）サイト訪問→購入申し込み</td>
                </tr>
            </tbody>
        </table>
        <p>※コンバージョンデータを表示するためには、あらかじめ目標を設定することが必要です。</p>
    </section>
    <section>
        <h3><?php if ( $enableSC == 1 ) { echo '4'; } else { echo '3'; } ?>.参照ページ</h3>
        <p>ページ毎のアクセス数の概要です。</p>
        <table>
            <thead>
                <tr>
                    <th>表示項目</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ページビュー数</td>
                    <td>総表示ページ数</td>
                </tr>
                <tr>
                    <td>ページ別訪問数</td>
                    <td>当該ページに訪れた人数</td>
                </tr>
                <tr>
                    <td>平均ページ滞在時間</td>
                    <td>当該ページに訪れた方の平均滞在時間</td>
                </tr>
                <tr>
                    <td>閲覧開始数</td>
                    <td>当該ページに外部サイトから入ってきた数</td>
                </tr>
                <tr>
                    <td>直帰率</td>
                    <td>当該ページから入って他のページを見ないで離脱</td>
                </tr>
                <tr>
                    <td>離脱率</td>
                    <td>複数ページを見て当該ページで最後に離脱した割合</td>
                </tr>
                <tr>
                    <td>ページの価値</td>
                    <td>販売サイトの場合の売上成果</td>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="page-break">
        <h3><?php if ( $enableSC == 1 ) { echo '5'; } else { echo '4'; } ?>.参照元サイト</h3>
        <p>当サイトへの流入元、たとえば検索エンジン（Google など）やドメイン（example.com）の一覧です。</p>
        <table>
            <thead>
                <tr>
                    <th>レポート内の表記例</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>google, yahoo</td>
                    <td>Google、Yahooを利用した通常検索による流入</td>
                </tr>
                <tr>
                    <td>(direct)</td>
                    <td>ユーザーがブラウザに直接 URL を入力した場合や、ブックマーク経由での流入</td>
                </tr>
                <tr>
                    <td>***.com</td>
                    <td>当サイトを参照しているドメイン（サイト）***.com からの流入</td>
                </tr>
            </tbody>
        </table>
    </section>
    <section>
        <h3><?php if ( $enableSC == 1 ) { echo '6'; } else { echo '5'; } ?>.地域/ユーザー分布</h3>
        <p>どの地域からのアクセスが多いかを表示しています。</p>
    </section>
    <aside>
        <h3><i class="far fa-question-circle" aria-hidden="true"></i>&nbsp;レポート内の英文表記 (not provided) (not set) について</h3>
        <dl>
            <dt>(not provided)</dt>
            <dd><?php if ( $enableSC == 1 ) { echo '「3.検索キーワード」のレポートに現れます。GoogleやYahoo等の検索エンジンがHTTPS（SSL通信）で暗号化され、検索キーワードが取れないためです。 尚、「2.検索クエリ」レポートは、検索解析専用のGoogle Search Consoleと連携しているので、Google検索のデータのみですが、ユーザの検索キーワードの傾向を確認することができます。'; } else { echo '「2.検索キーワード」のレポートに現れます。GoogleやYahoo等の検索エンジンがHTTPS（SSL通信）で暗号化され、検索キーワードが取れないためです。'; } ?></dd>
            <dt>(not set)</dt>
            <dd>リダイレクトによって参照元の情報が取得できなかった等、Googleアナリティクスの各レポート上の項目が何らかの事情によりデータを取得できなかった時に表示されます。従って、検索キーワードに限らず、各レポートのどの項目も(not set)となる可能性があります。</dd>
        </dl>
    </aside>
</section>