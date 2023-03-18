<?php

class database
{
    private $dbname;
    private $dbUser;
    private $dbPass;
    protected $pdo;
    private $options;
    public function __construct($dbname,$dbUser,$dbPass)
    {
        $this->dbname=$dbname;
        $this->dbUser=$dbUser;
        $this->dbPass=$dbPass;
        $this->options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING);
        $this->pdo = new PDO('mysql:host=localhost;dbname='.$this->dbname,$this->dbUser,$this->dbPass,$this->options);
    }
}
class do_select extends database
{
    function do($sql,$value=[])
    {
        $result = $this->pdo->prepare($sql);
        foreach($value as $key=>$item){
            $result->bindValue($key + 1,$item);
        }
        $result->execute();
    }
    function select($sql,$value=[],$fetch='')
    {
        $result = $this->pdo->prepare($sql);
        foreach($value as $key=> $item){
            $result->bindValue($key+1,$item);
        }
        $result->execute();
        if($result->rowCount() >= 1){
            if($fetch==''){
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }else{
                $data = $result->fetch(PDO::FETCH_ASSOC);
                return $data;
            }
        }
    }
}
?>