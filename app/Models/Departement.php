<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Departement extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function faculty(){
        return $this->hasOne(Faculty::class,'id','faculty_id');
    }


    public function getFullAttribute(): string
    {
        return $this->faculty['name'] . ' / '.$this->attributes['name'];
    }

    // public function scopeActive(Builder $query){
    //     return $query->where('faculty_id','status');
    // }
}
