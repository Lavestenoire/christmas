<?php

namespace App\Entities;

class Account
{
    private $id_account;
    private $nickname_account;
    private $email_account;
    private $password_account;
    private $tag_account;

    /**
     * Get the value of id_account
     */
    public function getId_account()
    {
        return $this->id_account;
    }

    /**
     * Set the value of id_account
     *
     * @return  self
     */
    public function setId_account($id_account)
    {
        $this->id_account = $id_account;

        return $this;
    }

    /**
     * Get the value of nickname_account
     */
    public function getNickname_account()
    {
        return $this->nickname_account;
    }

    /**
     * Set the value of nickname_account
     *
     * @return  self
     */
    public function setNickname_account($nickname_account)
    {
        $this->nickname_account = $nickname_account;

        return $this;
    }

    /**
     * Get the value of email_account
     */
    public function getEmail_account()
    {
        return $this->email_account;
    }

    /**
     * Set the value of email_account
     *
     * @return  self
     */
    public function setEmail_account($email_account)
    {
        $this->email_account = $email_account;

        return $this;
    }

    /**
     * Get the value of password_account
     */
    public function getPassword_account()
    {
        return $this->password_account;
    }

    /**
     * Set the value of password_account
     *
     * @return  self
     */
    public function setPassword_account($password_account)
    {
        $this->password_account = $password_account;

        return $this;
    }

    /**
     * Get the value of tag_account
     */
    public function getTag_account()
    {
        return $this->tag_account;
    }

    /**
     * Set the value of tag_account
     *
     * @return  self
     */
    public function setTag_account($tag_account)
    {
        $this->tag_account = $tag_account;

        return $this;
    }
}
