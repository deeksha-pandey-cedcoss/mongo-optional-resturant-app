<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
      
        $this->response->redirect("index/home");
    }
    public function homeAction()
    {

        $collection = $this->mongo->resturant;
        $data = $collection->find();
        $this->view->result = $data;
    }
    public function fulldetailAction()
    {
        $collection = $this->mongo->resturant;
        $data = $collection->findOne(['rid' => $_GET['id']]);
        $this->view->result = $data;
    }
    public function searchAction()
    {
        $collection = $this->mongo->resturant;
        $data = $collection->find(['cuisine' => $_POST['search']]);
        $this->view->result = $data;

    }
    public function reviewAction()
    {
        // action for preview
    }
    public function previewAction()
    {
        $collectiond = $this->mongo->Users;
        $name=$collectiond->findOne(['uid' => $_COOKIE['login']]);
        $collection = $this->mongo->review;
        $data = $collection->insertOne(["uid"=>$_COOKIE['login'] ,
        "name" => $name->name,
             "review" => $_POST['review']]);
        
             $this->response->redirect("index/home");
    }
}
