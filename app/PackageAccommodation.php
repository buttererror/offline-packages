<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageAccommodation extends Model
{
    protected $table = 'package_accommodations';

    protected $casts = [
        'rooms' => 'collection',
        'other_services' => 'collection'
    ];
}
