<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para la entidad Categoría
 * 
 * Este formulario maneja la creación y edición de categorías.
 * Es un formulario simple con un solo campo: nombre.
 * 
 * @package App\Form
 */
class CategoriaType extends AbstractType
{
    /**
     * Construye el formulario
     * 
     * Define qué campos tendrá el formulario y sus configuraciones.
     * En este caso, solo tiene el campo 'nombre' con configuración por defecto.
     * 
     * @param FormBuilderInterface $builder - Constructor del formulario
     * @param array $options - Opciones pasadas al formulario
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campo 'nombre': Se renderiza automáticamente como TextType
            // Symfony detecta el tipo basándose en la propiedad de la entidad
            // Si necesitas personalizar (label, placeholder, etc.), usa las opciones
            // Ejemplo: ->add('nombre', TextType::class, ['label' => 'Nombre de la Categoría'])
            ->add('nombre')
        ;
    }

    /**
     * Configura las opciones del formulario
     * 
     * Establece la clase de entidad a la que está asociado este formulario.
     * Esto permite que Symfony mapee automáticamente los datos del formulario
     * a las propiedades de la entidad Categoria.
     * 
     * @param OptionsResolver $resolver - Resolvedor de opciones
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Vincula este formulario con la entidad Categoria
            // Symfony automáticamente poblará los campos del formulario
            // con los datos de la entidad y viceversa
            'data_class' => Categoria::class,
        ]);
    }
}
