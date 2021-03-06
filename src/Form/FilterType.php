<?php

namespace App\Form;



use App\Entity\Campus;
use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class'=> Campus::class,
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Veuillez choisir un campus',
                'required'=>false
            ])
            ->add('keyWord', TextType::class, [
                'label'=>'Le nom de la sortie contient :',
                'attr' => ['placeholder'=>'Veuillez saisir un mot clé'],
                'required'=>false
            ])
            ->add('dateStart', DateType::class, [
                'label'=>'Entre :',
                'widget'=> 'single_text',
                'required'=>false
            ])
            ->add('dateEnd', DateType::class, [
                'label'=>'et :',
                'widget'=> 'single_text',
                'required'=>false
            ])
            ->add('eventOrganizer', CheckboxType::class, [
                'label'=>'Sortie dont je suis l\'organisateur(trice).',
                'required'=>false,
            ])
            ->add('eventSubscriber', CheckboxType::class, [
                'label'=>'Sortie auquelles je suis inscrit(e).',
                'required'=>false,
            ])
            ->add('eventNotSubscriber', CheckboxType::class, [
                'label'=>'Sortie auquelles je ne suis pas inscrit(e).',
                'required'=>false,
            ])
            ->add('eventOld', CheckboxType::class, [
                'label'=>'Sortie passées.',
                'required'=>false,
            ])
            // suppression du button pour mieux l'intégrer au CSS
            ;}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Suppression de l'association avec l'event
            // car par d'entity de ce formulaire dans l'entité Event
            //'data_class' => Event::class,
        ]);
    }
}
