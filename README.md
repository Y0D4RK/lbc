# LBC - README.md


## 1. Git clone
```
> git clone git@github.com:Y0D4RK/lbc.git
> cd lbc
> composer install

```

## 2. Database
```
> php bin/console doctrine:database:create
> php bin/console doctrine:schema:update --force(*)

```
(\*) When you make a new entity

## 3. Authentication by JWT 
```
> mkdir -p config/jwt
> openssl genrsa -out config/jwt/private.pem -aes256 4096 (*)
> openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

```
(\*) Tip your pass phrase and paste in parameters

## 3. Run app
```
> php bin/console server:run

```

## 4. User fixtures
```
> php bin/console doctrine:fixtures:load

```
- user: jdoe
- password: 11235

