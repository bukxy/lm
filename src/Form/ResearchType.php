<?php

namespace App\Form;

use App\Entity\Research;
use App\Entity\ResearchCat;
use App\Repository\ResearchCatRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('researchCat', EntityType::class, [
                'class' => ResearchCat::class,
                'query_builder' => function (ResearchCatRepository $r) {
                    return $r->createQueryBuilder('r')
                        ->orderBy('r.id', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Research::class,
        ]);
    }
}
