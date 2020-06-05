<?php

namespace App\Form;

use App\Entity\Hunt;
use App\Entity\HuntCat;
use App\Repository\HuntCatRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HuntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('huntCat', EntityType::class, [
                'class' => HuntCat::class,
                'query_builder' => function (HuntCatRepository $h) {
                    return $h->createQueryBuilder('h')
                        ->orderBy('h.id', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hunt::class,
        ]);
    }
}
