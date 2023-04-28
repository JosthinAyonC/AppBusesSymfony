<?php

namespace App\Form;

use App\Entity\Reserva;
use App\Entity\Solicitud;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\SecurityBundle\Security;


class SolicitudType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        if ($this->security->isGranted('ROLE_CLIENTE')){

            $builder
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
        }elseif ($this->security->isGranted('ROLE_SECRETARIA')){

            $builder
            ->add('observacion')
            ->add('estadoSolicitud', ChoiceType::class, [
                'label' => 'Seleccione',
                'placeholder' => 'Seleccione',
                'choices' => [
                    'Pendiente'=>'Pendiente',
                    'Aprobado' => 'Aprobado',
                    'Denegado' => 'Denegado'
                ]
            ])
            ->add('idUsuario', EntityType::class, [              
                'class'=>Usuario::class,
                'choice_label' => 'nombre',
                'label'=>'Seleccione a un usuario',
                'disabled'=>true
            ])
            ->add('idReserva', EntityType::class, [              
                'class'=>Reserva::class,
                'choice_label' => 'nombre',
                'label'=>'Seleccione un servicio',
                'disabled'=>true
                
            ] )
        ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
