<?php

pest()->extend(Tests\TestCase::class)
  ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
  ->in('Feature');

pest()->extend(Tests\TestCase::class)->in('Unit');

pest()->theme()->compact();

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{
    //
}
