<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/24
 * Time: 9:11
 */
require_once'D:/wamp/wamp/www/votesystem/application/controllers/DbController.php';

class VoteController extends DbController
{
    public function indexAction()
    {

    }

    public function voteAction()
    {
        $item_id = $this->getRequest()->getParam('itemid');//获取投票选项的id
        $ip = $this->getRequest()->getServer('REMOTE_ADDR');//获取投票人的ip

        $today = date('Ymd');
        //获得投票日志数据模型
        $voteLogModel = new Application_Model_VoteLog();
        $where = "ip='$ip' AND vote_date=$today";
        $result = $voteLogModel->fetchAll($where)->toArray();//查询ip是否在当天被投过

        $filterModel = new Application_Model_Filter();
        $filterwhere = "ip='$ip'";
        $filterres = $filterModel->fetchAll($filterwhere)->toArray();

        if(count($result)>0)
        {
            //跳转已投过票提示页面
            $this->view->info = '您今日已经投过票了';
            $this->_forward('error','global');
        }
        elseif(count($filterres)>0)
        {
            $this->view->info = '您的IP被禁止投票';
            $this->_forward('error','global');
        }
        else
        {
            //将投票者信息写入投票日志
            $data = array(
                'ip'=>$ip,
                'vote_date'=>$today,
                'item_id'=>$item_id
            );
            if($voteLogModel->insert($data)>0)
            {
                $itemModel = new Application_Model_Item();
                $item = $itemModel->find($item_id)->toArray();
                $newvotecount = $item[0]['vote_count']+1 ;//将vote_count加1
                $set = array('vote_count'=>$newvotecount);
                $where = "id=$item_id";
                $itemModel->update($set,$where);
            }
            //跳转到跳票成功页面
            $this->view->info = '投票成功';
            $this->_forward('ok','global');

        }

    }
}