<?php

namespace Pd\InternalSandbox\DashBoard\Presenters;

use Nette;
use Pd;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	use TSecuredPresenter;

	const FLASH_MESSAGE_SUCCESS = 'success';
	const FLASH_MESSAGE_INFO = 'info';
	const FLASH_MESSAGE_WARNING = 'warning';
	const FLASH_MESSAGE_ERROR = 'danger';

	/**
	 * @var Pd\InternalSandbox\DashBoard\Controls\Logout\IFactory
	 */
	private $logoutControlFactory;

	/**
	 * @var Pd\InternalSandbox\User\UsersRepository
	 */
	private $usersRepository;


	public function injectServices(
		Pd\InternalSandbox\DashBoard\Controls\Logout\IFactory $logoutControlFactory,
		Pd\InternalSandbox\User\UsersRepository $usersRepository
	) {
		$this->logoutControlFactory = $logoutControlFactory;
		$this->usersRepository = $usersRepository;
	}


	protected function createComponentLogout(): Pd\InternalSandbox\DashBoard\Controls\Logout\Control
	{
		return $this->logoutControlFactory->create();
	}


	protected function createTemplate()
	{
		$template = parent::createTemplate();

		$template->addFilter('dateTime', function (\DateTime $s) {
			return $s->format('j. n. Y H:i:s');
		});

		return $template;
	}

}
