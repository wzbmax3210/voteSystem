<?php
/**
创建数据库连接控制器
 */
class DbController extends Zend_Controller_Action
{
    public function init()
    {
        $url = 'D:/wamp/wamp/www/votesystem/application/configs/application.ini';
        $dbconfig = new Zend_Config_Ini($url,'mysql');
        $db = Zend_Db::factory($dbconfig->db);
        $db->query('SET NAMES UTF8');
        Zend_Db_Table::setDefaultAdapter($db);
    }
}