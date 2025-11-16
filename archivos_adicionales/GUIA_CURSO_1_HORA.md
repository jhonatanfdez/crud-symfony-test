# 🎓 Guía de Curso Symfony - 1 Hora

**Proyecto:** CRUD Symfony con Autenticación y Roles  
**Duración:** 60 minutos  
**Objetivo:** Crear una aplicación web funcional con sistema de usuarios, categorías y productos

---

## 📋 Tabla de Contenidos

1. [Preparación del Entorno (10 min)](#1-preparación-del-entorno)
2. [Creación del Proyecto (5 min)](#2-creación-del-proyecto)
3. [Configuración de Base de Datos (5 min)](#3-configuración-de-base-de-datos)
4. [Creación de Todas las Entidades (10 min)](#4-creación-de-todas-las-entidades)
5. [Sistema de Autenticación (8 min)](#5-sistema-de-autenticación)
6. [Controladores Base (7 min)](#6-controladores-base)
7. [CRUD Automático (8 min)](#7-crud-automático)
8. [Mejoras Visuales y Funcionales (7 min)](#8-mejoras-visuales-y-funcionales)

---

## 1. Preparación del Entorno
**⏱️ Tiempo: 10 minutos**

### 1.1 Instalaciones Necesarias

#### Git
```bash
# Verificar instalación
git --version

# Si no está instalado:
# Linux: sudo apt install git
# Windows: https://git-scm.com/download/win
# macOS: brew install git
```

#### Composer
```bash
# Verificar instalación
composer --version

# Si no está instalado:
# Linux/macOS:
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Windows:
# https://getcomposer.org/Composer-Setup.exe
```

#### PHP 8.2+
```bash
# Verificar versión
php -v

# Debe ser PHP 8.2 o superior
```

#### Symfony CLI
```bash
# Linux/macOS:
curl -sS https://get.symfony.com/cli/installer | bash

# Windows (Scoop):
scoop install symfony-cli

# Verificar:
symfony -v
```

### 1.2 Inicializar Git
```bash
mkdir mi-proyecto-symfony
cd mi-proyecto-symfony
git init
git config user.name "Tu Nombre"
git config user.email "tu@email.com"
```

---

## 2. Creación del Proyecto
**⏱️ Tiempo: 5 minutos**

### 2.1 Crear Proyecto Symfony

```bash
# Crear proyecto con todas las dependencias web
symfony new crud-symfony --version="7.1.*" --webapp

cd crud-symfony

# Verificar estructura
ls -la
```

**Explicación rápida de carpetas:**
- `/src/` → Código de la aplicación
- `/templates/` → Vistas Twig
- `/public/` → Archivos públicos
- `/config/` → Configuración

### 2.2 Iniciar Servidor

```bash
symfony server:start -d

# Abrir en navegador: https://127.0.0.1:8000
```

### 2.3 Primer Commit

```bash
git add .
git commit -m "Proyecto Symfony inicial v7.1"
```

---

## 3. Configuración de Base de Datos
**⏱️ Tiempo: 5 minutos**

### 3.1 Configurar MySQL

Editar `.env`:
```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/crud_symfony?serverVersion=8.0"
```

### 3.2 Crear Base de Datos

```bash
php bin/console doctrine:database:create
```

**Commit:**
```bash
git add .env
git commit -m "Configuración de base de datos MySQL"
```

---

## 4. Creación de Todas las Entidades
**⏱️ Tiempo: 10 minutos**

### 4.1 Entidad User (Autenticación)

```bash
php bin/console make:user
# ✓ User
# ✓ yes (store in database)
# ✓ email
# ✓ yes (password hashing)
```

### 4.2 Entidad Categoria

```bash
php bin/console make:entity Categoria
```
Campos a crear:
- `nombre`: string, 100, no

### 4.3 Entidad Producto

```bash
php bin/console make:entity Producto
```
Campos a crear:
- `nombre`: string, 150, no
- `precio`: decimal (precision: 10, scale: 2), no
- `fecha`: datetime, yes (nullable)
- `categoria`: relation
  - Tipo: ManyToOne
  - Clase relacionada: Categoria
  - ¿Nullable? no
  - ¿Mapear el otro lado? yes (productos)
- `user`: relation
  - Tipo: ManyToOne
  - Clase relacionada: User
  - ¿Nullable? yes
  - ¿Mapear el otro lado? no

### 4.4 Generar y Ejecutar Migraciones

```bash
# Generar archivo de migración con TODAS las entidades
php bin/console make:migration

# Revisar el archivo generado en /migrations
# Debe incluir tablas: user, categoria, producto

# Ejecutar migración
php bin/console doctrine:migrations:migrate
```

**Verificar tablas creadas:**
```bash
php bin/console doctrine:schema:validate
# Debe mostrar: [OK] The database schema is in sync with the mapping files.
```

**Commit:**
```bash
git add .
git commit -m "Entidades creadas: User, Categoria y Producto"
```

---

## 5. Sistema de Autenticación
**⏱️ Tiempo: 8 minutos**

### 5.1 Sistema de Login

```bash
php bin/console make:auth
# ✓ 1 (Login form authenticator)
# ✓ LoginFormAuthenticator
# ✓ SecurityController
# ✓ yes (logout route)
```

### 5.2 Sistema de Registro

```bash
php bin/console make:registration-form
# ✓ no (no email verification)
# ✓ yes (auto authenticate)
```

### 5.3 Mejorar Rutas de Login/Registro

**`templates/security/login.html.twig`:**
```twig
{# Agregar después del formulario: #}
<p>¿No tienes cuenta? <a href="{{ path('app_register') }}">Regístrate aquí</a></p>
```

**`templates/registration/register.html.twig`:**
```twig
{# Agregar después del formulario: #}
<p>¿Ya tienes cuenta? <a href="{{ path('app_login') }}">Inicia sesión aquí</a></p>
```

**Commit:**
```bash
git add .
git commit -m "Sistema de autenticación completo"
```

**⚡ DEMO:** Registrar usuario y hacer login

---

## 6. Controladores Base
**⏱️ Tiempo: 7 minutos**

### 6.1 Controlador Home

```bash
php bin/console make:controller HomeController
```

**Editar `src/Controller/HomeController.php`:**
```php
#[Route('/', name: 'app_home')]
public function index(
    ProductoRepository $productoRepo,
    CategoriaRepository $categoriaRepo
): Response {
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
    return $this->render('home/index.html.twig', [
        'totalProductos' => $productoRepo->count([]),
        'totalCategorias' => $categoriaRepo->count([]),
    ]);
}
```

### 6.2 Redirección de Login

**Editar `src/Security/LoginFormAuthenticator.php`:**
```php
public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
{
    return new RedirectResponse($this->urlGenerator->generate('app_home'));
}
```

**Commit:**
```bash
git add .
git commit -m "Controlador Home y redirección de login"
```

---

## 7. CRUD Automático
**⏱️ Tiempo: 8 minutos**

### 7.1 CRUD de Categoria

```bash
php bin/console make:crud Categoria
# ✓ CategoriaController
# ✓ yes (generate tests)
```

**Agregar seguridad en `src/Controller/CategoriaController.php`:**
```php
#[Route('/categoria')]
#[IsGranted('ROLE_USER')]
class CategoriaController extends AbstractController
{
    // ... resto del código
}
```

### 7.2 CRUD de Producto

```bash
php bin/console make:crud Producto
```

**Modificar `src/Controller/ProductoController.php` para asignar usuario automáticamente:**
```php
#[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $producto = new Producto();
    
    // Asignar usuario actual automáticamente
    $producto->setUser($this->getUser());
    
    $form = $this->createForm(ProductoType::class, $producto);
    // ... resto del código
}
```

**Ocultar campo user en formulario (`src/Form/ProductoType.php`):**
```php
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('nombre')
        ->add('precio')
        ->add('fecha')
        ->add('categoria')
        // ->add('user')  // ← Comentar esta línea
    ;
}
```

**Commit:**
```bash
git add .
git commit -m "CRUD completo de Categoria y Producto"
```

**⚡ DEMO:** Crear categoría y producto

---

## 8. Mejoras Visuales y Funcionales
**⏱️ Tiempo: 7 minutos**

### 8.1 Integrar Bootstrap 5

**Editar `templates/base.html.twig`:**
```twig
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{% block title %}CRUD Symfony{% endblock %}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {% block stylesheets %}{% endblock %}
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ path('app_home') }}">CRUD Symfony</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ path('app_categoria_index') }}">Categorías</a>
                <a class="nav-link" href="{{ path('app_producto_index') }}">Productos</a>
                <a class="nav-link" href="{{ path('app_logout') }}">Salir</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        {% block body %}{% endblock %}
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {% block javascripts %}{% endblock %}
</body>
</html>
```

### 8.2 Fecha Automática en Producto

**Editar `src/Entity/Producto.php`:**
```php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
#[ORM\HasLifecycleCallbacks]  // ← Agregar esto
class Producto
{
    // ... propiedades ...
    
    #[ORM\PrePersist]
    public function setFechaAutomatica(): void
    {
        if ($this->fecha === null) {
            $this->fecha = new \DateTime();
        }
    }
}
```

**Hacer campo fecha opcional en formulario (`src/Form/ProductoType.php`):**
```php
->add('fecha', null, [
    'required' => false,
    'label' => 'Fecha (opcional)',
])
```

### 8.3 Sistema de Roles Automático

**Editar `src/Controller/RegistrationController.php`:**
```php
#[Route('/register', name: 'app_register')]
public function register(Request $request, UserRepository $userRepository, /* ... */): Response
{
    $user = new User();
    
    // Primer usuario es ADMIN, los demás USER
    $totalUsers = $userRepository->count([]);
    if ($totalUsers === 0) {
        $user->setRoles(['ROLE_ADMIN']);
    } else {
        $user->setRoles(['ROLE_USER']);
    }
    
    // ... resto del código
}
```

**Commit final:**
```bash
git add .
git commit -m "Bootstrap, fecha automática y sistema de roles"
git tag v1.0.0
```

**⚡ DEMO FINAL:** Mostrar aplicación completa funcionando

---

## 🌟 Extras Avanzados (Si hay tiempo)

### 9.1 Mejoras en Formularios (Opcional - 3 min)

**Agregar validaciones y opciones en `src/Form/ProductoType.php`:**
```php
use Symfony\Component\Validator\Constraints as Assert;

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('nombre', TextType::class, [
            'label' => 'Nombre del Producto',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Ej: Laptop Dell XPS 15'
            ],
            'help' => 'Máximo 150 caracteres',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 150])
            ]
        ])
        ->add('precio', NumberType::class, [
            'label' => 'Precio',
            'scale' => 2,
            'attr' => [
                'class' => 'form-control',
                'step' => '0.01',
                'min' => '0'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThanOrEqual(999999)
            ]
        ])
        ->add('fecha', DateType::class, [
            'required' => false,
            'widget' => 'single_text',
            'label' => 'Fecha (opcional)',
            'attr' => ['class' => 'form-control']
        ])
        ->add('categoria', EntityType::class, [
            'class' => Categoria::class,
            'choice_label' => 'nombre',
            'label' => 'Categoría',
            'attr' => ['class' => 'form-control']
        ])
    ;
}
```

### 9.2 API REST Simple (Opcional - 4 min)

**Crear `src/Controller/ProductoApiController.php`:**
```php
<?php

namespace App\Controller;

use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/producto')]
class ProductoApiController extends AbstractController
{
    #[Route('', name: 'api_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): JsonResponse
    {
        $productos = $productoRepository->findAll();
        $data = [];
        
        foreach ($productos as $producto) {
            $data[] = [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'precio' => $producto->getPrecio(),
                'categoria' => [
                    'id' => $producto->getCategoria()->getId(),
                    'nombre' => $producto->getCategoria()->getNombre()
                ]
            ];
        }
        
        return $this->json($data);
    }
    
    #[Route('/{id}', name: 'api_producto_show', methods: ['GET'])]
    public function show(int $id, ProductoRepository $productoRepository): JsonResponse
    {
        $producto = $productoRepository->find($id);
        
        if (!$producto) {
            return $this->json(['error' => 'Producto no encontrado'], 404);
        }
        
        $data = [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'fecha' => $producto->getFecha()?->format('Y-m-d'),
            'categoria' => [
                'id' => $producto->getCategoria()->getId(),
                'nombre' => $producto->getCategoria()->getNombre()
            ]
        ];
        
        return $this->json($data);
    }
}
```

**Probar API:**
```bash
# Listar todos los productos
curl http://localhost:8000/api/producto

# Ver un producto específico
curl http://localhost:8000/api/producto/1
```

**Commit extras:**
```bash
git add .
git commit -m "Mejoras en formularios y API REST básica"
```

---

## 🎯 Resumen del Curso

### Lo que construimos:
✅ Proyecto Symfony 7.1 con arquitectura MVC  
✅ Sistema de autenticación (login/registro)  
✅ Sistema de roles (ADMIN/USER)  
✅ Base de datos MySQL con Doctrine  
✅ 3 entidades relacionadas (User, Categoria, Producto)  
✅ CRUD completo con formularios  
✅ Interfaz Bootstrap 5  
✅ Asignación automática de usuario  
✅ Fecha automática en productos  
✅ **BONUS:** Validaciones en formularios y API REST básica

### Conceptos cubiertos:
- MVC Pattern
- ORM (Doctrine)
- Relaciones de base de datos (ManyToOne)
- Autenticación y Autorización
- Formularios Symfony con validaciones
- Twig Templates
- Migrations
- Routing
- Dependency Injection
- API REST con JSON
- HTTP Status Codes

### Próximos pasos (fuera del curso):
- Mensajes flash
- Paginación
- Búsqueda y filtros
- API REST completa (POST, PUT, DELETE)
- Autenticación API (JWT)
- Tests automatizados
- Deploy en producción

---

## 📚 Recursos Adicionales

- **Documentación oficial:** https://symfony.com/doc/current/index.html
- **Symfony CLI:** https://symfony.com/download
- **Doctrine:** https://www.doctrine-project.org/
- **Twig:** https://twig.symfony.com/
- **Bootstrap:** https://getbootstrap.com/

---

**¡Gracias por seguir el curso! 🚀**

**Repositorio del proyecto:** [Agregar tu URL de GitHub]
