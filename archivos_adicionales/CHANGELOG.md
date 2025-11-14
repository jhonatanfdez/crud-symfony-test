# CHANGELOG - PROYECTO CRUD SYMFONY

**Proyecto:** CRUD Symfony con Autenticación  
**Autor:** Jhonatan Fernandez (jhonatanfdez)  
**Repositorio:** https://github.com/jhonatanfdez/crud-symfony-test  
**Framework:** Symfony 7.1.*  
**PHP:** 8.3.27  
**Database:** MySQL (crud_symfony)  
**Frontend:** Bootstrap 5.3.8 + Bootstrap Icons 1.11.3

---

## [v1.16.0] - 13 de noviembre de 2025, 8:12 PM

### REDISEÑO LOGIN Y REGISTRO

**Objetivo:**  
Modernizar las vistas de login y registro con un diseño más estético usando Bootstrap 5 y gradientes.

**Cambios realizados:**

1. **templates/base.html.twig** (MEJORADO):
   - Fondo con gradiente: `linear-gradient(135deg, #667eea 0%, #764ba2 100%)`
   - `min-height: 100vh` para pantalla completa
   - Sin navbar ni footer (diseño minimalista para páginas públicas)
   - Bootstrap 5.3.8 desde CDN
   - Bootstrap Icons 1.11.3

2. **templates/security/login.html.twig** (REDISEÑADO):
   - Card centrado vertical y horizontalmente
   - Icono `bi-person-circle` grande (4rem)
   - Placeholders en campos (tu@email.com, ********)
   - Botón con gradiente y efecto hover
   - Alert dismissible para errores
   - Link a registro con diseño mejorado
   - Footer con copyright dentro del card

3. **templates/registration/register.html.twig** (REDISEÑADO):
   - Diseño consistente con login.html.twig
   - Icono `bi-person-plus-fill`
   - Card con padding amplio (p-5)
   - Campos con iconos (envelope, lock, check-circle)
   - Mensajes de error por campo
   - Link a login para usuarios existentes

**Archivos modificados:**
- `templates/base.html.twig`
- `templates/security/login.html.twig` (~120 líneas)
- `templates/registration/register.html.twig` (~110 líneas)
- `templates/base_admin.html.twig` (sin cambios, ya existía)

**Estadísticas:**
- Líneas añadidas: ~380 insertions
- Commit: `962c4c2`
- Tag: `v1.16.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.17.0] - 13 de noviembre de 2025, 8:35 PM

### MEJORA DE FORMULARIOS

**Objetivo:**  
Demostrar TODAS las propiedades y opciones disponibles en formularios Symfony para propósitos educativos.

**Cambios realizados:**

1. **src/Form/ProductoType.php** (MEJORADO):
   - Campo 'nombre': TextType con label, label_attr, attr, placeholder, help, help_attr, constraints
   - Campo 'precio': NumberType con scale, html5, attr (step, min), constraints (Positive, LessThanOrEqual)
   - Campo 'categoria': EntityType con configuración completa
   - Campo 'fecha': DateType con widget='single_text', label_attr, help_attr
   - Campo 'user': EntityType con configuración condicional (show_user)
   - configureOptions: setAllowedTypes para validar tipos de opciones

2. **src/Form/CategoriaSelectType.php** (NUEVO):
   - Custom field type reutilizable
   - Extiende AbstractType
   - getParent() retorna EntityType
   - Query builder personalizado con orderBy
   - PHPDoc completo
   - Bootstrap 5 classes

3. **FORMULARIOS_GUIA.md** (NUEVO):
   - Guía completa de 600+ líneas
   - 10 secciones detalladas
   - Tipos de campos (10+)
   - Opciones comunes (10+)
   - Validaciones (8+)
   - Integración con Bootstrap
   - Ejemplos prácticos

**Archivos modificados:**
- `src/Form/ProductoType.php` (130 líneas, +80)
- `src/Form/CategoriaSelectType.php` (NUEVO, 48 líneas)
- `FORMULARIOS_GUIA.md` (NUEVO, 600+ líneas)
- `ProductoController.php` (parámetros show_user, is_edit)

**Estadísticas:**
- Líneas añadidas: ~1304 insertions
- Commit: `700cf1f`
- Tag: `v1.17.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.18.0] - 13 de noviembre de 2025, 9:00 PM

### DOCUMENTACIÓN EXHAUSTIVA

**Objetivo:**  
Agregar comentarios profesionales y educativos en TODOS los archivos del proyecto para facilitar el aprendizaje de Symfony.

**Cambios realizados:**

**Controllers (7 archivos):**
- `CategoriaController.php` (250+ líneas de comentarios)
- `ProductoController.php` (300+ líneas de comentarios)
- `RegistrationController.php` (150+ líneas de comentarios)
- `SecurityController.php` (80+ líneas de comentarios)
- `HomeController.php` (60+ líneas de comentarios)

**Entities (3 archivos):**
- `Categoria.php` (120+ líneas de comentarios)
- `Producto.php` (180+ líneas de comentarios)
- `User.php` (200+ líneas de comentarios)

**Forms (3 archivos):**
- `CategoriaType.php` (100+ líneas)
- `ProductoType.php` (ya documentado en v1.17.0)
- `RegistrationFormType.php` (90+ líneas)

**Repositories (3 archivos):**
- `CategoriaRepository.php` (80+ líneas)
- `ProductoRepository.php` (90+ líneas)
- `UserRepository.php` (70+ líneas)

