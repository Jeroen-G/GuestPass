<?php

namespace JeroenG\GuestPass;

use Illuminate\Database\Eloquent\Model;

class GuestPassService
{
    /**
     * Create a new instance.
     */
    public function __construct()
    {
        // constructor body
    }

    /**
     * Register the routes.
     * @return void
     */
    public function routes()
    {
        $router = app('router');
        $router->get('gp/{owner}/{key}', 'JeroenG\GuestPass\Controllers\Access');
    }

    /**
     * Create a new Guest Pass.
     * @param  lluminate\Database\Eloquent\Model $owner
     * @param  lluminate\Database\Eloquent\Model $object
     * @param  string|null                       $view   Leave out the .blade.php extension.
     * @return bool|Exception
     */
    public function create(Model $owner, Model $object, $view = null)
    {
        try {
            GuestPass::create([
                'key' => str_random(10),
                'owner_id' => $owner->id,
                'owner_model' => get_class($owner),
                'object_id' => $object->id,
                'object_model' => get_class($object),
                'view' => $view,
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check if the given user created the Guest Pass.
     * @param  lluminate\Database\Eloquent\Model $owner
     * @param  lluminate\Database\Eloquent\Model $guestpass
     * @return bool
     */
    public function isOwner(Model $owner, Model $guestpass)
    {
        return $owner->id == $guestpass->owner_id;
    }

    /**
     * Get all keys belonging to the owner.
     * @param  lluminate\Database\Eloquent\Model  $owner
     * @return array
     */
    public function getKeysOf(Model $owner)
    {
        return GuestPass::where([
            'owner_id' => $owner->id,
            'owner_model' => get_class($owner),
        ])->get()->keyBy('key');
    }

    /**
     * Find (or fail) the Guest Pass belonging to an owner-object pairing.
     * @param  lluminate\Database\Eloquent\Model                $owner
     * @param  lluminate\Database\Eloquent\Model                $object
     * @return lluminate\Database\Eloquent\Collection|Exception
     */
    public function findGuestPass(Model $owner, Model $object)
    {
        return GuestPass::where([
            'owner_id' => $owner->id,
            'owner_model' => get_class($owner),
            'object_id' => $object->id,
            'object_model' => get_class($object),
        ])->firstOrFail();
    }

    /**
     * Get a Guest Pass by its key (or fail).
     * @param  string                                      $key
     * @return lluminate\Database\Eloquent\Model|Exception
     */
    public function getGuestPass($key)
    {
        return GuestPass::where('key', $key)->firstOrFail();
    }
}
