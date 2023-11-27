# API de Autenticación y Registro

Esta es una API de autenticación y registro desarrollada en Laravel 9 utilizando el paquete Sanctum para la autenticación basada en tokens

## Funcionalidades

- Registro de usuarios.
- Inicio de sesión de usuarios.
- Obtener perfil de usuario autenticado.
- Editar usuario
- Cierre de sesión de usuario autenticado.
- Listar todos los usuarios (requiere autenticación).
- Eliminar usuario

## Requisitos

- PHP >= 7.4+
- Composer
- Laravel 9
- Base de datos compatible (ejemplo: MySQL, PostgreSQL, SQLite)

## Instalación

1. Clona este repositorio en tu máquina local.
2. Navega al directorio de tu proyecto y abrelo.
3. Instala las dependencias de Composer

``` bash
composer install
```

4. Crea un archivo `.env` basado en el archivo `.env.example` y configura tu base de datos y las variables de entorno.
6. Ejecuta las migraciones para crear las tablas de la base de datos

``` bash
php artisan migrate
```
7. Inicia el servidor de desarrollo

``` bash
php artisan serve
```

8. Tu API estará disponible en `http://localhost:8000`.


## API Referencia - Postman

#### Obtener resultados REGISTRO

```http
  POST http://localhost:8000/api/register
```
- Headers

| Key | Value     | Description                |
| :-------- | :------- | :------------------------- |
| ` Accept ` | `application/json` |  |

- Body / form-data

| Key | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `admin` |  |
| `email` | `admin@example.com` |  |
| `password` | `xxxxxxxx` |  |
| `password_confirmation` | `xxxxxxxx` |  |

#### Obtener resultados INICIO DE SESIÓN

```http
  POST http://localhost:8000/api/login
```

- Body / form-data

| Key | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `admin@example.com` |  |
| `password` | `xxxxxxxx` |  |

Resultado esperado

```javascript
{
    "token": "1|P59GxUt9xYqCE59yiSkfVb9a1ZoKzpG2eM3Z85cO9f4cd5c6",
    "message": "Inicio sesión exitosamente"
}

```

#### Obtener resultados PERFIL

```http
  GET http://localhost:8000/api/user/profile
```
- Authorization - Pegar token del user

| Type | Bearer Token |
| :-------- | :------- |

| Token| `P59GxUt9xYqCE59yiSkfVb9a1ZoKzpG2eM3Z85cO9f4cd5c6` |
| :----| :------------------------------------------------- |

#### Obtener resultados CERRRAR SESIÓN

```http
  POST http://localhost:8000/api/logout
```
- Headers

| Key | Value     | Description                |
| :-------- | :------- | :------------------------- |
| ` Accept ` | `application/json` |  |

- Authorization - Pegar token del user

| Type | Bearer Token |
| :-------- | :------- |

| Token| `P59GxUt9xYqCE59yiSkfVb9a1ZoKzpG2eM3Z85cO9f4cd5c6` |
| :----| :------------------------------------------------- |

```javascript
{
    "message": "Cierre de sesión exitoso"
}

```

## Author

- [@KilberMarcano](https://github.com/ingkilber)
