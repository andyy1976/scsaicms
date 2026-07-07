<?php

class ExperienceAction extends Action {
    public function index() {
        C('SEO_TITLE', '工业智能体体验中心 - 左帮右臂');
        C('SEO_KEYWORDS', '左帮右臂,BOM比对,工艺优化,内容生成,工业智能体,AI体验');
        C('SEO_DESCRIPTION', '免费在线体验左帮右臂工业智能体：BOM结构比对、工艺参数优化、智能内容生成，无需注册即开即用');
        cookie('skip_title',1);
        $this->display();
    }
}
