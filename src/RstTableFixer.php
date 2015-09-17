<?php

namespace Phalcon\Docs;

class RstTableFixer
{
    public function fix($rstString)
    {
        $lines = explode("\n", $rstString);
//        var_dump($lines); exit;
        $output = '';
        $inTable = false;
        
        foreach ($lines as $line) {
            if ($inTable && $line == '') {
                $inTable = false;
                $output .= $rstTable->render();
            } elseif (! $inTable && substr($line, 0, 7) == '+------') {
                $inTable = true;
                $header = false;
                $rstTable = new RstTable();
            } elseif (! $inTable) {
                $output .= $line . "\n";
            }
            
            if ($inTable) {
                if (substr($line, 0, 2) === '| ') {
                    // escape '\|'
                    $line = str_replace('\\|', '\\｜', $line);
                    $items = explode('|', $line);
                    
                    // remove first and last empty elements
                    array_shift($items);
                    array_pop($items);
                    
                    $newItems = array();
                    foreach ($items as $item) {
                        $newItem = trim($item);
                        // unescape '\|'
                        $newItem = str_replace('\\｜', '\\|', $newItem);
                        $newItems[] = $newItem;
                    }
                    
                    if ($header) {
                        $rstTable->addRecord($newItems);
                    } else {
                        $rstTable->setHeader($newItems);
                        $header = true;
                    }
                }
            }
        }
        
        return $output;
    }
}
