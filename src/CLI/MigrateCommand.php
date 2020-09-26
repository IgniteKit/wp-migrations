<?php

namespace IgniteKit\WP\Migrations\CLI;

use WP_CLI;
use IgniteKit\WP\Migrations\Engine\Migrator;


if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Class MigrateCommand
 * @package IgniteKit\WP\Migrations\CLI
 */
class MigrateCommand {

	/**
	 * Run database migrations
	 *
	 * @param $args
	 * @param $assoc_args
	 */
	public function migrate( $args, $assoc_args ) {

		$migrator = new Migrator();

		#var_dump( $assoc_args );
		#die;

		if ( isset( $assoc_args['rollback'] ) ) {
			$migrator->down();
		} else {
			$migrator->up();
		}

		// Print a success message
		WP_CLI::success( "All migrations ran" );

	}
}

try {
	WP_CLI::add_command( 'tables', MigrateCommand::class );
} catch ( \Exception $e ) {
	error_log( $e->getMessage() );
}



