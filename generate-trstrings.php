<?php

class Docs
{

	private $_output = '';

	private $_prefix;

	private $_uniqueStrings = array();

	private $debug = false;

	public function processUniqueSection($section, &$uniqueStrings)
	{
		if ($this->debug) {
			echo '### processUniqueSection() $section', PHP_EOL;
			var_dump($section);
		}

		if (!isset($section[0])) {
			return array();
		}

		$first = true;
		$newSection = array();
		foreach ($section as $line) {
			if ($first) {
				if (!trim($line)) {
					continue;
				}
				$first = false;
				$newSection[] = $line;
			} else {
				$newSection[] = $line;
			}
		}
		$section = $newSection;

		if (preg_match('#[ \t]*\.\.[ \t]+code-block::#', $section[0])) {
			foreach ($section as $str) {

				if (preg_match('#//[ \t]*([^;]*)[\r\n]$#', $str, $matches)) {
					if (preg_match('#[a-zA-Z]#', $str)) {
						$key = $this->_prefix . '_' . md5($matches[1]);
						$str = str_replace($matches[1], '%{' . $key . '}%', $str);
						$this->_uniqueStrings[$key] = $matches[1];
					}
				}

				$uniqueStrings[] = array('type' => 'code-section', 'value' => $str);
			}
		} else {

			if (preg_match('#[ \t]*\.\.[ \t]+[a-z\-]+::#', $section[0])) {

				$section1 = join('', $section);
				$uniqueStrings[] = array('type' => 'text-raw', 'value' => $section1);
				$uniqueStrings[] = array('type' => 'separator', 'value' => PHP_EOL);

			} elseif (substr($section[0], 0, 7) == '+------') {
				// table
				foreach ($section as $position => $line) {
					if (substr($line, 0, 1) === '|') {
						// escape '\|'
						$line = str_replace('\\|', '\\｜', $line);
						$items = explode('|', $line);
						// remove first and last empty elements
						array_shift($items);
						array_pop($items);
						
						$section[$position] = '| ';
						foreach ($items as $item) {
							$item = trim($item);
							// unescape '\|'
							$item = str_replace('\\｜', '\\|', $item);
							
							$doc_link_only = false;
							if (preg_match('#^:doc:`[^`]+`$#', $item)) {
								$doc_link_only = true;
							}
							
							$link_only = false;
							if (preg_match('#^`[^`]+`_$#', $item)) {
								$link_only = true;
							}
							
							$number = 1;
							$placeholders = array();
							if (! $doc_link_only && preg_match_all('#:doc:`[^`]+`#', $item, $matches, PREG_SET_ORDER)) {
								foreach ($matches as $position_tmp => $match) {
									$placeholders[$number] = $match[0];
									$item_ph = str_replace($match[0], ':' . ($number) . ':', $item);
									$number++;
								}
							} elseif (! $link_only && preg_match_all('#`[^`]+`_#', $item, $matches, PREG_SET_ORDER)) {
								foreach ($matches as $position_tmp => $match) {
									$placeholders[$number] = $match[0];
									$item_ph = str_replace($match[0], ':' . ($number) . ':', $item);
									$number++;
								}
							} else {
								$item_ph = $item;
							}
							
							if (! $doc_link_only && ! $link_only) {
								$key = $this->_prefix . '_' . md5($item);
								if (count($placeholders)) {
									$section[$position] .= '%{' . $key . '\\|' . join('|', $placeholders) . '}% | ';
								} else {
									$section[$position] .= '%{' . $key . '}% | ';
								}
								$this->_uniqueStrings[$key] = $item_ph;
							} else {
								$section[$position] .= $item . ' | ';
							}
						}
						
						$section[$position] = rtrim($section[$position]);
						$section[$position] .= "\n";
					}
				}
				$section1 = join('', $section);
				$uniqueStrings[] = array('type' => 'text-raw', 'value' => $section1);
			} else {

				$list = true;
				foreach ($section as $position => $line) {
					if (!preg_match('#^[ \t]*\* #', $line)) {
						$list = false;
						break;
					}
				}

				if (!$list) {
					$markdownLinks = true;
					foreach ($section as $position => $line) {
						if (!preg_match('#^\.\.[ \t]+\_[a-zA-Z]#', $line)) {
							$markdownLinks = false;
							break;
						}
					}
				} else {
					$markdownLinks = false;
				}

				if ($list) {
					foreach ($section as $position => $line) {
						if (preg_match('#^[ \t]*\* (.*)#', $line, $listMatches)) {

							$number = 1;
							$placeholders = array();
							if (preg_match_all('#:doc:`[^`]+`#', $line, $matches, PREG_SET_ORDER)) {
								foreach ($matches as $position_tmp => $match) {
									$placeholders[$number] = $match[0];
									$listMatches[1] = str_replace($match[0], ':' . ($number) . ':', $listMatches[1]);
									$number++;
								}
							}

							if (preg_match_all('#`[^`]+`_#', $line, $matches, PREG_SET_ORDER)) {
								foreach ($matches as $position_tmp => $match) {
									$placeholders[$number] = $match[0];
									$listMatches[1] = str_replace($match[0], ':' . ($number) . ':', $listMatches[1]);
									$number++;
								}
							}

							if (preg_match_all('#[a-zA-Z0-9]+_ #', $line, $matches, PREG_SET_ORDER)) {
								foreach ($matches as $position_tmp => $match) {
									$placeholders[$number] = $match[0];
									$listMatches[1] = str_replace($match[0], ':' . ($number) . ': ', $listMatches[1]);
									$number++;
								}
							}

							if (!preg_match('#^:([0-9]+):$#', $listMatches[1])) {
								$key = $this->_prefix . '_' . md5($listMatches[0]);
								if (count($placeholders)) {
									$section[$position] = str_replace($listMatches[1], '%{' . $key . '|' . join('|', $placeholders) . '}%', '* ' . $listMatches[1] . "\n");
								} else {
									$section[$position] = str_replace($listMatches[1], '%{' . $key . '}%', $line);
								}
								$this->_uniqueStrings[$key] = $listMatches[1];
//								var_dump($section);
							}

						}
					}
				}

				if (!$list && !$markdownLinks) {

					$section1 = str_replace(array("\r\n", "\n"), ' ', join('', $section));
					$originalSection1 = $section1;

					$number = 1;
					$placeholders = array();
					if (preg_match_all('#:doc:`[^`]+`#', $section1, $matches, PREG_SET_ORDER)) {
						foreach ($matches as $position_tmp => $match) {
							$placeholders[$number] = $match[0];
							$section1 = str_replace($match[0], ':' . ($number) . ':', $section1);
							$number++;
						}
					}

					if (preg_match_all('#`[^`]+`_#', $section1, $matches, PREG_SET_ORDER)) {
						foreach ($matches as $position_tmp => $match) {
							$placeholders[$number] = $match[0];
							$section1 = str_replace($match[0], ':' . ($number) . ':', $section1);
							$number++;
						}
					}

					if (preg_match_all('#[a-zA-Z0-9]+_ #', $section1, $matches, PREG_SET_ORDER)) {
						foreach ($matches as $position_tmp => $match) {
							$placeholders[$number] = $match[0];
							$section1 = str_replace($match[0], ':' . ($number) . ': ', $section1);
							$number++;
						}
					}

					$hash1 = md5(mb_strtolower($originalSection1));
					$uniqueStrings[] = array('type' => 'text-section', 'consecutive' => $hash1, 'value' => $section1, 'placeholders' => $placeholders);

				} else {
					$section1 = join('', $section);
					$uniqueStrings[] = array('type' => 'text-raw', 'value' => $section1);
				}
			}
		}
	}

