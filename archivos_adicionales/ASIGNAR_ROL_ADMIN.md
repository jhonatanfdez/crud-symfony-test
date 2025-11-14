# 🔐 Cómo Asignar Rol ADMIN a un Usuario

Este documento explica cómo asignar el rol `ROLE_ADMIN` a un usuario para que pueda crear, editar y eliminar categorías.

## 📋 Contexto

Por defecto, todos los usuarios registrados tienen el rol `ROLE_USER`. Este rol permite:
- ✅ Ver categorías
- ✅ Ver productos
- ✅ Crear productos
- ✅ Editar productos
- ✅ Eliminar productos

Pero **NO permite**:
- ❌ Crear categorías
- ❌ Editar categorías
- ❌ Eliminar categorías

Para realizar estas acciones, el usuario necesita el rol `ROLE_ADMIN`.

---

## 🛠️ Método 1: Usando la Consola de Symfony (Recomendado)

### Paso 1: Conectarse a la base de datos con Symfony CLI

```bash
cd /ruta/a/tu/proyecto/crud-symfony
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'usuario@example.com'"
```

**Reemplaza:**
- `usuario@example.com` con el email del usuario al que quieres dar permisos de administrador

### Ejemplo completo:
```bash
# Dar rol ADMIN al usuario admin@test.com
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'admin@test.com'"
```

---

## 🛠️ Método 2: Usando phpMyAdmin o MySQL Workbench (Visual)

### Paso 1: Acceder a phpMyAdmin
1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `crud_symfony`

### Paso 2: Buscar el usuario
1. Haz clic en la tabla `user`
2. Encuentra el usuario al que quieres dar permisos (busca por email)

### Paso 3: Editar el campo roles
1. Haz clic en **Editar** (icono de lápiz)
2. En el campo `roles`, cambia el valor a:
   ```json
   ["ROLE_ADMIN"]
   ```
3. Haz clic en **Continuar** para guardar

---

## 🛠️ Método 3: Usando la Terminal de MySQL

### Paso 1: Conectarse a MySQL
```bash
mysql -u root -p
```

### Paso 2: Seleccionar la base de datos
```sql
USE crud_symfony;
```

### Paso 3: Actualizar el usuario
```sql
UPDATE user 
SET roles = '["ROLE_ADMIN"]' 
WHERE email = 'admin@test.com';
```

### Paso 4: Verificar el cambio
```sql
SELECT id, email, roles FROM user WHERE email = 'admin@test.com';
```

Deberías ver:
```
+----+------------------+-----------------+
| id | email            | roles           |
+----+------------------+-----------------+
|  1 | admin@test.com   | ["ROLE_ADMIN"]  |
+----+------------------+-----------------+
```

### Paso 5: Salir de MySQL
```sql
EXIT;
```

---

## 🔍 Verificar que Funciona

### 1. Cerrar sesión y volver a iniciar sesión
El cambio de roles solo se aplica cuando el usuario inicia sesión nuevamente.

### 2. Ir a la página de Categorías
```
http://localhost:8000/categoria
```

### 3. Verificar que aparecen los botones:
- ✅ **Nueva Categoría** (arriba a la derecha)
- ✅ **Editar** (en cada categoría de la tabla)
- ✅ **Eliminar** (en cada categoría de la tabla)

---

## 👥 Usuario con Múltiples Roles

Si quieres que un usuario tenga ambos roles (USER y ADMIN):

```json
["ROLE_USER", "ROLE_ADMIN"]
```

**Ejemplo SQL:**
```sql
UPDATE user 
SET roles = '["ROLE_USER", "ROLE_ADMIN"]' 
WHERE email = 'admin@test.com';
```

---

## 📝 Notas Importantes

1. **El campo roles es JSON**: Debe estar entre corchetes `[]` y con comillas dobles `"`
2. **Mayúsculas**: Los roles SIEMPRE en mayúsculas: `ROLE_ADMIN`, no `role_admin`
3. **Cerrar sesión**: Los cambios solo se aplican al iniciar sesión nuevamente
4. **ROLE_USER automático**: Symfony agrega automáticamente `ROLE_USER` a todos los usuarios, no es necesario incluirlo manualmente

---

## 🚨 Solución de Problemas

### Problema: No aparecen los botones después de asignar ROLE_ADMIN

**Solución:**
1. Verifica que hayas cerrado sesión y vuelto a iniciar sesión
2. Verifica en la base de datos que el campo `roles` se guardó correctamente:
   ```sql
   SELECT email, roles FROM user WHERE email = 'tu@email.com';
   ```
3. Limpia la caché de Symfony:
   ```bash
   php bin/console cache:clear
   ```

### Problema: Error "Array to string conversion"

**Causa:** El formato JSON del campo `roles` está mal escrito

**Solución:** Asegúrate de usar el formato correcto:
```json
["ROLE_ADMIN"]
```

NO uses:
- `"ROLE_ADMIN"` (sin corchetes)
- `['ROLE_ADMIN']` (comillas simples)
- `[ROLE_ADMIN]` (sin comillas)

---

## 🎓 Explicación Técnica

### ¿Cómo funciona `is_granted()` en Twig?

En las plantillas usamos:
```twig
{% if is_granted('ROLE_ADMIN') %}
    <!-- Botón visible solo para ADMIN -->
{% endif %}
```

Esto verifica si el usuario actual tiene el rol `ROLE_ADMIN` en su campo `roles` de la base de datos.

### ¿Cómo funciona en el controlador?

En `CategoriaController.php` usamos:
```php
if (!$this->isGranted('ROLE_ADMIN')) {
    $this->addFlash('error', 'Usted no tiene privilegios para esta acción');
    return $this->redirectToRoute('app_categoria_index');
}
```

Esto:
1. Verifica el rol del usuario
2. Si NO tiene `ROLE_ADMIN`, muestra un mensaje flash de error
3. Redirige al index de categorías

---

## 📚 Recursos Adicionales

- [Documentación oficial de Symfony Security](https://symfony.com/doc/current/security.html)
- [Jerarquía de Roles en Symfony](https://symfony.com/doc/current/security.html#hierarchical-roles)
- [Voters en Symfony](https://symfony.com/doc/current/security/voters.html)

---

## ✅ Resumen Rápido

**Comando más rápido para asignar ROLE_ADMIN:**
```bash
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'admin@test.com'"
```

**Luego:**
1. Cierra sesión
2. Vuelve a iniciar sesión
3. Ve a `/categoria`
4. ¡Deberías ver todos los botones! 🎉
