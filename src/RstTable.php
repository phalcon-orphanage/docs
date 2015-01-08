<?php

namespace Phalcon\Docs;

/**
 * Generate RST Table
 */
class RstTable
{
    private $header = array();
    private $records = array();
    private $maxLength = array();
    
    /**
     * Set Header
     * 
     * @param array $items
     */
    public function setHeader(array $items)
    {
        $this->header = $items;
    }
    
    /**
     * Add Record
     * 
     * @param array $items
     */
    public function addRecord(array $items)
    {
        $this->records[] = $items;
    }
    
    private function generateLine($str = '-')
    {
        $output = '+';
        foreach ($this->maxLength as $key => $val) {
            $output .= str_repeat($str, $val + 2);
            $output .= '+';
        }
        $output .= "\n";
        
        return $output;
    }
    
    /**
     * Render RST table
     * 
     * @return string
     * @throws \RuntimeException
     */
    public function render()
    {
        if (count($this->header) === 0) {
            throw new \RuntimeException('no header');
        }
        
        if (count($this->records) === 0) {
            throw new \RuntimeException('no record');
        }
        
        $this->getMaxlength();
        
        $output = $this->generateLine();
        
        $output .= '|';
        foreach ($this->header as $key => $item) {
            $output .= sprintf(
                ' %-'.$this->maxLength[$key].'s |',
                $item
            );
        }
        $output .= "\n";
        
        $output .= $this->generateLine('=');
        
        foreach ($this->records as $items) {
            $output .= '|';
            foreach ($items as $key => $item) {
                $output .= sprintf(
                    ' %-'.$this->maxLength[$key].'s |',
                    $item
                );
            }
            $output .= "\n";
            $output .= $this->generateLine();
        }
        
        return $output . "\n";
    }
    
    private function getMaxlength()
    {
        $length = array();
        
        foreach ($this->header as $key => $item) {
            if (! isset($length[$key])) {
                $length[$key] = 0;
            }
            $length[$key] = max($length[$key], mb_strlen($item));
        }
        
        foreach ($this->records as $items) {
            foreach ($items as $key => $item) {
                $length[$key] = max($length[$key], mb_strlen($item));
            }
        }
        
        $this->maxLength = $length;
    }
}
