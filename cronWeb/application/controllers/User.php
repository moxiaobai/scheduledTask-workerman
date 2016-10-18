<?php
/**
 * 用户管理
 *
 * @author: moxiaobai
 * @since : 2016/9/19 11:29
 */

class UserController extends Yaf_Controller_Abstract
{

    private $_model;
    private $_pageSize;

    function init()
    {
        $this->_model = new UserModel();

        $this->_pageSize = 20;
    }

    /**
     * 引导页
     */
    function indexAction($page=1)
    {
        $username   = isset($_GET['username']) ? Helper_Filter::format($_GET['username']) : '';
        $page   = intval($page);


        //分页参数，读取参数设置
        $where      = array('username'=>$username);
        $pagination = array('page'=>$page, 'pagesize'=>$this->_pageSize);

        //做分页
        $total    = $this->_model->countData($where);

        $page     = new Page(array('total'=>$total, 'perpage'=>$this->_pageSize, 'url'=>'/user/index/', 'nowindex'=>$page));
        $pageHtml = $page->show(4);

        //数据列表
        $data = $this->_model->getList( $where, $pagination );

        //模版赋值
        $this->getView()->assign(array(
            'username'  => $username,
            'data'      => $data,
            'pageHtml'  => $pageHtml
        ));
    }


    //表单页
    public function formAction($id=0) {
        $id = intval($id);

        $row = array();
        if($id > 0) {
            $row  = $this->_model->getInfo($id);
        }

        $this->getView()->assign(array(
            'id'        => isset($row['u_id']) ? $row['u_id'] : '',
            'username'  => isset($row['u_username']) ? $row['u_username'] : '',
            'realname'  => isset($row['u_realname']) ? $row['u_realname'] : '',
        ));
    }

    //修改密码表单页
    public function formPasswordAction($id=0) {
        $id = intval($id);
        $this->getView()->assign('id', $id);
    }

    //新增保存数据
    public function saveAction() {
        $id  = intval( $_POST['id'] );

        // 基本数据过滤
        $data  = $this->getRequest()->getPost();
        unset($data['id']);
        if($id > 0) {
            $result = $this->_model->saveData($data, $id);
        } else {
            $result = $this->_model->saveData($data);
        }

        if($result['code'] == 1) {
            Helper_Json::formJson('操作成功', 'y');
        } else {
            Helper_Json::formJson($result['data'], 'n');
        }

    }

    //更改状态
    public function statusAction($id, $status) {
        $id = intval($id);
        if( empty($id) ) {
            Helper_Json::formJson('缺失参数');
        }

        $status  = ($status == 1) ? 2: 1;
        $data     = array('u_status'=>$status);
        $result   = $this->_model->changeData($id,$data);
        if($result) {
            Helper_Json::formJson('操作成功', 'y');
        } else {
            Helper_Json::formJson('操作失败');
        }
    }

    //修改密码
    public function editPasswordAction() {
        $id       = intval( $_POST['id'] );
        $password = $_POST['password'];

        $this->_model->editPassword($id, $password);
        Helper_Json::formJson('修改成功', 'y');
    }
}