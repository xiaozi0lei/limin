```shell
server {
        listen 80;
        server_name limin;

        root   /home/work/www/limin;
# 参考项目目录的 apache .htaccess 文件制定 rewrite 规则
#include /home/work/www/limin/.htaccess;

        location / {
                index index.php index.html;
        }

#去掉$是为了不匹配行末，即可以匹配.php/，以实现pathinfo
        location ~ .php {
                fastcgi_pass   127.0.0.1:9000;
                fastcgi_index  index.php;
                include        fastcgi_params;
#定义变量 $path_info ，用于存放pathinfo信息
                set $path_info "";
#定义变量 $real_script_name，用于存放真实地址
                set $real_script_name $fastcgi_script_name;
#如果地址与引号内的正则表达式匹配
                if ($fastcgi_script_name ~ "^(.+?\.php)(/.+)$") {
#将文件地址赋值给变量 $real_script_name
                        set $real_script_name $1;
#将文件地址后的参数赋值给变量 $path_info
                        set $path_info $2;
                }
#配置fastcgi的一些参数
                fastcgi_param SCRIPT_FILENAME $document_root$real_script_name;
                fastcgi_param SCRIPT_NAME $real_script_name;
                fastcgi_param PATH_INFO $path_info;
        }
}
```
