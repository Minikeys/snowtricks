<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Photo' => 'picture',
                    'Youtube' => 'youtube',
                    'Dailymotion' => 'dailymotion',
                ],
            ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();

            var_dump($form->getData());

            /*if ($type == 'picture') {
                $form->add('file', FileType::class, array('data_class' => null, 'label' => false, 'attr' => ['placeholder' => 'Sélectionner une image']));
            }else{
                dump($type);
                $form->add('link', UrlType::class, ['attr' => ['placeholder' => 'Http://...'],  'label' => false]);
            }*/


        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
