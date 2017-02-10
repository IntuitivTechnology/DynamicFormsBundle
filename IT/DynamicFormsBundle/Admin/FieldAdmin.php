<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class FieldAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général', array('class' => 'col-md-6'))
                ->add('label', 'text', array(
                    'label' => 'Libellé du champ',
                    'required' => true,
                    'help' => 'Champ texte, case à cocher, liste, etc.'
                ))
                ->add('type', 'text', array(
                    'label' => 'Type de formulaire',
                    'required' => true,
                    'help' => 'text, textarea, checkbox, choice, etc.'
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
            ->add('label', null, array('label' => 'Libellé'))
            ->add('type', null, array('label' => 'Type de formulaire'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('label', null, array('label' => 'Libellé'))
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