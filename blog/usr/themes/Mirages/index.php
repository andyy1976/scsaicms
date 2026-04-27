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
		          
		           <li><span class="arrow"></span><span class="file"><a href="admin/index.php">我的文章</a></span></li>
		               <?php if($this->user->pass('contributor', true)): ?>
		           <li><span class="arrow"></span><span class="file"><a href="admin/write-post.php">发布文章</a></span></li>
		            <?php endif?>
		           <?php endif?>
		           <li><span class="arrow"></span><span class="file"><a href="/index.php?s=memberlist">团队展示</a></span></li>
		        	</ul>
		  	 	  </div>
				</div>
				<div class="second-treemenu">
						<div class="title"><h3><a href="/blog">主题分类</a></h3></div>
							<div class="treemenu">
							                           
							
		                    <?php $this->widget('Widget_Metas_Category_List')->listCategories(); ?>
		         
								
							</div>
				</div>
			
			</div>
		</div>

		<div class="second-right">
		<!--	
		<div class="joint">
		<span>
		你的位置：<a href="/">首页</a> > 专家页面
		</span>
		</div>
		-->
				<div class="pusl-list">
				<div class="bule">
				</div>
						<ul>
				
			
							<?php while($this->next()): ?>
				        <article  itemscope itemtype="http://schema.org/BlogPosting">
										<li>
											<div class="number"></div>
							        <div class="rit-cont"> 
									       	<div class="name">
									       		<a href="<?php $this->permalink() ?>" target="_blank"><?php $this->title() ?></a>
									       	</div>
									        <div class="tips">
														<span itemprop="datePublished"><?php $this->date('F j, Y'); ?> on </span>
														<span itemprop="categoryPublished"><?php $this->category(','); ?></span>
														<?php $parsed = parse_url($this->permalink);?>
														<?php if(strlen($this->options->disqusShortName) > 0):?>
															<span class="comments"><a href="<?php $this->permalink() ?>#disqus_thread" data-disqus-identifier="<?= $parsed['path'];?>">评论</a></a></span>
														<?php elseif(strlen($this->options->duoshuoShortName) > 0):?>
															<span class="comments"><a href="<?php $this->permalink() ?>#comments"><span class="ds-thread-count" data-thread-key="<?php echo $this->cid;?>" data-count-type="comments"></span></a></span>
														<?php else:?>
															<span class="comments"><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a></span>
														<?php endif?>
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
