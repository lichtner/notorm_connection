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

4. If you need some addition configuration for NotORM you can do it in bootstrap.php:

	......
	$container = $configurator->loadConfig(__DIR__ . '/config.neon');

	// NotORM setup
	$container->notorm->rowClass = 'My_NotORM_Row';

5. You can create shortcuts in BasePresenter.
	(X-layers-domain-model-lovers read more only on your own risk! ;-)

	abstract class BasePresenter extends Nette\Application\UI\Presenter
	{
		/**
		 * @var NotORM
		 */
		public $notorm;

		protected function startup() {
			$this->notorm = $this->context->notorm;
		}

		protected function beforeRender() {
			$this->template->notorm = $this->notorm;
		}

	}

	Now you can use notorm in all presenters e.g.:

		public function renderDefault() {
			$title = $this->notorm->article[$id]['title'];
			// or
			$this->template->article = $this->notorm->article[$id];
		}

	and in template e.g.:

		{$article['title']}

6. Now you can delete libs/Nette/Database directory ;-)


For more information see source code or NotORM and Nette framework documentation.


License
--------

Feel free use it for everything ;-)

