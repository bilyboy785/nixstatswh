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


## Installation

* Now you can clone this repo in the folder of your server where Nixstats could call your Webhook :

```bash
cd /var/www
git clone https://github.com/bilyboy785/nixstats-webhook-telegram.git nixstats
cd nixstats
```

* Replace **Bot Token** and **Telegram User ID** in the nixstats Webhook with Tokenizer script :

```bash
chmod +x tokenizer.sh
./tokenizer.sh
Please enter your Telegram Token : 378865447:AAQe2OB9I-pl1__eVEHzI6KCDT5XW-HGAjs
Enter now your ChatUserID : 65284287
Token and ChatID are successfully applied !
Exiting..
```

## Configuration

* To configure your Webhook in Nixstats you just have to put your **Webhook URL** in your **Settings / Notifications Contacts** :

![Configure your Webhook URL](https://img.bouillaudmartin.fr/7U0VbvpA.png)

* On each Server / Monitor, add the Webhook option to your selected recipients :

![Add Webhook in your Recipients](https://img.bouillaudmartin.fr/D2WbptwY.png)

## Todo list

If you have any idea of enhancements, tell me ;)

* [x] Check if there is a POST query before notify
* [x] Clean the files with a function folder
* [ ] Simplify my code
* [ ] Remove some useless lines

## Thank's to

* [Nixstats On Github](https://github.com/NIXStats)
* [Nixstats On Twitter](https://twitter.com/nixstats?lang=fr)
* [Me on Twitter](https://twitter.com/bilyb0y)
* [Punk__R0ck on Twitter]()
* [Punk__R0ck on Github]()
