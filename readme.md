## Features

- Use git for version control.
- Use Laravel Framework.
- Use of event and listener method.
- Use Vue java Script Framework and create all view with component.

## Quick Start

- Clone this repo or download it's release archive and extract it somewhere
- Run `composer install`
- Configure your `.env` file for APP_KEY mailTrap e.g:
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=0145921852502d
MAIL_PASSWORD=9fffd67740c9ef
```

- Run `npm install` and then Run `npm run dev`.
## Migrate database and seeds
- Run `php artisan migrate` for Run the database migrations
- Run `php artisan db:seed` for seed todolists and tasks tables OR Run `php artisan db:seed --class=TasksTableSeeder` for only seed tasks table.

## A Live PoC

- Run a PHP built in server from your root project:

```sh
php artisan serve
```

## Check failed tasks

For check failed task run this command :

`php artisan checktaskfailed`
 OR
 `php artisan schedule:run` for check daily task 

## Defualt users for login

```
username: mohammad@gmail.com
password : 123456

AND

username: shahab@gmail.com
password : 123456
```

# Enjoy!