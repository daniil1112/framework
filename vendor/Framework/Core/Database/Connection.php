<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 04.10.2019
 * Time: 19:47
 */

namespace Engine\Core\Database;
use PDO;
use Engine\Core\AbstractCore;
use Engine\Config\ConfigParse;
use Engine\Core\Config\ConfigClass;



class Connection extends AbstractCore
{

    private $link;


    /**
     * Connection constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->connect();
    }

    /**
     * @return $this
     */
    private function connect()
    {

        
        $this->config = ConfigClass::getConfig();

        $dsn = 'mysql:host='.$this->config['host']. ';dbname='.$this->config['db_name'] . ';charset='.$this->config['charset'];

        $this->link = new PDO($dsn, $this->config['username'], $this->config['password'], [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        return $this;
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function execute($sql)
    {
        $sht = $this->link->prepare($sql);
        return $sht->execute();
    }

    /**
     * @param $sql
     * @return array
     */
    public function query($sql)
    {
        $exe = $this->execute($sql);

        $result = $exe->fechAll(PDO::FETCH_ASSOC);

        if ($result ==='false')
        {
            return [];
        }
        return $result;
    }

    /**
     * Получение экземпляра базы PDO
     *
     * @return void
     */
    public function getLink()
    {
        return $this->link;
    }

}