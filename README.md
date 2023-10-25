TECH STACK : LARAVEL
Database : PostgreSQL

Git Clone

type this command to run:

```Shell
git clone https://github.com/prasetyama/lenna.git
```

```Shell
composer install
```

Create file .env and change with your database config

```Shell
cp .env.example .env
```

Migrate Database

```Shell
php artisan migrate
```

Genereta JWT Secret
```Shell
php artisan jwt:secret
```

Build Frontend

```Shell
npm install 
```

```Shell
npm run dev 
```

## Run this Project
```Shell
php artisan serve
```

## API Documentation POSTMAN
There is postman file in project root
