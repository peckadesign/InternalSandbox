<?php

namespace Pd\InternalSandbox\Commands;

use Nette;


trait TNamedCommand
{

	private function generateName()
	{
		$className = __CLASS__;
		$name = substr($className, 0);
		$name = str_replace('Module', '', $name);
		$name = str_replace('Commands', '', $name);
		$name = str_replace('Command', '', $name);
		$name = str_replace('\\', ':', $name);
		$name = str_replace('::', ':', $name);
		$name = Nette\Utils\Strings::replace($name, '~([^:])([A-Z])~', '$1-$2');
		$name = strtolower($name);
		$name = ltrim($name, '-');

		return $name;
	}
}
