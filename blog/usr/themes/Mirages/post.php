<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

 
			<div class="crumb">
			<span>你的位置：<a href="/">首页</a> > 专家页面 > 文档查看</span>
			</div>
			<div class="width-block">
				<div class="text-field">
					 
						<?php if(!(isset($this->fields->hideTitle) && intval($this->fields->hideTitle) > 0)): ?>
								        <h2><?php $this->title() ?></h2>
								        <ul class="post-meta">
								            <li itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li>
								            <li><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time></li>
								            <?php if(intval($this->viewsNum) > 0): ?>
								            <li><?php _e('阅读: '); ?><?php $this->viewsNum();?></li>
								            <?php endif?>
								            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
								            <li>	<?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></li>
								            <?php if($this->user->hasLogin()):?>
								            <li class="edit"><a href="<?php $this->options->rootUrl();?>/<?=isset($this->options->adminDir) ? trim($this->options->adminDir, '/') : "admin";?>/write-post.php?cid=<?=$this->cid?>" target="_blank"><?php _e('编辑'); ?></a></li>
								            <?php endif?>
								            
								            
								        </ul>
						<?php endif?>
					
		  	</div>
			  <div class="text-conent">
					<div class="text-info">
						<!--
						<h2 style="font-size: 22px;" align="center">
						<b><?php $this->title() ?></b>
						</h2>
						-->
						
						
					
										
							<?php if(!(isset($_SESSION['cms_username'])&&$_SESSION['cms_username'] !='')){ ?>
								<div class="tips-line">
									<div class="login-tisp">
										<p>很抱歉，您没有权限查看请求的内容，您可以<a href="/index.php?s=/member/login.html">登录</a>/<a href="javascript:">申请免费试用</a>,或直接联系我们：
										<p>热线电话:  400-888-6688</p>
										<p>客服邮箱:  Support@HR.com</p>
										<p>传    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 真:  400-088-6688</p>
									</div>
								</div>
							<?php	}else{ ?>
						
							
							<?php echo renderCards($this->content) ?>
						
								   <?php $this->need('comments.php'); ?>
			    		<?php	} ?>
							
					</div>
						
							
				</div>
			</div>
<?php $this->need('footer.php'); ?>
