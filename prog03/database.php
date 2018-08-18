<?php
<<<<<<< HEAD
=======
//connect to database
>>>>>>> 8061ab387aa428a750f4988c147f34954b95d383
class Database
{
    private static $dbName = 'adseitz' ;
    private static $dbHost = 'localhost' ;
<<<<<<< HEAD
    private static $dbUsername = 'adseitz';
    private static $dbUserPassword = '612586';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

=======
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';
    private static $cont  = null;
    public function __construct() {
        die('Init function is not allowed');
    }
>>>>>>> 8061ab387aa428a750f4988c147f34954b95d383
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
        }
        catch(PDOException $e)
        {
          die($e->getMessage());
        }
       }
       return self::$cont;
    }
<<<<<<< HEAD

=======
>>>>>>> 8061ab387aa428a750f4988c147f34954b95d383
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>