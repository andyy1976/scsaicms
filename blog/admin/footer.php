<div class="footer">
	<div class="width-block">
		<p><a href="javascript:">版权声明</a>  |  <a href="javascript:">免责声明</a>  |  <a href="javascript:">服务条款</a>  |  <a href="javascript:">隐私政策</a>  |  <a href="javascript:">关于我们</a>  |  <a href="javascript:">联系我们</a></p>
		<p>Copyright © HR. All rights reserved &nbsp; 京ICP证110088号</p>
		<p>客服电话：400-555-888 &nbsp;  客服邮箱:Support@HR.com</p>
	</div>
</div>

			
<!--登录弹层-->
<div class="box-dl" style="display: none;">
	<div class="register dl-login">
		<div class="reg-block">
		
			<div class="caption"><h3>用户登录</h3><span class="pul-close"><img src="__TMPL__images/modal-close.png" width="18"></span></div>
			<form role="form" action="/index.php?s=/member/dologin" method="post">

			<div class="reg-list">
				<div class="reg-info">
					<div class="name"><font>*</font>用户名：</div>
					<div class="rit-input"><input type="text" name="username" placeholder="请输入用户名"></div>
				</div>
				<div class="reg-info">
					<div class="name"><font>*</font>密码：</div>
					<div class="rit-input"><input type="password" name="userpwd"  placeholder="请输入密码"></div>
				</div>
				
				<div class="reg-btn"><button type="submit">立即登录</button></div>
				<div class="lb-bt pad-jl"><a href="javascript:" class="zc-tc">注册</a><a href="{:U('Member/find_password')}" class="ps">忘记密码?</a></div>
			</div>
	</form>
			
		</div>
	</div>
</div>

<!--注册弹层-->
<div class="box-zc" style="display: none;">
	<div class="register zc-reg">
		<div class="reg-block">
			<div class="caption"><h3>用户注册</h3><span class="pul-close"><img src="__TMPL__images/modal-close.png" width="18"></span></div>
			<div class="reg-list">
			 	<form action="/index.php?s=/member/doreg" name="reg_form" id="regform" method="post" class="form-horizontal">

				<div class="reg-info">
					<div class="name"><font>*</font>用户名：</div>
					<div class="rit-input"><input type="text" name="username" id="username" placeholder="请输入用户名"></div>
				</div>
				<div class="reg-info">
					<div class="name"><font>*</font>密码：</div>
					<div class="rit-input"><input type="password" id="userpwd" name="userpwd" placeholder="请输入密码"></div>
				</div>
				<div class="reg-info">
					<div class="name"><font>*</font>确认密码：</div>
					<div class="rit-input"><input type="password" name="userpwd2" id="userpwd2" placeholder="再次输入密码确认"></div>
				</div>
				<div class="reg-info">
					<div class="name"><font>*</font>Email：</div>
					<div class="rit-input"><input type="text" name="email" id="email" placeholder="请输入Email"></div>
				</div>
				<div class="reg-btn"><button type="submit">立即注册</button></div>
			<!--	<div class="agree"><label><input type="checkbox">阅读并接受<a href="javscript:">《用户注册协议》</a></label></div>-->
			</form>
			</div>
			
		</div>
	</div>
</div>
</body>
</html>
