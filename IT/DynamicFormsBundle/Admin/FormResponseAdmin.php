<?php

namespace IT\DynamicFormsBundle\Admin;

use CoreBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use IT\DynamicFormsBundle\Entity\FieldOption;
use IT\DynamicFormsBundle\Entity\Form;
use IT\DynamicFormsBundle\Entity\FormField;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Mapper\BaseMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FormResponseAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'admin_form_response';

    protected $baseRoutePattern = 'core/form-response';

    protected $name;

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $qb */
        $qb = parent::createQuery($context);

        $qb
            ->leftJoin($qb->getRootAliases()[0] . '.form', 'form')
            ->andWhere('form.name = :form_name')
            ->setParameter('form_name', $this->name)
        ;

        return $qb;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général', array('class' => 'col-md-6'))
                ->add('id', 'text', array(

                ))
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $form = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ITDynamicFormsBundle:Form')->getFormByName($this->name);

        if ($form instanceof Form) {

            /** @var FormField $formField */
            foreach ($form->getFormFields() as $formField) {
                $label = $formField->getFieldName();
                $option = $formField->getFieldOptions()->filter(function(FieldOption $fieldOption) {
                    return $fieldOption->getOption()->getLabel() == 'label';
                })->first();

                if ($option instanceof FieldOption) {
                    $label = $option->getValue();
                }

                $show->add($formField->getFieldName(), null, array(
                    'label' => $label,
                ));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Libellé'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        
        $form = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ITDynamicFormsBundle:Form')->getFormByName($this->name);

        if ($form instanceof Form) {

            /** @var FormField $formField */
            foreach ($form->getFormFields() as $formField) {
                if ($formField->getDisplayOnAdminList()) {

                    $label = $formField->getFieldName();
                    $option = $formField->getFieldOptions()->filter(function(FieldOption $fieldOption) {
                        return $fieldOption->getOption()->getLabel() == 'label';
                    })->first();

                    if ($option instanceof FieldOption) {
                        $label = $option->getValue();
                    }

                    $listMapper->add($formField->getFieldName(), null, array(
                        'label' => $label,
                    ));
                }
            }
        }

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'delete' =>  array()
                )
            ))
        ;
    }

    protected function configureListAndDatagridFilters(BaseMapper $mapper)
    {

    }

    public function setName($name)
    {
        $this->baseRouteName .= '_' . $name;
        $this->baseRoutePattern .= '-' . $name;
        $this->name = $name;
    }


}