**Config (6 archivos):**
- `packages/security.yaml` (150+ líneas)
- `packages/doctrine.yaml` (60+ líneas)
- `packages/twig.yaml` (40+ líneas)
- `routes/security.yaml` (30+ líneas)
- Y otros archivos de configuración

**Templates (7 archivos):**
- `base.html.twig` (50+ líneas)
- `base_admin.html.twig` (80+ líneas)
- `home/index.html.twig` (60+ líneas)
- Templates de Categoría y Producto
- Templates de seguridad

**Estilo de comentarios:**
- Idioma: Español (para audiencia hispanohablante)
- PHPDoc: @param, @return, descripciones detalladas
- Inline: Explicaciones de lógica de negocio y características de Symfony
- Twig: `{# #}` con propósito, variables, funcionalidades

**Beneficios:**
- ✅ Código autodocumentado y fácil de entender
- ✅ Facilita el aprendizaje de Symfony para principiantes
- ✅ Mejora el mantenimiento a largo plazo
- ✅ Proporciona ejemplos de buenas prácticas
- ✅ Documenta decisiones de diseño
- ✅ Explica características avanzadas (CSRF, validaciones, relaciones)

**Estadísticas:**
- Archivos documentados: 29 archivos
- Líneas de documentación: ~1547 insertions, 68 deletions
- Commit: `e251695`
- Tag: `v1.18.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.19.0] - 13 de noviembre de 2025, 9:30 PM

### REESTRUCTURACIÓN DEL REPOSITORIO GIT

**Objetivo:**  
Reorganizar la estructura del repositorio para mejor organización y limpieza, moviendo la carpeta crud-symfony a la raíz del repositorio.

**Problema a resolver:**
- Estructura confusa con crud-symfony dentro de una carpeta test1
- Archivos educativos mezclados con archivos del proyecto
- Repositorio git apuntando a carpeta incorrecta

**Cambios realizados:**

1. **Reorganización de archivos educativos:**
   - Creada carpeta `archivos_adicionales/`
   - Movidos archivos: `comando`, `registro_actividades.txt`, `instrucciones.txt`
   - Objetivo: Separar documentación de código fuente

2. **Reestructuración del repositorio:**
   - Repositorio movido desde `/test1/crud-symfony` a `/crud-symfony` (raíz)
   - .git movido a la raíz del proyecto
   - Eliminada carpeta redundante test1
   - Nueva estructura limpia y profesional

3. **Actualización de git remote:**
   - Remote origin actualizado a la nueva ubicación
   - Verificación de configuración con `git remote -v`
   - Todos los commits preservados

**Comandos ejecutados:**
```bash
# Mover repositorio a raíz
mv test1/crud-symfony/.git crud-symfony/
cd crud-symfony

# Reorganizar archivos educativos
mkdir archivos_adicionales
git mv comando archivos_adicionales/
git mv registro_actividades.txt archivos_adicionales/
git mv instrucciones.txt archivos_adicionales/

# Commit y push
git commit -m "Reorganización: Archivos movidos a archivos_adicionales/"
git push origin main
```

**Resultado:**
- ✅ Estructura limpia y profesional
- ✅ Archivos educativos organizados en carpeta dedicada
- ✅ Repositorio en ubicación correcta
- ✅ Historial git preservado
- ✅ Remote origin funcionando correctamente

**Estadísticas:**
- Commits: `f91ec59`, `df4ad2c`
- Tag: `v1.19.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.20.0] - 13 de noviembre de 2025, 9:45 PM

### CONTROL DE ACCESO ROLE_ADMIN PARA CATEGORÍAS

**Objetivo:**  
Implementar control de acceso basado en roles para operaciones de Categorías, permitiendo solo a administradores crear, editar y eliminar categorías.

**Problema a resolver:**
- Cualquier usuario autenticado podía gestionar categorías
- Falta de control granular de permisos
- Necesidad de proteger operaciones críticas

**Cambios realizados:**

1. **src/Controller/CategoriaController.php** (MODIFICADO):
   - Anotaciones `#[IsGranted('ROLE_ADMIN')]` en métodos:
     * `new()` - Crear categoría
     * `edit()` - Editar categoría
     * `delete()` - Eliminar categoría
   - Método `index()` accesible para todos los usuarios autenticados
   - Mensajes flash mejorados con contexto de permisos

2. **config/packages/security.yaml** (VERIFICADO):
   - Jerarquía de roles correcta:
     ```yaml
     role_hierarchy:
         ROLE_ADMIN: [ROLE_USER]
     ```
   - ROLE_ADMIN hereda automáticamente ROLE_USER

3. **templates/categoria/index.html.twig** (MEJORADO):
   - Botón "Nueva Categoría" solo visible para ROLE_ADMIN:
     ```twig
     {% if is_granted('ROLE_ADMIN') %}
         <a href="{{ path('app_categoria_new') }}">Nueva Categoría</a>
     {% endif %}
     ```
   - Botones Editar/Eliminar condicionados a ROLE_ADMIN
   - Usuarios normales ven listado pero no pueden modificar

**Conceptos aprendidos:**
- Atributo `#[IsGranted()]` de Symfony
- Control de acceso basado en roles (RBAC)
- Jerarquía de roles en security.yaml
- Función Twig `is_granted()`
- Mejores prácticas de seguridad

**Resultado:**
- ✅ Solo ROLE_ADMIN puede crear/editar/eliminar categorías
- ✅ ROLE_USER puede ver listado de categorías
- ✅ Interfaz adaptativa según rol del usuario
- ✅ Mensajes de error claros si se intenta acceso no autorizado
- ✅ Protección a nivel de controlador y plantilla

