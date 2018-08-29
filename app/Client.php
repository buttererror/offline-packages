<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'country_id',
        'address',
        'gender',
        'age'
    ];

    protected $searchable = [
        'name',
        'email',
        'mobile'
    ];

    public function packages()
    {
        return $this->hasMany('App/Package');
    }

    public function scopeSearch($builder, $searchText)
    {
        return $builder->where('name', 'like', "%{$searchText}%")
            ->orWhere('mobile', 'like', "%{$searchText}%")
            ->orWhere('email', 'like', "%{$searchText}%");
    }


}
