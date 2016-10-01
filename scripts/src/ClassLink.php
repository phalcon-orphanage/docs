<?php

namespace PhalconDocs;

class ClassLink
{
    /**
     * @var string
     */
    protected $className;



    public function __construct($className)
    {
        $this->className = $className;
    }



    public function get()
    {
        if (class_exists($this->className) || interface_exists($this->className)) {
            if (preg_match("/^(\\\\?Phalcon\\\\[a-zA-Z0-9\\\\]+)/", $this->className)) {
                $classPath = preg_replace("/^\\\\/", "", $this->className);
                $classPath = str_replace("\\", "_", $classPath);
                $className = preg_replace("/^\\\\/", "", $this->className);
                $className = str_replace("\\", "\\\\", $className);

                return str_replace(
                    $this->className,
                    ":doc:`" . $className . " <" . $classPath . ">`",
                    $this->className
                );
            } else {
                $className = preg_replace("/^\\\\/", "", $this->className);
                $className = str_replace("\\", "\\\\", $className);

                return str_replace(
                    $this->className,
                    "`" . $className . " <http://php.net/manual/en/class." . strtolower($className) . ".php>`_",
                    $this->className
                );
            }
        } elseif (preg_match("/\\\\/", $this->className)) {
            $className = preg_replace("/^\\\\/", "", $this->className);
            $className = str_replace("\\", "\\\\", $className);

            return $className;
        } else {

            return "*" . $this->className . "*";
        }
    }
}
