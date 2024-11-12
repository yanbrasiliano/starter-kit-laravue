<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

pest()->extend(Tests\TestCase::class)
  ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
  ->beforeEach(function () {
    Http::preventStrayRequests();

    Mail::fake();
    Event::fake();
  })
  ->in('Feature');

pest()->extend(Tests\TestCase::class)
  ->in('Unit');

pest()->printer()->compact();

expect()->extend('toBeOne', function () {
  return $this->toBe(1);
});

function something()
{
  //
}
