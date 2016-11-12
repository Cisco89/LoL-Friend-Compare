<?php

namespace App\Controllers;

abstract class BaseController
{
    /**
     * @var \Mustache_Engine
     */
    protected $view;

    public function __construct()
    {
        $this->view = new \Mustache_Engine(
            [
                'loader' => new \Mustache_Loader_FilesystemLoader( VIEWPATH )
            ]
        );
    }
}
