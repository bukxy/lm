<?php

namespace App\Form;

use App\Entity\BTCategory;
use App\Entity\BoostTerritory;
use App\Repository\BTCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BoostTerritoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('btCategory', EntityType::class, [
                'class' => BTCategory::class,
                'query_builder' => function (BTCategoryRepository $bt) {
                    return $bt->createQueryBuilder('b')
                        ->orderBy('b.id', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoostTerritory::class,
        ]);
    }
}
