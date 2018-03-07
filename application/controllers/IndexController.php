<?php
require_once'D:/wamp/wamp/www/votesystem/application/controllers/DbController.php';

class IndexController extends DbController
{
    public function indexAction()
    {
        // 展示投票页面
        $itemModel = new Application_Model_Item();
        $items = $itemModel->fetchAll()->toArray();
        $this->view->items = $items;
        $this->render('index');
    }

}

