<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IT\DynamicFormsBundle\Entity\FormResponseField
 *
 * Réponse pour chaque champ du formulaire
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FormResponseFieldRepository")
 * @ORM\Table(name="df_form_response_field")
 */
class FormResponseField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="FormResponse", inversedBy="formResponseFields")
     * @ORM\JoinColumn(name="form_response_id", referencedColumnName="id", nullable=false)
     */
    protected $formResponse;

    /**
     * @ORM\ManyToOne(targetEntity="FormField", inversedBy="formResponseFields")
     * @ORM\JoinColumn(name="form_field_id", referencedColumnName="id", nullable=false)
     */
    protected $formField;

    public function __construct()
    {
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
     * Set value
     *
     * @param string $value
     *
     * @return FormResponseField
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set formResponse
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponse $formResponse
     *
     * @return FormResponseField
     */
    public function setFormResponse(\IT\DynamicFormsBundle\Entity\FormResponse $formResponse)
    {
        $this->formResponse = $formResponse;

        return $this;
    }

    /**
     * Get formResponse
     *
     * @return \IT\DynamicFormsBundle\Entity\FormResponse
     */
    public function getFormResponse()
    {
        return $this->formResponse;
    }

    /**
     * Set formField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormField $formField
     *
     * @return FormResponseField
     */
    public function setFormField(\IT\DynamicFormsBundle\Entity\FormField $formField)
    {
        $this->formField = $formField;

        return $this;
    }

    /**
     * Get formField
     *
     * @return \IT\DynamicFormsBundle\Entity\FormField
     */
    public function getFormField()
    {
        return $this->formField;
    }
}
