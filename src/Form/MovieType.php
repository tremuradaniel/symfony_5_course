<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('poster', UrlType::class)
            ->add('country', ChoiceType::class, ['choices' => ['England' => 'England' , 'France' => 'France', 'Spain' => 'Spain']])
            ->add('rated')
            ->add('price', MoneyType::class, ['currency' => 'EUR'])
            ->add('description', TextareaType::class, ['attr'   => ['cols' => 5, 'foo' => 'bar']])
            ->add('genres', EntityType::class, ['choice_label'  => 'name', 'class' => Genre::class, 'multiple' => true,
                                                'query_builder' => static function (EntityRepository $r) {
                        return $r->createQueryBuilder('g')->orderBy('g.name', 'ASC');
                                                }])
            ->add('submit', SubmitType::class)
            //->add('accept the rules', CheckboxType::class, ['mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
