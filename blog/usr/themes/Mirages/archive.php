<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="second">
	<div class="width-block">
		<div class="second-left">
			<div class="left-list">
				
				<div class="second-treemenu">
						<div class="title"><h3><a href="#">功能导航</a></h3></div>
						<div class="treemenu">
							<ul id='suckertree1'>

		           
		           <?php if($this->user->hasLogin() && $_SESSION['cms_bloggroup'] !='visitor'&& $_SESSION['cms_bloggroup'] !='subscriber'):?>
		          
		           <li><span class="arrow"></span><span class="file"><a href="/blog/admin/index.php">我的文章</a></span></li>
		             <?php if($this->user->pass('contributor', true)): ?>
		           <li><span class="arrow"></span><span class="file"><a href="/blog/admin/write-post.php">发布文章</a></span></li>
		            <?php endif?>
		           <?php endif?>
		           <li><span class="arrow"></span><span class="file"><a href="/index.php?s=memberlist">团队展示</a></span></li>
		        	</ul>
		  	 	  </div>
				</div>
				<div class="second-treemenu">
							<div class="title"><h3>主题分类</h3></div>
							<div class="treemenu">
							                           
							
		                    <?php $this->widget('Widget_Metas_Category_List')->listCategories(); ?>
		         
								
							</div>
				</div>
			
			</div>
		</div>

	<div class="second-right">
			<div class="joint">
			<span>
			你的位置：<a href="/">首页</a> > 专家页面>
		<?php $this->archiveTitle(array(
	            'category'  =>  _t('%s'),
	            'search'    =>  _t('包含关键字 %s 的文章'),
	            'tag'       =>  _t('标签 %s 下的文章'),
	            'author'    =>  _t('%s 发布的文章')
        	), '', ''); ?>
				</span>
	</div>
				<div class="pusl-list">
				<div class="bule">
				</div>
						<ul>
				
       
        		<?php if ($this->have()): ?>
    				<?php while($this->next()): ?>
	            <article  itemscope itemtype="http://schema.org/BlogPosting">
											<li>
												<div class="number"></div>
								        <div class="rit-cont"> 
										       	<div class="name">
									       		<a href="<?php $this->permalink() ?>" target="_blank"><?php $this->title() ?></a>
										       	</div>
														<div class="tips">
															<span itemprop="datePublished"><?php $this->date('F j, Y'); ?></span>
															<span class="comments"><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a></span>
														</div>
														<!--
														<div class="info" itemprop="description">
															<p><?php $this->content("Continue Reading..."); ?></p>
														</div>
														-->
												</div>
											</li>
							</article>
    				<?php endwhile; ?>
        		<?php else: ?>
	            <article class="post">
	                <h2 class="post-title no-content"><?php _e('没有找到内容'); ?></h2>
	            </article>
        		<?php endif; ?>

      
    			</ul>
				
				
				<div class="page-al">
					<div class="dataTables_paginate pagination">
					    <nav>
					        <ul class="pagination">
					        	
					        		<?php $this->pageNav('&laquo;', '&raquo;'); ?>
					        </ul>
					    </nav>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<?php $this->need('footer.php'); ?>
