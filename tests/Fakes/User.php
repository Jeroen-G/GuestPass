<?php

namespace JeroenG\GuestPass\Tests\Fakes;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'users';
    protected $guarded = [];
}
