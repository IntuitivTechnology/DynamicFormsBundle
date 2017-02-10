<?php

namespace IT\DynamicFormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IT\DynamicFormsBundle\Entity\Option
 *
 * @ORM\Entity(repositoryClass="IT\DynamicFormsBundle\Entity\Repository\OptionRepository")
 * @ORM\Table(name="df_option")
 */
class Option
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
     * @ORM\Column(type="string", length=255)
     */
    protected $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="FieldOption", mappedBy="option")
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id", nullable=false)
     */
    protected $fieldOptions;

    public function __construct()
    {
        $this->fieldOptions = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->getName() ?: 'Nouvelle option';
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Option
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
     * Set type
     *
     * @param string $type
     *
     * @return Option
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
     * Add fieldOption
     *
     * @param \IT\DynamicFormsBundle\Entity\FieldOption $fieldOption
     *
     * @return Option
     */
    public function addFieldOption(\IT\DynamicFormsBundle\Entity\FieldOption $fieldOption)
    {
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
}
