NotORM Connection for Nette Framework 2
=======================================

This class create NotORM connection in Nette Framework 2 project with panel for Nette\Debugger.
For NotORM you can specify your NotORM_Structure or NotORM_Cache.


Installing
----------

1. Copy notorm_connection/ directory into your nette libs/ project.
	(of course you need also notorm/ in libs/)

2. Setup config.neon. (see included config.neon file for config possibilities)

3. Now NotORM connection is accessible via context:

		$this->context->notorm->...

4. You can create shortcuts in BasePresenter.
	(X-layers-domain-model-lovers read more only on your own risk! ;-)

	abstract class BasePresenter extends Nette\Application\UI\Presenter
	{
		/**
		 * @var NotORM
		 */
		public $db;

		protected function startup() {
			$this->db = $this->context->notorm;
		}

		protected function beforeRender() {
			$this->template->db = $this->db;
		}

	}

	Now you can use notorm in all presenters e.g.:

		public function renderDefault() {
			$title = $this->db->article[$id]['title'];
		}

	or in all templates e.g.:

		{$db->article[$id]['title']}

5. If you need some addition configuration for NotORM you can do it in bootstrap.php:

	......
	$container = $configurator->loadConfig(__DIR__ . '/config.neon');

	// NotORM setup
	$container->notorm->rowClass = 'My_NotORM_Row';

6. Now you can delete Nette/Database directory ;-)


For more information see source code or NotORM and Nette framework documentation.


License
--------

Feel free use it for everything ;-)

