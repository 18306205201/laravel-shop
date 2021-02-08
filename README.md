# laravel-shop
cp .env.example .env
## 编辑 .env 文件
APP_URL = http://shop.test

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=laravel

DB_USERNAME=root

DB_PASSWORD=

ALIPAY_PUBLIC_KEY=

ALIPAY_PRIVATE_KEY=
## 执行 composer install
composer install
## 生成应用 key
php artisan key:generate
## 执行数据迁移，构建表结构
php artisan migrate
## 生成测试数据
php artisan db:seed
## 配置前端样式
yarn config set registry https://registry.npm.taobao.org

SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass yarn

npm run watch-poll
