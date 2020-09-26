<?php

	namespace IgniteKit\WP\Migrations\Contracts;


	interface QueryProducer{

		public function getTable();
		public function getColumns();
		public function getCommands();

	}