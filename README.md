Al clonar mi repositorio de backend debe de seguir estos pasos.

1. Debe de crear una base de datos llamada pervolare

2.Primero hay que ejecutar el comando 
    composer update

3.	Segundo vamos a correr migraciones y seeder para crear las tablas y el usuario 
Comando : php artisan migrate:fresh --seed

4.	Después de correr migraciones ya podemos iniciar el laravel
Comando: php artisan serve
