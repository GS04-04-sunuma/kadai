# kadai

## 6. CakePHPを使った漫画評価アプリ

### 設定
	amazonAPIを使っているのでapp/Vender/AmazonAPIHelper.phpに以下の記入が必要。行番6、14、15、43、44あたり
	・AWSのアクセスキー<br>
	・AWSのシークレットキー<br>
	・アソシエイトタグ<br>

### 画面構成
	トップ画面							www.example.com/manga/　<br>
	漫画情報取得画面（管理画面）			www.example.com/manga/add/　<br>
	漫画評価画面							www.example.com/manga/view/　<br>

###アプリ内容
####漫画データの取得
	manga/add/にて漫画のタイトルを入力　<br>
####漫画の評価
	manga/view/にてストーリー、画力、キャラ、世界観を５段階とコメントを記入 <br>

###できなかったこと、やりたかったこと

	・評価時にタグを作る機能 <br>
	・ジャンルやタグごとの評価ランキング <br>
	・facebookやtwitterへの連携 <br>
	・セキュリティ面の強化 <br>
	・デザイン <br>
