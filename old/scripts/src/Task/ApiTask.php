<?php

namespace PhalconDocs\Task;

use Exception;
use Phalcon\Cli\Task;

class ApiTask extends Task
{
    public function generateAction()
    {
        if (!$this->dispatcher->hasParam(0)) {
            throw new Exception(
                "cphalcon directory required"
            );
        }

        $cphalconDir = $this->dispatcher->getParam(0);

        define("CPHALCON_DIR", $cphalconDir);

        require "scripts/gen-api.php";
    }
}
