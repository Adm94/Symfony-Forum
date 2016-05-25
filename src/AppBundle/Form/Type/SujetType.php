<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SujetType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $option){
		$builder
			->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('Valider', SubmitType::class)
        ;
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Sujets'
		));
	}
}
