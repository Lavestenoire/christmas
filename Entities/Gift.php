<?php

namespace App\Entities;

class Gift
{
    private $id_gift;
    private $name_gift;
    private $description_gift;
    private $reserved_gift;

    /**
     * Get the value of id_gift
     */
    public function getId_gift()
    {
        return $this->id_gift;
    }

    /**
     * Set the value of id_gift
     *
     * @return  self
     */
    public function setId_gift($id_gift)
    {
        $this->id_gift = $id_gift;

        return $this;
    }

    /**
     * Get the value of name_gift
     */
    public function getName_gift()
    {
        return $this->name_gift;
    }

    /**
     * Set the value of name_gift
     *
     * @return  self
     */
    public function setName_gift($name_gift)
    {
        $this->name_gift = $name_gift;

        return $this;
    }

    /**
     * Get the value of description_gift
     */
    public function getDescription_gift()
    {
        return $this->description_gift;
    }

    /**
     * Set the value of description_gift
     *
     * @return  self
     */
    public function setDescription_gift($description_gift)
    {
        $this->description_gift = $description_gift;

        return $this;
    }

    /**
     * Get the value of reserved_gift
     */
    public function getReserved_gift()
    {
        return $this->reserved_gift;
    }

    /**
     * Set the value of reserved_gift
     *
     * @return  self
     */
    public function setReserved_gift($reserved_gift)
    {
        $this->reserved_gift = $reserved_gift;

        return $this;
    }
}
