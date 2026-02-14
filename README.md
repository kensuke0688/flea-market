# coachtechフリマ  

## 環境構築  
Dockerビルド  
・git clone git@github.com:kensuke0688/flea-market.git  
・cd flea-market  
・docker compose build  
・docker compose up -d  
Laravel環境構築  
・docker compose exec php bash  
・composer install  
・cp .env.example .env  
・php artisan key:generate  
・php artisan migrate  
・php artisan db:seed  

## 使用技術(実行環境)  
・PHP 7.3  
・Laravel 8.75  
・MySQL 8.0.26  
・nginx:1.21.1  

## URL  
・商品一覧ページ：http://localhost/  
・商品詳細ページ：http://localhost/item  
・商品購入ページ：http://localhost/purchase  
・商品出品ページ：http://localhost/sell  
・会員登録ページ：http://localhost/register  
・メール認証誘導ページ：http://localhost/email/verify  
・ログインページ：http://localhost/login  
・配送先住所変更ページ：http://localhost/purchase/address  
・プロフィール設定ページ：http://localhost/mypage/profile  
・マイページ：http://localhost/mypage?(購入した商品表示:http://localhost/mypage?page=buy、出品した商品表示：http://localhost/mypage?page=sell、取引中の商品：http://localhost/mypage?page=trading)  
・取引チャット画面：http://localhost/trade/chat  

## ダミーデータ情報  
ダミーデータ1(商品ID：CO01〜CO05の商品データを出品済み)  
・名前：ユーザーA  
・メールアドレス：usera@test.com  
・パスワード：password  

ダミーデータ2(商品ID：CO06〜CO010の商品データを出品済み)  
・名前：ユーザーB. 
・メールアドレス：userb@test.com  
・パスワード：password  

ダミーデータ3(出品なし)  
・名前：ユーザーC  
・メールアドレス：userc@test.com  
・パスワード：password  
