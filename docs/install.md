# 安装

## 1. 下载

```bash
composer create-project --prefer-dist --stability=dev drodata/ebp
```

Fork 的话，执行（clone 完毕后需手动 `composer install`）

```bash
git clone git@github.com:drodata/ebp.git
```

> :bell: 请确保电脑上已安装 Composer 和 `fxp/composer-asset-plugin` 插件。如未安装，参考 [下载、安装 Composer][download-composer].

## 2. 配置数据库

### 2.1 配置数据库敏感信息

在 `common/` 目录下，复制 `yii2-sensitive.json.sample` 为 `yii2-sensitive.json` 文件；编辑新复制的文件 `yii2-sensitive.json`，输入 MySQL 密码
   
```
{
    "password": "yourpassword",
    "domain": "domain-name",
    "dbname": "your-db-name"
}
```

设置 `yii2-sensitive.json` 权限，确保安全：

```bash
# replace <you> with your login name
# on Mac, sustitude www-data with _www
sudo chown <you>:www-data yii2-sensitive.json
sudo chmod 640 yii2-sensitive.json
```

### 2.1 建立数据库

新建数据库，数据库名称与上面 `yii2-sensitive.json` 中配置的值一致。

### 2.2 初始化数据库

在项目根目录下，依次运行如下命令：

```bash
# 初始化项目，选择开发环境
./init

# 执行分散在各地的 migrations, 构建应用所需的所有表格
./post-init
```

## 3. 配置 Apache 虚拟主机

1. 将 [ebp.conf](images/ebp.conf) 文件内容复制到 Apache 配置目录下:

    - Debian: `/etc/apache2/sites-available/`;
    - Mac: `/etc/apache2/other/`;
   
   编辑 ebp.conf, 将 DocumentRoot 替换成你的真实路径
2. 【Only for Debian】`sudo a2ensite yat.conf` 启用新的配置；
3. 编辑 `/etc/hosts`, 追加如下内容：

   ```bash
   127.0.0.1	         i.ebp.com
   127.0.0.1	    static.ebp.com
   ```

4. 重启 Apache 使配置生效

    - Debian: `sudo systemctl reload apache2` 
    - Mac: `sudo apachectl restart` 

至此，程序安装完成，在浏览器内输入 http://i.ebp.com, 即可进入系统后台登录界面。默认的用户名和密码分别为 `admin` 和 `123456`.

[download-composer]: https://github.com/drodata/learning-notes/blob/master/meet/composer/download.md
