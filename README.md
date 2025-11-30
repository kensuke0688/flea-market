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

## ER図  
![ER図](https://github.com/user-attachments/assets/6089c435-0398-475d-96ff-4fe4ad31b98a)  

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
・マイページ：http://localhost/mypage?(購入した商品表示:http://localhost/mypage?page=buy、出品した商品表示：http://localhost/mypage?page=sell)  