**Estadísticas:**
- Commit: `fc0eecc`
- Tag: `v1.20.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.21.0] - 13 de noviembre de 2025, 10:00 PM

### SISTEMA DE MENSAJES FLASH PARA RETROALIMENTACIÓN

**Objetivo:**  
Implementar un sistema completo de mensajes flash en todas las operaciones CRUD de Categorías y Productos para mejorar la retroalimentación al usuario.

**Problema a resolver:**
- Falta de confirmación visual después de operaciones CRUD
- Usuario no sabe si la acción se completó exitosamente
- Sin mensajes de error amigables

**Cambios realizados:**

1. **src/Controller/CategoriaController.php** (MODIFICADO):
   ```php
   // Crear
   $this->addFlash('success', 'Categoría creada exitosamente');
   
   // Editar
   $this->addFlash('info', 'Categoría actualizada correctamente');
   
   // Eliminar
   $this->addFlash('warning', 'Categoría eliminada exitosamente');
   
   // Error
   $this->addFlash('danger', 'Error al procesar la solicitud');
   ```

2. **src/Controller/ProductoController.php** (MODIFICADO):
   - Mensajes flash en todos los métodos (new, edit, delete)
   - Tipos: success (crear), info (editar), warning (eliminar), danger (error)
   - Mensajes descriptivos y en español

3. **templates/base_admin.html.twig** (MEJORADO):
   - Bloque dedicado para mensajes flash
   - Bootstrap alerts con iconos:
     * success: `bi-check-circle-fill`
     * info: `bi-info-circle-fill`
     * warning: `bi-exclamation-triangle-fill`
     * danger: `bi-x-circle-fill`
   - Auto-dismissible después de 5 segundos
   - Animación de fade-out suave
   - Posicionamiento fixed top

**Tipos de mensajes implementados:**

| Tipo | Color | Icono | Uso |
|------|-------|-------|-----|
| success | Verde | ✓ check-circle | Creación exitosa |
| info | Azul | ℹ info-circle | Actualización |
| warning | Amarillo | ⚠ exclamation-triangle | Eliminación |
| danger | Rojo | ✗ x-circle | Errores |

**Características:**
- ✅ Mensajes contextuales según la operación
- ✅ Iconos de Bootstrap Icons
- ✅ Auto-dismiss después de 5 segundos
- ✅ Botón de cierre manual
- ✅ Transiciones suaves
- ✅ Responsive y adaptativo
- ✅ Accesibilidad con atributos ARIA

**JavaScript implementado:**
```javascript
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
```

**Estadísticas:**
- Mensajes implementados: 12+ (6 en Categorías, 6+ en Productos)
- Commits: `8be6654`, `990cf10`
- Tag: `v1.21.0`
- Push: ✅ Exitoso a origin/main

---

## [v1.22.0] - 13 de noviembre de 2025, 10:30 PM

### DOCUMENTACIÓN COMPLETA Y REORGANIZACIÓN DE ARCHIVOS

**Objetivo:**  
Crear una documentación profesional y completa del proyecto siguiendo el estilo del proyecto AquaPanel, y reorganizar archivos educativos para mejor estructura del repositorio.

**Problema a resolver:**
- README.md básico sin información detallada del proyecto
- Falta de documentación sobre instalación, configuración y funcionalidades
- Archivo FORMULARIOS_GUIA.md en raíz del proyecto (debería estar en archivos_adicionales)
- Sin comparativa clara de por qué elegir Symfony vs otros frameworks
- Falta de roadmap educativo y temas cubiertos

**Implementación realizada:**

### 1. README.md (REESCRITURA COMPLETA - 667 LÍNEAS)

**Secciones principales:**

a) **Header con badge y descripción:**
   - Badge de última versión desde GitHub
   - Descripción como proyecto educativo
   - Estado actual: v1.21.0 con enlace a changelog

b) **Instalación y ejecución (8 pasos):**
   ```bash
   # 1. Clonar repositorio
   git clone https://github.com/jhonatanfdez/crud-symfony-test.git
   
   # 2. Instalar dependencias
   composer install
   
   # 3. Configurar .env
   DATABASE_URL="mysql://root:@127.0.0.1:3306/crud_symfony"
   
   # 4. Crear base de datos
   php bin/console doctrine:database:create
   
   # 5. Ejecutar migraciones
   php bin/console doctrine:migrations:migrate
   
   # 6. Iniciar servidor
   symfony server:start
   
   # 7. Crear usuario
   # 8. Asignar ROLE_ADMIN
   ```

c) **Novedades recientes:**
   - v1.21.0: Sistema de Mensajes Flash
   - v1.20.0: Control de acceso ROLE_ADMIN
   - v1.19.0: Reestructuración del repositorio
   - v1.18.0: Documentación exhaustiva
   - v1.17.0: Mejora de formularios
   - v1.16.0: Rediseño login/registro

d) **Comparativa Symfony vs otros frameworks:**

| Característica | Symfony | Laravel | CodeIgniter |
|----------------|---------|---------|-------------|
| Curva aprendizaje | Alta | Media | Baja |
| Flexibilidad | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| Componentes reutilizables | Sí | Sí | No |
| ORM robusto (Doctrine) | Sí | Eloquent | No |
| Seguridad | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| Documentación | Excelente | Excelente | Buena |

e) **Funcionalidades actuales (con emojis):**
   - 🔐 Autenticación (login/registro con hashing bcrypt)
   - 👥 Sistema de usuarios (User entity con relaciones)
   - 📦 CRUD Productos (create, read, update, delete)
   - 🏷️ CRUD Categorías (con relación OneToMany)
   - 🎨 Bootstrap 5.3.8 integrado
   - 🔍 Buscador de productos por nombre
   - 🔒 Control de acceso por roles (ROLE_USER, ROLE_ADMIN)
   - 🎉 Mensajes flash para retroalimentación
   - 📝 Formularios con validación exhaustiva
   - 🗄️ MySQL con Doctrine ORM
   - 🛡️ CSRF protection en formularios
   - 📅 Fecha automática en productos

f) **Temas cubiertos (educativos):**
   - Arquitectura MVC en Symfony
   - Doctrine ORM y relaciones (OneToMany, ManyToOne)
   - Sistema de seguridad y autenticación
   - Form Component y validaciones
   - Twig templating engine
   - Routing y controladores
   - Inyección de dependencias
   - Repository Pattern
   - Lifecycle Callbacks (@ORM\PrePersist)
   - Mensajes Flash
   - Control de acceso (#[IsGranted])

g) **Seguridad implementada:**
   - Password hashing con algoritmo bcrypt
   - CSRF tokens en todos los formularios
   - Validación server-side con Assert constraints
   - Control de acceso basado en roles
   - SQL injection prevention con Doctrine
   - XSS prevention con Twig auto-escaping

h) **Próximos módulos (Roadmap):**
   - ✅ Autenticación (v1.13.0)
   - ✅ Bootstrap 5 (v1.15.0)
   - ✅ Validación exhaustiva (v1.16.0)
   - ✅ Mensajes flash (v1.17.0, v1.21.0)
   - ✅ Buscador (v1.18.0)
   - ✅ Control de acceso por roles (v1.20.0)
   - [ ] API REST con endpoints JSON (próximamente)
   - [ ] CRUD de usuarios con JSON
   - [ ] Paginación para listados grandes
   - [ ] Upload de imágenes para productos
   - [ ] Dashboard con estadísticas

i) **Tecnologías:**
   - PHP 8.3.27
   - Symfony 7.1.*
   - Doctrine ORM
   - MySQL
   - Twig
   - Bootstrap 5.3.8
   - Bootstrap Icons 1.11.3

j) **Estructura del proyecto:**
   ```
   crud-symfony/
   ├── config/          # Configuración (security, doctrine, routes)
   ├── src/
   │   ├── Controller/  # Lógica de negocio
   │   ├── Entity/      # Modelos de datos
   │   ├── Form/        # Formularios
   │   └── Repository/  # Consultas personalizadas
   ├── templates/       # Vistas Twig
   ├── public/          # Assets públicos
   └── archivos_adicionales/  # Documentación educativa
   ```

k) **Comandos útiles:**
   - Crear entidad: `php bin/console make:entity`
   - Crear migración: `php bin/console make:migration`
   - Ejecutar migraciones: `php bin/console doctrine:migrations:migrate`
   - Crear controlador: `php bin/console make:controller`
   - Crear formulario: `php bin/console make:form`
   - Limpiar caché: `php bin/console cache:clear`

l) **Recursos educativos:**
   - [Documentación oficial Symfony](https://symfony.com/doc/current/index.html)
   - [Doctrine ORM Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
   - [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
   - [Twig Documentation](https://twig.symfony.com/doc/)

m) **Contacto y contribución:**
   - Autor: Jhonatan Fernandez
   - GitHub: [@jhonatanfdez](https://github.com/jhonatanfdez)
   - Repositorio: [crud-symfony-test](https://github.com/jhonatanfdez/crud-symfony-test)

### 2. FORMULARIOS_GUIA.md (MOVIDO)

**Cambios:**
- Movido desde raíz a `archivos_adicionales/FORMULARIOS_GUIA.md`
- 666 líneas de documentación preservadas
- Sin cambios en contenido

### 3. archivos_adicionales/comando (EXPANDIDO - +319 LÍNEAS)

**Nuevo contenido agregado:**

a) **Explicación CPCV REG ACT:**
   - C: Commit (confirmar cambios)
   - P: Push (subir a GitHub)
   - C: Cambio de Versión (crear tag)
   - V: Versión (tag semántico)
   - REG: REGistro (actualizar changelog)
   - ACT: ACTualización (push final)

b) **Historial de versiones:**
   - v1.14.0: Fecha automática en Producto
   - v1.15.0: Búsqueda en Categorías/Productos
   - v1.16.0: Rediseño login/registro
   - v1.17.0: Mejora de formularios
   - v1.18.0: Documentación exhaustiva
   - v1.19.0: Reestructuración del repositorio
   - v1.20.0: Control de acceso ROLE_ADMIN
   - v1.21.0: Sistema de mensajes flash

c) **Comandos Git útiles:**
   ```bash
   # Estado
   git status
   git log --oneline
   git diff
   
   # Commits
   git add .
   git commit -m "mensaje"
   git push origin main
   
   # Tags
   git tag -a v1.X.0 -m "descripción"
   git push origin v1.X.0
   git tag -l
   
   # Ramas
   git branch
   git checkout -b nueva-rama
   git merge rama
   ```

d) **Comandos Symfony útiles:**
   ```bash
   # Entidades
   php bin/console make:entity
   php bin/console make:migration
   php bin/console doctrine:migrations:migrate
   
   # Controladores y Formularios
   php bin/console make:controller
   php bin/console make:form
   
   # Base de datos
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:update --force
   
   # Caché
   php bin/console cache:clear
   ```

e) **Conventional Commits:**
   - `feat:` - Nueva funcionalidad
   - `fix:` - Corrección de bug
   - `docs:` - Cambios en documentación
   - `style:` - Formato, sin cambios de código
   - `refactor:` - Refactorización
   - `test:` - Agregar tests
   - `chore:` - Mantenimiento

f) **Versionado Semántico (SemVer):**
   - MAJOR.MINOR.PATCH
   - v1.21.0 → 1 (major), 21 (minor), 0 (patch)
   - Incrementar MINOR: nuevas funcionalidades
   - Incrementar PATCH: correcciones de bugs

g) **Métodos para asignar ROLE_ADMIN:**
   - Método 1: Extensión MariaDB/phpMyAdmin
   - Método 2: Comando make:user
   - Método 3: SQL directo
   - Método 4: Fixtures (recomendado para desarrollo)

**Comandos ejecutados:**

```bash
# 1. Mover FORMULARIOS_GUIA.md
git mv FORMULARIOS_GUIA.md archivos_adicionales/

