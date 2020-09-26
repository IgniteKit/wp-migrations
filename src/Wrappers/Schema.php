<?php

namespace IgniteKit\WP\Migrations\Wrappers;

/**
 * Class Schema
 * @package IgniteKit\WP\Migrations\Wrappers
 *
 * @method static create($table, $callback)
 * @method static hasTable($table)
 * @method static hasColumn($table, $column)
 * @method static drop($table)
 * @method static table($table)
 * @method static dropIfExists($table)
 * @method static rename($from, $to)
 */
class Schema extends Wrapper {

    /**
     * Return the igniter service key responsible for the Schema class.
     * The key must be the same as the one used in the assigned
     * igniter service.
     *
     * @return string
     */
    protected static function getFacadeAccessor(){
        return 'schema';
    }

}
