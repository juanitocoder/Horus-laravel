<?php

namespace App\Models;

use Dom\Attr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Post extends Model
{
    protected function casts ():array{
        return [
            'published_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    protected $table = "posts";
    protected function title():Attribute
    {
       
        return Attribute::make(
           set:function($value){
            return strtolower($value);
           },

           get:function($value){
            return ucfirst($value);
           }
        );
    }
}
