<?php

namespace App\Controllers;

abstract class BaseController
{
    /**
     * @var \Twig_Environment
     */
    protected $view;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(VIEWPATH);
        $this->view = new \Twig_Environment($loader);

    }

    protected function isLoggedIn() {
        return isset($_SESSION['user']['id']);
    }
}

