<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/23
 * Time: 16:44
 */
require_once'D:/wamp/wamp/www/votesystem/application/controllers/DbController.php';

class AdminController extends DbController
{
    public function indexAction()
    {

    }

    public function additemAction()
    {
        //跳转到增加物品页面
    }

    //执行添加物品
    public function addAction()
    {
        //获取提交表单的内容
        $name = $this->getRequest()->getParam('name');
        $description = $this->getRequest()->getParam('description');
        $vote_count = $this->getRequest()->getParam('vote_count');

        $data = array
        (
            'name' => $name,
            'description' => $description,
            'vote_count' => $vote_count
        );

        //创建item表模型对象
        $itemModel = new Application_Model_Item();
        if($itemModel->insert($data)>0)
        {
            $this->view->info = '新增选项成功';
            $this->_forward('ok','global');
        }
        else
        {
            $this->view->info = '新增选项失败';
            $this->_forward('error','global');
        }


    }

    public function addfilteripAction()
    {
        //跳转增加过滤ip页面
    }

    //执行添加过滤ip
    public function addipAction()
    {
        $ip = $this->getRequest()->getParam('addip');//获取从表单提交过来的ip
        $filterModle = new Application_Model_Filter();
        $data = array('ip'=>$ip);
        if($filterModle->insert($data)>0)
        {
            $this->view->info = '新增过滤ip成功！';
            $this->_forward('ok','global');
        }
        else
        {
            $this->_forward('error','global');
        }
    }
}