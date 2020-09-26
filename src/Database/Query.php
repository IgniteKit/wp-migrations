<?php

	namespace IgniteKit\WP\Migrations\Database;

	use IgniteKit\WP\Migrations\Utilities\Fluent;
	use IgniteKit\WP\Migrations\Database\Grammars\MySql;
	use IgniteKit\WP\Migrations\Contracts\QueryProducer;

	class Query extends BaseInterface implements QueryProducer{


		/**
		 * WHERE Clauses
		 * @var array
		 */
		public $clauses = [];


		/**
		 * Create a new schema record
		 * 
		 * @param string  $table
		 *
		 * @return void
		 */
		public function __construct( $table )
		{
			$this->table = $table;

		}


		/**
		 * Insert a record into the database
		 * @param $data
		 *
		 * @return $this
		 */
		public function insert( $data )
		{
			$this->addCommand( 'insert', [ 'data' => $data ] );
			return $this;
		}


		/**
		 * Upsert a record into the database
		 *
		 * @param int $id
		 * @param array $data
		 *
		 * @return $this
		 */
		public function update( $id, $data )
		{
			$this->where([ 'id' => $id ]);
			$this->addCommand( 'update', [ 'data' => $data ] );
			return $this;
		}


		/**
		 * Delete a record
		 * @param int $id
		 *
		 * @return $this
		 */
		public function delete( $id )
		{
			$this->where([ 'id' => $id ]);
			$this->addCommand( 'delete' );
			return $this;
		}


		/**
		 * Set where parameters
		 * @param $attributes
		 *
		 * @return $this
		 */
		public function where( $attributes )
		{
			$this->clauses[] = $attributes;
			return $this;
		}


		/**
		 * Return a find command
		 * @return $this
		 */
		public function find()
		{
			$command = $this->addCommand( 'find' );	
			return $this;
		}


		/**
		 * Add a limit to the eventual query
		 *
		 * @param $limit
		 *
		 * @return $this
		 */
		public function limit( $limit )
		{
			$this->clauses[] = [ 'limit' => $limit ];	
			return $this;
		}


		/**
		 * Execute the query against the database
		 * 
		 * @param  \wpdb $connection
		 * @return void
		 */
		public function run( $connection )
		{
			//set the grammar
			$this->grammar = new MySql( $this, $connection );

			foreach( $this->toSql() as $statement ) {
				$connection->query( $statement );	
			}
		}


		/**
		 * Execute a select query against the databse 
		 * 
		 * @param  \wpdb $connection
		 * 
		 * @return array
		 */
		public function results( $connection )
		{
			$this->grammar = new MySql( $this, $connection );
			$sql = $this->toSql();

			$results = $connection->get_results( $sql[0] );
			return $results;
		}


		/**
		 * Get the prepared SQL statements for the blueprint
		 * 
		 * @return array
		 */
		public function toSql()
		{

			$statements = [];

			foreach( $this->commands as $command ) {

				$method = 'compile'.ucfirst( $command->name );

				if( method_exists( $this->grammar, $method ) ){
					$sql = $this->grammar->$method( $command );
					if( $sql != null ){
						$statements = array_merge( $statements, ( array ) $sql );
					}

				}
			}

			return $statements;
		}

		
	}