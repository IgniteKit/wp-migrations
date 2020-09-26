# WP Migrations

#### Migrations for WordPress inspired by Laravel.

The package can be used in different plugins in the same time if you create your own `BaseMigration` in each plugin. 

Follow the steps before to properly setup the package.

## Instructions


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