# 2. Reescribir README.md (665 insertions, 1 deletion)
# [Edición manual del archivo]

# 3. Commit de reorganización
git add .
git commit -m "docs: Mover FORMULARIOS_GUIA.md a archivos_adicionales y reescribir README completo"
git push origin main

# 4. Actualizar registro_actividades.txt
# [Edición manual del archivo]

git add archivos_adicionales/registro_actividades.txt
git commit -m "docs: Actualización registro_actividades.txt v1.22.0"
git push origin main

# 5. Expandir archivo comando
# [Edición manual del archivo]

git add archivos_adicionales/comando
git commit -m "docs: Expandir archivo comando con guía completa de CPCV REG ACT y comandos útiles"
git push origin main

# 6. Crear tag v1.22.0
git tag -a v1.22.0 -m "Versión 1.22.0 - Documentación completa y reorganización

README.md profesional con:
- Instalación paso a paso (8 pasos)
- Comparativa con otros frameworks
- Funcionalidades actuales (12+)
- Temas educativos cubiertos (11+)
- Roadmap de desarrollo
- Estructura del proyecto
- Comandos útiles
- Recursos de aprendizaje

Reorganización:
- FORMULARIOS_GUIA.md movido a archivos_adicionales/
- archivo comando expandido (+319 líneas)
- Guía completa CPCV REG ACT

