<?php
include 'common.php';
include 'header.php';
include 'menu.php';
?>
								<div class="crumb"><span>你的位置：首页 >专家页面 >阅读设置</span></div>

<div class="width-block">

							
<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main" role="form">
            <div class="col-mb-12 col-tb-8 col-tb-offset-2">
                <?php Typecho_Widget::widget('Widget_Options_Reading')->form()->render(); ?>
            </div>
        </div>
    </div>
											</div>
	
</div>
<?php
include 'common-js.php';
include 'form-js.php';
?>
<script>
$('#frontPage-recent,#frontPage-page,#frontPage-file').change(function () {
    var t = $(this);
    if (t.prop('checked')) {
        if ('frontPage-recent' == t.attr('id')) {
            $('.front-archive').addClass('hidden');
        } else {
            $('.front-archive').insertAfter(t.parent()).removeClass('hidden');
        }
    }
});
</script>
<?php
include 'footer.php';
?>
