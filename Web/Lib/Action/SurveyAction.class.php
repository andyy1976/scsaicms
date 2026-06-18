<?php

class SurveyAction extends Action {

    public function index() {
        $this->display();
    }

    public function save() {
        if (!IS_POST) {
            $this->ajaxReturn(array('success' => false, 'message' => '请求方式错误'));
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少数据'));
        }

        $survey = array(
            'industry' => $data['industry'] ?: '',
            'size' => $data['size'] ?: '',
            'hours' => isset($data['hours']) ? json_encode($data['hours']) : '',
            'responsible' => $data['responsible'] ?: '',
            'bottleneck' => $data['bottleneck'] ?: '',
            'painpoints' => isset($data['painpoints']) ? json_encode($data['painpoints']) : '',
            'painpoint_other' => $data['painpointOther'] ?: '',
            'ai_exp' => $data['aiExp'] ?: '',
            'payment' => $data['payment'] ?: '',
            'contact_name' => $data['contactName'] ?: '',
            'contact_company' => $data['contactCompany'] ?: '',
            'contact_wechat' => $data['contactWechat'] ?: '',
            'total_hours' => floatval($data['totalHours']) ?: 0,
            'score' => intval($data['score']) ?: 0,
            'created_at' => date('Y-m-d H:i:s')
        );

        $result = M('Survey')->add($survey);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '问卷已保存', 'id' => $result));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '保存失败'));
        }
    }

    public function list() {
        $page = intval($_GET['page']) ?: 1;
        $limit = intval($_GET['limit']) ?: 20;
        $offset = ($page - 1) * $limit;

        $count = M('Survey')->count();
        $list = M('Survey')->order('created_at DESC')->limit($offset, $limit)->select();

        $this->ajaxReturn(array(
            'success' => true,
            'data' => $list,
            'total' => $count,
            'page' => $page,
            'limit' => $limit
        ));
    }

    public function delete() {
        $id = intval($_POST['id']);
        if (!$id) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少ID'));
        }

        $result = M('Survey')->delete($id);
        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '删除成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '删除失败'));
        }
    }
}