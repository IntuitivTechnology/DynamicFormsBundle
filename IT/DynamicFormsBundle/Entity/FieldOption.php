<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IT\DynamicFormsBundle\Entity\FieldOption
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\FieldOptionRepository")
 * @ORM\Table(name="df_field_option")
 */
class FieldOption
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
     * @ORM\ManyToOne(targetEntity="FormField", inversedBy="fieldOptions")
     * @ORM\JoinColumn(name="form_field_id", referencedColumnName="id", nullable=false)
     */
    protected $formField;

    /**
     * @ORM\ManyToOne(targetEntity="Option", inversedBy="fieldOptions")
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id", nullable=false)
     */
    protected $option;

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
     * @return FieldOption
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
     * Set formField
     *
     * @param \IT\DynamicFormsBundle\Entity\FormField $formField
     *
     * @return FieldOption
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

    /**
     * Set option
     *
     * @param \IT\DynamicFormsBundle\Entity\Option $option
     *
     * @return FieldOption
     */
    public function setOption(\IT\DynamicFormsBundle\Entity\Option $option)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \IT\DynamicFormsBundle\Entity\Option
     */
    public function getOption()
    {
        return $this->option;
    }
}
