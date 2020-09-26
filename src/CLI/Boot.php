<?php

namespace IgniteKit\WP\Migrations\CLI;

/**
 * Class Boot
 * @package IgniteKit\WP\Migrations\CLI
 */
class Boot {

	/**
	 * Boot the CLI interface
	 * @return void
	 */
	public static function start() {

		if(defined('WP_CLI') && WP_CLI) {
			new \IgniteKit\WP\Migrations\CLI\MigrateCommand();
		}
	}
}