	public function processSection($section)
	{
		if ($this->debug) {
			echo '### processSection() $section', PHP_EOL;
			var_dump($section);
		}

		if (!isset($section[0])) {
			return array();
		}

		$first = true;
		$newSection = array();
		foreach ($section as $line) {
			if ($first) {
				if (!trim($line)) {
					continue;
				}
				$first = false;
				$newSection[] = $line;
			} else {
				$newSection[] = $line;
			}
		}
		$section = $newSection;

		$separator = null;
		$twoSections = false;
		foreach ($section as $number => $line) {
			if (preg_match('!^[\-=\~#\^\*]{2,}$!', trim($line))) {
				$separator = $line;
				$twoSections = $number;
				break;
			}
		}

		if ($twoSections !== false) {

			$section1parts = array_slice($section, 0, $number);
			$section2parts = array_slice($section, $number + 1);

			$uniqueStrings = array();

			$this->processUniqueSection($section1parts, $uniqueStrings);
			$uniqueStrings[] = array('type' => 'separator', 'value' => $separator);

			$this->processUniqueSection($section2parts, $uniqueStrings);

		} else {
			$uniqueStrings = array();
			$this->processUniqueSection($section, $uniqueStrings);

		}

		$uniqueStrings[] = array('type' => 'separator', 'value' => PHP_EOL);

		if ($this->debug) {
			echo '### processSection() $uniqueStrings', PHP_EOL;
			var_dump($uniqueStrings);
		}

		return $uniqueStrings;
	}

