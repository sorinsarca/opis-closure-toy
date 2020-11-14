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
