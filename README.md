
# php_bot_template

## System dependencies
- PHP >= 7.4
- MySQL

## Deployment
### Via GitHub
- Download from repository `git clone https://github.com/iCoderNet/php-bot-template`
- Go into the 'php-bot-template' folder `cd php-bot-template`

## Development
### Create a database in MySQL 

**1. Connect to MySQL**

    mysql -u root -p

**2. Create a New User**

    CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';

**3. Create a New Database**

    CREATE DATABASE newdatabase;

**4. Grant Privileges**

    GRANT ALL PRIVILEGES ON newdatabase.* TO 'newuser'@'localhost';

**5. Flush Privileges**

    FLUSH PRIVILEGES;

**6. Exit MySQL**

    EXIT;

### Setting ENV
1. Open the `env.php` file inside the `config` folder
2. Put your bot token from [@BotFather](https://t.me/botfather) in the `API_TOKEN` variable
3. Put your bot username from [@BotFather](https://t.me/botfather) in the `BOT_USERNAME` variable
4. Add your Telegram profile ID number to the `ADMINS` array
5. In the variables `DB_HOST`, `DB_USER`, `DB_PASS` and `DB_NAME`, put the username and password of the MySQL user created above, followed by the name of the attached database

### WEBHOOK CONNECTION
Webhook the `index.php` file in the main (`./`) folder

## Used technologies:
- [cURL](https://www.php.net/manual/en/book.curl.php) (working with API request)
- [MySQL](https://www.postgresql.org/) (database)
- [MySQLi](https://www.php.net/manual/en/book.mysqli.php) (working with database from PHP)