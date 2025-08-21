# Prueba-T-cnica-Laravel
Repositorio de la prueba técnica 


Sistema para registrar máquinas, tareas y generar una producciòn

Requisitos

PHP 8.2.12, Composer

MySQL 8.0.43

Node 10.9.3

React 19.1

LARAVEL(Backend)

-Primeros pasos
composer install
Configura DB_* en .env 
php artisan migrate --seed  
php artisan serve

-Modelo de datos
maquinas: id, nombre, coeficiente

tareas: id, id_maquina, id_produccion(nullable), fecha_hora_inicio, fecha_hora_termino, tiempo_empleado(nullable), tiempo_produccion(nullable), estado (PENDIENTE|COMPLETADA)

produccion: id, maquina_id, tiempo_produccion, tiempo_inactividad, fecha_hora_inicio_inactividad, fecha_hora_termino_inactividad

-Rutina Automatizada 
php artisan app:procesar-produccion            



REACT (Frontend)


Primeros pasos

npm install
npm start  

Endpoints usados 

GET /api/maquinas – listar máquinas

POST /api/maquina – crear { nombre, coeficiente }

PUT /api/maquina/{id} – actualizar { nombre, coeficiente }

DELETE /api/maquina/{id} – eliminar
