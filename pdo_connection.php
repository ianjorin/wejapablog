<?php

require_once "config/constants.php";
date_default_timezone_set("Africa/Lagos");




final class ConnectionManagerPDO
{

    private $dsn;
    private $username;
    private $passwd;
    private $options;
    private $db;
    private $shouldReconnect;

    const RETRY_ATTEMPTS = 3;

    public function __construct($dsn, $username, $passwd, $options = array())
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->passwd = $passwd;
        $this->options = $options;
        $this->shouldReconnect = true;
        try {
            $this->connect();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param $method 
     * @param $args
     * @return mixed
     * @throws Exception
     * @throws PDOException
     */
    public function __call($method, $args)
    {
        $has_gone_away = false;
        $retry_attempt = 0;
        try_again:
        try {

            if (is_callable(array($this->db, $method))) {

                return call_user_func_array(array($this->db, $method), $args);
            } else {

                trigger_error("Call to undefined method '{$method}'");
                /*
                 * or
                 *
                 * throw new Exception("Call to undefined method.");
                 *
                 */
            }
        } catch (\PDOException $e) {

            $exception_message = $e->getMessage();

            if (
                ($this->shouldReconnect)
                && strpos($exception_message, 'server has gone away') !== false
                && $retry_attempt <= self::RETRY_ATTEMPTS
            ) {
                $has_gone_away = true;
            } else {
                /*
                 * What are you going to do with it... Throw it back.. FIRE IN THE HOLE
                 */
                throw $e;
            }
        }

        if ($has_gone_away) {
            $retry_attempt++;
            $this->reconnect();
            goto try_again;
        }
    }


    /**
     * Connects to DB
     */
    private function connect()
    {
        $this->db = new PDO($this->dsn, $this->username, $this->passwd, $this->options);
        /*
         * I am manually setting to catch error as exception so that the connection lost can be handled.
         */
        $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

    /**
     * Reconnects to DB
     */
    private function reconnect()
    {
        $this->db = null;
        $this->connect();
    }
}





try{
$database = new ConnectionManagerPDO("mysql:host=" . DB_SERVER . ";dbname=" .DB_NAME . "",'' . DB_USER . '','' .DB_PASS . '');

//$database = new PDO("mysql:host=DB_SERVER;dbname=compsci",'DB_USER','DB_PASS');
} 

catch(PDOException $e)
{
    echo $e->getMessage();    
}


$database->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$database->setAttribute(PDO::ATTR_TIMEOUT,30000000);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
































/*
try{
$database = new PDO("mysql:host=" . DB_SERVER . ";dbname=" .DB_NAME . "",'' . DB_USER . '','' .DB_PASS . '');

//$database = new PDO("mysql:host=DB_SERVER;dbname=compsci",'DB_USER','DB_PASS');
} catch(PDOException $e)
{
echo $e->getMessage();
	}



$database->setAttribute(PDO::ATTR_TIMEOUT,30000000);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

*/





 ?>