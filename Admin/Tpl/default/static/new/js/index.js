// var btData = require('./data.json')

var btData = [
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [
      { "title": "关注", "type": 1},
      { "title": "需求", "type": 1},
      { "title": "支付", "type": 1},
      { "title": "关注", "type": 2},
      { "title": "需求", "type": 2},
      { "title": "支付", "type": 2},
      { "title": "关注", "type": 2},
      { "title": "需求", "type": 2},
      { "title": "支付", "type": 2},
      { "title": "关注", "type": 2},
      { "title": "需求", "type": 2},
      { "title": "支付", "type": 2}
    ],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [
      { "title": "关注", "type": 1},
      { "title": "需求", "type": 1},
      { "title": "支付", "type": 1}
    ],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  },
  {
    "id": "4243923",
    "title": "退一步海阔天空，这些星座懂得...",
    "date": "03/16  07:33:01",
    "sensitive": [],
    "from": "百家号-综合",
    "audit": "北京基地",
    "states": "已入库"
  }
]


$(function () {
  //将json数据转成bootstrapTable适用的数据 
  function btSensitivelist (data) {
    let output = ''
    data.map( item => {
      output += `<li class=${item.type == 1 ? 'ss-tag-fff-ff9900' : 'ss-tag-fff-fc4944'}>${item.title}</li>`
    })
    return `<ul class='ss-tag-list-2'>${output}</ul>`
  }
  function btFunc(data) {
    if (btData && btData.length > 0){
      return btData.map( item=> {
        return {
            id: `<p class='color-006dce'>${item.id}</p>`,
            title: `<p class='textellipsis-1 click-modal color-006dce' data-id=${item.id}>${item.title}</p>`,
            date:  item.date,
            sensitive: item.sensitive.length > 0 ? btSensitivelist(item.sensitive) : '',
            from: item.from,
            audit: item.audit,
            states: item.states
          }
      })
    }
  }
  $('.ss-bootstrapTable').bootstrapTable({
    data: btFunc(btData),
    // url: '/Home/GetDepartment',         //请求后台的URL（*）
    // method: 'get',                      //请求方式（*）
    toolbar: '.ss-table-search-wrap',                //工具按钮用哪个容器
    // striped: true,                      //是否显示行间隔色
    cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
    pagination: true,                   //是否显示分页（*）
    sortable: false,                     //是否启用排序
    sortOrder: "asc",                   //排序方式
    // queryParams: queryParams,        //传递参数（*）
    sidePagination: "client",           //分页方式：client客户端分页，server服务端分页（*）
    queryParamsType:  "limit",
    pageNumber: 1,                       //初始化加载第一页，默认第一页
    pageSize: 3,                       //每页的记录行数（*）
    pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
    // search: true,                       //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
    // strictSearch: true,
    // showColumns: true,                  //是否显示所有的列
    // showRefresh: true,                  //是否显示刷新按钮
    minimumCountColumns: 2,             //最少允许的列数
    clickToSelect: true,                //是否启用点击选中行
    // height: 500,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
    uniqueId: "ID",                     //每一行的唯一标识，一般为主键列
    // showToggle:true,                    //是否显示详细视图和列表视图的切换按钮
    // cardView: false,                    //是否显示详细视图
    // detailView: false,                   //是否显示父子表
    // silentSort: true,                      // option to sort the data with loading message.
    checkboxHeader: false,                //为否隐藏全选按钮
    columns: [
      {
          checkbox: true
      },
      {
          field: 'id',
          title: 'ID',
          width: '10%'
      },
      {
          field: 'title',
          title: '标题',
          width: '24%'
      },
      {
          field: 'date',
          title: '入库时间',
          width: '15%'
      },
      {
          field: 'sensitive',
          title: '敏感词等',
          width: '25%'
      },
      {
          field: 'from',
          title: '内容来源',
          width: '10%'
      },
      {
          field: 'audit',
          title: '审核分配',
          width: '9%'
      },
      {
          field: 'states',
          title: '状态',
          width: '7%'
      },
    ]
  })


  //双日历
  const newDate = new Date();
  const nowDt = newDate.toJSON(); 
  $('#datetimepickerstart').datetimepicker({
    language: 'zh-CN',
    format: 'yyyy-mm-dd',
    minViewMode: 'month', //最小选择范围
    // todayBtn:  1,
    autoclose: 1,
    // todayHighlight: 1,
    startDate: new Date(nowDt),
  })
  let startTime = $('#datetimepickerstart').val();
  $('#datetimepickerend').datetimepicker({
    language: 'zh-CN',
    format: 'yyyy-mm-dd',
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startDate: startTime,
  })

  //指定页数 监控键盘
  $(".assignpage").keydown(function(event){ 
    let getNum = parseInt($(this).val())
    console.log(getNum)
    if (event.keyCode === 13){ 
      $('.ss-bootstrapTable').bootstrapTable('selectPage', getNum);
      // $('.ss-bootstrapTable').bootstrapTable('refresh')
    } 
  }); 

  //modal
  $('.click-modal').click(function(){
    console.log('===============')
    $('.modal').modal('show')
  })
  // $("#myModal").on("hidden.bs.modal", function() {
  //   $(this).removeData("bs.modal");
  //   /*modal页面加载$()错误,由于移除缓存时加载到<div class="modal-content"></div>未移除的数据，            手动移除加载的内容*/
  //   $(this).find(".modal-content").children().remove();
  // })
  
})

// $table.bootstrapTable('checkAll')
// $table.bootstrapTable('uncheckAll')
// $table.bootstrapTable('remove', {field: 'id', values: ids})
// $table.bootstrapTable('refresh')
//$table.bootstrapTable('getSelections')