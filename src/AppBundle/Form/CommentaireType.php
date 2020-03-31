<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $evaluation = array('Qu\'est ce que vous pensez de ce produit' => 'Qu\'est ce que vous pensez de ce produit', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $builder
            ->add('textCommentaire', TextType::class, array(
                'label' => 'textCommentaire', 'attr' => array('class' => 'form-control ', 'placeholder' => "Ajouter un commentaire")))

            ->add('evaluation', ChoiceType::class, array(
                'required' => true,
                'choices' => $evaluation,
                'choices_as_values' => true,
                'attr' => array('class' => 'form-control')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commentaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commentaire';
    }


}
