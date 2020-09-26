<?php

namespace IgniteKit\WP\Migrations\Wrappers;

/**
 * Class Record
 * @package IgniteKit\WP\Migrations\Wrappers
 *
 * @method static table($table)
 * @method static insert($table, $data)
 * @method static update($table, $id, $data)
 * @method static delete($table, $id)
 * @method static find($table)
 * @method static where($data)
 * @method static first()
 * @method static results()
 */
class Record extends Wrapper {

    /**
     * Return the igniter service key responsible for the Record class.
     * The key must be the same as the one used in the assigned
     * igniter service.
     *
     * @return string
     */
    protected static function getFacadeAccessor(){
        return 'record';
    }

}
