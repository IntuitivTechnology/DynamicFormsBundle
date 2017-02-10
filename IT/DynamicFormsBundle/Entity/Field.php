<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IT\DynamicFormsBundle\Entity\Field
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FieldRepository")
 * @ORM\Table(name="df_field")
 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="FormField", mappedBy="field")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", nullable=false)
     */
    protected $formFields;

    public function __construct()
    {
        $this->formFields = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getLabel() ?: 'Nouveau champ';
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
     * Set type
     *
     * @param string $type
     *
     * @return Field
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Field
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add formField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormField $formField
     *
     * @return Field
     */
    public function addFormField(\IT\DynamicFormsBundle\Entity\FormField $formField)
    {
        $this->formFields[] = $formField;

        return $this;
    }

    /**
     * Remove formField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormField $formField
     */
    public function removeFormField(\IT\DynamicFormsBundle\Entity\FormField $formField)
    {
        $this->formFields->removeElement($formField);
    }

    /**
     * Get formFields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormFields()
    {
        return $this->formFields;
    }
}
