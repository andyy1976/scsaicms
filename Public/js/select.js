// var name = "heizai";	// 元素ID、select名称
// var pid  = "10001";	// 顶级ID
// var data = [10006];	// 数据
// var html = "";		// html代码
// var i    = 0;		// 循环变量

// 初始化
var data = new Array();	// 数据
var html = "";	// html代码
var i    = 0;	// 循环变量
// $(function(){
// 	initial();
// });


// AJAX获取分类
function getList(pid, name){
	//alert(pid);
	if(pid==0){return '';}
	$.ajax({
		url:'/admin.php?m=Public&a=ajax_city',
		async:false,
		type:'post',
		data:{'city_id':pid},
		success:function(data){	
		//alert(data);
			if (data !== null && data != "" && data != undefined) {
				html = "<select name='" + name + "[]' onchange=\"change($(this).index(), $(this).val(), $(this).attr('name'))\">";
				html += "<option value='0'>请选择</option>";
				$.each(data, function(index, list){
					html += "<option value='" + list.city_id + "'>" + list.city_name + "</option>";
				})
				html += "</select>&nbsp;&nbsp;";
			} else {
				html = "";
			}
		}
	});
	return html;
};

// 循环输出分类
function initial(pid, name, data){
	if(pid==0){return;}
	html = getList(pid, name);
	$("#"+name).append(html);
	i = 0;
	while(html != ""){
		//alert(data[i]);
		if ( typeof(data[i]) != "undefined" && data[i] != '') {
			pid = data[i];
			$("select[name='"+name+"[]']:eq("+i+")").val(pid);
		} else {
			pid = $("select[name='"+name+"[]']:eq("+i+")").val();
		};
		html = getList(pid, name);
		$("#"+name).append(html);
		i++;
	};

};

// 选择事件
function change(index, pid, name){
	if(pid==0){return;}
	$("select[name='" + name + "']:gt(" + index + ")").remove();
	var new_name = name.replace("[]", "");
	html = getList(pid, new_name);
	i = index;
	while(html != ''){
		$("#"+new_name).append(html);
		i++;
		pid = $("select[name='" + name + "']:eq(" + i + ")").val();
		html = getList(pid, new_name);
	}
};