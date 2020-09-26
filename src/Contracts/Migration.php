<?php 

	namespace IgniteKit\WP\Migrations\Contracts;

	interface Migration{

		public function up();
		public function down();
		
	}