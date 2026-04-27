<?php
include 'common.php';
include 'header.php';
//include 'menu.php';
$stat = Typecho_Widget::widget('Widget_Stat');
?>
<div class="second">
	<div class="width-block">
		<div class="second-left">
			<div class="left-list">
				<div class="second-treemenu">
						<div class="title"><h3><a href="#">功能导航</a></h3></div>
						<div class="treemenu">
							<ul id='suckertree1'>

		           
		           <?php if($user->hasLogin() && $_SESSION['cms_bloggroup'] !='visitor'&& $_SESSION['cms_bloggroup'] !='subscriber'):?>
		          
		           <li><span class="arrow"></span><span class="file active"><a href="<?php $options->adminUrl('index.php'); ?>">我的文章</a></span></li>
		           <?php endif?>
		           <li><span class="arrow"></span><span class="file"><a href="http://localhost/index.php?s=memberlist">团队展示</a></span></li>
		        	</ul>
		  	 	  </div>
				</div>
				<div class="second-treemenu">
							<div class="title"><h3><a href="<?php $options->adminUrl('../index.php'); ?>">主题分类</a></h3></div>
							<div class="treemenu">
							                           
							
		                    <?php $user->widget('Widget_Metas_Category_List')->listCategories(); ?>
		         
								
							</div>
				</div>

			</div>
		</div>
	
				
			<div class="second-right">
					<div class="tw-menu">
						
																                <ul >
																                 <li class="active"><a href="<?php $options->adminUrl('index.php'); ?>"><?php _e('最近发布的文章'); ?></a></li>
																                	  <li><a href="<?php $options->adminUrl('comments_recent.php'); ?>"><?php _e('最近得到的回复'); ?></a></li>
																                	  
																                    <?php if($user->pass('contributor', true)): ?>
																                    <li><a href="<?php $options->adminUrl('write-post.php'); ?>"><?php _e('发布新文章'); ?></a></li>
																                    <?php if($user->pass('editor', true) && 'on' == $request->get('__typecho_all_comments') && $stat->waitingCommentsNum > 0): ?>
																                        <li><a href="<?php $options->adminUrl('manage-comments.php?status=waiting'); ?>"><?php _e('管理评论'); ?></a>
																                        <span class="balloon"><?php $stat->waitingCommentsNum(); ?></span>
																                        </li>
																                    <?php elseif($stat->myWaitingCommentsNum > 0): ?>
																                        <li><a href="<?php $options->adminUrl('manage-comments.php?status=waiting'); ?>"><?php _e('管理评论'); ?></a>
																                        <span class="balloon"><?php $stat->myWaitingCommentsNum(); ?></span>
																                        </li>
																                    <?php endif; ?>
																                    
																                    <?php if($user->pass('editor', true) && 'on' == $request->get('__typecho_all_comments') && $stat->spamCommentsNum > 0): ?>
																                        <li><a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>"><?php _e('管理评论'); ?></a>
																                        <span class="balloon"><?php $stat->spamCommentsNum(); ?></span>
																                        </li>
																                    <?php elseif($stat->mySpamCommentsNum > 0): ?>
																                        <li><a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>"><?php _e('管理评论'); ?></a>
																                        <span class="balloon"><?php $stat->mySpamCommentsNum(); ?></span>
																                        </li>
																                    <?php endif; ?>
																                    
																                    <?php if($user->pass('contributor', true)): ?>
																                    <li><a href="<?php $options->adminUrl('manage-posts.php'); ?>"><?php _e('管理文章'); ?></a></li>
																                     <?php endif; ?>
																                     
																                    <?php if($user->pass('administrator', true)): ?>
																                    <!--<li><a href="<?php $options->adminUrl('manage-posts.php'); ?>"><?php _e('管理文章'); ?></a></li>-->
																                    <!--
																                    <li><a href="<?php $options->adminUrl('themes.php'); ?>"><?php _e('更换外观'); ?></a></li>
																                    <li><a href="<?php $options->adminUrl('plugins.php'); ?>"><?php _e('插件管理'); ?></a></li>
																                    <li><a href="<?php $options->adminUrl('options-general.php'); ?>"><?php _e('系统设置'); ?></a></li>
																                    -->
																                    <?php endif; ?>
																                    
																                     <?php if($user->pass('editor', true)): ?>
																                    <li><a href="<?php $options->adminUrl('manage-categories.php'); ?>"><?php _e('管理分类'); ?></a></li>
																                     <li><a href="<?php $options->adminUrl('manage-tags.php'); ?>"><?php _e('管理标签'); ?></a></li>
																                      <li><a href="<?php $options->adminUrl('manage-medias.php'); ?>"><?php _e('管理文件'); ?></a></li>
																                    <?php endif; ?>
																                    <?php endif; ?>
																                    <!--<li><a href="<?php $options->adminUrl('profile.php'); ?>"><?php _e('更新我的资料'); ?></a></li>-->
																                </ul>
																             
					</div>
				
					<div class="pusl-list questions">
							<div class="joint">
								<p><?php _e('目前有 <em>%s</em> 篇文章, 并有 <em>%s</em> 条关于你的评论在 <em>%s</em> 个分类中.',
																		    $stat->myPublishedPostsNum, $stat->myPublishedCommentsNum, $stat->categoriesNum); ?>
								</p>
						
					    </div>
							<div class="bule"></div>
								
															                  
															                    <?php Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=10')->to($posts); ?>
															                    <ul>
																	                    <?php if($posts->have()): ?>
																	                    <?php while($posts->next()): ?>
																	                        <li>
																	                        		<div class="rit-cont">
																															<div class="name">
																																<div><a href="<?php $posts->permalink(); ?>" class="title"><?php $posts->title(); ?></a></div>
																																<div style="float:right;"> [<span><?php $posts->date('n.j'); ?></span>]</div>
																															</div>
																														
																														</div>
																	                            
																	                            
																	                        </li>
																	                    <?php endwhile; ?>
																	                    <?php else: ?>
																	                        <li><?php _e('暂时没有文章'); ?></li>
																	                    <?php endif; ?>
															                    </ul>
															         

															     
					</div>
			</div>
				
  </div>

		
	</div>
</div>		
<?php
include 'common-js.php';
?>


<?php include 'footer.php'; ?>
