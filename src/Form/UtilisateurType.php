<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' ,TextType::class,[
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'nom'
                ]
            ])
            ->add('prenom',TextType::class,[
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'prenom'
                ]
            ])
            ->add('mdp',PasswordType::class,[
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'mod de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
