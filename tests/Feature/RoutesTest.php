<?php

it('test all GET routes', function () {
    $responseHome = $this->get('/');
    $responseHome->assertStatus(200);

    $responseContact = $this->get('/contact');
    $responseContact->assertStatus(200);

    $responseAbout = $this->get('/blog');
    $responseAbout->assertStatus(200);

    $responseServices = $this->get('/blog/test-blog-post');
    $responseServices->assertStatus(200);
});
