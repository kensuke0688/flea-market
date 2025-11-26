#coachtechフリマ

##環境構築  
・git clone git@github.com:kensuke0688/flea-market.git  
・docker-compose up -d --build  
・docker compose exec php bash  
・composer install  
・cp .env.example .env  
・php artisan key:generate  
・php artisan migrate  
・php artisan db:seed  

##使用技術(実行環境)  
・PHP 7.3  
・Laravel 8.75  
・MySQL 8.0.26  
・nginx:1.21.1  

##ER図  
<img width="1142" height="622" alt="flea-market" src="https://github.com/user-attachments/assets/5b90e71c-943d-4fd7-a098-29b858374804" />  

##URL  
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


