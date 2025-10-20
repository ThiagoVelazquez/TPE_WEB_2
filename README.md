# Segunda Entrega - OUTDATED hasta la parte de la imagen - Bajar hasta la parte de la segunda entrega

# TPE_WEB_2
TPE de Web 2 TUDAI
## INTEGRANTES: 
Thiago Velázquez Giuliani (velazquezgiulianithiago@gmail.com) y Juan Ignacio Arballo (arballojuancho@gmail.com)

## TEMÁTICA: 
El proyecto es un sitio web de un cine que se caracteriza por tener salas especiales, es decir el enfoque está puesto sobre las salas donde se dan las funciones

## DESCRIPCIÓN: 
Sitio web del cine donde el usuario puede consultar las funciones que hay y en qué salas se dan

## DER: 
El diagrama muestra las entidades Sala y Función (relación 1 a N)

* Una sala está asociada a muchas funciones
* Cada función se realiza únicamente en una sala

![image alt](https://github.com/ThiagoVelazquez/TPE_WEB_2/blob/e0d8f80182bccdbcf8ea5ddc11f65cc0c4a25349/DER.jpeg)

# Segunda Entrega - Sistema Completo

Sistema completo de gestión de funciones de cine con panel de administración, desarrollado en PHP con arquitectura MVC.

### Configuración de la base de datos

1. Abre phpMyAdmin en tu navegador
2. Crea una nueva base de datos llamada `tpe1`
3. Selecciona la base de datos `tpe1`
4. Haz clic en la pestaña **Importar**
5. Haz clic en **Seleccionar archivo** y elige el archivo `tpe1.sql` de este proyecto
6. Presiona **Continuar** para importar las tablas y datos

### Configuración del sitio

1. Coloca los archivos del proyecto en el directorio web de Apache (htdocs o www)
2. El sistema configurará automáticamente la conexión a la base de datos
3. Las tablas necesarias se crearán automáticamente si no existen
4. El usuario administrador se genera automáticamente al primer acceso

### Acceso al sistema

**Acceso público:**
- Navega a la URL del sitio para ver las funciones y salas disponibles

**Acceso administrador:**
- Usuario: `webadmin`
- Contraseña: `admin`
- Ir a la sección "Login" en el menú superior
- El sitio tiene un ayudamemorias con estos datos para logearnos como admin que de ser un sitio real removeríamos obviamente

### Funcionalidades

**Públicas:**
- Listado de todas las funciones
- Detalle individual de cada función
- Listado de todas las salas
- Funciones filtradas por sala específica

**Administración:**
- Gestión completa de funciones (agregar, editar, eliminar)
- Gestión completa de salas (agregar, editar, eliminar)
- Sistema de autenticación seguro
- Protección de rutas administrativas

### Estructura de la base de datos

- **salas**: Almacena la información de las salas (categorías)
- **funciones**: Almacena la información de las funciones (ítems)
- **usuarios**: Almacena los usuarios administradores del sistema
