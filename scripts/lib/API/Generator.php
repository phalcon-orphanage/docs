<?php

class API_Generator {
    protected $_directory;
    protected $_docs = array();
	protected $_docsOverride = array(
        'Exception' => array(
            '__construct' => '/**
             * Exception constructor
             *
             * @param string $message
             * @param int $code
             * @param Exception $previous
            */',
                'getMessage' => '/**
             * Gets the Exception message
             *
             * @return string
            */',
                'getCode' => '/**
             * Gets the Exception code
             *
             * @return int
            */',
                'getLine' => '/**
             * Gets the line in which the exception occurred
             *
             * @return int
            */',
                'getFile' => '/**
             * Gets the file in which the exception occurred
             *
             * @return string
            */',
                'getTrace' => '/**
             * Gets the stack trace
             *
             * @return array
            */',
                'getTrace' => '/**
             * Gets the stack trace
             *
             * @return array
            */',
                'getTraceAsString' =>'/**
             * Gets the stack trace as a string
             *
             * @return Exception
            */',
                '__clone' => '/**
             * Clone the exception
             *
             * @return Exception
            */',
                'getPrevious' => '/**
             * Returns previous Exception
             *
             * @return Exception
            */',
                '__toString' => '/**
             * String representation of the exception
             *
             * @return string
            */'
        )
    );

	public function __construct($directory){
        $this->_directory = $directory;
		$this->_scanSources($directory);
	}

	protected function _scanSources($directory){
		$iterator = new DirectoryIterator($directory);
		foreach($iterator as $item){
			if($item->isDir()){
				if($item->getFileName()!='.'&&$item->getFileName()!='..'){
					$this->_scanSources($item->getPathname());
				}
			} else {
				if(preg_match('/\.c$/', $item->getPathname())){
					if(strpos($item->getPathname(), 'kernel')===false){
						$this->_getDocs($item->getPathname());
					}
				}
			}
		}
	}

	protected function _getDocs($file){
		$firstDoc = true;
		$openComment = false;
		$nextLineMethod = false;
		$comment = '';
		foreach(file($file) as $line){
			if(trim($line)=='/**'){
				$openComment = true;
				$comment.=$line;
			}
			if($openComment===true){
				$comment.=$line;
			} else {
				if($nextLineMethod===true){
					if(preg_match('/^PHP_METHOD\(([a-zA-Z\_]+), (.*)\)/', $line, $matches)){
						$this->_docs[$matches[1]][$matches[2]] = $comment;
						$className = $matches[1];
					} else {
						if(preg_match('/^PHALCON_DOC_METHOD\(([a-zA-Z\_]+), (.*)\)/', $line, $matches)){
							$this->_docs[$matches[1]][$matches[2]] = $comment;
							$className = $matches[1];
						} else {
							if($firstDoc===true){
								$classDoc = $comment;
								$firstDoc = false;
								$comment = '';
							}
						}
					}
					$nextLineMethod = false;
				} else {
					$comment = '';
				}
			}
			if($openComment===true){
				if(trim($line)=='*/'){
					$comment.=$line;
					$openComment = false;
					$nextLineMethod = true;
				}
			}
		}
		if(isset($classDoc)){
			if(isset($className)){
				if(!isset($this->_classDocs[$className])){
					$this->_classDocs[$className] = $classDoc;
				}
			} else {
				$fileName = str_replace($this->_directory, '', $file);
				$fileName = str_replace('.c', '', $fileName);

				$parts = array();
				foreach(explode(DIRECTORY_SEPARATOR, $fileName) as $part){
					$parts[] = ucfirst($part);
				}
				$className = 'Phalcon\\'.join('\\', $parts);
				if(!isset($this->_classDocs[$className])){
					if(class_exists($className)){
						$this->_classDocs[$className] = $classDoc;
					}
				}
			}
		}
	}

	public function getDocs(){
		return array_merge($this->_docs, $this->_docsOverride);
	}

	public function getClassDocs(){
		return $this->_classDocs;
	}

