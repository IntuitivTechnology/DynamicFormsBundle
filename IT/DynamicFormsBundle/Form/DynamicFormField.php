<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 09/02/17
 * Time: 14:50
 */

namespace IT\DynamicFormsBundle\Form;


use IT\DynamicFormsBundle\Entity\FieldOption;
use IT\DynamicFormsBundle\Entity\FormField;
use IT\DynamicFormsBundle\Entity\FormResponseField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DynamicFormField extends AbstractType
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
        /** @var FormResponseField $entity */
        $entity = $evt->getData();

        $form = $evt->getForm();

        if ($entity->getFormField() instanceof FormField) {

            $options = array();

            /** @var FieldOption $fieldOption */
            foreach ($entity->getFormField()->getFieldOptions() as $fieldOption) {
                switch ($fieldOption->getOption()->getType()) {

                    case 'array':

                        $value = json_decode($fieldOption->getValue(), true);
                        if (!is_array($value)) {
                            throw new \InvalidArgumentException(sprintf('The paramaters for the option %s of the form %s are invalid json', $fieldOption->getFormField()->getFieldName(), $fieldOption->getFormField()->getForm()->getName()));
                        }

                        $options[$fieldOption->getOption()->getLabel()] = $value;
                        break;
                    case 'boolean':
                        $value = $fieldOption->getValue();
                        if (strtolower($value) == 'oui') {
                            $value = true;
                        } elseif (strtolower($value) == 'non') {
                            $value = false;
                        } else {
                            $value = (bool)$value;
                        }
                        $options[$fieldOption->getOption()->getLabel()] = $value;
                        break;
                    default:
                        $options[$fieldOption->getOption()->getLabel()] = $fieldOption->getValue();
                }
            }
            $form->add('value', $entity->getFormField()->getField()->getType(), $options);

        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => 'IT\DynamicFormsBundle\Entity\FormResponseField',
            'error_bubbling' => false,
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'dynamic_form_field';
    }


}