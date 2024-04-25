<?php

namespace App\Entities;

class User
{
    private $id_user;
    private $nickname_user;
    private $picture_user;
    private $email_user;
    private $password_user;
    private $role_user;
    private $status_user;
    private $id_account;

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

    /**
     * Get the value of nickname_user
     */
    public function getNickname_user()
    {
        return $this->nickname_user;
    }

    /**
     * Set the value of nickname_user
     *
     * @return  self
     */
    public function setNickname_user($nickname_user)
    {
        $this->nickname_user = $nickname_user;

        return $this;
    }

    /**
     * Get the value of picture_user
     */
    public function getPicture_user()
    {
        return $this->picture_user;
    }

    /**
     * Set the value of picture_user
     *
     * @return  self
     */
    public function setPicture_user($picture_user)
    {
        $this->picture_user = $picture_user;

        return $this;
    }

    /**
     * Get the value of email_user
     */
    public function getEmail_user()
    {
        return $this->email_user;
    }

    /**
     * Set the value of email_user
     *
     * @return  self
     */
    public function setEmail_user($email_user)
    {
        $this->email_user = $email_user;

        return $this;
    }

    /**
     * Get the value of password_user
     */
    public function getPassword_user()
    {
        return $this->password_user;
    }

    /**
     * Set the value of password_user
     *
     * @return  self
     */
    public function setPassword_user($password_user)
    {
        $this->password_user = $password_user;

        return $this;
    }

    /**
     * Get the value of role_user
     */
    public function getRole_user()
    {
        return $this->role_user;
    }

    /**
     * Set the value of role_user
     *
     * @return  self
     */
    public function setRole_user($role_user)
    {
        $this->role_user = $role_user;

        return $this;
    }

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
     * Get the value of status_user
     */
    public function getStatus_user()
    {
        return $this->status_user;
    }

    /**
     * Set the value of status_user
     *
     * @return  self
     */
    public function setStatus_user($status_user)
    {
        $this->status_user = $status_user;

        return $this;
    }
}
