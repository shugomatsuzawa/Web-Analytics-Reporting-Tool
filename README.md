# アクセス解析レポート作成プログラム（Webサーバーアプリケーション版）
Web制作会社の社内アプリケーションとして開発されたプログラムです。  
GoogleアナリティクスとGoogleサーチコンソールからデータを収集し、顧客に提出するための印刷やPDF出力を想定したアクセス解析レポートを作成します。  
一般的なレンタルサーバーにインストールし、ブラウザから操作できます。

**このプログラムはユニバーサルアナリティクスプロパティにのみ対応しています。  
新しい Google アナリティクス 4 プロパティでは使用できません。**

## インストール
### 新規のインストールの場合
プログラムのファイルをサーバーにコピーします。  
まずサーバーにSSHで接続してください。  
```bash
cd ~/www #任意のWebサーバーディレクトリに移動してください。
git clone git@github.com:shugomatsuzawa/Web-Analytics-Reporting-Tool.git
```
複数のGoogleアカウントを使用するなどの理由で、複数のプログラムをインストールする場合は、ディレクトリをリネームします。  
```bash
mv Web-Analytics-Reporting-Tool/ 任意の名前/
```
顧客の重要な情報を扱いますので、このディレクトリにはBasic認証等の設定を推奨します。  
### アップデートの場合
古いプログラムディレクトリの名前を変更しておきます。  
```bash
# 例
cd ~/www
mv Web-Analytics-Reporting-Tool/ Web-Analytics-Reporting-Tool-old/
```
ファイルをダウンロードします。  
必要な場合はディレクトリをリネームします。  
```bash
git clone git@github.com:shugomatsuzawa/Web-Analytics-Reporting-Tool.git
```
ユーザーディレクトリをコピーします。  
Basic認証を設定している場合は、```.htaccess```、```.htpasswd```もコピーしておきます。  
```bash
# 例
cp -r Web-Analytics-Reporting-Tool-old/user/ Web-Analytics-Reporting-Tool/
cp -fa Web-Analytics-Reporting-Tool-old/.htaccess Web-Analytics-Reporting-Tool-old/.htpasswd Web-Analytics-Reporting-Tool
```
問題なければ古いディレクトリを削除します。  
```bash
# 例
rm -r Web-Analytics-Reporting-Tool-old
```

### 認証情報の追加
[Google API コンソール](https://console.developers.google.com/apis/)にアクセスし、次のAPIを有効にします。
- Analytics Reporting API
- Google Search Console API

サービスアカウントを取得し、使用するアナリティクス・サーチコンソールアカウントに登録します。

JSONキーファイルをサーバーに保存し、設定にファイルの場所を記入します。

### データベースの準備
このプログラム専有のMySQLデータベースが必要です。  
複数のテーブルを登録可能です。  
カラムの例は次の通りです。
Field | Type | Key | 説明 | 例
-|-|-|-|-
viewId | int | PRI | Google アナリティクスのビューID | 123456789
name | varchar | | 顧客名 | 〇〇株式会社
siteName | varchar | | サイト名（マルチサイトの場合に必要） | 通販サイト
url | varchar | | サイトのURL | https://example.com
searchConsole | tinyint(1) | | サーチコンソールの使用（使用する場合は 1） | 1
keyword | text | | ランキングの設定キーワード（カンマ区切り） | キーワード,キーワード,キーワード,キーワード,キーワード

設定に必要な情報を入力し、データベースを登録します。

## ヘルプと連絡先
### 製作者
- [松沢 柊吾](https://github.com/shugomatsuzawa)