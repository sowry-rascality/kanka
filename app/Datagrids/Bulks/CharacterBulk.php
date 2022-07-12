<?php

namespace App\Datagrids\Bulks;

class CharacterBulk extends Bulk
{
    protected array $fields = [
        'name',
        'title',
        'families',
        'location_id',
        'races',
        'type',
        'sex',
        'dead_choice',
        'age',
        'organisations',
        'tags',
        'private_choice',
    ];

    protected $mappings = [
        'is_dead'
    ];

    protected $maths = [
        'age'
    ];

    protected $belongsTo = [
        'races',
        'families',
        'organisations'
    ];
}
