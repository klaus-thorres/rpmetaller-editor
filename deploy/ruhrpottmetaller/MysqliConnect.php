<?php


namespace ruhrpottmetaller;

use Exception;
use mysqli;

class MysqliConnect
{
    private string $db_config_file = 'includes/db_preferences.inc.php';
    private mysqli|null $mysqli= null;

    private function initMysqli(): mysqli
    {
        $db_host = 'localhost';
        $db_user = '';
        $db_user_password = '';
        $db = '';
        require $this->db_config_file;
        try {
            return new mysqli(hostname: $db_host, username: $db_user, password: $db_user_password, database: $db);
        } catch (Exception) {
            throw new Exception('Database connection could not be established.');
        }
    }

    public function getMysqli(): mysqli
    {
        if(is_null($this->mysqli)) {
            $this->mysqli = $this->initMysqli();
        }
        return $this->mysqli;
    }

}