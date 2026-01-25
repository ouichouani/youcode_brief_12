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
    public function getBody(){
        $path = $_SERVER['REQUEST_URI'] ; 
        $position = strpos($path, '?');
        if($position === false){
            return [];
        }else{
        // return explode('&' ,str_replace('=' ,'=>' , substr($path ,$postion+1))) ;
            $queryString = substr($path, $position + 1);
            parse_str($queryString, $result);
            return $result ;
        }        
    }

}