<?php

namespace App\Form;

use App\Entity\EtatStock;
use App\Entity\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ouvrage')
            ->add('dateEtatStock', DateType::class, [
                'label' => 'Date de l\'opération',
                'widget' => 'single_text',
                'years' => range(2020,2050),
                'required' => true,
                ])
            ->add('quantiteEntree')
            ->add('quantiteSortie')
            ->add('detailOperation')
            ->add('stockTotal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EtatStock::class,
        ]);
    }
}
