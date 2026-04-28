<?php

namespace App;

use Illuminate\Foundation\Application as FoundationApplication;

class Application extends FoundationApplication
{
    protected $appPath = __DIR__;
    
    public function path($path = '')
    {
        return $this->appPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
