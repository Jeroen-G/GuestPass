<?php

namespace JeroenG\GuestPass\Controllers;

use JeroenG\GuestPass\GuestPassFacade as GuestPass;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Access extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke($owner, $key)
    {
        // First, get the Guest Pass and corresponding object models.
        $pass = GuestPass::getGuestPass($key);
        $object = (new $pass->object_model)->findOrFail($pass->object_id);

        // Check if there is a view handle saved in the database.
        if ($pass->view == null) {
            // If not, see if a view named after the object model exists.
            $viewName = strtolower(class_basename($object));
            if (file_exists(resource_path('views/guests/'.$viewName.'.blade.php'))) {
                return view('guests/'.$viewName, ['object' => $object]);
            }
        // If there is a view handle saved, check if the file exists.
        } elseif (file_exists(resource_path('views/guests/'.$pass->view.'.blade.php'))) {
            return view('guests/'.$$pass->view, ['object' => $object]);
        }
        // In case neither exists, abort.
        abort(404);
    }
}
