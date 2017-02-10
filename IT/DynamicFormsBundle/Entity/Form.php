<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IT\DynamicFormsBundle\Entity\Form
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FormRepository")
 * @ORM\Table(name="df_form")
 */
class Form
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
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="FormField", mappedBy="form", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", nullable=false)
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    protected $formFields;

    /**
     * @ORM\OneToMany(targetEntity="FormResponse", mappedBy="form")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", nullable=false)
     */
    protected $formResponses;

    public function __construct()
    {
        $this->formFields = new ArrayCollection();
        $this->formResponses = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName() ?: 'Nouveau formulaire';
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
     * Set name
     *
     * @param string $name
     *
     * @return Form
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add formField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormField $formField
     *
     * @return Form
     */
    public function addFormField(\IT\DynamicFormsBundle\Entity\FormField $formField)
    {

        $formField->setForm($this);

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

    /**
     * Add formResponse
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponse $formResponse
     *
     * @return Form
     */
    public function addFormResponse(\IT\DynamicFormsBundle\Entity\FormResponse $formResponse)
    {
        $this->formResponses[] = $formResponse;

        return $this;
    }

    /**
     * Remove formResponse
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponse $formResponse
     */
    public function removeFormResponse(\IT\DynamicFormsBundle\Entity\FormResponse $formResponse)
    {
        $this->formResponses->removeElement($formResponse);
    }

    /**
     * Get formResponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormResponses()
    {
        return $this->formResponses;
    }
}
