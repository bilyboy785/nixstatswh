## Description 

This Webhook wrote in PHP allow telegram notifications when [Nixstats](https://nixstats.com) monitor's status changes.

* Customize servers and domains notifications in the functions.php file
* Check the downtime intervall when the domain's close notification is sent
* Enable or disable the Bitly API function to minimize URLs

### Monitor Notification

![Monitor Notification](https://i.imgur.com/h58GsZM.png)

### Server Notification

![Server Notification](https://i.imgur.com/aI0Tv04.png)

## Prepatation

* First, you need to start a conversation with **@BotFather** and create a BOT in Telegram, choose a **Name**, a **Nickname** and get your **Bot Token** :

![Create Bot Token](https://i.imgur.com/DVY1ak9.png)

* Start a conversation now with **@MyIdBot** to get your **Telegram User ID** :

![Get your Chat User ID](https://i.imgur.com/QRcnmJX.png)


## Docker Image Utilization

* Now you can pull image

```bash
docker pull martinbouillaud/nixstatswh:latest
```

## Define environnement variables

- `HTTP_SERVER_NAME` (a [server name](https://httpd.apache.org/docs/2.4/fr/mod/core.html#servername), defaults to `www.example.com`)
- `LOG_LEVEL` (a [log level](https://httpd.apache.org/docs/2.4/fr/mod/core.html#loglevel), defaults to `info`)
- `TZ` (a [timezone](https://www.php.net/manual/timezones.php), defaults to `UTC`)
- `PHP_MEMORY_LIMIT` (a [memory-limit](https://www.php.net/manual/ini.core.php#ini.memory-limit), defaults to `256M`)
- `PHP_UPLOAD_MAX_FILESIZE` (a [upload_max_filesize](https://www.php.net/manual/fr/ini.core.php#ini.upload-max-filesize), defaults to `8M`)
- `PHP_POST_MAX_SIZE` (a [post_max_size](https://www.php.net/manual/fr/ini.core.php#ini.post-max-size), defaults to `8M`)
- `TELEGRAM_BOT_TOKEN` (Your Telegram Bot Token)
- `TELEGRAM_CHATID`(Your Telegram Chat ID)

### Build

Replace *nixstatswh* and tags with whatever you want when building your own image.

```sh
docker build -t nixstatswh:latest .
```

## Run

```bash
docker run -d --name nixstatswh -e TELEGRAM_BOT_TOKEN=XXXX -e TELEGRAM_CHATID=XXXX -p 80:80 martinbouillaud/nixstatswh:latest
```

## Customized run

```sh
docker run -d \
    --name nixstatswh \
    -e HTTP_SERVER_NAME="www.example.xyz" \
    -e HTTPS_SERVER_NAME="www.example.xyz" \
    -e TZ="Europe/Paris" \
    -e PHP_MEMORY_LIMIT="512M" \
    --publish 80:80 \
    --publish 443:443 \
    --restart unless-stopped \
    martinbouillaud/nixstatswh:latest
```

## Docker-compose Stack

```
version: "3.3"
nixstatswh:
    container_name: nixstatswh
    image: martinbouillaud/nixstatswh:latest
    ports:
        - "8080:80"
    environment:
        - HTTP_SERVER_NAME=nixstatswh.example.com
        - TZ=Europe/Paris
        - PHP_MEMORY_LIMIT=256M
        - TELEGRAM_BOT_TOKEN=XXXXXX
        - TELEGRAM_CHATID=XXXXXX
```


## Thank's to

* [Nixstats On Github](https://github.com/NIXStats)
* [Nixstats On Twitter](https://twitter.com/nixstats?lang=fr)
* [Me on Twitter](https://twitter.com/bilyb0y)
* [Punk__R0ck on Twitter]()
* [Punk__R0ck on Github]()
