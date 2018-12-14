<?php

class usuario {

    private $userId;
    private $nombre;
    private $email;
    private $pass;

    function __construct($userId, $nombre, $email, $pass) {
        $this->userId = $userId;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->pass = $pass;
    }

    function getPass() {
        return $this->pass;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getUserID() {
        return $this->userId;
    }
    function getEmail() {
        return $this->email;
    }
}
