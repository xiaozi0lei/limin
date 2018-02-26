# limin

* copy limin.tar 到新的服务器
* 安装 php
* 安装 php-fpm for fastcgi
* 修改 /etc/php-fpm.d/www.conf

```bash
user = work
group = work
```

* root 用户启动 php-fpm
  ```bash
  nohup php-fpm &
  ```
* 安装 php-pdo for 数据库连接
* 安装 php-gd for 验证码图片
