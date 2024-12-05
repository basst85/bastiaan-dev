<?php

it('test al GET routes', function () {
    $responseHome = $this->get('/');
    $responseHome->assertStatus(200);

    $responseContact = $this->get('/contact');
    $responseContact->assertStatus(200);
});
