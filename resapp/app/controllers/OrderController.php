<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        //   default
    }
    public function placeorderAction()
    {
        if (isset($_COOKIE['login'])) {

            $collection = $this->mongo->food;
            $data = $collection->findOne(['fid' => $_GET['fid']]);

            $collectionne = $this->mongo->resturant;
            $datarnmae = $collectionne->findOne(['rid' => $data->rid]);

            $collectionnew = $this->mongo->Users;
            $data1 = $collectionnew->findOne(['uid' => $_COOKIE['login']]);

            $collectionn = $this->mongo->order;
            $datanew = $collectionn->insertOne([
                "rid" =>  $data->rid,
                "fid" =>   $data->fid,
                "rname" => $datarnmae->rname,
                "cname" => $data1->name,
                "caddress" =>  "Indira Nagar",
                "price" =>  $data->fprice,
                "cid" => $_COOKIE['login'],
                "status" =>  "placed",
                "img" => $data->img,
            ]);
            if ($datanew->getInsertedCount() == 1) {

                $this->response->redirect("/index/home");
            } else {
                echo "INvalid details";
                die;
            }
        } else {
            $this->response->redirect("/login/");
        }
    }
    public function vieworderAction()
    {
        $collection = $this->mongo->order;
        $data = $collection->find();
        $this->view->data = $data;

    }
}
