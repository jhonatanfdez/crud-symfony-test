# 📝 GUÍA COMPLETA DE FORMULARIOS EN SYMFONY

## 🎯 Propósito de este documento

Este documento explica todas las opciones, propiedades y características disponibles para crear formularios en Symfony, usando `ProductoType` como ejemplo práctico.

---

## 🏗️ ESTRUCTURA BÁSICA DE UN FORMULARIO

```php
class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nombre_campo', TipoDeCampo::class, [
            // Opciones del campo
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
```

---

## 📚 TIPOS DE CAMPOS DISPONIBLES

### 1. **TextType** - Campos de texto simple

```php
use Symfony\Component\Form\Extension\Core\Type\TextType;

->add('nombre', TextType::class, [
    'label' => 'Nombre',
    'attr' => ['placeholder' => 'Ingresa el nombre'],
])
```

**Renderiza:** `<input type="text" name="nombre" />`

---

### 2. **NumberType** - Campos numéricos

```php
use Symfony\Component\Form\Extension\Core\Type\NumberType;

->add('precio', NumberType::class, [
    'scale' => 2,        // 2 decimales
    'html5' => true,     // Usa input type="number"
    'attr' => [
        'step' => '0.01',
        'min' => '0',
    ],
])
```

**Renderiza:** `<input type="number" step="0.01" min="0" />`

---

### 3. **TextareaType** - Áreas de texto grandes

```php
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

->add('descripcion', TextareaType::class, [
    'attr' => [
        'rows' => 5,
        'placeholder' => 'Describe el producto...',
    ],
])
```

**Renderiza:** `<textarea rows="5"></textarea>`

---

### 4. **EmailType** - Campos de email

```php
use Symfony\Component\Form\Extension\Core\Type\EmailType;

->add('email', EmailType::class)
```

**Renderiza:** `<input type="email" />` (con validación HTML5)

---

### 5. **PasswordType** - Campos de contraseña

```php
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

->add('password', PasswordType::class, [
    'always_empty' => false,  // Mantener valor después de error
])
```

**Renderiza:** `<input type="password" />` (oculta caracteres)

---

### 6. **ChoiceType** - Listas desplegables (selects)

```php
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

->add('estado', ChoiceType::class, [
    'choices' => [
        'Activo' => 'activo',
        'Inactivo' => 'inactivo',
        'Pendiente' => 'pendiente',
    ],
    'placeholder' => '-- Selecciona --',
])
```

**Renderiza:** `<select><option>...</option></select>`

---

### 7. **EntityType** - Select con datos de base de datos

```php
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

->add('categoria', EntityType::class, [
    'class' => Categoria::class,
    'choice_label' => 'nombre',
    'placeholder' => '-- Selecciona --',
])
```

**Renderiza:** `<select>` con opciones cargadas desde la tabla `categoria`

---

### 8. **CheckboxType** - Casillas de verificación

```php
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

->add('activo', CheckboxType::class, [
    'label' => '¿Producto activo?',
    'required' => false,
])
```

**Renderiza:** `<input type="checkbox" />`

---

### 9. **DateType / DateTimeType** - Selectores de fecha

```php
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

->add('fecha_nacimiento', DateType::class, [
    'widget' => 'single_text',  // Un solo input
    'html5' => true,            // Usa <input type="date">
])

->add('fecha_hora', DateTimeType::class, [
    'widget' => 'single_text',
    'html5' => true,
])
```

---

### 10. **FileType** - Upload de archivos

```php
use Symfony\Component\Form\Extension\Core\Type\FileType;

->add('imagen', FileType::class, [
    'mapped' => false,  // No mapear directamente a la entidad
    'required' => false,
    'attr' => ['accept' => 'image/*'],
])
```

**Renderiza:** `<input type="file" accept="image/*" />`

---

## 🎨 OPCIONES COMUNES PARA TODOS LOS CAMPOS

### 1. **label** - Etiqueta del campo

```php
'label' => 'Nombre del Producto'
```

Texto que aparece encima del campo.

---