	public function getPhpDoc($phpdoc, $className, $methodName, $realClassName){

		$ret = array();
		$lines = array();
		$description = '';
		$phpdoc = trim($phpdoc);
		foreach(explode("\n", $phpdoc) as $line){
			$line = preg_replace('#^/\*\*#', '', $line);
			$line = str_replace('*/', '', $line);
			$line = preg_replace('#^[ \t]+\*#', '', $line);
			$tline = trim($line);
			if($className!=$tline){
				$lines[] = $line;
			}
		}

		$rc = str_replace("\\\\", "\\", $realClassName);

		$numberBlock = -1;
		$insideCode = false;
		$codeBlocks = array();
		foreach($lines as $line){
			if(strpos($line, '<code')!==false){
				$numberBlock++;
				$insideCode = true;
			}
			if(strpos($line, '</code')!==false){
				$insideCode = false;
			}
			if($insideCode==false){
				$line = str_replace('</code>', '', $line);
				if(trim($line)!=$rc){
					if(preg_match('/@([a-z0-9]+)/', $line, $matches)){
						$content = trim(str_replace($matches[0], '', $line));
						if($matches[1]=='param'){
							$parts = preg_split('/[ \t]+/', $content);
							if(count($parts)==2){
								$ret['parameters'][$parts[1]] = trim($parts[0]);
							} else {
								//throw new Exception("Failed proccessing parameters in ".$className.'::'.$methodName);
							}
						} else {
							$ret[$matches[1]] = $content;
						}
					} else {
						$description.=ltrim($line)."\n";
					}
				}
			} else {
				if(!isset($codeBlocks[$numberBlock])){
					$line = str_replace('<code>', '', $line);
					$codeBlocks[$numberBlock] = $line."\n";
					$description.='%%'.$numberBlock.'%%';
				} else {
					$codeBlocks[$numberBlock].=$line."\n";
				}
			}
		}

		foreach($codeBlocks as $n => $cc){
			$c = '';
			$firstLine = true;
			$p = explode("\n", $cc);
			foreach($p as $pp){
				if($firstLine){
					if(substr(ltrim($pp), 0, 1)!='['){
						if(!preg_match('#^<?php#', ltrim($pp))){
							if(count($p)==1){
								$c.='    <?php ';
							} else {
								$c.='    <?php'.PHP_EOL.PHP_EOL;
							}
						}
					}
					$firstLine = false;
				}
				$pp = preg_replace('#^\t#', '', $pp);
				if(count($p)!=1){
					$c.='    '.$pp.PHP_EOL;
				} else {
					$c.= $pp.PHP_EOL;
				}
			}
			$c.=PHP_EOL;
			$codeBlocks[$n] = rtrim($c);
		}

		$description = str_replace('<p>', '', $description);
		$description = str_replace('</p>', PHP_EOL.PHP_EOL, $description);

		$c = $description;
		$c = str_replace("\\", "\\\\", $c);
		$c = trim(str_replace("\t", "", $c));
		$c = trim(str_replace("\n", " ", $c));
		foreach($codeBlocks as $n => $cc){
			if(preg_match('#\[[a-z]+\]#', $cc)){
				$type = 'ini';
			} else {
				$type = 'php';
			}
			$c = str_replace('%%'.$n.'%%', PHP_EOL.PHP_EOL.'.. code-block:: '.$type.PHP_EOL.PHP_EOL.$cc.PHP_EOL.PHP_EOL, $c);
		}

		$final = '';
		$blankLine = false;
		foreach(explode("\n", $c) as $line){
			if(trim($line)==''){
				if($blankLine==false){
					$final.=$line."\n";
					$blankLine = true;
				}
			} else {
				$final.=$line."\n";
				$blankLine = false;
			}
		}

		$ret['description'] = $final;
		return $ret;
	}

    function extractComment($commentStr) {
        return preg_replace('/\*\/\s*\*\/\s*$/', '*/', preg_replace('/^\/\*\*\s*\/\*\*/', '/**', $commentStr));
    }
    
    function getRuntimeClasses() {
        $classes = array();
        foreach(get_declared_classes() as $className){
            if (!preg_match('#^Phalcon#', $className)) {
                continue;
            }
            $classes[] = $className;
        }

        foreach(get_declared_interfaces() as $className){
            if (!preg_match('#^Phalcon#', $className)) {
                continue;
            }
            $classes[] = $className;
        }

        sort($classes);
        return $classes;
    }
}
