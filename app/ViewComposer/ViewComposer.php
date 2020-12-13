<?php

namespace App\ViewComposer;

use Illuminate\View\View;

class ViewComposer
{

    public function __construct()
    {
    }
    public function compose(View $view)
    {
        $view->with([]);
    }
}
