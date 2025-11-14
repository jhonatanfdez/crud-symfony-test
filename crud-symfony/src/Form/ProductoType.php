<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // =====================================================================
            // CAMPO NOMBRE - TextType con validaciones y propiedades completas
            // =====================================================================
            // Tipo: TextType - Renderiza un input type="text"
            // Label: Texto que aparece encima del campo
            // Placeholder: Texto de ayuda dentro del input (desaparece al escribir)
            // Help: Texto informativo debajo del campo (siempre visible)
            // Attr: Atributos HTML adicionales (class, maxlength, etc.)
            // Constraints: Validaciones que se aplican al campo
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del Producto',
                'label_attr' => [
                    'class' => 'fw-bold',  // Label en negrita
                ],
                'attr' => [
                    'placeholder' => 'Ej: Laptop HP Pavilion 15',
                    'class' => 'form-control',
                    'maxlength' => 255,  // Máximo de caracteres permitidos
                    'autocomplete' => 'off',  // Desactivar autocompletado del navegador
                ],
                'help' => 'Ingresa un nombre descriptivo para el producto (máximo 255 caracteres)',
                'help_attr' => [
                    'class' => 'text-muted small',  // Estilo del texto de ayuda
                ],
                'required' => true,  // Campo obligatorio
                'constraints' => [
                    // Validación: El campo no puede estar vacío
                    new NotBlank([
                        'message' => 'El nombre del producto es obligatorio',
                    ]),
                    // Validación: Longitud mínima y máxima
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'El nombre debe tener al menos {{ limit }} caracteres',
                        'maxMessage' => 'El nombre no puede exceder {{ limit }} caracteres',
                    ]),
                ],
            ])
            
            // =====================================================================
            // CAMPO PRECIO - NumberType con validaciones numéricas
            // =====================================================================
            // Tipo: NumberType - Renderiza un input type="number" con soporte decimal
            // Scale: Cantidad de decimales permitidos (2 = centavos)
            // Html5: Si es true, usa input type="number", si es false usa type="text"
            // Grouping: Si es true, agrupa miles con comas (ej: 1,234.56)
            ->add('precio', NumberType::class, [
                'label' => 'Precio del Producto',
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'attr' => [
                    'placeholder' => '0.00',
                    'class' => 'form-control',
                    'step' => '0.01',  // Incremento de 1 centavo
                    'min' => '0.01',   // Valor mínimo permitido
                ],
                'help' => 'Precio en dólares (máximo $999,999.99). Usa formato decimal: 1234.56',
                'help_attr' => [
                    'class' => 'text-muted small',
                ],
                'required' => true,
                'scale' => 2,  // 2 decimales (centavos)
                'html5' => true,  // Usar input type="number" de HTML5
                'constraints' => [
                    // Validación: No puede estar vacío
                    new NotBlank([
                        'message' => 'El precio es obligatorio',
                    ]),
                    // Validación: Debe ser un número positivo mayor a 0
                    new Positive([
                        'message' => 'El precio debe ser mayor a 0',
                    ]),
                    // Validación: No puede exceder 999,999.99
                    new LessThanOrEqual([
                        'value' => 999999.99,
                        'message' => 'El precio no puede exceder $999,999.99',
                    ]),
                ],
            ])
            
            // =====================================================================
            // CAMPO CATEGORIA - EntityType (Select con entidades de base de datos)
            // =====================================================================
            // Tipo: EntityType - Carga opciones desde una entidad (tabla de BD)
            // Class: La clase de la entidad a cargar
            // Choice_label: El campo de la entidad que se mostrará como texto
            // Placeholder: Opción vacía inicial ("Seleccione...")
            // Query_builder: Permite personalizar la consulta (filtros, orden)
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',  // Mostrar el nombre de la categoría
                'label' => 'Categoría',
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'attr' => [
                    'class' => 'form-select',  // Clase de Bootstrap para selects
                ],
                'placeholder' => '-- Selecciona una categoría --',  // Opción vacía
                'help' => 'Selecciona la categoría a la que pertenece este producto',
                'help_attr' => [
                    'class' => 'text-muted small',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debes seleccionar una categoría',
                    ]),
                ],
            ])
        ;
        
        // =====================================================================
        // CAMPO CONDICIONAL FECHA: Solo mostrar en EDICIÓN (deshabilitado)
        // =====================================================================
        // En creación NO aparece porque se genera automáticamente con PrePersist
        // En edición SÍ aparece pero está deshabilitado para preservar la fecha original
        if ($options['is_edit']) {
            $builder->add('fecha', DateTimeType::class, [
                'label' => 'Fecha de Creación',
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'disabled' => true,  // Siempre deshabilitado en edición
                'required' => false,
                'widget' => 'single_text',  // Renderiza como un solo input
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,  // Atributo HTML adicional
                ],
                'help' => 'La fecha de creación no se puede modificar',
                'help_attr' => [
                    'class' => 'text-warning small',
                ],
            ]);
        }
        
        // =====================================================================
        // CAMPO CONDICIONAL USER: Solo mostrar en modo EDICIÓN
        // =====================================================================
        // Cuando show_user es false (en creación), este campo NO aparece
        // Cuando show_user es true (en edición), permite cambiar el usuario asignado
        if ($options['show_user']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',  // Mostrar el email del usuario
                'label' => 'Usuario Asignado',
                'label_attr' => [
                    'class' => 'fw-bold',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'placeholder' => '-- Selecciona un usuario --',
                'help' => 'Usuario responsable de este producto',
                'help_attr' => [
                    'class' => 'text-muted small',
                ],
                'required' => false,  // Campo opcional
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            
            // =====================================================================
            // OPCIONES PERSONALIZADAS DEL FORMULARIO
            // =====================================================================
            
            // OPCIÓN: show_user
            // Controla si el campo 'user' se muestra en el formulario
            // - false (predeterminado): No muestra el campo user (útil al crear)
            // - true: Muestra el campo user (útil al editar)
            // Uso en controlador: $form = $this->createForm(ProductoType::class, $producto, ['show_user' => true]);
            'show_user' => false,
            
            // OPCIÓN: is_edit
            // Controla si el campo 'fecha' se muestra en el formulario
            // - false (predeterminado): No muestra fecha (creación automática con PrePersist)
            // - true: Muestra fecha deshabilitada (solo lectura en edición)
            // Uso en controlador: $form = $this->createForm(ProductoType::class, $producto, ['is_edit' => true]);
            'is_edit' => false,
        ]);
        
        // PERMITIR OPCIONES ADICIONALES
        // Esto permite pasar opciones personalizadas al formulario sin errores
        $resolver->setAllowedTypes('show_user', 'bool');
        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}

/*
 * ============================================================================
 * EJEMPLO ALTERNATIVO: USAR LA CLASE PERSONALIZADA CategoriaSelectType
 * ============================================================================
 * 
 * Si descomentas la siguiente línea y comentas el campo 'categoria' actual,
 * usarás la clase personalizada CategoriaSelectType que creamos.
 * 
 * VENTAJAS:
 * - Código más limpio y corto
 * - Reutilizable en otros formularios
 * - Configuración centralizada
 * 
 * Para usarlo, reemplaza el campo 'categoria' con:
 * 
 *   ->add('categoria', CategoriaSelectType::class)
 * 
 * O con opciones personalizadas:
 * 
 *   ->add('categoria', CategoriaSelectType::class, [
 *       'help' => 'Texto de ayuda personalizado',
 *       'required' => false,
 *   ])
 * 
 * NOTA: No olvides agregar el use al inicio del archivo:
 *   use App\Form\CategoriaSelectType;
 * ============================================================================
 */