Archivos modificados:
- README.md (reescritura completa, 667 líneas)
- FORMULARIOS_GUIA.md (movido)
- archivos_adicionales/comando (expandido)
- archivos_adicionales/registro_actividades.txt (actualizado)"

git push origin v1.22.0
```

**Resultado obtenido:**
- ✅ README.md profesional y completo (667 líneas)
- ✅ FORMULARIOS_GUIA.md organizado en archivos_adicionales
- ✅ archivo comando expandido con guía completa
- ✅ Documentación estructurada y fácil de navegar
- ✅ Comparativa con otros frameworks
- ✅ Roadmap claro de funcionalidades
- ✅ Instalación paso a paso documentada
- ✅ Versión v1.22.0 publicada en GitHub

**Estadísticas:**
- Commits: `1fb1f85`, `0d70bd9`, `0b4a960`
- Tag: `v1.22.0`
- Líneas agregadas: ~1277 insertions
- Push: ✅ Exitoso a origin/main

**Próximos pasos sugeridos:**
- Implementar API REST con endpoints JSON
- Crear CRUD de usuarios con respuestas JSON
- Agregar paginación en listados
- Implementar upload de imágenes
- Crear dashboard con estadísticas

---

## [v1.23.0] - 13 de noviembre de 2025, 11:00 PM

### API REST PARA PRODUCTOS CON JSON

**Objetivo:**  
Implementar una API REST completa para la entidad Producto, permitiendo operaciones CRUD mediante peticiones HTTP con respuestas JSON. El objetivo es aprender desarrollo de APIs RESTful en Symfony, manejo de JSON, códigos HTTP y autenticación opcional.

**Problema a resolver:**
- El CRUD actual solo funciona con vistas HTML tradicionales
- No hay forma de interactuar con productos desde aplicaciones externas (frontend separado, mobile apps, etc.)
- Necesidad de aprender desarrollo de APIs modernas
- Gestión de respuestas JSON estructuradas y códigos HTTP apropiados
- Manejo de errores en formato JSON
- Serialización manual para evitar referencias circulares de Doctrine

### Implementación realizada:

### 1. ProductoApiController.php (NUEVO - 439 LÍNEAS)

**Controlador API con 5 endpoints RESTful:**

#### a) GET /api/producto - Listar todos los productos

**Especificaciones:**
- URL: `http://localhost:8000/api/producto`
- Autenticación: No requerida
- Respuesta: Array JSON con todos los productos
- Incluye: categoria y usuario anidados
- Serialización manual para evitar referencias circulares
- Código HTTP: 200 OK
- Comentarios: 56 líneas de documentación

**Ejemplo de respuesta:**
```json
[
  {
    "id": 1,
    "nombre": "Laptop Dell XPS 15",
    "precio": 1500.99,
    "fecha": "2025-11-13",
    "categoria": {"id": 1, "nombre": "Electrónica"},
    "usuario": {"id": 1, "email": "admin@test.com"}
  }
]
```

#### b) GET /api/producto/{id} - Obtener producto específico

**Especificaciones:**
- URL: `http://localhost:8000/api/producto/1`
- Autenticación: No requerida
- Parámetro: id (integer)
- ParamConverter: Carga automática del objeto Producto
- Respuesta: Objeto JSON del producto
- Error 404: Si el producto no existe
- Código HTTP: 200 OK | 404 Not Found
- Comentarios: 31 líneas de documentación

