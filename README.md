# CRUD Symfony — Tutorial Completo

[![latest-tag](https://img.shields.io/github/v/tag/jhonatanfdez/crud-symfony-test)](https://github.com/jhonatanfdez/crud-symfony-test/releases)

Proyecto educativo en Symfony 7.1 que enseña paso a paso cómo construir una aplicación web completa con autenticación, CRUD, API REST, sistema de roles, mensajes flash y búsquedas. Ideal para aprender Symfony desde cero hasta funcionalidades avanzadas.

**Estado actual: v1.21.0** — Sistema de Mensajes Flash implementado: retroalimentación visual completa para todas las acciones CRUD (crear, editar, eliminar) con alertas de colores (verde para éxito, rojo para error), iconos de Bootstrap Icons, alertas dismissibles y experiencia de usuario mejorada significativamente.

• Changelog: ver [v1.21.0 en registro_actividades.txt](https://github.com/jhonatanfdez/crud-symfony-test/blob/main/archivos_adicionales/registro_actividades.txt) · Tag: [v1.21.0](https://github.com/jhonatanfdez/crud-symfony-test/releases/tag/v1.21.0)

---

## Instalación y ejecución

### Requisitos previos

• PHP 8.3 o superior  
• Composer  
• Git  
• MySQL/MariaDB  
• Extensiones PHP: pdo_mysql  
• Opcional pero recomendado: Symfony CLI  

### Pasos de instalación

1. **Clonar el repositorio:**

```bash
# HTTPS
git clone https://github.com/jhonatanfdez/crud-symfony-test.git
# o SSH
git clone git@github.com:jhonatanfdez/crud-symfony-test.git

cd crud-symfony-test
```

2. **Instalar dependencias:**

```bash
composer install
```

3. **Configurar variables de entorno:**

```bash
# Copiar el archivo de ejemplo
cp .env .env.local

# Editar .env.local y configurar la conexión a BD
# Ejemplo para MySQL:
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/crud_symfony?serverVersion=8.0"
```

4. **Crear la base de datos:**

```bash
# Con Symfony CLI
symfony console doctrine:database:create
# o con PHP
php bin/console doctrine:database:create
```

5. **Ejecutar migraciones:**

```bash
symfony console doctrine:migrations:migrate
# o
php bin/console doctrine:migrations:migrate
```

6. **Crear usuario inicial:**

```bash
# Registrarse manualmente en /register
# Luego asignar ROLE_ADMIN desde la base de datos:
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'tu@email.com'"
```

7. **Iniciar el servidor:**

```bash
# Con Symfony CLI (recomendado)
symfony serve -d
# o con PHP
php -S localhost:8000 -t public/
```

8. **Acceder a la aplicación:**

• URL: `http://localhost:8000`  
• Login: `/login`  
• Registro: `/register`  

**Notas:**

• Los usuarios registrados por defecto tienen `ROLE_USER`
• Para asignar `ROLE_ADMIN`, consultar [ASIGNAR_ROL_ADMIN.md](archivos_adicionales/ASIGNAR_ROL_ADMIN.md)
• El proyecto usa Bootstrap 5.3.8 desde CDN (no requiere instalación adicional)

---

## Novedades recientes

• **v1.21.0**: Sistema de Mensajes Flash completo 🎉 - Implementados mensajes flash de éxito para todas las operaciones CRUD (6 mensajes: crear/actualizar/eliminar para categorías y productos), sistema de visualización con colores diferenciados (verde=éxito, rojo=error, amarillo=advertencia, azul=info), iconos de Bootstrap Icons para cada tipo de mensaje, alertas dismissibles con botón de cerrar, y mejora significativa en la experiencia de usuario.

• **v1.20.0**: Control de Acceso ROLE_ADMIN para Categorías 🔒 - Solo usuarios con ROLE_ADMIN pueden crear, editar y eliminar categorías. Los usuarios con ROLE_USER solo pueden visualizar. Implementado con `isGranted('ROLE_ADMIN')` en controlador, templates ocultan botones según permisos, mensajes flash informativos para acceso denegado, documentación completa de asignación de roles, y doble validación (backend + frontend).

• **v1.19.0**: Reestructuración del Repositorio 📁 - Movido `.git` de `/test1/` a `/test1/crud-symfony/` para corregir estructura en GitHub (90 files reorganizados), eliminada carpeta extra en GitHub, archivos adicionales organizados en `archivos_adicionales/` (comando, contexto.txt, registro_actividades.txt, ASIGNAR_ROL_ADMIN.md).

• **v1.18.0**: Buscador de Productos implementado - Búsqueda por nombre de producto con formulario GET, método `findBySearchQuery()` en repositorio con query builder, plantilla con campo de búsqueda, estilos Bootstrap, y mensajes informativos cuando no hay resultados.

• **v1.17.0**: Mensajes Flash en Productos - Feedback visual para crear, editar y eliminar productos con alertas de colores.

• **v1.16.0**: Validación de Errores en Formularios - Sistema completo de validación con constraints `@Assert`, prevención de errores 500 con `empty_data`, mensajes específicos por campo, y doble capa HTML5 + servidor.

• **v1.15.0**: Bootstrap y Twig Form Theme - Configuración global de Bootstrap en formularios (`form_themes: ['bootstrap_5_layout.html.twig']`), estilos profesionales automáticos, botones estilizados, y mejora visual significativa.

• **v1.14.0**: Protección de Rutas con Autenticación - Controladores protegidos con `#[IsGranted('IS_AUTHENTICATED_FULLY')]`, redirección automática al login, y seguridad mejorada.

---

## Objetivo del proyecto

Este proyecto es un **tutorial educativo completo** diseñado para enseñar Symfony 7.1 desde los fundamentos hasta características avanzadas. Cubre:

• **Instalación y Configuración** - Symfony CLI, estructura de carpetas, variables de entorno  
• **Autenticación** - Sistema de login/registro con Security component  
• **Entidades y Relaciones** - Doctrine ORM, migraciones, relaciones ManyToOne  
• **CRUD Completo** - Make CRUD, controladores, formularios, vistas Twig  
• **API REST** - Endpoints JSON, serialización  
• **Estilos CSS** - Bootstrap 5 desde CDN, form themes  
• **Validaciones** - Doble capa HTML5 + servidor con @Assert  
• **Mensajes Flash** - Retroalimentación visual para acciones CRUD  
• **Sistema de Roles** - Control de acceso con ROLE_USER y ROLE_ADMIN  
• **Búsquedas** - Implementación de buscadores con QueryBuilder  

**¿Por qué Symfony y no Laravel, Drupal u otros?**

✅ **Arquitectura modular** - Componentes independientes reutilizables  
✅ **Estándares PSR** - Código profesional siguiendo mejores prácticas PHP  
✅ **Doctrine ORM** - Gestión de base de datos potente y flexible  
✅ **Symfony CLI** - Herramientas de desarrollo excepcionales  
✅ **Seguridad robusta** - Sistema de autenticación y autorización de clase empresarial  
✅ **Documentación excelente** - Referencias completas y actualizadas  
✅ **Comunidad activa** - Soporte continuo y ecosistema maduro  
✅ **Flexibilidad** - Desde microservicios hasta aplicaciones empresariales complejas  

---

## Funcionalidades actuales (v1.21.0)

### 🎉 Sistema de Mensajes Flash (v1.21.0) — NUEVO

**Retroalimentación visual completa para el usuario**

• **Controladores actualizados:**
  - `CategoriaController`: 3 mensajes de éxito (crear, editar, eliminar) + mensajes de error existentes (ROLE_ADMIN)
  - `ProductoController`: 3 mensajes de éxito (crear, editar, eliminar)

• **Sistema de visualización en `base_admin.html.twig`:**
  - Loop automático por todos los tipos de flash: `{% for type, messages in app.flashes %}`
  - Mapeo de colores Bootstrap: `success` → verde, `error` → rojo (danger), `warning` → amarillo, `info` → azul
  - Iconos contextuales de Bootstrap Icons:
    - ✓ Success: `bi-check-circle-fill` (verde)
    - ✗ Error: `bi-exclamation-triangle-fill` (rojo)
    - ⚠ Warning: `bi-exclamation-circle-fill` (amarillo)
    - ℹ Info: `bi-info-circle-fill` (azul)
  - Alertas dismissibles con botón de cerrar (`btn-close`)
  - Animación fade show de Bootstrap

• **Mensajes implementados:**
  - "La categoría ha sido creada exitosamente" (verde)
  - "La categoría ha sido actualizada exitosamente" (verde)
  - "La categoría ha sido eliminada exitosamente" (verde)
  - "El producto ha sido creado exitosamente" (verde)
  - "El producto ha sido actualizado exitosamente" (verde)
  - "El producto ha sido eliminado exitosamente" (verde)
  - "Usted no tiene privilegios para esta acción" (rojo) - ya existente desde v1.20.0

• **Experiencia de usuario:**
  - Feedback visual inmediato tras cada acción
  - Colores intuitivos según el tipo de mensaje
  - Alertas pueden cerrarse manualmente
  - Diseño profesional y consistente

### 🔒 Control de Acceso ROLE_ADMIN (v1.20.0)

**Sistema de roles para gestión de categorías**

• **Restricciones implementadas:**
  - Solo `ROLE_ADMIN` puede crear, editar y eliminar categorías
  - `ROLE_USER` solo puede visualizar categorías y productos
  - Validación doble: controlador + templates

• **Seguridad en Controlador (`CategoriaController`):**
  - Método `new()`: `if (!$this->isGranted('ROLE_ADMIN'))` → flash error + redirección
  - Método `edit()`: `if (!$this->isGranted('ROLE_ADMIN'))` → flash error + redirección
  - Método `delete()`: `if (!$this->isGranted('ROLE_ADMIN'))` → flash error + redirección

• **Seguridad en Templates:**
  - `categoria/index.html.twig`: botón "Nueva Categoría" oculto con `{% if is_granted('ROLE_ADMIN') %}`
  - `categoria/index.html.twig`: botones "Editar" y "Eliminar" en tabla ocultos por rol
  - `categoria/show.html.twig`: botones de acción ocultos para usuarios sin privilegios

• **Documentación incluida:**
  - Archivo `ASIGNAR_ROL_ADMIN.md` con 3 métodos de asignación de roles
  - Ejemplos SQL completos
  - Solución de problemas comunes
  - Formato correcto del campo JSON `roles`

### 🔍 Buscador de Productos (v1.18.0)

**Búsqueda funcional por nombre de producto**

• **Características:**
  - Formulario de búsqueda con método GET en `/producto`
  - Método `findBySearchQuery()` en `ProductoRepository` usando QueryBuilder
  - Búsqueda case-insensitive con `LIKE %query%`
  - Mensaje informativo cuando no hay resultados
  - Estilos Bootstrap integrados

• **Implementación técnica:**
  - Query: `$qb->where('p.nombre LIKE :query')->setParameter('query', '%' . $query . '%')`
  - Template con campo de búsqueda en `index.html.twig`
  - Botón de búsqueda con icono
  - Preservación del término de búsqueda en el campo

### 📝 Sistema de Autenticación Completo

**Login y registro funcional con Security Component**

• **Características:**
  - Formulario de login en `/login` con CSRF protection
  - Formulario de registro en `/register` con validaciones
  - Autenticador personalizado `LoginFormAuthenticator`
  - Hashing automático de contraseñas con `PasswordHasher`
  - Redirección post-login a `/home`
  - Logout funcional en `/logout`

• **Entidad User:**
  - Campos: email, password, roles, createdAt
  - Roles almacenados en JSON: `["ROLE_USER"]` por defecto
  - Validaciones: email único, password mínimo 6 caracteres
  - Implementa `UserInterface` y `PasswordAuthenticatedUserInterface`

### 🏗️ Módulo Categorías (CRUD)

**Gestión completa de categorías con control de acceso**

• **Funcionalidades:**
  - Listado de categorías (`/categoria`)
  - Ver detalles (`/categoria/{id}`)
  - Crear nueva categoría (`/categoria/new`) - solo ROLE_ADMIN
  - Editar categoría (`/categoria/{id}/edit`) - solo ROLE_ADMIN
  - Eliminar categoría (`/categoria/{id}`) - solo ROLE_ADMIN

• **Entidad Categoria:**
  - Campos: nombre, descripción, createdAt, updatedAt
  - Relación OneToMany con Producto
  - Validaciones: nombre obligatorio, descripción opcional

• **Formulario `CategoriaType`:**
  - Campo nombre: TextType, required
  - Campo descripción: TextareaType, opcional
  - Bootstrap form theme aplicado globalmente

### 📦 Módulo Productos (CRUD completo)

**Gestión integral de productos con validaciones exhaustivas**

• **Funcionalidades:**
  - Listado de productos con búsqueda (`/producto`)
  - Ver detalles (`/producto/{id}`)
  - Crear nuevo producto (`/producto/new`)
  - Editar producto (`/producto/{id}/edit`)
  - Eliminar producto (`/producto/{id}`)
  - Mensajes flash para todas las acciones

• **Entidad Producto:**
  - Campos: nombre, precio, fecha, user (creador)
  - Relación ManyToOne con Categoria (obligatoria)
  - Relación ManyToOne con User (creador)
  - Validaciones exhaustivas con @Assert:
    - Nombre: NotBlank, Length min 3
    - Precio: NotNull, GreaterThanOrEqual 0
    - Fecha: NotNull
    - Categoria: NotNull

• **Formulario `ProductoType`:**
  - Campo nombre: TextType con validaciones
  - Campo precio: NumberType con step 0.01
  - Campo fecha: DateType con widget single_text
  - Campo categoria: EntityType con query builder
  - Bootstrap form theme aplicado
  - Manejo de errores completo

• **Validaciones doble capa:**
  - HTML5: required, min, max, step, pattern
  - Servidor: @Assert constraints en entidad
  - Prevención de errores 500 con `empty_data`
  - Mensajes específicos por campo en español

### 🎨 Bootstrap 5 y Estilos

**Interfaz moderna y responsive**

• **Configuración:**
  - Bootstrap 5.3.8 desde CDN
  - Bootstrap Icons 1.11.3 desde CDN
  - Form theme global: `form_themes: ['bootstrap_5_layout.html.twig']`
  - Templates base: `base.html.twig`, `base_admin.html.twig`

• **Componentes utilizados:**
  - Navbar responsive con menú hamburguesa
  - Cards para contenido estructurado
  - Tables con clases `table-striped`, `table-hover`
  - Buttons con variantes: primary, success, danger, warning, secondary
  - Alerts dismissibles para mensajes flash
  - Forms con labels, helps texts, error messages
  - Badges para estados y categorías

### 🔐 Protección de Rutas

**Seguridad en controladores**

• **Implementación:**
  - Atributo `#[IsGranted('IS_AUTHENTICATED_FULLY')]` en controladores
  - Redirección automática a `/login` si no está autenticado
  - Control granular con `isGranted('ROLE_ADMIN')` para acciones específicas
  - Protección CSRF en formularios de eliminación

• **Rutas protegidas:**
  - `/home` - requiere autenticación
  - `/producto/*` - requiere autenticación
  - `/categoria/*` - requiere autenticación (crear/editar/eliminar requiere ROLE_ADMIN)

### ✅ Validación de Errores Completa

**Sistema robusto de validación en formularios**

• **Estrategia de doble capa:**
  1. **HTML5 (cliente):** required, min, max, step, pattern - feedback inmediato
  2. **Servidor (PHP):** @Assert constraints - seguridad definitiva

• **Constraints utilizados:**
  - `@Assert\NotBlank` - campos obligatorios
  - `@Assert\NotNull` - valores no nulos
  - `@Assert\Length` - longitud mínima/máxima
  - `@Assert\GreaterThanOrEqual` - valores numéricos mínimos
  - `@Assert\Type` - tipo de dato correcto
  - `@Assert\Email` - formato de email válido

• **Manejo de errores:**
  - Prevención de errores 500 con `empty_data` ('' para strings, 0 para integers)
  - Mensajes específicos por campo con etiquetas descriptivas
  - Sistema exhaustivo que muestra todos los errores campo por campo
  - Estilos Bootstrap para errores: `is-invalid`, `invalid-feedback`

**Principio de seguridad:** NUNCA confiar solo en validación del cliente. Siempre validar en el servidor.

---

## 🚀 API REST para Productos (v1.23.0) — NUEVO

### Endpoints disponibles

El proyecto incluye una API REST completa para gestionar productos mediante peticiones HTTP con respuestas JSON.

**Base URL:** `/api/producto`

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| `GET` | `/api/producto` | Listar todos los productos | No requerida |
| `GET` | `/api/producto/{id}` | Obtener un producto específico | No requerida |
| `POST` | `/api/producto` | Crear nuevo producto | No requerida* |
| `PUT` | `/api/producto/{id}` | Actualizar producto existente | Requerida |
| `DELETE` | `/api/producto/{id}` | Eliminar producto | No requerida* |

*Autenticación desactivada para facilitar pruebas educativas.

---

### 📋 Ejemplos de uso

#### 1. Listar todos los productos

```bash
GET http://localhost:8000/api/producto
```

**Respuesta (200 OK):**
```json
[
  {
    "id": 1,
    "nombre": "Laptop Dell XPS 15",
    "precio": 1500.99,
    "fecha": "2025-11-13",
    "categoria": {
      "id": 1,
      "nombre": "Electrónica"
    },
    "usuario": {
      "id": 1,
      "email": "admin@test.com"
    }
  },
  {
    "id": 2,
    "nombre": "Mouse Logitech",
    "precio": 25.50,
    "fecha": "2025-11-13",
    "categoria": {
      "id": 1,
      "nombre": "Electrónica"
    },
    "usuario": {
      "id": 1,
      "email": "admin@test.com"
    }
  }
]
```

---

#### 2. Obtener un producto específico

```bash
GET http://localhost:8000/api/producto/1
```

**Respuesta (200 OK):**
```json
{
  "id": 1,
  "nombre": "Laptop Dell XPS 15",
  "precio": 1500.99,
  "fecha": "2025-11-13",
  "categoria": {
    "id": 1,
    "nombre": "Electrónica"
  },
  "usuario": {
    "id": 1,
    "email": "admin@test.com"
  }
}
```

**Respuesta de error (404 Not Found):**
```json
{
  "error": "Not Found"
}
```

---

#### 3. Crear un nuevo producto

```bash
POST http://localhost:8000/api/producto
Content-Type: application/json

{
  "nombre": "Teclado Mecánico",
  "precio": 89.99,
  "categoria_id": 1
}
```

**Respuesta (201 Created):**
```json
{
  "mensaje": "Producto creado exitosamente",
  "producto": {
    "id": 3,
    "nombre": "Teclado Mecánico",
    "precio": 89.99,
    "fecha": "2025-11-13",
    "categoria": {
      "id": 1,
      "nombre": "Electrónica"
    },
    "usuario": {
      "id": 1,
      "email": "admin@test.com"
    }
  }
}
```

**Campos requeridos:**
- `nombre` (string): Nombre del producto
- `precio` (float): Precio del producto
- `categoria_id` (int): ID de una categoría existente

**Campos opcionales:**
- `fecha` (string): Fecha en formato YYYY-MM-DD (se asigna automáticamente si no se envía)

**Posibles errores:**

**400 Bad Request - JSON inválido:**
```json
{
  "error": "JSON inválido o vacío"
}
```

**400 Bad Request - Campos faltantes:**
```json
{
  "error": "Faltan campos requeridos: nombre, precio, categoria_id"
}
```

**404 Not Found - Categoría no existe:**
```json
{
  "error": "Categoría no encontrada"
}
```

---

#### 4. Actualizar un producto existente

```bash
PUT http://localhost:8000/api/producto/3
Content-Type: application/json

{
  "nombre": "Teclado Mecánico RGB",
  "precio": 99.99
}
```

**Respuesta (200 OK):**
```json
{
  "mensaje": "Producto actualizado exitosamente",
  "producto": {
    "id": 3,
    "nombre": "Teclado Mecánico RGB",
    "precio": 99.99,
    "fecha": "2025-11-13",
    "categoria": {
      "id": 1,
      "nombre": "Electrónica"
    },
    "usuario": {
      "id": 1,
      "email": "admin@test.com"
    }
  }
}
```

**Nota:** Solo se actualizan los campos enviados. Los demás mantienen su valor actual.

**Campos opcionales (actualización parcial):**
- `nombre` (string): Nuevo nombre
- `precio` (float): Nuevo precio
- `categoria_id` (int): Nueva categoría

---

#### 5. Eliminar un producto

```bash
DELETE http://localhost:8000/api/producto/3
```

**Respuesta (200 OK):**
```json
{
  "mensaje": "Producto eliminado exitosamente",
  "id": 3
}
```

**Nota:** La eliminación es permanente (no soft delete).

---

### 🧪 Probar la API

#### Opción 1: Con cURL (Terminal)

```bash
# Listar productos
curl http://localhost:8000/api/producto

# Ver producto específico
curl http://localhost:8000/api/producto/1

# Crear producto
curl -X POST http://localhost:8000/api/producto \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Monitor LG 27 pulgadas","precio":299.99,"categoria_id":1}'

# Actualizar producto
curl -X PUT http://localhost:8000/api/producto/1 \
  -H "Content-Type: application/json" \
  -d '{"precio":1599.99}'

# Eliminar producto
curl -X DELETE http://localhost:8000/api/producto/3
```

#### Opción 2: Con Postman o Thunder Client

1. **Instalar Thunder Client** (extensión de VS Code) o **Postman**
2. **Crear nueva petición**
3. **Configurar:**
   - Método: `GET`, `POST`, `PUT` o `DELETE`
   - URL: `http://localhost:8000/api/producto` (o con /{id})
   - Headers: `Content-Type: application/json` (para POST/PUT)
   - Body (raw JSON): Datos del producto
4. **Enviar petición**

#### Opción 3: Con JavaScript/Fetch

```javascript
// Listar productos
fetch('http://localhost:8000/api/producto')
  .then(response => response.json())
  .then(data => console.log(data));

// Crear producto
fetch('http://localhost:8000/api/producto', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    nombre: 'Audífonos Sony',
    precio: 49.99,
    categoria_id: 1
  })
})
.then(response => response.json())
.then(data => console.log(data));
```

---

### 📖 Documentación técnica

**Controlador:** `src/Controller/ProductoApiController.php`

**Características implementadas:**
- ✅ Respuestas JSON estructuradas
- ✅ Códigos HTTP apropiados (200, 201, 400, 404)
- ✅ Validación exhaustiva de datos
- ✅ Manejo de errores con mensajes descriptivos
- ✅ Serialización manual para evitar referencias circulares
- ✅ Actualización parcial (PATCH-like con PUT)
- ✅ Comentarios profesionales en el código
- ✅ ParamConverter automático para objetos
- ✅ Inyección de dependencias
- ✅ Separación de responsabilidades

**Códigos de estado HTTP:**
- `200 OK` - Operación exitosa (GET, PUT, DELETE)
- `201 Created` - Recurso creado exitosamente (POST)
- `400 Bad Request` - Datos inválidos o faltantes
- `404 Not Found` - Recurso no encontrado
- `401 Unauthorized` - Usuario no autenticado (si está activada)

**Seguridad:**
- Autenticación desactivada en `POST` y `DELETE` para pruebas educativas
- Autenticación activa en `PUT` (requiere sesión)
- En producción: descomentar `$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')`

---

## Próximos módulos (Roadmap)

• Autenticación con login/registro ✅ Completado en v1.13.0  
• Bootstrap 5 integrado con form themes ✅ Completado en v1.15.0  
• Validación de errores exhaustiva ✅ Completado en v1.16.0  
• Mensajes flash para retroalimentación ✅ Completado en v1.17.0 y v1.21.0  
• Buscador de productos ✅ Completado en v1.18.0  
• Control de acceso por roles ✅ Completado en v1.20.0  
• API REST con endpoints JSON ✅ **Completado en v1.23.0**  
• CRUD de usuarios con respuesta JSON (próximamente)  
• Paginación para listados grandes (próximamente)  
• Upload de imágenes para productos (próximamente)  
• Dashboard con estadísticas (próximamente)  

---

## Tecnologías

• **PHP** 8.3.27  
• **Symfony** 7.1.* (HTTPKernel, Routing, Security, Doctrine ORM, Twig, Form, Validator)  
• **Doctrine ORM** (MySQL con PDO)  
• **Twig** (motor de plantillas)  
• **Bootstrap** 5.3.8 (desde CDN)  
• **Bootstrap Icons** 1.11.3 (desde CDN)  
• **MySQL** 8.0 (base de datos)  
• **Composer** (gestor de dependencias)  
• **Symfony CLI** (herramientas de desarrollo)  

---

## Estructura del proyecto

### Carpetas principales

```
crud-symfony/
├── archivos_adicionales/     # Documentación y archivos de referencia
│   ├── ASIGNAR_ROL_ADMIN.md  # Guía de asignación de roles
│   ├── comando               # Historial de comandos ejecutados
│   ├── contexto.txt          # Contexto del proyecto educativo
│   ├── FORMULARIOS_GUIA.md   # Guía de formularios Symfony
│   └── registro_actividades.txt  # Changelog detallado
├── config/                   # Configuración de la aplicación
│   ├── packages/            # Configuración de bundles
│   └── routes.yaml          # Rutas globales
├── migrations/              # Migraciones de base de datos
├── public/                  # Directorio público (index.php, assets)
├── src/
│   ├── Controller/         # Controladores
│   │   ├── CategoriaController.php
│   │   ├── ProductoController.php
│   │   ├── SecurityController.php
│   │   ├── RegistrationController.php
│   │   └── HomeController.php
│   ├── Entity/            # Entidades Doctrine
│   │   ├── Categoria.php
│   │   ├── Producto.php
│   │   └── User.php
│   ├── Form/              # Tipos de formularios
│   │   ├── CategoriaType.php
│   │   ├── ProductoType.php
│   │   └── RegistrationFormType.php
│   ├── Repository/        # Repositorios Doctrine
│   │   ├── CategoriaRepository.php
│   │   ├── ProductoRepository.php
│   │   └── UserRepository.php
│   └── Security/          # Autenticación
│       └── LoginFormAuthenticator.php
├── templates/             # Plantillas Twig
│   ├── base.html.twig            # Layout base público
│   ├── base_admin.html.twig      # Layout base autenticado
│   ├── categoria/                # Vistas de categorías
│   ├── producto/                 # Vistas de productos
│   ├── registration/             # Vista de registro
│   └── security/                 # Vista de login
├── .env                  # Variables de entorno (ejemplo)
└── composer.json         # Dependencias del proyecto
```

### Rutas principales

**Públicas:**
- `GET /login` - Formulario de login
- `POST /login` - Procesar login
- `GET /register` - Formulario de registro
- `POST /register` - Procesar registro
- `GET /logout` - Cerrar sesión

**Protegidas (requieren autenticación):**
- `GET /home` - Dashboard principal
- `GET /producto` - Listado de productos (con búsqueda)
- `GET /producto/new` - Crear producto
- `GET /producto/{id}` - Ver producto
- `GET /producto/{id}/edit` - Editar producto
- `POST /producto/{id}` - Eliminar producto
- `GET /categoria` - Listado de categorías
- `GET /categoria/{id}` - Ver categoría

**Requieren ROLE_ADMIN:**
- `GET /categoria/new` - Crear categoría
- `GET /categoria/{id}/edit` - Editar categoría
- `POST /categoria/{id}` - Eliminar categoría

---

## Seguridad y permisos

### Roles disponibles

• **ROLE_USER** (por defecto al registrarse)
  - Acceso a todas las vistas
  - Puede crear, editar y eliminar productos
  - Solo puede visualizar categorías (no crear/editar/eliminar)

• **ROLE_ADMIN** (asignado manualmente)
  - Todos los permisos de ROLE_USER
  - Puede crear, editar y eliminar categorías
  - Acceso completo a toda la aplicación

### Asignación de ROLE_ADMIN

**Opción 1: Comando Symfony CLI**
```bash
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'admin@test.com'"
```

**Opción 2: SQL directo**
```sql
UPDATE user SET roles = '["ROLE_ADMIN"]' WHERE email = 'admin@test.com';
```

**Opción 3: phpMyAdmin / MySQL Workbench**
- Editar registro del usuario
- Campo `roles`: `["ROLE_ADMIN"]`
- Guardar cambios

**IMPORTANTE:** Cerrar sesión y volver a iniciar sesión para que los cambios surtan efecto.

### Protecciones implementadas

✅ CSRF protection en todos los formularios  
✅ Password hashing con algoritmo moderno  
✅ Validación doble capa (cliente + servidor)  
✅ Control de acceso con atributos `#[IsGranted()]`  
✅ Redirección automática si no está autenticado  
✅ Mensajes flash informativos para acceso denegado  
✅ Templates ocultan opciones según permisos  

---

## Validaciones en formularios

### Doble capa de seguridad

**1. Validaciones HTML5 (navegador)**
- Mejora experiencia de usuario con feedback inmediato
- Atributos: `required`, `min`, `max`, `step`, `pattern`
- **ADVERTENCIA:** Puede ser bypasseada (deshabilitar JS, editar DOM, envío directo por API)

**2. Validaciones Server-Side (PHP)**
- Constraints `@Assert` en entidades (Producto, Categoria, User)
- Validación definitiva e infranqueable
- Protege contra envíos directos por cURL, Postman, o modificación del HTML
- Tipos de validaciones usadas:
  - `@Assert\NotBlank` - campos obligatorios
  - `@Assert\NotNull` - valores no nulos
  - `@Assert\Length` - longitud mínima/máxima
  - `@Assert\GreaterThanOrEqual` - valores numéricos mínimos
  - `@Assert\Type` - tipo de dato correcto
  - `@Assert\Email` - formato de email válido

**Principio de seguridad:** NUNCA confiar solo en validación del cliente. Siempre validar en el servidor.

---

## Uso de mensajes flash

### Implementación en controladores

```php
// Mensaje de éxito
$this->addFlash('success', 'El producto ha sido creado exitosamente');

// Mensaje de error
$this->addFlash('error', 'Usted no tiene privilegios para esta acción');

// Mensaje de advertencia
$this->addFlash('warning', 'Esta acción puede tener consecuencias');

// Mensaje informativo
$this->addFlash('info', 'Los cambios pueden tardar unos minutos');
```

### Visualización automática

Los mensajes flash se muestran automáticamente en `base_admin.html.twig` con:
- Colores diferenciados según tipo
- Iconos contextuales de Bootstrap Icons
- Botón de cerrar (dismissible)
- Animación fade

---

## Desarrollo

### Estilo de commits

Convencional (Conventional Commits):
- `feat`: nueva funcionalidad
- `fix`: corrección de errores
- `refactor`: refactorización de código
- `docs`: cambios en documentación
- `chore`: tareas de mantenimiento
- `style`: cambios de formato (no afectan lógica)

**Ejemplos:**
```bash
git commit -m "feat: Implementar buscador de productos"
git commit -m "fix: Corregir validación de precio en ProductoType"
git commit -m "docs: Actualizar README con instrucciones de instalación"
```

### Versionado

- Sistema: **SemVer** (Semantic Versioning)
- Formato: `vMAJOR.MINOR.PATCH`
- Tags anotados con descripción detallada

**Ejemplo:**
```bash
git tag -a v1.21.0 -m "Versión 1.21.0 - Sistema de Mensajes Flash

- Implementados mensajes flash de éxito para todas las operaciones CRUD
- Sistema de visualización con colores diferenciados
- Iconos de Bootstrap Icons
- Alertas dismissibles"
```

### Changelog

Archivo `registro_actividades.txt` en `archivos_adicionales/` siguiendo estructura:
- Versión y fecha
- Objetivo
- Problema a resolver
- Implementación realizada
- Archivos modificados
- Pruebas sugeridas

---

## Uso educativo

Este proyecto está diseñado como **material didáctico** para enseñar Symfony paso a paso:

### Temas cubiertos

1. ✅ **Instalación de Symfony CLI** - Comandos básicos y configuración
2. ✅ **Estructura de carpetas** - Entender la arquitectura MVC
3. ✅ **Variables de entorno** - Configuración con .env
4. ✅ **Doctrine ORM** - Entidades, migraciones, relaciones
5. ✅ **Sistema de autenticación** - Login, registro, hashing de passwords
6. ✅ **Make CRUD** - Generación automática de controladores
7. ✅ **Formularios Symfony** - Types, validaciones, renderizado
8. ✅ **Twig templates** - Herencia, includes, filters, functions
9. ✅ **Bootstrap integration** - CSS desde CDN y form themes
10. ✅ **Validaciones exhaustivas** - Doble capa HTML5 + @Assert
11. ✅ **Mensajes flash** - Retroalimentación visual
12. ✅ **Sistema de roles** - ROLE_USER y ROLE_ADMIN
13. ✅ **Búsquedas** - QueryBuilder con LIKE
14. ⏳ **API REST** - Endpoints JSON (próximamente)

### Recursos adicionales

- `archivos_adicionales/contexto.txt` - Plan educativo completo
- `archivos_adicionales/FORMULARIOS_GUIA.md` - Guía de formularios
- `archivos_adicionales/ASIGNAR_ROL_ADMIN.md` - Asignación de roles
- `archivos_adicionales/registro_actividades.txt` - Changelog detallado
- `archivos_adicionales/comando` - Historial de comandos

---

## Licencia

Este proyecto está bajo la licencia MIT incluida en el repositorio.

---

## Créditos

• Desarrollado por **Jhonatan Fernandez** ([@jhonatanfdez](https://github.com/jhonatanfdez))  
• Proyecto educativo para enseñar Symfony 7.1  
• Contribuciones bienvenidas vía Pull Requests  

---

## Contacto y soporte

• GitHub: [jhonatanfdez/crud-symfony-test](https://github.com/jhonatanfdez/crud-symfony-test)  
• Issues: [Reportar problemas](https://github.com/jhonatanfdez/crud-symfony-test/issues)  
• Documentación oficial Symfony: [symfony.com/doc](https://symfony.com/doc/current/index.html)  

---

**🎓 ¡Aprende Symfony construyendo una aplicación real desde cero!**
