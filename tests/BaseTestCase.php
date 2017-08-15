<?php

namespace JeroenG\GuestPass\Tests;

// Based on the BaseTestCase of the Bouncer package by Joseph Silber.

use PHPUnit\Framework\TestCase;
use JeroenG\GuestPass\GuestPassService;
use JeroenG\GuestPass\Tests\Fakes\Photos;
use JeroenG\GuestPass\Tests\Fakes\Schema;
use Illuminate\Database\Capsule\Manager as DB;

abstract class BaseTestCase extends TestCase
{
    /**
     * The database capsule instance.
     *
     * @var Illuminate\Database\Capsule\Manager
     */
    protected $db;

    /**
     * The GuestPass instance.
     *
     * @var JeroenG\GuestPass\GuestPassService
     */
    protected $guestpass;

    /**
     * Setup the database schema.
     *
     * @return void
     */
    public function setUp()
    {
        $this->migrate();
    }

    /**
     * Migrate the Guest Pass and test tables.
     * @return void
     */
    protected function migrate()
    {
        $this->db();

        $this->migrateTestTables();
    }

    /**
     * Create an users and photos table to test with.
     * @return void
     */
    protected function migrateTestTables()
    {
        Schema::create('guestpasses', function ($table) {
            $table->increments('id');
            $table->string('key', 10)->unique();
            $table->string('owner_model');
            $table->integer('owner_id');
            $table->string('object_model');
            $table->integer('object_id');
            $table->string('view')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('photos', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Tear down the database schema.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->rollbackTestTables();

        $this->db = null;
    }

    /**
     * Roll back the test tables.
     * @return void
     */
    protected function rollbackTestTables()
    {
        Schema::drop('guestpasses');
        Schema::drop('users');
        Schema::drop('photos');
    }

    /**
     * Get a GuestPass instance.
     *
     * @return JeroenG\GuestPass\GuestPassService
     */
    protected function guestpass()
    {
        return (is_null($this->guestpass)) ? new GuestPassService : $this->guestpass;
    }

    /**
     * Get an instance of the database capsule manager.
     *
     * @return \Illuminate\Database\Capsule\Manager
     */
    protected function db()
    {
        if ($this->db) {
            return $this->db;
        }

        $this->db = new DB;

        $this->db->addConnection([
            'driver'    => 'sqlite',
            'database'  => ':memory:',
        ]);

        $this->db->bootEloquent();

        $this->db->setAsGlobal();

        return $this->db;
    }
}
