<?php

class FeedbackAction extends Action {

    public function index() {
        $this->display();
    }

    public function save() {
        if (!IS_POST) {
            $this->ajaxReturn(array('success' => false, 'message' => '请求方式错误'));
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || empty($data['title']) || empty($data['description'])) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少必填信息'));
        }

        $feedback = array(
            'category' => $data['category'] ?: '',
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?: 'medium',
            'contact' => $data['contact'] ?: '',
            'votes' => 0,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        );

        $result = M('Feedback')->add($feedback);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '需求已提交', 'id' => $result));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '提交失败'));
        }
    }

    public function list() {
        $page = intval($_GET['page']) ?: 1;
        $limit = intval($_GET['limit']) ?: 20;
        $offset = ($page - 1) * $limit;
        $category = $_GET['category'] ?: '';
        $status = $_GET['status'] ?: '';

        $map = array();
        if ($category) {
            $map['category'] = $category;
        }
        if ($status) {
            $map['status'] = $status;
        }

        $count = M('Feedback')->where($map)->count();
        $list = M('Feedback')->where($map)->order('votes DESC, created_at DESC')->limit($offset, $limit)->select();

        $this->ajaxReturn(array(
            'success' => true,
            'data' => $list,
            'total' => $count,
            'page' => $page,
            'limit' => $limit
        ));
    }

    public function vote() {
        if (!IS_POST) {
            $this->ajaxReturn(array('success' => false, 'message' => '请求方式错误'));
        }

        $id = intval($_POST['id']);
        if (!$id) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少ID'));
        }

        $result = M('Feedback')->where(array('id' => $id))->setInc('votes', 1);
        
        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '投票成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '投票失败'));
        }
    }

    public function updateStatus() {
        if (!IS_POST) {
            $this->ajaxReturn(array('success' => false, 'message' => '请求方式错误'));
        }

        $id = intval($_POST['id']);
        $status = $_POST['status'];
        
        if (!$id || !$status) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少参数'));
        }

        $result = M('Feedback')->where(array('id' => $id))->save(array('status' => $status));
        
        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '状态更新成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '更新失败'));
        }
    }

    public function delete() {
        $id = intval($_POST['id']);
        if (!$id) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少ID'));
        }

        $result = M('Feedback')->delete($id);
        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '删除成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '删除失败'));
        }
    }
}