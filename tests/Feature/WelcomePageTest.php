<?php

use Illuminate\Foundation\Application;

test('welcome page loads successfully', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
});

test('welcome page renders the correct inertia component', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->component('Welcome')
    );
});

test('welcome page receives required props', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->component('Welcome')
        ->has('canLogin')
        ->has('canRegister')
        ->has('laravelVersion')
        ->has('phpVersion')
    );
});

test('welcome page shows correct laravel version', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->where('laravelVersion', Application::VERSION)
    );
});

test('welcome page shows correct php version', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->where('phpVersion', PHP_VERSION)
    );
});

test('welcome page indicates login is available', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->where('canLogin', true)
    );
});

test('welcome page indicates register is available', function () {
    $response = $this->get('/');

    $response->assertInertia(fn ($page) => $page
        ->where('canRegister', true)
    );
});
