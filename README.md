### Requisitos

Php > 7.1

### Instalacion

Primero clonamos el proyecto

```sh
$ git clone https://github.com/Enmel/PizzaApi
```

E instalamos las dependencias

```sh
$ composer install
```

Ahora renombramos el archivo ".env.example" que esta en la raiz del directorio a ".env" y configuramos los parametros de la base de datos

```sh
$ php artisan storage:link
```
Con eso se crea un link simbolico entre la carpeta storage y sus subcarpetas storage/app/public. Que es la utilizada por imagenes.

```sh
php artisan migrate:fresh
```

```sh
php artisan passport:install
```

### Documentacion del api

Para generar la documentacion usar:

```sh
php artisan l5-swagger:generate
```

Esto genera la documentacion con Swagger ui en la ruta /api/documentation

### TODOS (Release de Arturo)

* ~Sistema de Reservacion de Mesa~
    * ~Api~
    * ~Vistas de admin~
* ~Integrar el api y los recursos con el paquete spatie/laravel-query-builder~
    * ~Food~
    * ~Categories~
    * ~Tables~
    * ~Orders~
* ~Capacidad de agregar imagenes a la comida (Food) y las categorias (FoodCategories)~
	* ~Food~
	* ~Categorias~
* Agregar Factories y Seeders para llenar la base de datos con datos de prueba
    * Food
    * FoodCategories
    * Users (admin)
* Agregar la documentacion con Swagger
    * ~Agregar y configurar Swagger~
    * ~Users~
    * Orders
    * Foods
    * Categories
    * Tables
    * Reservations
* Agregar Gates para las autorizaciones de usuarios
* Integracion con MailGun
