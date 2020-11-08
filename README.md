# アクセス解析レポート作成プログラム（Webサーバーアプリケーション版）
Web制作会社の社内アプリケーションとして開発されたプログラムです。  
GoogleアナリティクスとGoogleサーチコンソールからデータを収集し、顧客に提出するための印刷やPDF出力を想定したアクセス解析レポートを作成します。  
一般的なレンタルサーバーにインストールし、ブラウザから操作できます。

**このプログラムはユニバーサルアナリティクスプロパティにのみ対応しています。  
新しい Google アナリティクス 4 プロパティでは使用できません。**

## インストール
### ファイルのコピー
プログラムのファイルをサーバーにコピーします。  
サーバーにSSHで接続してください。  
```sh
cd ~/www #任意のWebサーバーディレクトリに移動してください。
git clone git@github.com:shugomatsuzawa/Web-Analytics-Reporting-Tool.git
```
顧客の重要な情報を扱いますので、このディレクトリにはBasic認証等の設定を推奨します。    
### 依存関係のインストール
Python 3 のインストールが必要です。  
プログラムのディレクトリに移動し、requirements.txt の内容をインストールします。
```sh
pip install -r requirements.txt
```

サーバー上のPythonのパスを設定に入力します。

#### さくらのレンタルサーバを使用する場合
2020年8月現在、さくらのレンタルサーバで Python 3 や pip を使用することはできません。  
さくらのレンタルサーバにユーザーの Python 環境を構築するには、pyenv を使う方法が最も安定して使用することができます。  
**参考**
- [【python】sakuraサーバー上でpythonを使ってtwitter投稿するまでの話](https://qiita.com/ninoko1995/items/0fc8ab26178da0fc0ae5)
- [[サクラレンタルサーバー] (初心者向け) PythonとpyenvとFlaskの環境構築方法。| cshの場合](https://qiita.com/peace098beat/items/de9fdadfc4128e99bca6)

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
- [松沢 柊吾（WebQuest）](https://github.com/shugomatsuzawa)
- [miyasan-git](https://github.com/miyasan-git)