<?php




class User{

    
    public $id ,$login,$password,$name,$surname,$score,$type;

    public function __construct($param){
        $this->id = $param['id'];
        $this->login = $param['login'];
        $this->password =  $param['password'];
        $this->name = $param['name'];
        $this->surname = $param['surname'];
        $this->score = $param['score'];
        $this->type = $param['type'];

    }
    public function toQuery(){
        return "(NULL,'{$this->login}','{$this->password}','{$this->name}','{$this->surname}',0,0)";
    }
}