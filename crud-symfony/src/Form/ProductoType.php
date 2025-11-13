<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Campos básicos del producto
            ->add('nombre')
            ->add('precio')
            ->add('fecha')
            
            // Campo categoria: select con las categorías disponibles
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',  // Mostrar el nombre de la categoría en lugar del ID
            ])
        ;
        
        // CAMPO CONDICIONAL: Solo mostrar el campo user en modo EDICIÓN
        // Cuando show_user es false (en creación), este campo NO aparece en el formulario
        // Cuando show_user es true (en edición), este campo SÍ aparece y permite cambiar el usuario
        if ($options['show_user']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',  // Mostrar el email del usuario en lugar del ID
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            
            // OPCIÓN PERSONALIZADA: show_user
            // Por defecto es false, lo que significa que el campo user NO se muestra
            // En el controlador, al editar pasamos ['show_user' => true] para mostrarlo
            'show_user' => false,
        ]);
    }
}
