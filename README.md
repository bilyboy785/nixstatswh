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

* Replace **Bot Token** and **Telegram User ID** in the nixstats Webhook with Tokenizer script :

## Configuration

* Create a **nixstats.ini** file on your computer like this : 

```
tgtoken = YOUR_TELEGRAM_BOT_TOKEN
tgchatid = YOUR_TELEGRAM_CHAT_ID
bitlylogin = YOUR_BITLY_LOGIN
bitlyapikey = YOUR_BITLY_APIKEY
```

* Run docker with mounted volume on your INI file

```bash
docker run -d --name nixstatswh -p 80:80 -v /PATH/TO/nixstats.ini:/var/www/html/nixstatswh/nixstats.ini:ro martinbouillaud/nixstatswh:latest
```

## Thank's to

* [Nixstats On Github](https://github.com/NIXStats)
* [Nixstats On Twitter](https://twitter.com/nixstats?lang=fr)
* [Me on Twitter](https://twitter.com/bilyb0y)
* [Punk__R0ck on Twitter]()
* [Punk__R0ck on Github]()
