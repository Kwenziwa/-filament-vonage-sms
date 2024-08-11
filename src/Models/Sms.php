<?php

namespace kwenziwa\FilamentVonageSms\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = ['recipient', 'message', 'status'];

    public $timestamps = true;
}
