<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

/**
 * CLASE PERSONALIZADA DE FORMULARIO PARA SELECCIÓN DE CATEGORÍAS
 * ================================================================
 * 
 * Esta clase extiende EntityType y proporciona configuración predeterminada
 * para seleccionar categorías en cualquier formulario.
 * 
 * VENTAJAS DE CREAR UN TIPO PERSONALIZADO:
 * - Reutilización: Se puede usar en múltiples formularios
 * - Consistencia: Todos los selects de categoría tendrán la misma configuración
 * - Mantenibilidad: Un solo lugar para cambiar el comportamiento
 * - Configuración predeterminada: Menos código repetitivo
 * 
 * USO EN OTROS FORMULARIOS:
 * 
 *   $builder->add('categoria', CategoriaSelectType::class);
 * 
 * O con opciones personalizadas:
 * 
 *   $builder->add('categoria', CategoriaSelectType::class, [
 *       'required' => false,
 *       'placeholder' => 'Opcional - Selecciona categoría',
 *   ]);
 */
class CategoriaSelectType extends AbstractType
{
    /**
     * Configurar las opciones predeterminadas del tipo de campo
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Clase de la entidad
            'class' => Categoria::class,
            
            // Campo que se mostrará como texto en las opciones
            'choice_label' => 'nombre',
            
            // Ordenar las categorías alfabéticamente
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nombre', 'ASC');
            },
            
            // Placeholder (opción vacía) predeterminado
            'placeholder' => '-- Selecciona una categoría --',
            
            // Campo requerido por defecto
            'required' => true,
            
            // Atributos HTML para el select
            'attr' => [
                'class' => 'form-select form-select-lg',  // Bootstrap 5
            ],
            
            // Label predeterminado
            'label' => 'Categoría',
            
            // Atributos del label
            'label_attr' => [
                'class' => 'fw-bold text-primary',
            ],
            
            // Texto de ayuda predeterminado
            'help' => 'Selecciona la categoría a la que pertenece este producto',
            
            // Atributos del texto de ayuda
            'help_attr' => [
                'class' => 'text-muted small fst-italic',
            ],
            
            // Permitir que se anulen estas opciones al usar el tipo
            'allow_extra_options' => true,
        ]);
    }

    /**
     * Definir el tipo padre del cual hereda
     * 
     * Al heredar de EntityType, obtenemos toda la funcionalidad
     * de carga de entidades desde la base de datos
     */
    public function getParent(): string
    {
        return EntityType::class;
    }

    /**
     * Nombre único del tipo (opcional, pero recomendado)
     */
    public function getBlockPrefix(): string
    {
        return 'categoria_select';
    }
}
