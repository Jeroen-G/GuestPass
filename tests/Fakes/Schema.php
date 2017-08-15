<?php

namespace JeroenG\GuestPass\Tests\Fakes;

use Illuminate\Database\Capsule\Manager as DB;

class Schema
{
    public static function __callStatic($method, array $parameters)
    {
        $schema = DB::connection()->getSchemaBuilder();

        return call_user_func_array([$schema, $method], $parameters);
    }
}
