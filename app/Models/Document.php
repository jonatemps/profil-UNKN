<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

class Document extends Model
{
    use HasFactory, Attachable;

    protected $with = ['file'];

    public function file(){
        return $this->hasOne(Attachment::class,'id','file');
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];



    public function attach()
    {
        return $this->belongsTo(Attachment::class, 'carteId','id');
    }
}
