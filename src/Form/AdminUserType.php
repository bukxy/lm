<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('pseudo')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped'    => false,
                'required' => false,
                'invalid_message' => 'Les deux mots de passe doivent correspondre',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} characters',
                        'max' => 255,
                        'maxMessage' => 'Votre mot de passe doit faire au maximum {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'required'  => false,
                'multiple'  => true,
                'expanded'  => true, // render check-boxes
                'attr'      => ['class' => 'form-group'],
                'choices'   => [
                    'Admin' => 'ROLE_SUPER_ADMIN',
                    'Accés au panel admin'      => 'ROLE_ADMIN_ACCESS',
                    'Gestion des utilisateurs'  => 'ROLE_ADMIN_USERS',
                    'Gestion des images'        => 'ROLE_ADMIN_IMAGES',
                    'Gestion des boosts'        => 'ROLE_ADMIN_BOOSTS',
                    'Gestion des constructions' => 'ROLE_ADMIN_CONSTRUCTIONS',
                    'Gestion des recherches'    => 'ROLE_ADMIN_RESEARCHS',
                    'Gestion des familiers'     => 'ROLE_ADMIN_FAMILIARS',
                    'Gestion des evenements'    => 'ROLE_ADMIN_EVENTS',
                    // ...
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}