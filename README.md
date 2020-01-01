### Requisitos

Php > 7.1

### Instalacion

```sh
$ git clone https://github.com/Enmel/PizzaApi
```

```sh
php artisan migrate:fresh
```

```sh
php artisan passport:install
```

### TODOS (Release de Arturo)

* ~Sistema de Reservacion de Mesa~
    * ~Api~
    * ~Vistas de admin~
* ~Integrar el api y los recursos con el paquete spatie/laravel-query-builder~
    * ~Food~
    * ~Categories~
    * ~Tables~
    * ~Orders~
* Capacidad de agregar imagenes a la comida (Food) y las categorias (FoodCategories)
* Agregar Factories y Seeders para llenar la base de datos con datos de prueba
    * Food
    * FoodCategories
    * Users (admin)
* Agregar la documentacion con Swagger
* Agregar Gates para las autorizaciones de usuarios
* Integracion con MailGun
