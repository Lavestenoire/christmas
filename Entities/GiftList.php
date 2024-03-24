<?php

namespace App\Entities;

class GiftList
{
    private $id_gift;
    private $id_user;

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
     * Get the value of id_user
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }
}
