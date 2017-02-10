<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IT\DynamicFormsBundle\Entity\FormResponse
 *
 * Réponse à un formulaire
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FormResponseRepository")
 * @ORM\Table(name="df_form_response")
 */
class FormResponse
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="FormResponseField", mappedBy="formResponse", cascade={"all"})
     * @ORM\JoinColumn(name="form_response_id", referencedColumnName="id", nullable=false)
     */
    protected $formResponseFields;

    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="formResponses")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", nullable=false)
     */
    protected $form;

    public function __construct()
    {
        $this->formResponseFields = new ArrayCollection();
    }

    public function __call($name, $arguments)
    {
        $matches = array();
        if (preg_match('/([a-zA-Z0-9]+)/', $name, $matches)) {
            $fieldName = strtolower($matches[1]);

            $responseField = $this->getFormResponseFields()->filter(function (FormResponseField $formResponseField) use ($fieldName) {
                return strtolower($formResponseField->getFormField()->getFieldName()) == $fieldName;
            })->first();

            if ($responseField instanceof FormResponseField) {

                if (in_array($responseField->getFormField()->getField()->getType(), array(
                    'choice',
                    'radio'
                ))) {
                    $option = $responseField->getFormField()->getFieldOptions()->filter(function (FieldOption $fieldOption) {
                        return $fieldOption->getOption()->getLabel() == 'choices';
                    })->first();

                    if ($option instanceof FieldOption) {
                        $choices = json_decode($option->getValue(), true);

                        if (!is_array($choices)) {
                            throw new \InvalidArgumentException(sprintf('The paramaters for the option %s of the form %s are invalid json', $option->getFormField()->getFieldName(), $option->getFormField()->getForm()->getName()));
                        }

                        return isset($choices[$responseField->getValue()]) ? $choices[$responseField->getValue()] : $responseField->getValue();
                    } else {
                        return $responseField->getValue();
                    }
                } else {
                    return $responseField->getValue();
                }
            } else {
                throw new \BadMethodCallException(sprintf('The form %s does not implement any field called %s', $this->getForm()->getName(), $name));
            }

        }

        throw new \BadMethodCallException(sprintf('The class %s does not implement any method called %s', get_class($this), $name));

    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add formResponseField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponseField $formResponseField
     *
     * @return FormResponse
     */
    public function addFormResponseField(\IT\DynamicFormsBundle\Entity\FormResponseField $formResponseField)
    {
        $this->formResponseFields[] = $formResponseField;

        return $this;
    }

    /**
     * Remove formResponseField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponseField $formResponseField
     */
    public function removeFormResponseField(\IT\DynamicFormsBundle\Entity\FormResponseField $formResponseField)
    {
        $this->formResponseFields->removeElement($formResponseField);
    }

    /**
     * Get formResponseFields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormResponseFields()
    {
        return $this->formResponseFields;
    }

    /**
     * Set form
     *
     * @param \IT\DynamicFormsBundle\Entity\Form $form
     *
     * @return FormResponse
     */
    public function setForm(\IT\DynamicFormsBundle\Entity\Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \IT\DynamicFormsBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
