<?php

namespace PhalconDocs;

class ClassLink
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var boolean
     */
    protected $isArray;



    public function __construct($className)
    {
        $isArray = (preg_match("/^(.*)\[\]$/", $className, $match) === 1);

        if ($isArray) {
            $className = $match[1];
        }

        $this->className = $className;
        $this->isArray   = $isArray;
    }



    public function get()
    {
        $className = preg_replace("/^\\\\/", "", $this->className);

        if (!class_exists($className) && !interface_exists($className)) {
            return "*" . $className . "*" . ($this->isArray ? "\ []" : "");
        }

        $className = str_replace("\\", "\\\\", $className);

        if (preg_match("/^Phalcon\\\\/", $className)) {
            $path = str_replace("\\\\", "_", $className);

            return ":doc:`" . $className . " <" . $path . ">`" . ($this->isArray ? "\ []" : "");
        } else {
            $url = "http://php.net/manual/en/class." . strtolower($className) . ".php";

            return "`" . $className . " <" . $url . ">`_" . ($this->isArray ? "\ []" : "");
        }
    }
}
