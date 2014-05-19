<?php
use PhpOffice\PhpWord\Exceptions\Exception;

defined('SYSPATH') OR die('No direct script access.');

class Database_Query extends Kohana_Database_Query
{

    /**
     * Execute the current query on the given database.
     *
     * @param   mixed    $db  Database instance or name of instance
     * @param   string   result object classname, TRUE for stdClass or FALSE for array
     * @param   array    result object constructor arguments
     * @return  object   Database_Result for SELECT queries
     * @return  mixed    the insert id for INSERT queries
     * @return  integer  number of affected rows for all other queries
     */
    public function execute($db = NULL, $as_object = NULL, $object_params = NULL)
    {
        if ( ! is_object($db))
        {
            // Get the database instance
            $db = Database::instance($db);
        }

        if ($as_object === NULL)
        {
            $as_object = $this->_as_object;
        }

        if ($object_params === NULL)
        {
            $object_params = $this->_object_params;
        }

        // Compile the SQL query
        $sql = $this->compile($db);

        if ($this->_lifetime !== NULL AND $this->_type === Database::SELECT)
        {
            // Set the cache key based on the database instance name and SQL
            $cache_key = 'Database::query("'.$db.'", "'.$sql.'")';

            // Read the cache first to delete a possible hit with lifetime <= 0
            if (($result = Kohana::cache($cache_key, NULL, $this->_lifetime)) !== NULL
                AND ! $this->_force_execute)
            {
                // Return a cached result
                return new Database_Result_Cached($result, $sql, $as_object, $object_params);
            }
        }

        // Execute the query
        $result = $db->query($this->_type, $sql, $as_object, $object_params);

        if (isset($cache_key) AND $this->_lifetime > 0)
        {
            // Cache the result array
            Kohana::cache($cache_key, $result->as_array(), $this->_lifetime);
        }

        if ($this->_type === Database::INSERT || $this->_type === Database::UPDATE || $this->_type === Database::DELETE)
        {
            if (Kohana::$config->load('settings.sync'))
            {
                try
                {
                    switch($this->_type)
                    {
                        case Database::UPDATE:
                            preg_match('/UPDATE `(.*?)` SET /i', $sql, $result);
                        break;

                        case Database::INSERT:
                            preg_match('/INSERT INTO `(.*?)` VALUES /i', $sql, $result);
                        break;

                        case Database::DELETE:
                            preg_match('/DELETE FROM `(.*?)` WHERE /i', $sql, $result);
                        break;
                    }
                }
                catch(Exception $e)
                {
                    Log::instance()->add(Log::CRITICAL, 'API REGEPX ERROR - '.$e->getMessage());
                }

                list($table) = array_slice($result, 1);

                $obj = new Sync($this->_type, $sql, $table, mysql_insert_id());
                $obj->send();
            }


        }

        return $result;
    }
}
