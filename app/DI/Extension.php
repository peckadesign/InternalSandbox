<?php

namespace Pd\InternalSandbox\DI;

use Nette;
use Pd;


class Extension extends Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$userStorageDefinitionName = $builder->getByType(Nette\Security\IUserStorage::class) ?: 'nette.userStorage';
		$builder
			->getDefinition($userStorageDefinitionName)
			->setFactory(Pd\InternalSandbox\User\UserStorage::class)
		;
	}

}
