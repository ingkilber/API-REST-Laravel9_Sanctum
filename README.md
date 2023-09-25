
## API Reference - Postman

#### Obtener resultados REGISTRO

```http
  POST http://127.0.0.1:8000/api/register
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
  POST http://127.0.0.1:8000/api/login
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
  GET http://127.0.0.1:8000/api/user/profile
```
- Authorization - Pegar token del user
| Type | Bearer Token |
| :-------- | :------- |

| Token| `P59GxUt9xYqCE59yiSkfVb9a1ZoKzpG2eM3Z85cO9f4cd5c6` |
| :----| :------------------------------------------------- |

#### Obtener resultados CERRRAR SESIÓN

```http
  POST http://127.0.0.1:8000/api/logout
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


