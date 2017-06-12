<?php

namespace App\CloseIO;

class Contact
{
    private $name;
    private $emails = [];
    private $phones = [];

    public function addName($name)
    {
        $this->name = $name;
    }

    public function addEmail($email, $type = 'office')
    {
        $this->emails[] = compact($email, $type);
    }

    public function addPhone($phone, $type = 'office')
    {
        $this->phones[] = compact($phone, $type);
    }

    public function toArray()
    {
        $contacts['name'] = $this->name;
        $contacts['emails'] = $this->emails;
        $contacts['phones'] = $this->phones;

        return $contacts;
    }
}
