<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Filiere;
use App\Entity\SiteEntreposage;
use App\Entity\Technologie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OuvrageSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'required' => false,
                'label' => 'Titre de l\'ouvrage',
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('sites', EntityType::class, [
                'class' => SiteEntreposage::class,
                'required' => false,
                'label' => 'Site',
                'choice_label' => 'nomSite',
                'attr' => [
                    'placeholder' => 'Trier par site'
                ]
            ])
            ->add('minQ', NumberType::class, [
                'required' => false,
                'label' => 'Quantité minimum',
                'attr' => [
                    'placeholder' => 'Min'
                ]
            ])
            ->add('maxQ', NumberType::class, [
                'required' => false,
                'label' => 'et/ou maximum',
                'attr' => [
                    'placeholder' => 'Max'
                ]
            ])
            ->add('filieres', EntityType::class, [
                'class' => Filiere::class,
                'required' => false,
                'label' => 'Filière',
                'choice_label' => 'nomFiliere',
            ])
            ->add('technos', EntityType::class, [
                'class' => Technologie::class,
                'required' => false,
                'label' => 'Technologie',
                'choice_label' => 'nomTechno',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    //Permet de retourner dans la barre d'adresse du navigateur, le champ que l'on veut afficher.
    public function getBlockPrefix()
    {
        return '';
    }
}
