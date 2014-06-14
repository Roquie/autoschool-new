<?php defined('SYSPATH') OR die('No direct script access.');

class Database_MySQL extends Kohana_Database_MySQL
{
    public function create_backup()
    {
        $config = Kohana::$config->load('database.default.connection');
        $path = APPPATH.'backups/autoschool-'.date('d.m.Y_H:i').'.sql.gz';

        shell_exec(
            "mysqldump --user={$config['username']} --password={$config['password']} --host={$config['hostname']} {$config['database']} | gzip -cq9 > {$path}"
        );

        return $path;
    }
}
