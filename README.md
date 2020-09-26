# WP Migrations

#### Migrations for WordPress inspired by Laravel.

The package can be used in different plugins in the same time if you create your own `BaseMigration` in each plugin. 

Follow the steps before to properly setup the package.

### Instructions


1.) Create base class called `BaseMigration`

```php
namespace MyPlugin\Database\Migrations;

use IgniteKit\WP\Migrations\Engine\Migration;
use IgniteKit\WP\Migrations\Contracts\Migration as MigrationContract;

class BaseMigration extends Migration implements MigrationContract {

    /**
     * Specify custom migrations table
     * @var string
     */
    protected $migrationsTableName = 'your_migrations_table';

}
```

2.) Create migrations table setup migration. eg `SetupMigrations`


```php
namespace MyPlugin\Database\Migrations;

use IgniteKit\WP\Migrations\Engine\Setup;

class CreateMigrationsTable extends BaseMigration {
	use Setup;
}
```

3.) You can now create your own custom migrations. In this case create the `fruits` table.

```php
namespace MyPlugin\Database\Migrations;

use IgniteKit\WP\Migrations\Database\Blueprint;
use IgniteKit\WP\Migrations\Wrappers\Schema;

class CreateFruitsTable extends BaseMigration {

	/**
	 * Put the table up
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'fruits', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( 'name' );
		} );
	}

	/**
	 * Default down function
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop( 'fruits' );
	}

}
```

4.) Finally, register those migrations

```php

/**
 * Registers the plugin migrations
 * @return void
 */
function my_plugin_register_migrations() {
    
    // Boot the CLI interface
    if(!class_exists('\IgniteKit\WP\Migrations\CLI\Boot')) {
        return;
    }
    \IgniteKit\WP\Migrations\CLI\Boot::start();
    
    // Register the migrations table migration
    CreateMigrationsTable::register();

    // Register the other migrations
    // NOTE: The squence is important!
    CreateFruitsTable::register();
    // ... other

}
add_action('plugins_loaded', 'my_plugin_register_migrations');
```

### Creating columns

You can create a lot of different column types with Table Migrations. Here's a list:

| Command | Description |
|---------|-------------|
| $table->bigInteger('votes'); | BIGINT equivalent for the database. |
| $table->binary('data');  | BLOB equivalent for the database. |
| $table->boolean('confirmed'); | BOOLEAN equivalent for the database. |
| $table->char('name', 4); | CHAR equivalent with a length. |
| $table->date('created_at'); | DATE equivalent for the database. |
| $table->dateTime('created_at'); | DATETIME equivalent for the database. |
| $table->decimal('amount', 5, 2); | DECIMAL equivalent with a precision and scale. |
| $table->double('column', 15, 8); | DOUBLE equivalent with precision, 15 digits in total and 8 after the decimal point. |
| $table->float('amount', 8, 2); | FLOAT equivalent for the database, 8 digits in total and 2 after the decimal point. |
| $table->increments('id'); | Incrementing ID (primary key) using a "UNSIGNED INTEGER" equivalent. |
| $table->bigIncrements('id'); | Incrementing ID (primary key) using a "UNSIGNED BIGINT" equivalent. |
| $table->smallIncrements('id'); | Incrementing ID (primary key) using a "UNSIGNED SMALLINT" equivalent. |
| $table->mediumIncrements('id'); | Incrementing ID (primary key) using a "UNSIGNED MEDIUMINT" equivalent. |
| $table->integer('votes'); | INTEGER equivalent for the database. |
| $table->longText('description'); | LONGTEXT equivalent for the database. |
| $table->mediumInteger('numbers'); | MEDIUMINT equivalent for the database. |
| $table->mediumText('description'); | MEDIUMTEXT equivalent for the database. |
| $table->smallInteger('votes'); | SMALLINT equivalent for the database. |
| $table->string('email'); | VARCHAR equivalent column. |
| $table->string('name', 100); | VARCHAR equivalent with a length. |
| $table->text('description'); | TEXT equivalent for the database. |
| $table->time('sunrise'); | TIME equivalent for the database. |
| $table->tinyInteger('numbers'); | TINYINT equivalent for the database. |
| $table->timestamp('added_on'); | TIMESTAMP equivalent for the database. |

---

### Contributions

If you are interested in contributing to the project. Feel free to submit your issue or pull request.


### License

```
Copyright (C) 2020 Darko Gjorgjijoski (https://darkog.com)

This file is part of wp-migrations

WP Migrations is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

WP Migrations  is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Migrations. If not, see <https://www.gnu.org/licenses/>.
```