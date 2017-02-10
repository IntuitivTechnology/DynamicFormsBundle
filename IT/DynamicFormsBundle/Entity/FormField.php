<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IT\DynamicFormsBundle\Entity\FormField
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FormFieldRepository")
 * @ORM\Table(name="df_form_field")
 */
class FormField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="field_name", type="string", length=255)
     */
    protected $fieldName;

    /**
     * @ORM\Column(name="sort", type="integer")
     */
    protected $sort = 0;

    /**
     * @ORM\Column(name="display_on_admin_list", type="boolean")
     */
    protected $displayOnAdminList = false;

    /**
     * @ORM\OneToMany(targetEntity="FormResponseField", mappedBy="formField")
     * @ORM\JoinColumn(name="form_field_id", referencedColumnName="id", nullable=false)
     */
    protected $formResponseFields;

    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="formFields")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", nullable=false)
     */
    protected $form;

    /**
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="formFields", fetch="EAGER")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", nullable=false)
     */
    protected $field;

    /**
     * @ORM\OneToMany(targetEntity="FieldOption", mappedBy="formField", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", nullable=false)
     */
    protected $fieldOptions;

    public function __construct()
    {
        $this->formResponseFields = new ArrayCollection();
        $this->fieldOptions = new ArrayCollection();
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
     * Set fieldName
     *
     * @param string $fieldName
     *
     * @return FormField
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * Get fieldName
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Add formResponseField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormResponseField $formResponseField
     *
     * @return FormField
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
     * @return FormField
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

    /**
     * Set field
     *
     * @param \IT\DynamicFormsBundle\Entity\Field $field
     *
     * @return FormField
     */
    public function setField(\IT\DynamicFormsBundle\Entity\Field $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \IT\DynamicFormsBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Add fieldOption
     *
     * @param \IT\DynamicFormsBundle\Entity\FieldOption $fieldOption
     *
     * @return FormField
     */
    public function addFieldOption(\IT\DynamicFormsBundle\Entity\FieldOption $fieldOption)
    {
        $fieldOption->setFormField($this);
        $this->fieldOptions[] = $fieldOption;

        return $this;
    }

    /**
     * Remove fieldOption
     *
     * @param \IT\DynamicFormsBundle\Entity\FieldOption $fieldOption
     */
    public function removeFieldOption(\IT\DynamicFormsBundle\Entity\FieldOption $fieldOption)
    {
        $this->fieldOptions->removeElement($fieldOption);
    }

    /**
     * Get fieldOptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFieldOptions()
    {
        return $this->fieldOptions;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayOnAdminList()
    {
        return $this->displayOnAdminList;
    }

    /**
     * @param mixed $displayOnAdminList
     */
    public function setDisplayOnAdminList($displayOnAdminList)
    {
        $this->displayOnAdminList = $displayOnAdminList;
        return $this;
    }

}
