<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        php artisan db:seed --class=MetasTableSeeder
        $table_list = ['sites', 'users'];
        $schema = DB::getDoctrineSchemaManager();
        $tables = $schema->listTables();
        foreach ($tables as $table) {
            if(in_array($table->getName(), $table_list)){
                $model =  Str::singular(ucfirst($table->getName()));
                foreach ($table->getColumns() as $column) {
                    DB::table('metas')->insert([
                        'model' => $model,
                        'name' => $column->getName(),
                        'label' => str_replace("_", " ", Str:: ucfirst($column->getName())),
                        'type' => $column->getType()->getName(),
                    ]);
                }
            }
        }
    }
}
