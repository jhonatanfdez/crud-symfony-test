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
            ->add('nombre')
            ->add('precio')
            ->add('fecha')
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nombre',  // Mostrar el nombre de la categoría
            ])
        ;
        
        // Solo agregar el campo user si show_user es true (en EDIT)
        if ($options['show_user']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',  // Mostrar el email del usuario
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'show_user' => false,  // Por defecto NO mostrar el campo user
        ]);
    }
}
