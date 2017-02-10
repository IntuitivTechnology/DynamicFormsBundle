<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class FormFieldAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
                ->add('sort', null, array(
                    'label' => 'Ordre',
                    'required' => true,
                ))
                ->add('displayOnAdminList', 'checkbox', array(
                    'label' => 'Affichager dans la liste du BO',
                    'required' => false,
                ))
                ->add('fieldname', 'text', array(
                    'label' => 'Nom du champ',
                    'required' => true,
                    'help' => 'Sans espaces ni accents',
                ))
                ->add('field', null, array(
                    'label' => 'Type de champ',
                    'required' => true,
                ))
                ->add('fieldOptions', 'sonata_type_collection', array(
                    'label' => 'Options',
                    'type_options' => array(
                        // Prevents the "Delete" option from being displayed
                        'delete' => true,
                    ),
                    'by_reference' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ))
            ->end()
        ;
    }

}