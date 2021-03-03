<?php

namespace App\Ship\Core\Abstracts\Seeders;

use Eloquent;
use Illuminate\Database\Seeder as LaravelSeeder;
use Illuminate\Support\Facades\DB;

/**
 * Class Seeder.
 */
abstract class Seeder extends LaravelSeeder
{
    public function autoIncrementCleanup(string $tableName): void
    {
        if (in_array(config('database.default'), ['mysql'])) {
            DB::statement("SET @count = 0;");
            DB::statement("UPDATE `$tableName` SET `$tableName`.`id` = @count:= @count + 1;");
            DB::statement("ALTER TABLE `$tableName` AUTO_INCREMENT = 1;");
        }
    }

    /**
     * Run the database seeds without Foreign key constraint
     *
     * @param string $className
     *
     * @return void
     */
    public function unGuardDisableForeignKeyTesting(string $className): void
    {
        Eloquent::unguard();

        /** Disable Foreign key check for this connection before running seeders */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call($className);

        /**
         * FOREIGN_KEY_CHECKS is supposed to only apply to a single
         * connection and reset itself but I like to explicitly
         * undo what I've done for clarity
         */
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
