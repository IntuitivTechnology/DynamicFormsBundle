<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class FieldOptionAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
                ->add('option', null, array(
                    'label' => 'Nom du paramètre',
                    'required' => true,
                ))
                ->add('value', 'text', array(
                    'label' => 'Valeur du paramètre',
                    'required' => true,
                ))
            ->end()
        ;
    }

}