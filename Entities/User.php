<?php

namespace App\Entities;

class User
{
    private $id_user;
    private $nickname_user;
    private $picture_user;
    private $question_user;
    private $response_user;
    private $role_user;
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
     * Get the value of question_user
     */
    public function getQuestion_user()
    {
        return $this->question_user;
    }

    /**
     * Set the value of question_user
     *
     * @return  self
     */
    public function setQuestion_user($question_user)
    {
        $this->question_user = $question_user;

        return $this;
    }

    /**
     * Get the value of response_user
     */
    public function getResponse_user()
    {
        return $this->response_user;
    }

    /**
     * Set the value of response_user
     *
     * @return  self
     */
    public function setResponse_user($response_user)
    {
        $this->response_user = $response_user;

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
}
