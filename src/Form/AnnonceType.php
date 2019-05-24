<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
/**
 *
 * @return array
 *
 */
    private function getConf($label, $placeholder){
        return [
            'label' => $label,
            'attr' =>[
             "placeholder" => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConf("titre", "Mon titre d'annonce"))
            ->add('slug', TextType::class, $this->getConf('slug' , 'url (auto)'))
            ->add('price', MoneyType::class)
            ->add('introduction', TextType::class)
            ->add('content',TextareaType::class)
            ->add('coverImage', UrlType::class)
            ->add('rooms', IntegerType::class)
            ->add('images', CollectionType::class, [
                'entry_type'=> ImageType::class
            ])
            ->add('save', SubmitType::class, [
                'label'=>'Créer une nouvelle annonce',
                'attr'=>[
                    "class"=>'btn btn-primary mt-3'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