### 2. **label_attr** - Atributos HTML del label

```php
'label_attr' => [
    'class' => 'fw-bold text-primary',
    'style' => 'font-size: 1.2rem;',
]
```

---

### 3. **attr** - Atributos HTML del input

```php
'attr' => [
    'class' => 'form-control',
    'placeholder' => 'Ingresa el valor',
    'maxlength' => 100,
    'autocomplete' => 'off',
    'data-custom' => 'value',
]
```

Cualquier atributo HTML válido: `class`, `id`, `style`, `data-*`, etc.

---

### 4. **placeholder** - Texto dentro del input

```php
'attr' => [
    'placeholder' => 'Ej: Laptop HP Pavilion',
]
```

Texto de ayuda que desaparece al escribir.

---

### 5. **help** - Texto de ayuda debajo del campo

```php
'help' => 'Ingresa un nombre descriptivo (máximo 255 caracteres)'
```

Siempre visible, útil para instrucciones.

---

### 6. **help_attr** - Atributos del texto de ayuda

```php
'help_attr' => [
    'class' => 'text-muted small fst-italic',
]
```

---

### 7. **required** - Campo obligatorio

```php
'required' => true,  // Campo obligatorio (predeterminado)
'required' => false, // Campo opcional
```

Agrega el atributo HTML `required` y validación en el servidor.

---

### 8. **disabled** - Deshabilitar campo

```php
'disabled' => true,
```

El campo se muestra pero no se puede editar ni enviar.

---

### 9. **mapped** - Mapeo con la entidad

```php
'mapped' => false,
```

Si es `false`, el campo NO se vincula con ninguna propiedad de la entidad (útil para campos calculados o archivos).

---

### 10. **data** - Valor predeterminado

```php
'data' => 'Valor inicial',
```

Valor que tendrá el campo si la entidad no tiene valor.

---

## ✅ VALIDACIONES (constraints)

### Importar las clases de validación:

```php
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
```

---

### 1. **NotBlank** - No puede estar vacío

```php
'constraints' => [
    new NotBlank([
        'message' => 'El nombre es obligatorio',
    ]),
]
```

---

### 2. **Length** - Longitud mínima/máxima

```php
'constraints' => [
    new Length([
        'min' => 3,
        'max' => 255,
        'minMessage' => 'Mínimo {{ limit }} caracteres',
        'maxMessage' => 'Máximo {{ limit }} caracteres',
    ]),
]
```

---

### 3. **Email** - Validar formato de email

```php
'constraints' => [
    new Email([
        'message' => 'Email inválido',
    ]),
]
```

---

### 4. **Positive** - Número positivo

```php
'constraints' => [
    new Positive([
        'message' => 'El precio debe ser positivo',
    ]),
]
```

---

### 5. **Range** - Rango de valores

```php
'constraints' => [
    new Range([
        'min' => 1,
        'max' => 100,
        'notInRangeMessage' => 'Debe estar entre {{ min }} y {{ max }}',
    ]),
]
```

---

### 6. **LessThanOrEqual** - Menor o igual a

```php
'constraints' => [
    new LessThanOrEqual([
        'value' => 999999.99,
        'message' => 'No puede exceder {{ compared_value }}',
    ]),
]
```

---

### 7. **Regex** - Expresión regular

```php
'constraints' => [
    new Regex([
        'pattern' => '/^[a-zA-Z0-9]+$/',
        'message' => 'Solo letras y números',
    ]),
]
```

---

### 8. **Múltiples validaciones**

```php
'constraints' => [
    new NotBlank(),
    new Length(['min' => 3, 'max' => 100]),
    new Regex(['pattern' => '/^[a-zA-Z\s]+$/']),
]
```

---

## 🔧 OPCIONES ESPECÍFICAS POR TIPO

### **NumberType** - Opciones especiales

```php
'scale' => 2,           // Decimales permitidos
'html5' => true,        // Usar <input type="number">
'grouping' => false,    // Agrupar miles (1,234.56)
'rounding_mode' => \NumberFormatter::ROUND_HALFUP,
```

