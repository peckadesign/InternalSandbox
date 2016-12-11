<?php

namespace Pd\InternalSandbox\DashBoard\Presenters;

use Kdyby;
use Nette;
use Pd;
use Tracy;


class LoginPresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var string
	 * @persistent
	 */
	public $backLink;

	/**
	 * @var Kdyby\Github\Client
	 */
	private $github;

	/**
	 * @var Pd\InternalSandbox\User\UsersRepository
	 */
	private $users;

	/**
	 * @var int
	 */
	private $administratorTeamId;


	public function __construct(
		int $administratorTeamId,
		Kdyby\Github\Client $gitHub,
		Pd\InternalSandbox\User\UsersRepository $users
	) {
		parent::__construct();
		$this->administratorTeamId = $administratorTeamId;
		$this->github = $gitHub;
		$this->users = $users;
	}


	protected function createComponentGitHubLogin(): Kdyby\Github\UI\LoginDialog
	{
		$dialog = new Kdyby\Github\UI\LoginDialog($this->github);

		$dialog->onResponse[] = function (Kdyby\Github\UI\LoginDialog $dialog) {
			/** @var Kdyby\Github\Client $gitHub */
			$gitHub = $dialog->getClient();

			if ( ! $gitHub->getUser()) {
				$this->flashMessage("Sorry bro, github authentication failed.");

				return;
			}

			try {
				$me = $gitHub->api('/user');

				$conditions = [
					'gitHubId' => $gitHub->getUser(),
				];
				if ( ! $user = $this->users->getBy($conditions)) {
					$user = new Pd\InternalSandbox\User\User();
					$user->gitHubId = $me['id'];
					$user->gitHubName = $me['name'] ?: $me['login'];
					$user->administrator = FALSE;

					try {
						$response = $gitHub->api('/teams/' . $this->administratorTeamId . '/memberships/' . $me['login']);
						if ($response->state === 'active') {
							$user->administrator = TRUE;
						}
					} catch (Kdyby\Github\UnknownResourceException $e) {
					}
				}

				$user->gitHubToken = $gitHub->getAccessToken();
				$this->users->persistAndFlush($user);

				$this->getUser()->login($user);
			} catch (Kdyby\Github\ApiException $e) {

				Tracy\Debugger::log($e, 'github');
				$this->flashMessage("Sorry bro, github authentication failed hard.");
			}

			if ($this->backLink) {
				$this->restoreRequest($this->backLink);
			}

			$this->redirect(':DashBoard:HomePage:default');
		};

		return $dialog;
	}
}
