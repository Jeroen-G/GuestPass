<?php

namespace JeroenG\GuestPass\Tests\Fakes;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Photo extends Eloquent
{
    protected $table = 'photos';
    protected $guarded = [];
}
