<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\Type\ModelListType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('slug')
            ->add('showInquiryForm')
            ->add('translations', TranslationsType::class)
            ->add(
                'gallery',
                ModelListType::class,
                [],
                [
                    'link_parameters' => [
                        'context'  => 'page',
                    ],
                ]
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('translations.title')
            ->add('slug')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('title', FieldDescriptionInterface::TYPE_STRING)
            ->add('slug')
        ;
    }
}
