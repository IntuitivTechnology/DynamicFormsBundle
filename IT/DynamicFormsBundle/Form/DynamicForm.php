<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 09/02/17
 * Time: 14:41
 */

namespace IT\DynamicFormsBundle\Form;


use IT\DynamicFormsBundle\Entity\FormField;
use IT\DynamicFormsBundle\Entity\FormResponse;
use IT\DynamicFormsBundle\Entity\FormResponseField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DynamicForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $evt) {
                $this->onPostSetData($evt);
            });
        ;

    }

    public function onPostSetData(FormEvent $evt)
    {
        /** @var FormResponse $entity */
        $entity = $evt->getData();

        $form = $evt->getForm();

        $formEntity = $entity->getForm();

        /** @var FormField $formField */
        foreach ($formEntity->getFormFields() as $formField) {

            if (count($entity->getFormResponseFields()->filter(function(FormResponseField $formResponseField) use ($formField) {
                return $formResponseField->getFormField() && $formField->getId() == $formResponseField->getFormField()->getId();
            })) <= 0) {
                $formResponseField = new FormResponseField();
                $formResponseField
                    ->setFormField($formField)
                    ->setFormResponse($entity)
                ;

                $entity->addFormResponseField($formResponseField);
            }

        }

        $form->add('formResponseFields', 'collection', array(
            // each entry in the array will be an "email" field
            'entry_type'   => DynamicFormField::class,
            // these options are passed to each "email" type
            'entry_options'  => array(
            ),
            'by_reference' => false,
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => 'IT\DynamicFormsBundle\Entity\FormResponse',
            'error_bubbling' => false,
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'dynamic_form';
    }

}