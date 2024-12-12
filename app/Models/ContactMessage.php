<?php

namespace App\Models;

class ContactMessage
{
    public string $name;
    public string $email;
    public string $message;

    public function __construct(string $name, string $email, string $subject, string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

}
