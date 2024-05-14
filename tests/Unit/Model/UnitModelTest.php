<?php

namespace Tests\Unit\Model;

use App\Models\Unit;

describe('UnitModel Test', function () {
    it('has correct fillable attributes', function () {
        $fillable = ['description', 'acronym'];
        $unit = new Unit();

        expect($unit->getFillable())->toEqual($fillable);
    });

    it('has correct table name', function () {
        $unit = new Unit();
        expect($unit->getTable())->toBe('units');
    });

    it('has correct primary key', function () {
        $unit = new Unit();
        expect($unit->getKeyName())->toBe('id');
    });

    it('has correct timestamps', function () {
        $unit = new Unit();
        expect($unit->usesTimestamps())->toBe(true);
    });

    it('has correct model name', function () {
        $unit = new Unit();
        expect($unit::class)->toBe(Unit::class);
    });
})->group('model');
