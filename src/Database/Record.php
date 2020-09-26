<?php

namespace IgniteKit\WP\Migrations\Database;

class Record {


	/**
	 * Database connection
	 *
	 * @var \wpdb
	 */
	protected $connection;


	/**
	 * Query we're building
	 *
	 * @var Query
	 */
	protected $query;


	/**
	 * Create a new database schema manager
	 *
	 * @return  void
	 */
	public function __construct() {
		global $wpdb;
		$this->connection = $wpdb;
	}


	/**
	 * Sets the table
	 *
	 * @param string $table
	 *
	 * @return Record
	 */
	public function table( $table ) {
		$this->query = $this->createQuery( $table );

		return $this;
	}


	/**********************************************/
	/********  WRITE & DELETE
	 * /**********************************************/


	/**
	 * Insert a record
	 *
	 * @param $table
	 * @param $data
	 */
	public function insert( $table, $data ) {
		$query = $this->createQuery( $table );
		$query->insert( $data );

		$this->run( $query );
	}


	/**
	 * Update a record
	 *
	 * @param $table
	 * @param $id
	 * @param $data
	 */
	public function update( $table, $id, $data ) {
		$query = $this->createQuery( $table );
		$query->update( $id, $data );

		$this->run( $query );
	}


	/**
	 * Drop a record
	 *
	 * @param string $table
	 * @param int $id
	 *
	 * @return void
	 */
	public function delete( $table, $id ) {
		$query = $this->createQuery( $table );
		$query->delete( $id );

		$this->run( $query );
	}


	/**********************************************/
	/********  FIND
	 * /**********************************************/

	/**
	 * Find a table
	 *
	 * @param string $table
	 *
	 * @return Record
	 */
	public function find( $table ) {
		$this->query = $this->createQuery( $table );
		$this->query->find();

		return $this;
	}


	/**
	 * Add where clauses to a qu$this->query->find();ery
	 *
	 * @param array $data
	 *
	 * @return Record
	 */
	public function where( array $data ) {
		$this->query->where( $data );

		return $this;
	}


	/**
	 * Retrieve the first result
	 * @return mixed|null
	 */
	public function first() {
		$this->query->limit( 1 );
		$results = $this->results();

		if ( is_array($results) && count( $results ) > 0 ) {
			$results = array_values( $results );

			return $results[0];
		}

		return null;
	}


	/**
	 * Get the results
	 * @return array|null
	 */
	public function results() {
		$results = $this->query->results( $this->connection );

		if ( is_array($results) && count( $results ) > 0 ) {
			return $results;
		}

		return null;
	}


	/**
	 * Execute the query to run / modify the table.
	 *
	 * @param Query $query
	 */
	protected function run( Query $query ) {
		$query->run( $this->connection );
	}


	/**
	 * Create a new command set with a Closure
	 * @param $table
	 *
	 * @return Query
	 */
	protected function createQuery( $table ) {
		return new Query( $table );
	}

}