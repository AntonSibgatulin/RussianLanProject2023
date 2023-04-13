<?php



class WordModel{


    public  $id,$word,$answer,$type,$letter,$someWord,$fastanswer;


    public function __construct($request){
        
        $this->id = $request['id'];
        $this->word = $request['word'];
        $this->answer = $request['answer'];
        $this->type = intval($request['type']);
        $this->letter = $request['letter'];
        $this->someWord = $request['someWord'];
        $this->fastanswer = $request['fastanswer'];

    }


    public function toArray(){
        $param = array();
        $param['word'] = $this->word;
        $param['answer'] = $this->answer;
        $param['type'] = $this->type;
        $param['letter'] = $this->letter;
        $param['someWord'] = $this->someWord;
        $param['fastanswer'] = $this->fastanswer;
        return $param;
    }
 
    public function toQuery(){

        return "(NULL,'{$this->word}','{$this->answer}',{$this->type},'{$this->letter}','{$this->someWord}','{$this->fastanswer}')";
    }


}