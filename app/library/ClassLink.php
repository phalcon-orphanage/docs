<?php

namespace Docs;

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

    /**
     * ClassLink constructor.
     *
     * @param $className
     */
    public function __construct($className)
    {
        $isArray = (preg_match("/^(.*)\[\]$/", $className, $match) === 1);

        if ($isArray) {
            $className = $match[1];
        }

        $this->className = $className;
        $this->isArray   = $isArray;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        $className = preg_replace("/^\\\\/", "", $this->className);
        if (!class_exists($className) && !interface_exists($className)) {
            return "*" . $className . "*" . ($this->isArray ? "\ []" : "");
        }

        $className = str_replace("\\\\", '\\', $className);
        if (preg_match("/^Phalcon\\\\/", $className)) {
            $htmlClassName = str_replace("\\", "_", $className);
            return sprintf(
                '[%s](/[[language]]/[[version]]/api/%s)',
                $className,
                $htmlClassName . ($this->isArray ? '[]' : '')
            );
        } else {
            $url = "http://php.net/manual/en/class." . strtolower($className) . ".php";
            return sprintf(
                '[%s](%s)',
                $className,
                $url . ($this->isArray ? '[]' : '')
            );
        }
    }
}