<?php

namespace App\Form;

use App\Entity\SiteEntreposage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteEntreposageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSite', TextType::class, [
                'attr' => [
        'placeholder' => 'Nom'
    ]])
            ->add('adresse', TextType::class, [
        'attr' => [
        'placeholder' => 'Adresse'
    ]])
            ->add('codePostal', TextType::class, [
        'attr' => [
        'placeholder' => 'Code postal'
   ] ])
            ->add('ville', TextType::class, [
        'attr' => [
        'placeholder' => 'Ville'
    ]])
            ->add('infoUtile', TextType::class, [
                'label' => 'Pièce de stockage',
        'attr' => [
            'placeholder' => 'Pièce de stockage'
        ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteEntreposage::class,
        ]);
    }
}
