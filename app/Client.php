<?php

namespace App;

use Carbon\Carbon;
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

    public function scopeSearch($builder,$searchText)
    {
        return $builder->where('name', 'like', "%{$searchText}%")
            ->orWhere('mobile', 'like', "%{$searchText}%")
            ->orWhere('email', 'like', "%{$searchText}%");
    }
    public function country(){
        return $this->belongsTo("App/Country");
    }
    public static function getAge($birthDate){
        $birthDate=Carbon::parse($birthDate);
        $date_now=Carbon::now();
        $age=$date_now->diffInYears($birthDate);
        return $age;
    }
    public static function isMobileUnique($mobile){
        $count=self::where('mobile', $mobile)->count();
        return $count;
    }
    public static function isEmailUnique($email){
        $count=self::where('email', $email)->count();
        return $count;
    }



}
