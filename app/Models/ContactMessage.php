<?php

namespace App\Models;

class ContactMessage
{
    public function __construct(
        public string $name,
        public string $email,
        public string $subject,
        public string $message
    ){
    }
}
