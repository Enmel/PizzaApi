### Requisitos

Php > 7.1

### Instalacion

`git clone https://github.com/Enmel/PizzaApi`

`php artisan migrate:fresh`

`php artisan passport:install`

### TODOS (Release de Arturo)

* Sistema de Reservacion de Mesa
    * Api
    * Vistas de admin
* Integrar el api y los recursos con el paquete spatie/laravel-query-builder
* Capacidad de agregar imagenes a la comida (Food) y las categorias (FoodCategories)
* Agregar Factories y Seeders para llenar la base de datos con datos de prueba
    * Food
    * FoodCategories
    * Users (admin)
* Agregar la documentacion con Swagger
* Agregar Gates para las autorizaciones de usuarios
* Integracion con MailGun
