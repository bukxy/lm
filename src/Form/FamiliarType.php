<?php

namespace App\Form;

use App\Entity\Familiar;
use App\Entity\FamiliarCat;
use Symfony\Component\Form\AbstractType;
use App\Repository\FamiliarCatRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FamiliarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('competence1')
            ->add('competence1Desc')
            ->add('competence2')
            ->add('competence2Desc')
            ->add('competence3')
            ->add('competence3Desc')
            ->add('talent')
            ->add('talentDesc')
            ->add('familiarCat', EntityType::class, [
                'class' => FamiliarCat::class,
                'query_builder' => function (FamiliarCatRepository $f) {
                    return $f->createQueryBuilder('f')
                        ->orderBy('f.id', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Familiar::class,
        ]);
    }
}