	public function outputStrings($uniqueStrings)
	{
		foreach ($uniqueStrings as $consecutive => $uniqueString) {
			switch ($uniqueString['type']) {

				case 'text-section':
					$key = $this->_prefix . '_' . $uniqueString['consecutive'];
					if (count($uniqueString['placeholders'])) {
						$this->_output .= '%{' . $key . '|' . join('|', $uniqueString['placeholders']) . '}%' . PHP_EOL;
					} else {
						$this->_output .= '%{' . $key . '}%' . PHP_EOL;
					}
					$this->_uniqueStrings[$key] = rtrim($uniqueString['value']);
					break;

				case 'code-section':
				case 'text-raw':
					$this->_output .= $uniqueString['value'];
					break;

				case 'separator':
					$this->_output .= $uniqueString['value'];
					break;
			}
		}
	}

	public function processFile($path)
	{
		$section = array();
		$block = false;
		$this->_output = '';
		//$this->_uniqueStrings = array();
		foreach (file($path) as $line) {
			if (!trim($line) && !$block) {
				$uniqueStrings = $this->processSection($section);
				$this->outputStrings($uniqueStrings);
				$section = array();
			} else {
				if (!$block) {
					if (preg_match('#[ \t]*\.\.[ \t]+[a-z\-]+::#', $line)) {
						$block = true;
					}
				} else {
					if (preg_match('/^[A-Za-z:]/', $line)) {
						$block = false;
						$uniqueStrings = $this->processSection($section);
						$this->outputStrings($uniqueStrings);
						$section = array();

					} elseif (preg_match('#^\.\.[ \t]+\_[a-zA-Z]#', $line)) {
						$block = false;
						$uniqueStrings = $this->processSection($section);
						$this->outputStrings($uniqueStrings);
						$section = array();
					}
				}
				$section[] = $line;
			}
		}

		$uniqueStrings = $this->processSection($section);
		$this->outputStrings($uniqueStrings);
	}

	public function processBaseDirectory($directory)
	{
		$recursiveDirectoryIterator = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);

		/** @var $iterator RecursiveDirectoryIterator[] */
		$iterator = new RecursiveIteratorIterator($recursiveDirectoryIterator);

		foreach ($iterator as $item) {
			if ($item->getExtension() == 'rst') {

				$path = $item->getPathname();
				if (strpos($path, '_build/') === false && strpos($path, 'api/') === false) {

					if ($this->debug) {
						echo $path, PHP_EOL;
						if ($path !== 'en/reference/annotations.rst') continue;
					}

					$this->_prefix = str_replace('.rst', '', basename($path));
					$this->processFile($path);

					$baseRstPath = 'transifex/base-rst/' . dirname($path);
					@mkdir($baseRstPath, 0777, true);

					$output = rtrim($this->_output) . "\n";
					file_put_contents($baseRstPath . '/' . $this->_prefix . '.rst', $output);
				}
			}
		}

		$baseStrPath = 'transifex/strings/';
		@mkdir($baseStrPath, 0777, true);

		file_put_contents($baseStrPath . '/en.json', json_encode($this->_uniqueStrings, JSON_PRETTY_PRINT));
	}

	public function run()
	{
		$this->processBaseDirectory('en');

	}

}

$d = new Docs();
$d->run();
