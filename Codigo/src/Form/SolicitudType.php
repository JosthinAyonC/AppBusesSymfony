<?php

namespace App\Form;

use App\Entity\Reserva;
use App\Entity\Solicitud;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SolicitudType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('observacion')
            ->add('idUsuario', EntityType::class, [              
                'class'=>Usuario::class,
                'choice_label' => 'nombre',
                'label'=>'Seleccione a un usuario'
            ])
            ->add('idReserva', EntityType::class, [              
                'class'=>Reserva::class,
                'choice_label' => 'nombre',
                'label'=>'Seleccione un servicio'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
