<?php

namespace App\Libs;

use Illuminate\Support\Facades\Route;

class MMS {

    /**
     * [isController description]
     * @param  [type]  $controller [description]
     * @return boolean             [description]
     */
    public function isController($controller)
    {
        $route = Route::currentRouteAction();
        return str_contains($route, $controller);
    }

    /**
     * checks if action is the one being passed in
     *
     * @param  [type]  $controller [description]
     * @return boolean             [description]
     */
    public function isActive($controller)
    {
        if ($this->isController($controller)) {
            return 'class="active"';
        }
        return '';
    }
}