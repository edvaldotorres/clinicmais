# 🚀 CLINICMAIS

<p>
  <img alt="Version" src="https://img.shields.io/badge/php-^8.2-blue.svg?cacheSeconds=2592000" />
  <img alt="Version" src="https://img.shields.io/badge/laravel-^10.10-red.svg?cacheSeconds=2592000" />
  <a href="https://documenter.getpostman.com/view/13040502/UzBjrney#c3212110-5be6-45bd-b000-95c6538746ca" target="_blank">
    <img alt="Documentation" src="https://img.shields.io/badge/documentation-yes-brightgreen.svg" />
  </a>
  <a href="#" target="_blank">
    <img alt="License: MIT" src="https://img.shields.io/badge/License-MIT-yellow.svg" />
  </a>
</p>

> Este projeto foi desenvolvido utilizando o framework Laravel com arquitetura padrão MVC, visando criar um CMS de forma rápida e eficiente. Foi implementado o Laravel Breeze para fornecer uma base inicial, facilitando a autenticação e configuração inicial do projeto

## Instalação

1- Clone o repositório

```sh
git clone https://github.com/edvaldotorres/clinicmais.git
```

2- Acesse a pasta do projeto

```sh
cd clinicmais
```

3- Execute o script para instalar as dependências com docker

```sh
sh script-start-docker-compose.sh
```

Obs: Isso pode demorar um pouco, pois o docker irá baixar as imagens necessárias para rodar o projeto.

4- Instale as dependências do projeto

```sh
docker exec -it admin_clinicmais composer install
```

```sh
docker exec -it admin_clinicmais php artisan key:generate
```

```sh
docker exec -it admin_clinicmais npm install
```

5- Rodar as migrações

```sh
docker exec -it admin_clinicmais php artisan migrate
```

6- Rodar seeders

```sh
docker exec -it admin_clinicmais php artisan db:seed
```

7- Rodar vite

```sh
docker exec -it admin_clinicmais npm run dev
```

## Considerações

> A arquitetura utilizada foi o padrão MVC do Laravel. Optei por esse framework devido à sua eficiência na criação rápida de um CMS, além de seus recursos robustos, como autenticação, ORM, entre outros. Também utilizei o Inertia.js com Vue.js para a interface, proporcionando uma integração fluida entre frontend e backend. Embora não tenha escolhido uma solução totalmente pronta, optei por algo que permitisse desenvolver de forma ágil, por isso utilizei o Laravel Breeze como ponto de partida.

## Accesso

- Acesse o painel de administração em [http://localhost:8000/admin](http://localhost:8000/admin)
- Acesse a webapp em [http://localhost](http://localhost)

Login CMS:

- E-mail: admin@clinicmais.com.br
- Senha: password

## Autor

👤 **Edvaldo Torres de Souza**

- Website: [edvaldotorres.com.br](https://edvaldotorres.com.br/)
- Github: [@edvaldotorres](https://github.com/edvaldotorres)
- LinkedIn: [Edvaldo Torres](https://www.linkedin.com/in/edvaldo-torres-189894150/)
