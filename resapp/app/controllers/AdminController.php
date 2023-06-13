<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        // default action
    }
    public function editrestrauntAction()
    {
        $collection = $this->mongo->resturant;
        $datanew =  $collection->findOne(['rid' => $_GET['id']]);
        $this->view->data = $datanew;
    }
    public function updateresturantAction()
    {

        $collection = $this->mongo->resturant;
        $payload = [
            "rid" =>  $_POST['rid'],
            "rname" =>  $_POST['rname'],
            "cuisine" => $_POST['cuisine'],
            "raddress" =>  $_POST['raddress'],
            "rmanager" =>  $_POST['rmanager'],
            "ratings" =>  $_POST['ratings'],
            "img" =>$_POST['img'],
        ];
        $data = $collection->updateOne(
            ['rid' => $_POST['rid']],
            [
                '$set' => $payload,
            ],
            [
                'upsert' => true
            ]
        );
        $this->response->redirect("admin/adminblog");
    }
    public function deleterestrauntAction()
    {
        $collection = $this->mongo->resturant;
        $data = $collection->deleteOne(['rid' => $_GET['id']]);
        $this->response->redirect("admin/adminblog");
    }
    public function adminblogAction()
    {
        // action
    }
    public function addresturantAction()
    {
        if ($this->request->isPost()) {

            $rid = $this->request->getPost('rid');
            $rname = $this->request->getPost('rname');
            $cuisine = $this->request->getPost("cuisine");
            $raddress = $this->request->getPost("raddress");
            $rmanager = $this->request->getPost('rmanager');
            $img =  $this->request->getPost('img');
            $ratings = $this->request->getPost('ratings');

            $collection = $this->mongo->resturant;
            $data = $collection->insertOne([
                "rid" => $rid,
                "rname" => $rname,
                "cuisine" => $cuisine,
                "raddress" => $raddress,
                "rmanager" => $rmanager,
                "img" => $img,
                "ratings" => $ratings,
            ]);
            if ($data->getInsertedCount() == 1) {

                $this->response->redirect("/admin/adminblog");
            }
            else {
                echo "INvalid details";die;
            }
        }
    }
}
