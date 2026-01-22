<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class postController extends Controller{

    public function addPost(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $content=$_POST['content'];
            $post = Post::addPost($content);
            $this->redirect('/posts'); 
        }  
    }

    public function getAll(){
        $getPost = Post::getAll($content);
        $this->view('post/AllPost', ['post' => $post]);
    }

}
