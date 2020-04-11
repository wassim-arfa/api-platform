<p align="center">
<img src="https://camo.githubusercontent.com/0c6b72c593f69a3d8bdac424b1152a73ef5b2e22/68747470733a2f2f6170692d706c6174666f726d2e636f6d2f6c6f676f2d323530783235302e706e67">
<br/>
<a href="https://api-platform.com/docs/distribution/">Read the official "Getting Started" guide.</a>
</p>
<br/>

### Installation

Api-Platform requires [Docker](https://www.docker.com/products/docker-desktop) to run.

Build/Start the containers in the background.

```sh
$ docker-compose up -d
```
this starts the following services :
![N|Solid](https://i.imgur.com/KsdNVpQ.jpg)
pgAdmin  : http://localhost:5050/

### It's Ready!
Open https://localhost in your favorite web browser:
![N|Solid](https://api-platform.com/static/03f362d88e4214426697883fa908fce5/8aaee/api-platform-2.5-welcome.png)

### Setup JWT Auth
Create public/private keys for JWT auth
when asked to provide JWT_PASSPHRASE, you can find it under .env
```sh
$ docker exec -it api-platform_php_1 sh
/srv/api # mkdir config/jwt
/srv/api # openssl genrsa -out config/jwt/private.pem -aes256 4096
Enter pass phrase for config/jwt/private.pem: ********
Verifying - Enter pass phrase for config/jwt/private.pem: ********
/srv/api # openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
Enter pass phrase for config/jwt/private.pem: ********
```

### Add dependencies

Axios:
```sh
$ docker-compose exec client yarn add axios
```

JsonWebToken:
```sh
$ docker-compose exec client yarn add jsonwebtoken
```

### Redux DevTools Extension

Api-Platform is using [Redux DevTools Extension](https://github.com/zalmoxisus/redux-devtools-extension/blob/master/README.md). Instructions on how to use it in your own application are linked.

