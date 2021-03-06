<?php

namespace IgniteKit\WP\Migrations\Engine;

use IgniteKit\WP\Migrations\Wrappers\Record;
use WP_CLI;
use Exception;
use IgniteKit\WP\Migrations\Wrappers\StaticInstance;
use IgniteKit\WP\Migrations\Contracts\Migration as MigrationContract;

class Migration extends StaticInstance implements MigrationContract {

	/**
	 * Name of this migration
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The migration date stamp
	 *
	 * @var string
	 */
	protected $timestamp;

	/**
	 * The current migrator running
	 *
	 * @var Migrator
	 */
	protected $migrator;

	/**
	 * Migration table name
	 * @var
	 */
	protected $migrationsTableName = 'migrations';

	/**
	 * Build a migration instance
	 *
	 */
	function __construct() {

		$this->name      = $this->getName();
		$this->timestamp = $this->getTimestamp();
		$this->migrationsTableName = apply_filters('ignitekit_migrations_table_name', $this->migrationsTableName);

		add_action( 'run_table_migrations', array( &$this, 'run' ) );
	}


	/**
	 * Set a new metabox.
	 *
	 * @param Migrator $migrator
	 *
	 * @return void
	 */
	public function run( Migrator $migrator ) {

		if ( ! $this->ran( $migrator ) ) {

			if ( $migrator->direction == 'up' ) {

				$this->up();
				$this->save( $migrator );
				$this->notify();

			} else {

				$this->down();
				$this->notify( 'Migration ' . $this->getName() . ' rolled back.' );
			}
		}
	}


	/**
	 * Save this migration
	 *
	 * @param Migrator $migrator
	 *
	 * @return void
	 */
	protected function save( $migrator ) {
		$data = [ 'name' => $this->name ];
		Record::insert( $this->migrationsTableName, $data );
	}

	/**
	 * Notify WP CLI if the migration went as planned
	 *
	 * @return void
	 */
	public function notify( $msg = null ) {
		if ( $msg == null ) {
			$msg = 'Migration ' . $this->getName() . ' ran succesfully.';
		}

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::Success( $msg );
		}
	}


	/**
	 * Returns the name of this migration
	 *
	 * @return string
	 */
	protected function getName() {
		return sanitize_title( get_class( $this ) );
	}

	/**
	 * Returns the timestamp of a migration
	 *
	 * @return string | null
	 */
	public function getTimestamp() {
		try {

			$migration = Record::find( $this->migrationsTableName )
			                   ->where( [ 'name' => $this->getName() ] )
			                   ->first();

			if ( ! is_null( $migration ) ) {
				return strtotime( $migration->created );
			}

		} catch ( Exception $e ) {

			error_log( $e->getMessage() );
		}

		return null;
	}

	/**
	 * Check if this migration already ran
	 *
	 * @param Migrator $migrator
	 *
	 * @return bool
	 */
	public function ran( $migrator ) {
		if ( $migrator->direction == 'up' && ! is_null( $this->timestamp ) ) {
			return true;
		}

		if ( $migrator->direction == 'down' && is_null( $this->timestamp ) ) {
			return true;
		}

		return false;
	}

	/**
	 * What to do when we create this migration
	 *
	 * @return void | null
	 */
	public function up() {
		return null;
	}

	/**
	 * What to do when we roll back this migration
	 *
	 * @return void | null
	 */
	public function down() {
		return null;
	}

	/**
	 * Register migration (alias of getInstance())
	 * @return StaticInstance
	 */
	public static function register() {
		return self::getInstance();
	}

}

