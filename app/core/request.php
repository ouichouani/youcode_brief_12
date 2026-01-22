<?php


namespace App\Core;

class Request {

    public function getMethod(){

        return $_SERVER['REQUEST_METHOD'] ;
        
    }

    public function getPath(){

        $path = $_SERVER['REQUEST_URI'] ; 
        $postion = strpos($path, '?');

        if($postion === false){
            return $path ;
        }else{
            return substr($path ,0 ,$postion) ;
        }

    }


}