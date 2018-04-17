<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscriber';

    public $timestamps = false;

    protected $primaryKey = 'email';
}
