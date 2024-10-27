<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Aquí tienes un ejemplo de un archivo `README.md` para el proyecto `usuarioABM`:

---

# Proyecto usuarioABM

## Descripción
Este proyecto es una aplicación para la gestión de usuarios que utiliza Laravel como backend y Vue.js para el frontend. A continuación, se describen los pasos para levantar el proyecto en un entorno de desarrollo local.

## Requisitos
- PHP >= 8.0
- Composer
- Node.js & NPM
- MySQL o cualquier otra base de datos compatible

## Instalación

1. **Clonar el repositorio**:
  
   git clone https://github.com/cristhian9403/UsuariosABM.git
   cd usuarioABM
  

2. **Configurar las variables de entorno**:
   - Editar el archivo `.env` y ajustar las siguientes variables con los datos de conexión a la base de datos:
    env
     DB_DATABASE=nombre_de_tu_base_de_datos
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
    

3. **Instalar las dependencias**:
   
   composer install
   npm install
   

## Levantar la base de datos

1. **Crear la base de datos**:
   - Crear una base de datos en tu servidor MySQL con el nombre especificado en el archivo `.env`.

2. **Ejecutar las migraciones**:
  
   php artisan migrate
  
   Este comando creará las tablas necesarias en la base de datos según las migraciones definidas en el proyecto.

3. **Ejecutar los seeders**:
  
   php artisan db:seed
  
   Este comando llenará la base de datos con datos iniciales para poder empezar a utilizar la aplicación, como usuarios de ejemplo.

## Ejecutar la aplicación en local

1. **Levantar el servidor de desarrollo**:
  
   php artisan serve
  
   Esto levantará un servidor local de PHP, que permitirá acceder a la aplicación desde `http://localhost:8000`.

2. **Compilar los assets de frontend**:
  
   npm run dev
  
   Esto compilará los archivos de JavaScript y CSS necesarios para la interfaz del usuario y los cargará en modo de desarrollo.

## Acceder a la aplicación
Una vez realizados los pasos anteriores, puedes acceder a la aplicación desde tu navegador a través de la URL:
```
http://localhost:8000
```