---

### **EntityType** - Opciones especiales

```php
'class' => Categoria::class,        // Clase de la entidad
'choice_label' => 'nombre',         // Campo a mostrar
'query_builder' => function(EntityRepository $er) {
    return $er->createQueryBuilder('c')
        ->where('c.activo = :activo')
        ->setParameter('activo', true)
        ->orderBy('c.nombre', 'ASC');
},
'placeholder' => '-- Selecciona --',
'multiple' => false,                // Selección múltiple
'expanded' => false,                // Radios en lugar de select
```

---

### **ChoiceType** - Opciones especiales

```php
'choices' => [
    'Texto mostrado' => 'valor_guardado',
],
'multiple' => false,    // Selección múltiple (checkboxes)
'expanded' => false,    // Radio buttons en lugar de select
'placeholder' => '-- Selecciona --',
```

---

### **DateType / DateTimeType** - Opciones especiales

```php
'widget' => 'single_text',  // Un solo input (recomendado)
'html5' => true,            // Usar <input type="date">
'format' => 'yyyy-MM-dd',   // Formato de fecha
'years' => range(1900, 2025), // Años disponibles (si widget='choice')
```

---

### **FileType** - Opciones especiales

```php
'mapped' => false,          // No mapear a la entidad
'multiple' => false,        // Subir múltiples archivos
'attr' => [
    'accept' => 'image/*',  // Solo imágenes
],
```

---

## 🎭 CAMPOS CONDICIONALES

```php
if ($options['is_edit']) {
    $builder->add('fecha', DateTimeType::class, [
        'disabled' => true,
    ]);
}
```

Solo agrega el campo si se cumple una condición.

---

## 🌟 CLASES DE FORMULARIO PERSONALIZADAS

Crear tipos reutilizables:

```php
// src/Form/CategoriaSelectType.php
class CategoriaSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Categoria::class,
            'choice_label' => 'nombre',
            'placeholder' => '-- Selecciona --',
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
```

**Usar en otros formularios:**

```php
->add('categoria', CategoriaSelectType::class)
```

---

## 🎨 INTEGRACIÓN CON BOOTSTRAP 5

### Clases CSS útiles:

```php
'attr' => [
    'class' => 'form-control',          // Input normal
    'class' => 'form-control-lg',       // Input grande
    'class' => 'form-control-sm',       // Input pequeño
    'class' => 'form-select',           // Select
    'class' => 'form-check-input',      // Checkbox/Radio
]

'label_attr' => [
    'class' => 'fw-bold',               // Label en negrita
    'class' => 'text-primary',          // Label azul
]

'help_attr' => [
    'class' => 'text-muted small',      // Ayuda pequeña gris
    'class' => 'fst-italic',            // Cursiva
]
```

---

## 📖 EJEMPLO COMPLETO

```php
<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del Producto',
                'attr' => [
                    'placeholder' => 'Ej: Laptop HP',
                    'class' => 'form-control-lg',
                ],
                'help' => 'Nombre descriptivo del producto',
                'constraints' => [
                    new NotBlank(['message' => 'El nombre es obligatorio']),
                    new Length(['min' => 3, 'max' => 255]),
                ],
            ])
            ->add('precio', NumberType::class, [
                'label' => 'Precio',
                'scale' => 2,
                'attr' => ['placeholder' => '0.00'],
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ],
            ])
            ->add('descripcion', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 4],
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',
                'placeholder' => '-- Selecciona --',
            ])
        ;
    }
}
```

---

## 🚀 RECURSOS ADICIONALES

- [Documentación oficial de Symfony Forms](https://symfony.com/doc/current/forms.html)
- [Reference de Field Types](https://symfony.com/doc/current/reference/forms/types.html)
- [Validation Constraints](https://symfony.com/doc/current/validation.html)
- [Form Theming con Bootstrap](https://symfony.com/doc/current/form/bootstrap5.html)

---

**✨ ¡Este documento cubre todas las opciones principales de formularios en Symfony!**
