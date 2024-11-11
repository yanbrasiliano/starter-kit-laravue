<?php

use function Pest\Laravel\get;

it('should return 200 for the api status', function () {
    get('/api/v1')->assertStatus(200);
});
