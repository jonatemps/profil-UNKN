<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $with = ['faculty','department'];

    public function faculty(){
        return $this->belongsTo(Faculty::class,'faculty1_id','codefac');
    }

    public function department(){
        return $this->belongsTo(Departement::class,'departement1_id','codedpt');
    }
}
