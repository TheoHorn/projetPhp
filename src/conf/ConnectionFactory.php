<?php


namespace mywishlist\modele;
use PDO;

class ConnectionFactory
{

    private static $config;
    private static $db;


    /**
     * @throws \Exception
     */
    static function setConfig($file)
    {
        self::$config = parse_ini_file($file);
        if (is_null(self::$config)) throw new \Exception('config not found');
    }

    static function makeConnection(): PDO
    {
        if (is_null(self::$db)) {
            $dns = 'mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['database'];
            self::$db = new PDO($dns, self::$config['user'], self::$config['password'], array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false));
            self::$db->prepare('SET NAMES \'UTF8\'')->execute();
            $st = self::$db->prepare("Select * from item");
        }
        return self::$db;
    }
}