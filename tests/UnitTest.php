<?php

namespace JeroenG\GuestPass\Tests;

use JeroenG\GuestPass\Tests\Fakes\User;
use JeroenG\GuestPass\Tests\Fakes\Photo;

class UnitTest extends BaseTestCase
{
    public function test_create_guestpass()
    {
        $this->assertTrue(
            $this->guestpass()->create(
                User::create(['id' => 1, 'name' => 'Jeroen']),
                Photo::create(['id' => 90, 'name' => 'Windmill'])
        ));
    }

    public function test_create_guestpass_custom_view()
    {
        $this->assertTrue(
            $this->guestpass()->create(
                User::create(['id' => 1, 'name' => 'Jeroen']),
                Photo::create(['id' => 91, 'name' => 'Tulip']),
                'customphoto'
        ));
    }

    public function test_get_keys()
    {
        $user = User::create(['id' => 1, 'name' => 'Jeroen']);
        $photo = Photo::create(['id' => 92, 'name' => 'Clog']);

        $this->guestpass()->create($user, $photo);

        $this->assertTrue(
            $this->guestpass()->getKeysOf($user)->contains(function ($item) {
                return $item->object_id == 92;
        }));
    }

    public function test_find()
    {
        $user = User::create(['id' => 1, 'name' => 'Jeroen']);
        $photo = Photo::create(['id' => 92, 'name' => 'Clog']);

        $this->guestpass()->create($user, $photo);

        $this->assertContains(92, $this->guestpass()->findGuestPass($user, $photo)->toArray());
    }

    public function test_get_by_key()
    {
        $user = User::create(['id' => 1, 'name' => 'Jeroen']);
        $photo = Photo::create(['id' => 92, 'name' => 'Clog']);

        $this->guestpass()->create($user, $photo);

        $guestpass = $this->guestpass()->findGuestPass($user, $photo);

        $this->assertEquals($guestpass, $this->guestpass()->getGuestPass($guestpass->key));
    }

    public function test_is_owner()
    {
        $user = User::create(['id' => 1, 'name' => 'Jeroen']);
        $photo = Photo::create(['id' => 93, 'name' => 'Polder']);

        $this->guestpass()->create($user, $photo);

        $guestpass = $this->guestpass()->findGuestPass($user, $photo);

        $this->assertTrue($this->guestpass()->isOwner($user, $guestpass));
    }
}
