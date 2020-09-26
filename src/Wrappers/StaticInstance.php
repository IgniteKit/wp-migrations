<?php

    namespace IgniteKit\WP\Migrations\Wrappers;
    
    class StaticInstance {

	    /**
	     * @var StaticInstance
	     */
        public static $instance = null;


	    /**
	     * @return StaticInstance
	     */
        public static function getInstance(){
            
            return static::$instance = new static();

        }
    
    
    } 