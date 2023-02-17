<?php

namespace Cellular\Controllers;

use CodeIgniter\Controller;

class AssetController extends Controller
{
    public function scripts()
    {
        $this->response->setHeader('Content-Type', 'application/javascript');
        $this->response->setBody(include_once(__DIR__ .'/../../dist/Cellular.js'));
    }

    public function styles()
    {
        $this->response->setHeader('Content-Type', 'text/css');
        $this->response->setBody(include_once(__DIR__ .'/../../dist/Cellular.css'));
    }
}
