<?php

use Nette\Diagnostics\Debugger;

/**
 * Service for NotORM and PDO connection
 *
 * @package	NotORM
 * @author	Marek Lichtner <marek@licht.sk>
 * @license	license.txt MIT
 * @version	1.0
 *
 */
class Connection /*extends \Nette\DI\Container*/ {

	/**
	 * Create PDO connection
	 *
	 * @param string|array $dsn could be dns or $dns is array of params
	 * @param string $username
	 * @param string $password
	 */
	public static function createServicePDO(Nette\DI\Container $container, $dsn, $username = '', $password = '') {
		if (is_array($dsn)) {
			$username = $dsn['username'];
			$password = $dsn['password'];
			$dsn = "$dsn[driver]:host=$dsn[host];dbname=$dsn[database]";
		}
		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->query('SET NAMES utf8');
		return $pdo;
	}

	/**
	 * Create Service NotORM
	 *
	 * @param IContainer $container
	 * @param NotORM_Structure $structure
	 * @param NotORM_Cache $cache
	 * @param string $notormClassName sometimes you need descendant of NotORM
	 * @return NotORM or descendant
	 */
	public static function createServiceNotORM(Nette\DI\Container $container, $structure = NULL, $cache = NULL, $notormClassName = 'NotORM', $notormRowClass = '') {

		$notorm = new $notormClassName($container->pdo, $structure, $cache);

		$panel = Panel::getInstance();
		$panel->setPlatform($container->pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
		Debugger::addPanel($panel);

		$notorm->debug = function($query, $parameters) {
					Panel::getInstance()->logQuery($query, $parameters);
				};

		if ($notormRowClass) {
			$notorm->setRowClass($notormRowClass);
		}

		return $notorm;
	}

}
