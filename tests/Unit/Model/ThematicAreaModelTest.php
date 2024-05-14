<?php

namespace Tests\ThematicArea\Model;

use App\Models\ThematicArea;

describe('ThematicAreaModel Test', function () {
    it('has correct fillable attributes', function () {
        $fillable = ['description'];
        $thematicArea = new ThematicArea();

        expect($thematicArea->getFillable())->toEqual($fillable);
    });

    it('has correct table name', function () {
        $thematicArea = new ThematicArea();
        expect($thematicArea->getTable())->toBe('thematic_areas');
    });

    it('has correct primary key', function () {
        $thematicArea = new ThematicArea();
        expect($thematicArea->getKeyName())->toBe('id');
    });

    it('has correct timestamps', function () {
        $thematicArea = new ThematicArea();
        expect($thematicArea->usesTimestamps())->toBe(true);
    });

    it('has correct model name', function () {
        $thematicArea = new ThematicArea();
        expect($thematicArea::class)->toBe(ThematicArea::class);
    });
})->group('model');