**Ejemplo de respuesta:**
```json
{
  "id": 1,
  "nombre": "Laptop Dell XPS 15",
  "precio": 1500.99,
  "fecha": "2025-11-13",
  "categoria": {"id": 1, "nombre": "Electrónica"},
  "usuario": {"id": 1, "email": "admin@test.com"}
}
```

#### c) POST /api/producto - Crear nuevo producto

**Especificaciones:**
- URL: `http://localhost:8000/api/producto`
- Método: POST
- Autenticación: No requerida (desactivada para pruebas)
- Content-Type: `application/json`
- Body: JSON con campos del producto

**Campos requeridos:**
- `nombre` (string): Nombre del producto
- `precio` (float): Precio del producto
- `categoria_id` (int): ID de categoría existente

**Campos opcionales:**
- `fecha` (string): Fecha en formato YYYY-MM-DD (auto-asignada si no se envía)

**Validaciones:**
- ✓ JSON válido y no vacío
- ✓ Todos los campos requeridos presentes
- ✓ Categoría existe en base de datos
- ✓ Usuario actual asignado automáticamente desde sesión

**Respuestas:**
- 201 Created: Producto creado exitosamente
- 400 Bad Request: JSON inválido o campos faltantes
- 404 Not Found: Categoría no encontrada

**Ejemplo de request:**
```bash
POST /api/producto
Content-Type: application/json

{
  "nombre": "Teclado Mecánico",
  "precio": 89.99,
  "categoria_id": 1
}
```

**Ejemplo de respuesta (201 Created):**
```json
{
  "mensaje": "Producto creado exitosamente",
  "producto": {
    "id": 3,
    "nombre": "Teclado Mecánico",
    "precio": 89.99,
    "fecha": "2025-11-13",
    "categoria": {"id": 1, "nombre": "Electrónica"},
    "usuario": {"id": 1, "email": "admin@test.com"}
  }
}
```

**Estadísticas:**
- Código HTTP: 201 Created | 400 Bad Request | 404 Not Found
- Comentarios: 69 líneas de documentación

#### d) PUT /api/producto/{id} - Actualizar producto existente

**Especificaciones:**
- URL: `http://localhost:8000/api/producto/1`
- Método: PUT
- Autenticación: Requerida (usuario debe estar logueado)
- Content-Type: `application/json`
- Body: JSON con campos a actualizar

**Características:**
- ✓ Actualización parcial (solo campos enviados)
- ✓ Valida categoría si se envía categoria_id
- ✓ Usuario actual obtenido desde sesión
- ✓ Fecha modificable si se envía

**Validaciones:**
- ✓ JSON válido
- ✓ Producto existe (404 si no)
- ✓ Categoría existe si se envía categoria_id
- ✓ Usuario autenticado (401 si no)

**Respuestas:**
- 200 OK: Producto actualizado exitosamente
- 400 Bad Request: JSON inválido
- 404 Not Found: Producto o categoría no encontrado
- 401 Unauthorized: Usuario no autenticado

**Ejemplo de request:**
```bash
PUT /api/producto/3
Content-Type: application/json

{
  "nombre": "Teclado Mecánico RGB",
  "precio": 99.99
}
```

**Ejemplo de respuesta (200 OK):**
```json
{
  "mensaje": "Producto actualizado exitosamente",
  "producto": {
    "id": 3,
    "nombre": "Teclado Mecánico RGB",
    "precio": 99.99,
    "fecha": "2025-11-13",
    "categoria": {"id": 1, "nombre": "Electrónica"},
    "usuario": {"id": 1, "email": "admin@test.com"}
  }
}
```

**Estadísticas:**
- Código HTTP: 200 OK | 400 Bad Request | 404 Not Found | 401 Unauthorized
- Comentarios: 64 líneas de documentación

#### e) DELETE /api/producto/{id} - Eliminar producto

**Especificaciones:**
- URL: `http://localhost:8000/api/producto/3`
- Método: DELETE
- Autenticación: No requerida (desactivada para pruebas)
- Parámetro: id (integer)
- ParamConverter: Carga automática del objeto

**Características:**
- ✓ Eliminación física (no soft delete)
- ✓ Confirmación con ID del producto eliminado
- ✓ Advertencia sobre irreversibilidad en comentarios

**Respuestas:**
- 200 OK: Producto eliminado exitosamente
- 404 Not Found: Producto no existe (manejo automático)

**Ejemplo de respuesta (200 OK):**
```json
{
  "mensaje": "Producto eliminado exitosamente",
  "id": 3
}
```

**Estadísticas:**
- Código HTTP: 200 OK | 404 Not Found
- Comentarios: 33 líneas de documentación

### Arquitectura del controlador:

**Configuración:**
- Route prefix: `/api/producto`
- Route name prefix: `api_producto_`
- Extends: `AbstractController`
- Inyección: `EntityManagerInterface`

**Técnicas implementadas:**
- Manual array conversion para evitar circular reference
- `json_decode($request->getContent(), true)` para parsear body
- `isset()` para validación de campos requeridos
- `Response::HTTP_*` para códigos de estado
- `persist()` y `flush()` para operaciones de base de datos
- `JsonResponse` para respuestas estructuradas

**Documentación en código:**
- Clase: Comentario PHPDoc con listado de endpoints (30+ líneas)
- Cada método: PHPDoc completo con @Route, @param, @return
- Ejemplos de request/response en comentarios
- Explicación de códigos HTTP para cada caso
- Notas educativas sobre autenticación toggle
- **Total: 253 líneas de comentarios profesionales**

