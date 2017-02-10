<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class FormAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général', array('class' => 'col-md-6'))
                ->add('name', 'text', array(
                    'label' => 'Nom du formulaire',
                    'required' => true,
                    'help' => 'Eviter les espaces et les accents'
                ))
            ->end()
            ->with('Champs du formulaire', array('class' => 'col-md-12'))
                ->add('formFields', 'sonata_type_collection', array(
                    'type_options' => array(
                        // Prevents the "Delete" option from being displayed
                        'delete' => true,
                    ),
                    'by_reference' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'sort',
                ))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nom du formulaire'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('label' => 'Nom du formulaire'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' =>  array()
                )
            ))
        ;
    }

}