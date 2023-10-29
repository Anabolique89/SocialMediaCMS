<?php

class loginContr extends Login
{

    private $username;
    private $pwd;

    public function __construct($username, $pwd)
    {
        $this->uid = $username;
        $this->pwd = $pwd;
    }

    public function loginUser()
    {
        if ($this->emptyInput() == false) {
            // echo "Empty input!";
            header("location: ../indexlogin.php?error=emptyinput");
            exit();
        }

        $this->getUser($this->uid, $this->pwd);
    }

    private function emptyInput()
    {
        $result = "";
        if (empty($this->uid) || empty($this->pwd)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
