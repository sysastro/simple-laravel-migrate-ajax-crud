# Simple Laravel Migrate Ajax CRUD

Laravel application with migrate example for create table in database and single page for manage data with CRUD functionallity in ajax.
Laravel version 5.3.

### Installing

Download the project on your local machine.

Change configuration in file .env for database name, username and password
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-migrate
DB_USERNAME=root
DB_PASSWORD=
```

Run migrate command for create table into your database
```
php artisan migrate
```
Check on your database, if it is success it should be 4 table created : migrations, news, users, password_reset


Open Single Page Ajax CRUD URL
```
http://localhost/{your folder name}/public/news
```

## Step by step create migration file

1. Change configuration in file .env for database name, username and password
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-migrate
DB_USERNAME=root
DB_PASSWORD=
```

2. Create migration file for some table
```
php artisan make:migration create_news_table --create=news
```
If it is success will be created file in /database/migrations/****_**_**_******_create_news_table.php

3. Adjust the table fields in file migration
There is 2 function on the class CreateNewsTable, function up for create table with the fields and function down for drop the table.
You can adjust table field what you need in up function like this for example
```
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->integer('visitor');
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });
    }
```

4. Run migrate command for create table
```
php artisan migrate
```

5. More info laravel migration
[https://laravel.com/docs/5.3/migrations](https://laravel.com/docs/5.3/migrations)

## The advantages of using laravel migration

    1. If you need to change database from mysql into postgresql just only run : php artisan migrate
    2. If any problem in your database and want to change to the previous version run : php artisan migrate:rollback
    3. If any new developer need to install database run : php artisan migrate:refresh
    etc.

## Version

1.0

## Authors

* **Siswanto** - [sysastro](http://sysastro.com)


## License

This project is licensed under the MIT License