<?php

class DiagnosisAction extends Action {

    public function index() {
        $this->display();
    }

    public function save() {
        if (!IS_POST) {
            $this->ajaxReturn(array('success' => false, 'message' => '请求方式错误'));
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || empty($data['contactName']) || empty($data['contactPhone'])) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少必填信息'));
        }

        $diagnosis = array(
            'company_name' => $data['companyName'] ?: '',
            'industry' => $data['industry'] ?: '',
            'contact_name' => $data['contactName'],
            'contact_phone' => $data['contactPhone'],
            'team_size' => $data['teamSize'] ?: '',
            'remark' => $data['remark'] ?: '',
            'tasks' => isset($data['tasks']) ? json_encode($data['tasks']) : '',
            'painpoints' => isset($data['painpoints']) ? json_encode($data['painpoints']) : '',
            'created_at' => date('Y-m-d H:i:s')
        );

        $result = M('Diagnosis')->add($diagnosis);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '诊断报告已保存', 'id' => $result));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '保存失败'));
        }
    }

    public function list() {
        $page = intval($_GET['page']) ?: 1;
        $limit = intval($_GET['limit']) ?: 20;
        $offset = ($page - 1) * $limit;

        $count = M('Diagnosis')->count();
        $list = M('Diagnosis')->order('created_at DESC')->limit($offset, $limit)->select();

        $this->ajaxReturn(array(
            'success' => true,
            'data' => $list,
            'total' => $count,
            'page' => $page,
            'limit' => $limit
        ));
    }

    public function detail() {
        $id = intval($_GET['id']);
        if (!$id) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少ID'));
        }

        $detail = M('Diagnosis')->find($id);
        if ($detail) {
            $detail['tasks'] = json_decode($detail['tasks'], true);
            $detail['painpoints'] = json_decode($detail['painpoints'], true);
            $this->ajaxReturn(array('success' => true, 'data' => $detail));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '记录不存在'));
        }
    }

    public function delete() {
        $id = intval($_POST['id']);
        if (!$id) {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少ID'));
        }

        $result = M('Diagnosis')->delete($id);
        if ($result) {
            $this->ajaxReturn(array('success' => true, 'message' => '删除成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'message' => '删除失败'));
        }
    }
}