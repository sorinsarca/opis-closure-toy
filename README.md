### Install

Install [docker](https://docs.docker.com/engine/install/ubuntu/) (also check [post-install](https://docs.docker.com/engine/install/linux-postinstall/), you may need to logout or reboot),
[docker-compose](https://docs.docker.com/compose/install/) and [composer](https://getcomposer.org/download/).

### Run

Install dependencies
```sh
composer update
```

Start services
```sh
docker-compose up --build
```

Open `index.html` in browser.


### Other info

To use `opcache.preload` with fpm you must run the php-fpm master process as NON-root
and use an empty value for `opcache.preload_user`.

If you use `opcache.preload` and `opcache.preload_user` you will see an error like: https://bugs.php.net/bug.php?id=79232

In these examples we set the user to `www-data` (for master processes).

#### Run fpm master process as www-data

If fpm is running then you must stop it first.

```bash
sudo service php8.0-fpm stop
```

Change the owner for `/var/log/php8.0-fpm.log`

```bash
sudo chown www-data:www-data /var/log/php8.0-fpm.log
```

Open the fpm service file

```bash
nano /lib/systemd/system/php8.0-fpm.service
```

It should look something like this

```conf
[Unit]
Description=The PHP 8.0 FastCGI Process Manager
Documentation=man:php-fpm8.0(8)
After=network.target

[Service]
Type=notify
ExecStart=/usr/sbin/php-fpm8.0 --nodaemonize --fpm-config /etc/php/8.0/fpm/php-fpm.conf
ExecStartPost=-/usr/lib/php/php-fpm-socket-helper install /run/php/php-fpm.sock /etc/php/8.0/fpm/pool.d/www.conf 80
ExecStopPost=-/usr/lib/php/php-fpm-socket-helper remove /run/php/php-fpm.sock /etc/php/8.0/fpm/pool.d/www.conf 80
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Under the `[Service]` section add the following directives

```conf
User=www-data
Group=www-data
```

Save the file and exit. Restart the fpm service

```bash
sudo service php8.0-fpm start
```


