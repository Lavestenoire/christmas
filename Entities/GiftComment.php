<?php

namespace App\Entities;

class GiftComment
{
    private $id_giftcomment;
    private $text_giftcomment;
    private $id_gift;

    /**
     * Get the value of id_giftcomment
     */
    public function getId_giftcomment()
    {
        return $this->id_giftcomment;
    }

    /**
     * Set the value of id_giftcomment
     *
     * @return  self
     */
    public function setId_giftcomment($id_giftcomment)
    {
        $this->id_giftcomment = $id_giftcomment;

        return $this;
    }

    /**
     * Get the value of text_giftcomment
     */
    public function getText_giftcomment()
    {
        return $this->text_giftcomment;
    }

    /**
     * Set the value of text_giftcomment
     *
     * @return  self
     */
    public function setText_giftcomment($text_giftcomment)
    {
        $this->text_giftcomment = $text_giftcomment;

        return $this;
    }

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
}
