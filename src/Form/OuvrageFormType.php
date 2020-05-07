<?php

namespace App\Form;

use App\Entity\Filiere;
use App\Entity\Ouvrage;
use App\Entity\SiteEntreposage;
use App\Entity\Technologie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OuvrageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre :',
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('auteur', TextType::class, [
                'label' => 'Auteur :',
                'attr' => [
                    'placeholder' => 'Auteur'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('isbn', IntegerType::class, [
                'label' => 'ISBN :',
                'attr' => [
                    'placeholder' => 'ISBN'
                ]
            ])
            ->add('nbreTome', IntegerType::class, [
                'label' => 'Nombre de tome :',
                'attr' => [
                    'placeholder' => 'Nombre de tome'
                ]
            ])
            ->add('nbrePage', IntegerType::class, [
                'label' => 'Nombre de page :',
                'attr' => [
                    'placeholder' => 'Nombre de page'
                ]
            ])
            ->add('quantiteStock', IntegerType::class, [
                'label' => 'Quantité en stock :',
                'attr' => [
                    'placeholder' => 'Quantité en stock'
                ]
            ])
            ->add('filiere', EntityType::class, [
                'label' => 'Filière :',
                'class' => Filiere::class,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Filière'
                ],
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomFiliere', 'ASC');
                }
            ])
            ->add('technologie', EntityType::class, [
                'label' => 'Technologie :',
                'class' => Technologie::class,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Technologie'
                ],
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomTechno', 'ASC');
                }
            ])
            ->add('site', EntityType::class, [
                'label' => 'Site :',
                'class' => SiteEntreposage::class,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Site'
                ],
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.nomSite', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ouvrage::class,
        ]);
    }
}
