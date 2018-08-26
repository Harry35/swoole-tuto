<?php

class AysMysql {

    /**
     * @var string
     */
    public $dbSource = "";

    public function __construct() {
        $this->dbSource = new Swoole\Mysql;

        $this->dbConfig = [
            'host' => '127.0.0.1',
            'port' => 5123,
            'user' => 'root',
            'password' => 123456,
            'database' => 'swoole',
            'charset' => 'utf8'
        ];
    }

    public function update()
    {

    }

    public function add()
    {

    }

    public function execute($id, $username)
    {
        $this->dbSource->connect($this->dbConfig, function($db, $result) {
            if ($result === false) {
                // var_dump($db->connect_error);
            }

            $sql = "select * from test where id = 1";
            //query (add select update delete)
            $db->query($sql, function($db, $result) {
                // select => result返回的是 查询的结果内容
                 
                if ($result === false) {
                    //todo
                } elseif ($result === true) {// add update delete
                    //todo
                } else {
                    var_dump($result);
                }
            });
        });
        
        return true;
    }
}

$obj = new AysMysql();
$obj->execute(1, 'singwa-11111');