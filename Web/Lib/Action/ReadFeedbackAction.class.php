<?php

class ReadFeedbackAction extends Action {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = M('read_feedback');
    }

    public function index() {
        $this->display();
    }

    /**
     * 追踪阅读行为
     */
    public function track() {
        $aid = I('aid', 0, 'intval');
        $action = I('action', 'read');
        $duration = I('duration', 0, 'intval');
        $scrollDepth = I('scrollDepth', 0, 'intval');
        $device = I('device', 'desktop');
        $referrer = I('referrer', '');

        if (!$aid) {
            $this->ajaxReturn(array('success' => false, 'msg' => '缺少文章ID'));
        }

        $data = array(
            'article_id' => $aid,
            'user_id' => cookie('user_id') ?: 0,
            'action' => $action,
            'duration' => $duration,
            'scroll_depth' => $scrollDepth,
            'device' => $device,
            'referrer' => $referrer,
            'addtime' => time()
        );

        $result = $this->db->add($data);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'msg' => '追踪成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'msg' => '追踪失败'));
        }
    }

    /**
     * 点赞
     */
    public function like() {
        $aid = I('aid', 0, 'intval');

        if (!$aid) {
            $this->ajaxReturn(array('success' => false, 'msg' => '缺少文章ID'));
        }

        // 检查是否已经点赞
        $exists = $this->db->where(array(
            'article_id' => $aid,
            'user_id' => cookie('user_id') ?: 0,
            'action' => 'like'
        ))->find();

        if ($exists) {
            $this->ajaxReturn(array('success' => true, 'msg' => '已点赞'));
        }

        $data = array(
            'article_id' => $aid,
            'user_id' => cookie('user_id') ?: 0,
            'action' => 'like',
            'addtime' => time()
        );

        $result = $this->db->add($data);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'msg' => '点赞成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'msg' => '点赞失败'));
        }
    }

    /**
     * 分享
     */
    public function share() {
        $aid = I('aid', 0, 'intval');

        if (!$aid) {
            $this->ajaxReturn(array('success' => false, 'msg' => '缺少文章ID'));
        }

        $data = array(
            'article_id' => $aid,
            'user_id' => cookie('user_id') ?: 0,
            'action' => 'share',
            'addtime' => time()
        );

        $result = $this->db->add($data);

        if ($result) {
            $this->ajaxReturn(array('success' => true, 'msg' => '分享成功'));
        } else {
            $this->ajaxReturn(array('success' => false, 'msg' => '分享失败'));
        }
    }

    /**
     * 统计报告
     */
    public function statsReport() {
        $startDate = I('startDate', date('Y-m-d', strtotime('-7 days')));
        $endDate = I('endDate', date('Y-m-d'));

        $startTime = strtotime($startDate . ' 00:00:00');
        $endTime = strtotime($endDate . ' 23:59:59');

        $where = array(
            'addtime' => array('between', array($startTime, $endTime))
        );

        // 总阅读数
        $totalReads = $this->db->where($where)->where(array('action' => 'read'))->count();

        // 总点赞数
        $totalLikes = $this->db->where($where)->where(array('action' => 'like'))->count();

        // 总分享数
        $totalShares = $this->db->where($where)->where(array('action' => 'share'))->count();

        // 平均阅读时长
        $avgDuration = $this->db->where($where)->where(array('action' => 'read'))->avg('duration');

        // 平均阅读深度
        $avgDepth = $this->db->where($where)->where(array('action' => 'read'))->avg('scroll_depth');

        $this->ajaxReturn(array(
            'success' => true,
            'data' => array(
                'totalReads' => (int)$totalReads,
                'totalLikes' => (int)$totalLikes,
                'totalShares' => (int)$totalShares,
                'avgDuration' => round($avgDuration, 0) ?: 0,
                'avgDepth' => round($avgDepth, 0) ?: 0,
                'startDate' => $startDate,
                'endDate' => $endDate
            )
        ));
    }

    /**
     * 文章统计
     */
    public function articleStats() {
        $aid = I('aid', 0, 'intval');

        if (!$aid) {
            $this->ajaxReturn(array('success' => false, 'msg' => '缺少文章ID'));
        }

        $where = array('article_id' => $aid);

        $totalReads = $this->db->where($where)->where(array('action' => 'read'))->count();
        $totalLikes = $this->db->where($where)->where(array('action' => 'like'))->count();
        $totalShares = $this->db->where($where)->where(array('action' => 'share'))->count();
        $avgDuration = $this->db->where($where)->where(array('action' => 'read'))->avg('duration');
        $avgDepth = $this->db->where($where)->where(array('action' => 'read'))->avg('scroll_depth');

        $this->ajaxReturn(array(
            'success' => true,
            'data' => array(
                'articleId' => $aid,
                'totalReads' => (int)$totalReads,
                'totalLikes' => (int)$totalLikes,
                'totalShares' => (int)$totalShares,
                'avgDuration' => round($avgDuration, 0) ?: 0,
                'avgDepth' => round($avgDepth, 0) ?: 0
            )
        ));
    }
}
