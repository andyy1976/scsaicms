<?php
include 'common.php';
include 'header.php';
//include 'menu.php';
?>


<div class="second">
<div class="width-block">
		<div class="pusl-list">
								<div class="joint"><span>你的位置：首页 >  专家页面 > <a href="/blog/admin/index.php">我的文章</a> > 新增分类   <!-- <?php echo "<a href=\"{$menu->addLink}\">" . _t("新增") . "</a>"; ?>--></span></div>
								<div class="bule"></div>
	<div class="main">
								 <div class="body container">
											        <?php include 'page-title.php'; ?>
											        <div class="row typecho-page-main" role="form">
											            <div class="col-mb-12 col-tb-6 col-tb-offset-3">
											                <?php Typecho_Widget::widget('Widget_Metas_Category_Edit')->form()->render(); ?>
											            </div>
											        </div>
								</div>
	</div>
</div>

<?php
include 'common-js.php';
include 'form-js.php';
include 'footer.php';
?>
