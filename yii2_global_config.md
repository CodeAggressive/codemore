## yii2 改变默认首页入口为newsController控制器
如果你想变更yii2的默认路由，请在web.php配置config数组下面添加下面语句
```php
$config=[
   ....
   'defaultRoute' => 'news'`    //注意这里控制器的名称必须全部是小写
   ....
]
注意上面这条语句不能写入 $config=['urlManager'] 中,而是$config=[]中
```
## yii2 去掉URL的中间目录
在生产环境的服务器上，你可能会想配置服务器让应用程序可以通过URL **http://www.example.com/index.php** 访问，而不是 **http://www.example.com/basic/web/index.php** 这种配置需要将 Web 服务器的文档根目录(document root)指向 **basic/web** 目录。 可能你还会想隐藏掉 URL 中的 index.php，具体细节在 URL 解析和生成一章中有介绍， 你将学到如何配置 Apache 或 Nginx 服务器实现这些目标。
## yii2 网站下线
```php
在 $config[] 配置中添加下面语句
$config =[
  ....
  'catchAll'=>['site/offline'],
  ....
]
```
## yii2 接收JSON格式请求
```php
$config = [
    ....
    'components'=>[
        'request'=>[
            'parsers'=>[
                'application/json'=>'yii\web\JsonParser',
            ]
            ....
        ]
    
    ]
]
```
## yii2 添加路径后缀名
```php
如果想以 'http://www.example.com/site/view/1.html' 访问网址,
请配置$config['urlManger']的 'suffix' 选项
$config=[
   ....
   'components'=>[
      'urlManager'=>[
          'suffix'=>'.html',
          ....
      ]
   ]
   ....
]
  
```
## yii2 美化参数传递
```php
在
```
## yii2 隐藏掉URL的index.php
> **Apache 服务器**  
*Windows* 环境，在web目录中添加一个 **.htaccess**文件, 内容如下
```Apache
# prevent directory listings
Options -Indexes
# follow symbolic links
Options FollowSymlinks
IndexIgnore */*
RewriteEngine on

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# otherwise forward it to index.php
RewriteRule . index.php
```
> **Nginix 服务器**
```Nginx
server {
    charset      utf-8;
    client_max_body_size  200M;

    listen       80; ## listen for ipv4
    #listen       [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name  advanced.loc;
    root         /path/to/advanced;

    access_log   /path/to/logs/advanced.access.log main buffer=50k;
    error_log    /path/to/logs/advanced.error.log warn;

    location / {
        root  /path/to/advanced/frontend/web;

        try_files  $uri /frontend/web/index.php?$args;

        # avoiding processing of calls to non-existing static files by Yii
        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            access_log  off;
            expires  360d;

            try_files  $uri =404;
        }
    }

    location /admin {
        alias  /path/to/advanced/backend/web;

        rewrite  ^(/admin)/$ $1 permanent;
        try_files  $uri /backend/web/index.php?$args;
    }

    # avoiding processing of calls to non-existing static files by Yii
    location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
        access_log  off;
        expires  360d;

        rewrite  ^/admin/(.+)$ /backend/web/$1 break;
        rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
        try_files  $uri =404;
    }

    location ~ \.php$ {
        include  fastcgi_params;
        # check your /etc/php5/fpm/pool.d/www.conf to see if PHP-FPM is listening on a socket or port
        fastcgi_pass  unix:/var/run/php5-fpm.sock; ## listen for socket
        #fastcgi_pass  127.0.0.1:9000; ## listen for port
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        try_files  $uri =404;
    }
    #error_page  404 /404.html;

    location = /requirements.php {
        deny all;
    }

    location ~ \.(ht|svn|git) {
        deny all;
    }
}
```