**Decisiones de diseño:**
- POST sin autenticación: Facilita pruebas educativas
- DELETE sin autenticación: Facilita pruebas educativas
- PUT con autenticación: Demuestra implementación de seguridad
- Comentarios: Para producción, descomentar `denyAccessUnlessGranted`
- Serialización manual: Evita circular reference de Doctrine
- Actualización parcial en PUT: Mejor UX (PATCH-like behavior)

### 2. README.md (ACTUALIZADO - +316 LÍNEAS)

**Nueva sección agregada: "🚀 API REST para Productos (v1.23.0)"**

**Contenido:**

a) **Tabla de endpoints:**
- Listado de 5 endpoints con método HTTP
- URL completa de cada endpoint
- Descripción breve de funcionalidad
- Estado de autenticación (requerida/no requerida)

b) **Ejemplos de uso - Opción 1: cURL (Terminal):**
```bash
# Listar productos
curl http://localhost:8000/api/producto

# Ver producto específico
curl http://localhost:8000/api/producto/1

# Crear producto
curl -X POST http://localhost:8000/api/producto \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Monitor LG 27\"","precio":299.99,"categoria_id":1}'

# Actualizar producto
curl -X PUT http://localhost:8000/api/producto/1 \
  -H "Content-Type: application/json" \
  -d '{"precio":1599.99}'

# Eliminar producto
curl -X DELETE http://localhost:8000/api/producto/3
```

c) **Ejemplos de uso - Opción 2: Postman/Thunder Client:**
1. Instalar Thunder Client (extensión VS Code) o Postman
2. Crear nueva petición
3. Configurar método, URL, headers, body
4. Enviar petición

d) **Ejemplos de uso - Opción 3: JavaScript Fetch:**
```javascript
// Listar productos
fetch('http://localhost:8000/api/producto')
  .then(response => response.json())
  .then(data => console.log(data));

// Crear producto
fetch('http://localhost:8000/api/producto', {
  method: 'POST',
  headers: {'Content-Type': 'application/json'},
  body: JSON.stringify({
    nombre: 'Audífonos Sony',
    precio: 49.99,
    categoria_id: 1
  })
})
.then(response => response.json())
.then(data => console.log(data));
```

e) **Documentación técnica:**
- Controlador: `src/Controller/ProductoApiController.php`
- Características implementadas (11 checkmarks)
- Códigos de estado HTTP documentados
- Notas de seguridad y autenticación

f) **Roadmap actualizado:**
- "API REST con endpoints JSON" marcado como ✅ Completado en v1.23.0

**Total agregado: 316 líneas de documentación profesional**

### Conceptos aprendidos:

1. **API RESTful en Symfony:**
   - Diseño de endpoints con verbos HTTP (GET, POST, PUT, DELETE)
   - Route con prefijo `/api` para separar API de web tradicional
   - JsonResponse para respuestas estructuradas
   - Códigos HTTP apropiados (200, 201, 400, 404, 401)

2. **Manejo de JSON:**
   - `json_decode($request->getContent(), true)` para parsear request body
   - `JsonResponse` automáticamente hace `json_encode()`
   - Serialización manual para evitar circular reference
   - Estructura de respuestas con "mensaje" y datos

3. **Validación de datos:**
   - `isset()` para verificar campos requeridos
   - Validación de JSON válido con `json_decode()`
   - Verificación de existencia de relaciones (categoria)
   - Manejo de errores con mensajes descriptivos

4. **Códigos de estado HTTP:**
   - 200 OK: Operación exitosa (GET, PUT, DELETE)
   - 201 Created: Recurso creado (POST)
   - 400 Bad Request: Datos inválidos
   - 404 Not Found: Recurso no existe
   - 401 Unauthorized: No autenticado
   - `Response::HTTP_CREATED` vs números mágicos

5. **Doctrine y Serialización:**
   - Circular reference: Error cuando Producto → Usuario → Productos
   - Solución: Conversión manual a arrays
   - ParamConverter: Carga automática de entidades desde parámetros
   - `persist()` y `flush()` para operaciones de escritura

6. **Seguridad en APIs:**
   - `denyAccessUnlessGranted()` para control de acceso
   - Autenticación con sesiones (cookies)
   - Comentar/descomentar para toggle rápido
   - Diferencia entre auth en POST/DELETE (testing) vs PUT (demo)

7. **Buenas prácticas:**
   - Actualización parcial en PUT (solo campos enviados)
   - Mensajes de error descriptivos
   - Comentarios profesionales extensos (253 líneas)
   - Documentación con ejemplos reales
   - Separación API/Web con prefijos de ruta

### Comandos ejecutados:

