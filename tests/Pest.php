<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(
    TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

uses(
    TestCase::class,
    RefreshDatabase::class,
)->in('Unit');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{
    //
}
