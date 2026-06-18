<?php

class SmartColumnAction extends Action {

    public function index() {
        $this->display();
    }

    public function generate() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }

        $categoryCount = intval($postData['categoryCount']) ?: 5;
        $minArticles = intval($postData['minArticles']) ?: 3;

        $articles = M('article', 'lvbo_')->where(array('status' => 1))->field('aid, title, description, content, typeid, addtime, hits')->select();

        if (empty($articles)) {
            $this->ajaxReturn(array('success' => false, 'message' => '暂无文章数据'), 'JSON');
            return;
        }

        $categories = $this->clusterArticles($articles, $categoryCount, $minArticles);

        $this->ajaxReturn(array(
            'success' => true,
            'data' => $categories,
            'totalArticles' => count($articles)
        ), 'JSON');
    }

    private function clusterArticles($articles, $categoryCount, $minArticles) {
        $categoryKeywords = array(
            'AI' => array('人工智能', 'AI', '智能', '机器学习', '深度学习', '大模型', 'GPT', '生成式'),
            '数字化' => array('数字化', '数字转型', '数字孪生', '智能制造', '工业4.0', '产业升级'),
            '技术' => array('技术', '架构', '开发', '编程', '系统', '平台', '解决方案'),
            '企业' => array('企业', '管理', '运营', '效率', '协作', '办公', '流程'),
            '营销' => array('营销', '推广', '获客', '内容营销', '私域', '增长', '转化'),
            '产品' => array('产品', '功能', '特性', '使用', '教程', '指南'),
            '案例' => array('案例', '客户', '成功', '实践', '经验', '分享'),
            '趋势' => array('趋势', '洞察', '分析', '预测', '未来', '展望'),
            '工具' => array('工具', '软件', '应用', '插件', '平台', '服务'),
            '行业' => array('行业', '领域', '垂直', '细分', '市场', '竞争')
        );

        $categories = array();
        foreach ($categoryKeywords as $name => $keywords) {
            $articlesInCategory = array();
            foreach ($articles as $article) {
                $text = $article['title'] . ' ' . ($article['description'] ?: '') . ' ' . ($article['content'] ?: '');
                $matchCount = 0;
                foreach ($keywords as $keyword) {
                    if (strpos($text, $keyword) !== false) {
                        $matchCount++;
                    }
                }
                if ($matchCount >= 1) {
                    $articlesInCategory[] = $article;
                }
            }
            if (count($articlesInCategory) >= $minArticles) {
                $totalHits = array_sum(array_column($articlesInCategory, 'hits'));
                $avgHits = round($totalHits / count($articlesInCategory), 1);
                $categories[] = array(
                    'name' => $name,
                    'articles' => $articlesInCategory,
                    'articleCount' => count($articlesInCategory),
                    'totalHits' => $totalHits,
                    'avgHits' => $avgHits,
                    'keywords' => $keywords
                );
            }
        }

        usort($categories, function($a, $b) {
            return $b['articleCount'] - $a['articleCount'];
        });

        return array_slice($categories, 0, $categoryCount);
    }

    public function analyze() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $articles = M('article', 'lvbo_')->where(array('status' => 1))->field('aid, title, description, content, typeid, addtime, hits')->select();

        $analysis = array(
            'totalArticles' => count($articles),
            'totalHits' => array_sum(array_column($articles, 'hits')),
            'avgHits' => count($articles) > 0 ? round(array_sum(array_column($articles, 'hits')) / count($articles), 1) : 0,
            'topArticles' => array(),
            'categoryStats' => array(),
            'monthlyTrend' => array()
        );

        $sortedArticles = $articles;
        usort($sortedArticles, function($a, $b) {
            return $b['hits'] - $a['hits'];
        });

        $analysis['topArticles'] = array_slice($sortedArticles, 0, 10);

        $typeMap = M('type', 'lvbo_')->where(array('modelid' => 1))->getField('typeid,name');
        foreach ($articles as $article) {
            $typeName = isset($typeMap[$article['typeid']]) ? $typeMap[$article['typeid']] : '未分类';
            if (!isset($analysis['categoryStats'][$typeName])) {
                $analysis['categoryStats'][$typeName] = array('count' => 0, 'hits' => 0);
            }
            $analysis['categoryStats'][$typeName]['count']++;
            $analysis['categoryStats'][$typeName]['hits'] += $article['hits'];
        }

        foreach ($articles as $article) {
            $month = date('Y-m', strtotime($article['addtime']));
            if (!isset($analysis['monthlyTrend'][$month])) {
                $analysis['monthlyTrend'][$month] = array('count' => 0, 'hits' => 0);
            }
            $analysis['monthlyTrend'][$month]['count']++;
            $analysis['monthlyTrend'][$month]['hits'] += $article['hits'];
        }

        ksort($analysis['monthlyTrend']);

        $this->ajaxReturn(array(
            'success' => true,
            'data' => $analysis
        ), 'JSON');
    }

    public function optimize() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }

        $typeid = intval($postData['typeid']);
        $newName = trim($postData['newName']);
        $action = $postData['action'];

        if (!$typeid && $action !== 'create') {
            $this->ajaxReturn(array('success' => false, 'message' => '缺少栏目ID'), 'JSON');
            return;
        }

        if ($action === 'rename') {
            $result = M('type', 'lvbo_')->where(array('typeid' => $typeid))->save(array('name' => $newName));
            if ($result !== false) {
                $this->ajaxReturn(array('success' => true, 'message' => '栏目重命名成功'), 'JSON');
            } else {
                $this->ajaxReturn(array('success' => false, 'message' => '重命名失败'), 'JSON');
            }
        } elseif ($action === 'create') {
            $type = M('type', 'lvbo_');
            $maxId = $type->max('typeid');
            $newType = array(
                'typeid' => $maxId + 1,
                'name' => $newName,
                'modelid' => 1,
                'parentid' => 0,
                'sort' => 0,
                'status' => 1,
                'ishtml' => 0
            );
            $result = $type->add($newType);
            if ($result) {
                $this->ajaxReturn(array('success' => true, 'message' => '栏目创建成功', 'typeid' => $newType['typeid']), 'JSON');
            } else {
                $this->ajaxReturn(array('success' => false, 'message' => '创建失败'), 'JSON');
            }
        } elseif ($action === 'merge') {
            $targetId = intval($postData['targetId']);
            if (!$targetId || $typeid == $targetId) {
                $this->ajaxReturn(array('success' => false, 'message' => '目标栏目ID无效'), 'JSON');
                return;
            }
            M('article', 'lvbo_')->where(array('typeid' => $typeid))->save(array('typeid' => $targetId));
            M('type', 'lvbo_')->where(array('typeid' => $typeid))->delete();
            $this->ajaxReturn(array('success' => true, 'message' => '栏目合并成功'), 'JSON');
        }

        $this->ajaxReturn(array('success' => false, 'message' => '未知操作'), 'JSON');
    }
}