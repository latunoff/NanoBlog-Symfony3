<?php

namespace AppBundle\Form;

use AppBundle\Entity\Loc;
use AppBundle\Entity\Locs;
use AppBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locales = ['en','de'];
        /*
                $locs = new Locs();
                $title_en = new Loc();
                $title_en->setLang('en');
                $title_en->setVar('testing');
                $title_de = new Loc();
                $title_de->setLang('de');
                $title_de->setVar('testen');

        /*
                $builder
                    ->add('title', CollectionType::class, [
                        'entry_type'   => Locs::class,
                        'entry_options' => [
                            'attr' => ['autofocus' => true]
                        ]
                        //'label' => 'label.title'.$locale,
                        //'data' => print_r($_REQUEST, true),
                    ]);
        /*
                $builder
                    ->add('title', EntityType::class, [
                        'class'         => 'AppBundle\Entity\Loc',
                        'query_builder' => function (EntityRepository $repository) use ($options) {
                            $qb = $repository->createQueryBuilder('e');
                            $qb->select('AppBundle\Entity\Loc');
                        }
                    ]);
        */

        foreach ($locales as $locale) {
            $builder
                ->add('title_'.$locale, null, [
                    'attr' => ['autofocus' => true],
                    'label' => 'label.title',
                    //'data' => print_r($_REQUEST, true),
                ])
                ->add('content_'.$locale, CKEditorType::class, [
                    'attr' => ['rows' => 20],
                    'label' => 'label.content',
                    'config' => [
                        'uiColor' => '#ffffff',
                    ],
                ]);
        }

        $builder
            ->add('authorName', null, ['label' => 'label.author_name'])
            ->add('authorEmail', null, ['label' => 'label.author_email'])
            ->add('publishedAt', DateTimePickerType::class, [
                'label' => 'label.published_at',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
