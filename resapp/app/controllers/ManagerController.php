<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class ManagerController extends Controller
{
    public function indexAction()
    {
        // default action
    }
    public function editmenuAction()
    {
        $collection = $this->mongo->food;
        $datanew =  $collection->findOne(['fid' => $_GET['id']]);
        $this->view->data = $datanew;
    }
    public function updatemenuAction()
    {

        $collection = $this->mongo->food;
        $payload = [
            "rid" =>  $_POST['rid'],
            "fid" =>  $_POST['fid'],
            "fname" =>  $_POST['fname'],
            "type" => $_POST['type'],
            "img" =>  $_POST['img'],
            "ratings" =>  $_POST['ratings'],
        ];
        $data = $collection->updateOne(
            ['fid' => $_POST['fid']],
            [
                '$set' => $payload,
            ],
            [
                'upsert' => true
            ]
        );
        $this->response->redirect("manager");
    }
    public function deletemenuAction()
    {
        $collection = $this->mongo->food;
        $data = $collection->deleteOne(['fid' => $_GET['id']]);
        $this->response->redirect("manager");
    }
    public function adminblogAction()
    {
        // action
    }
    public function addmenuAction()
    {
        
        if ($this->request->isPost()) {

            $rid = $this->request->getPost('rid');
            $fid = $this->request->getPost('fid');
            $fname = $this->request->getPost('fname');
            $type = $this->request->getPost("type");
            $fprice = $this->request->getPost("fprice");
            $img = $this->request->getPost('img');
            $ratings = $this->request->getPost('ratings');

            $collection = $this->mongo->food;
            $data = $collection->insertOne([
                "rid" => $rid,
                "fid" => $fid,
                "fname" => $fname,
                "type" => $type,
                "fprice" => $fprice,
                "img" => $img,
                "ratings" => $ratings,
            ]);
            if ($data->getInsertedCount() == 1) {

                $this->response->redirect("/manager");
            }
            else {
                echo "INvalid details";die;
            }
        }
    }
}
