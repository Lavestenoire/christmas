<?php

namespace App\Entities;

class CategoryGift
{
    private $id_gift;
    private $id_category;

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
     * Get the value of id_category
     */
    public function getId_category()
    {
        return $this->id_category;
    }

    /**
     * Set the value of id_category
     *
     * @return  self
     */
    public function setId_category($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }
}
