<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DBUpdateController extends GroundController
{
    public function checkLaravelColumns()
    {
        $columns = [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $sql = '';

        $query = DB::select('show tables');

        foreach ($query as $k => $v) {
            foreach ($v as $k2 => $table) {
                $fields_array = [];
                $q2 = DB::select("SHOW COLUMNS FROM `" . $table . "`");
                foreach ($q2 as $k3 => $c) {
                    $fields_array[] = $c->Field;
                }
                foreach ($columns as $key => $column) {
                    if (!in_array($column, $fields_array)) {
                        $sql .= "ALTER TABLE `" . $table . "` ADD `" . $column . "` datetime DEFAULT NULL;\n";
                    }
                }
            }
        }
        $h = fopen(public_path('/') . 'missing_laravel_sql.sql', 'w+');
        fwrite($h, $sql);
        fclose($h);
        echo 'Fertig!';
        exit();
    }
}