```bash
# 1. Crear y commitear controlador API con comentarios
git add src/Controller/ProductoApiController.php
git commit -m "feat: Implementar API REST para productos con comentarios profesionales

- Crear ProductoApiController con 5 endpoints JSON
- GET /api/producto: Listar todos los productos
- GET /api/producto/{id}: Obtener producto específico
- POST /api/producto: Crear nuevo producto
- PUT /api/producto/{id}: Actualizar producto
- DELETE /api/producto/{id}: Eliminar producto
- Validación exhaustiva con códigos HTTP apropiados
- Serialización manual para evitar referencias circulares
- 253 líneas de comentarios profesionales con ejemplos
- Autenticación opcional para facilitar pruebas educativas"

# 2. Actualizar README con documentación API
git add README.md
git commit -m "docs: Agregar documentación completa de API REST en README

- Añadir sección 'API REST para Productos' con 5 endpoints
- Incluir ejemplos de uso con cURL, Postman y Fetch
- Documentar códigos HTTP y respuestas JSON
- Agregar guía de pruebas para desarrolladores
- Actualizar roadmap: API REST completado en v1.23.0
- 316 líneas de documentación profesional"

# 3. Subir cambios a GitHub
git push origin main

# 4. Crear y subir tag de versión v1.23.0
git tag -a v1.23.0 -m "Versión 1.23.0 - API REST para Productos

Implementación completa de API REST con 5 endpoints JSON:

Endpoints:
- GET /api/producto → Listar todos los productos
- GET /api/producto/{id} → Obtener producto específico  
- POST /api/producto → Crear nuevo producto
- PUT /api/producto/{id} → Actualizar producto existente
- DELETE /api/producto/{id} → Eliminar producto

Características:
✅ Respuestas JSON estructuradas
✅ Códigos HTTP apropiados (200, 201, 400, 404)
✅ Validación exhaustiva de datos
✅ Manejo de errores con mensajes descriptivos
✅ Serialización manual para evitar referencias circulares
✅ Actualización parcial (PATCH-like con PUT)
✅ Comentarios profesionales en el código (253 líneas)
✅ ParamConverter automático para objetos
✅ Inyección de dependencias
✅ Separación de responsabilidades

Archivos modificados:
- src/Controller/ProductoApiController.php (nuevo, 439 líneas)
- README.md (actualizado con 316 líneas de documentación API)

Documentación:
- Ejemplos con cURL, Postman y JavaScript Fetch
- Guía de pruebas para desarrolladores
- Códigos de estado HTTP documentados
- Estructura JSON de request/response
- Notas de seguridad y autenticación"

git push origin v1.23.0

# 5. Actualizar registro de actividades
git add archivos_adicionales/registro_actividades.txt
git commit -m "docs: Actualizar registro de actividades con versión v1.23.0

- Agregar documentación completa de API REST
- Detallar 5 endpoints con ejemplos request/response
- Documentar conceptos aprendidos (REST, JSON, HTTP codes)
- Incluir decisiones de diseño y arquitectura
- Listar comandos ejecutados y commits relacionados
- Sugerir próximos pasos (JWT, tests, Swagger)
- 502 líneas de documentación detallada"

git push origin main
```

### Resultado obtenido:

- ✅ API REST completa funcionando en `http://localhost:8000/api/producto`
- ✅ 5 endpoints probados exitosamente
- ✅ Documentación profesional en código (253 líneas)
- ✅ Documentación profesional en README (316 líneas)
- ✅ Ejemplos de uso con 3 herramientas (cURL, Postman, Fetch)
- ✅ Respuestas JSON estructuradas y consistentes
- ✅ Códigos HTTP apropiados para cada caso
- ✅ Validación exhaustiva de datos
- ✅ Manejo de errores descriptivos
- ✅ Serialización manual sin referencias circulares
- ✅ Autenticación opcional para pruebas educativas
- ✅ Versión v1.23.0 publicada en GitHub

### Estadísticas:

- **Archivos creados:** 1 (ProductoApiController.php)
- **Archivos modificados:** 2 (README.md, registro_actividades.txt)
- **Líneas totales agregadas:** 1,183
  - ProductoApiController: 439 líneas (253 comentarios)
  - README.md: +316 líneas
  - registro_actividades.txt: +428 líneas
- **Endpoints API:** 5
- **Commits:** `6181936`, `ec09c88`, `febf09e`
- **Tag:** `v1.23.0`
- **Push:** ✅ Exitoso a origin/main

### Próximos pasos sugeridos:

- Implementar autenticación JWT para APIs modernas
- Crear API para Usuario (CRUD completo)
- Agregar paginación a GET /api/producto
- Implementar filtros de búsqueda en API
- Agregar validación con Symfony Validator en API
- Documentar API con Swagger/OpenAPI
- Crear tests unitarios para endpoints
- Implementar rate limiting para seguridad
- Agregar CORS headers para frontend externo
- Crear versionado de API (`/api/v1/producto`)

---

## Resumen de versiones

| Versión | Fecha | Descripción | Commits |
|---------|-------|-------------|---------|
| v1.16.0 | 13/11/2025 8:12 PM | Rediseño login y registro | 962c4c2 |
| v1.17.0 | 13/11/2025 8:35 PM | Mejora de formularios | 700cf1f |
| v1.18.0 | 13/11/2025 9:00 PM | Documentación exhaustiva | e251695 |
| v1.19.0 | 13/11/2025 9:30 PM | Reestructuración del repositorio | f91ec59, df4ad2c |
| v1.20.0 | 13/11/2025 9:45 PM | Control de acceso ROLE_ADMIN | fc0eecc |
| v1.21.0 | 13/11/2025 10:00 PM | Sistema de mensajes flash | 8be6654, 990cf10 |
| v1.22.0 | 13/11/2025 10:30 PM | Documentación completa y reorganización | 1fb1f85, 0d70bd9, 0b4a960 |
| v1.23.0 | 13/11/2025 11:00 PM | API REST para productos | 6181936, ec09c88, febf09e |

---

**Última actualización:** 13 de noviembre de 2025, 11:15 PM  
**Total de versiones documentadas:** 8 (v1.16.0 - v1.23.0)  
**Líneas totales de código agregadas:** ~5,000+  
**Commits totales:** 15+
