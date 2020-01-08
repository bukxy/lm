<?php

namespace App\Form;

use App\Entity\Construction;
use App\Entity\ConstructionCat;
use App\Repository\ConstructionCatRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConstructionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('constructionCat', EntityType::class, [
                'class' => ConstructionCat::class,
                'query_builder' => function (ConstructionCatRepository $c) {
                    return $c->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Construction::class,
        ]);
    }
}
