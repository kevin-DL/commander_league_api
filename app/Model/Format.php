<?php

namespace App\Model;

class Format extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];
}
