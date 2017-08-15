<?php

namespace JeroenG\GuestPass;

use Illuminate\Database\Eloquent\Model;

class GuestPass extends Model
{
    protected $table = 'guestpasses';
    protected $fillable = ['key', 'owner_id', 'owner_model', 'object_id', 'object_model'];
}
