# API REST - Sistema de Gestión de Cine

Este repositorio contiene una API REST simple para gestionar funciones de cine.

## Qué hay en este proyecto

- `api_router.php` - Entry point para los endpoints de la API.
- `app/controllers/` - Controladores, por ejemplo funcion-api.controller.php.
- `app/models/` - Modelos, por ejemplo funcion.model.php.
- `libs/router/` - Librería ligera de ruteo usada por este proyecto.
- `libs/jwt/` - Librería para autenticación JWT.
- `database/tpe1.sql` - Script SQL para crear la base de datos y tablas iniciales.
- `.htaccess` - reglas apache para soportar URL semánticas.

## Librería de ruteo

Este proyecto usa una librería interna para rutear peticiones ubicada en libs/router/.

## Endpoints

GET /api/funciones - Listar todas las funciones
### Parámetros opcionales:
- sort - Ordenar por campo (id, nombre, duracion, horarios, id_sala)
- order - Dirección del orden (asc/desc)
- page - Número de página para paginado
- limit - Cantidad de resultados por página
- filterField - Campo para filtrar (id_sala, nombre, duracion)
- filterValue - Valor del filtro

### Ejemplos:
GET /api/funciones?sort=nombre&order=desc
GET /api/funciones?page=1&limit=5
GET /api/funciones?filterField=id_sala&filterValue=6

GET /api/funciones/:id - Obtener una función específica por ID
### Ejemplo:
GET /api/funciones/7

GET /api/auth/login - Obtener token de autenticación
### Ejemplo:
GET /api/auth/login
Headers: Authorization: Basic YWRtaW46cGFzc3dvcmQ=

POST /api/funciones - Crear nueva función (requiere token)
### Ejemplo:
POST /api/funciones
Headers: 
  Authorization: Bearer [token]
  Content-Type: application/json
Body: {
  "nombre": "Nueva Película",
  "duracion": 120,
  "horarios": 18,
  "id_sala": 1,
  "token": "[token]"
}

PUT /api/funciones/:id - Actualizar función existente (requiere token)
### Ejemplo:
PUT /api/funciones/11
Headers: 
  Authorization: Bearer [token]
  Content-Type: application/json
Body: {
  "nombre": "Película Actualizada",
  "duracion": 150,
  "horarios": 20,
  "id_sala": 1,
  "token": "[token]"
}

DELETE /api/funciones/:id - Eliminar función (requiere token)
### Ejemplo:
DELETE /api/funciones/11
Headers: Authorization: Bearer [token]

