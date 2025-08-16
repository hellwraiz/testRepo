<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FormInput extends Model {

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'imgUrl',
    ];
}
