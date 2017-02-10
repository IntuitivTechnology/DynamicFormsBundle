<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use IT\DynamicFormsBundle\Form\JsonEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class OptionAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général', array('class' => 'col-md-6'))
                ->add('name', 'text', array(
                    'label' => 'Libellé de l\'option (libellé intelligible)',
                    'required' => true,
                ))
                ->add('label', 'text', array(
                    'label' => 'Libellé de l\'option (libellé symfony)',
                    'required' => true,
                ))
                ->add('type', 'text', array(
                    'label' => 'Type de formulaire',
                    'required' => true,
                    'help' => 'text, textarea, boolean, choice, array, etc.'
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
            ->add('name', null, array('label' => 'Libellé'))
            ->add('type', null, array('label' => 'Type de formulaire'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('label' => 'Libellé'))
            ->add('type', null, array('label' => 'Type de formulaire'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' =>  array()
                )
            ))
        ;
    }

}