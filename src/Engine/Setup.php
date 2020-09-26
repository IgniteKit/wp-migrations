<?php

namespace IgniteKit\WP\Migrations\Engine;

use IgniteKit\WP\Migrations\Wrappers\Schema;
use IgniteKit\WP\Migrations\Database\Blueprint;

trait Setup {

	/**
	 * Setup the migrations table
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( $this->migrationsTableName, function ( Blueprint $table ) {
			$table->increments( 'id' )->unique();
			$table->string( 'name' );
			$table->timestamp( 'created' )->useCurrent();
		} );
	}


	public function down() {
		Schema::drop( $this->migrationsTableName );
	}

}