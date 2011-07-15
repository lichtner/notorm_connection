<?php

namespace NotORM;

use Nette\Diagnostics\Debugger,
	PDO,
	NotORM;

/**
 * Service for NotORM and PDO connection
 *
 * @package	NotORM
 * @author	Marek Lichtner <marek@licht.sk>
 * @license	license.txt MIT
 * @version	1.0
 *
 */
class Connection {

	/**
	 * @var PDO
	 */
	private $pdo;
	/**
	 * @var NotORM
	 */
	private $notorm;

	/**
	 * Create PDO connection
	 *
	 * @param string|array $dsn could be dns or $dns is array of params
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($dsn = NULL, $username = NULL, $password = NULL) {
		if (is_array($dsn)) {
			$username = $dsn['username'];
			$password = $dsn['password'];
			$dsn = "$dsn[driver]:host=$dsn[host];dbname=$dsn[database]";
		}
		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->query('SET NAMES utf8');

		$this->pdo = $pdo;
	}

	public function getPDO() {
		return $this->pdo;
	}

	/**
	 *
	 *
	 * @param IContainer $container
	 * @param NotORM_Structure $structure
	 * @param NotORM_Cache $cache
	 * @param string $notormClassName sometimes you need descendant of NotORM
	 * @return NotORM
	 */
	public function getNotORM($container, $structure = NULL, $cache = NULL, $notormClassName = 'NotORM') {
		if (!$this->notorm) {
			$this->notorm = new $notormClassName($this->pdo, $structure, $cache);

			$panel = Panel::getInstance();
			$panel->setPlatform($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
			Debugger::addPanel($panel);

			$this->notorm->debug = function($query, $parameters) {
						Panel::getInstance()->logQuery($query, $parameters);
					};
		}
		return $this->notorm;
	}

}
