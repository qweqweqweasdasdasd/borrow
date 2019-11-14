@extends('admin/common/layout')
@section('content')
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="#">{{$pathinfo['module']}}</a>
            <a href="#">{{$pathinfo['contr']}}</a>
            <a>
              <cite>{{$pathinfo['method']}}</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">
	                        	
                             	<div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userAccount" placeholder="请输入会员账号" autocomplete="off" class="layui-input" style="width:200px" value="{{$whereData['userAccount']}}">
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userName" placeholder="请输入真实姓名" autocomplete="off" class="layui-input" style="width:200px" value="{{$whereData['userName']}}">
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="telephone" placeholder="请输入手机号码" autocomplete="off" class="layui-input" style="width:200px" value="{{$whereData['telephone']}}">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                       <!--  <div class="layui-card-header"> 
                            <button type="button" class="layui-btn" id="test1">
              							  <i class="layui-icon">&#xe67c;</i>上传csv表格
              							</button>
                        </div> -->
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                 
                                <tr>
                                  <th>ID</th>
                                  <th>用户昵称</th>
                                  <th>真实姓名</th>
                                  <th>手机号码</th>
                                  <th>平台id</th>
                                  <th>VIP等级</th>
                                  <th>已借金额</th>
                                  <th>更新vip时间</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                                @foreach($members as $v)
                                <tr>
                                  <td>{{$v->m_id}}</td>
                                  <td>{{$v->userAccount}}</td>
                                  <td>{{$v->userName}}</td>
                                  <td>{{$v->telephone}}</td>
                                  <td>{{$v->userId}}</td>
                                  <td>{{$v->vip->vipName}}</td>
                                  <td>{{$v->balanced}}</td>
                                  <td class="td-status">
                                   {{$v->update_vip_time}}
                                  </td>
                                  <td class="td-manage">
   
                                    <a title="编辑"  onclick="xadmin.open('编辑','/admin/member/{{$v->m_id}}/edit',600,800,true)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="手动更新" onclick="update_vip(this,'{{$v->m_id}}')" href="javascript:;">
                                      <i class="layui-icon">&#xe9aa;</i>
                                    </a>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                {{ $members->appends($whereData)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
@endsection
@section('my-js')
<script>
  layui.use(['laydate','form','upload'], function(){
	    var laydate = layui.laydate;
	    var form = layui.form;
	    var upload = layui.upload;
	    
	    //执行实例
	  	var uploadInst = upload.render({
		    elem: '#test1' //绑定元素
		    ,url: '/admin/upload' //上传接口
        ,accept: 'file'
        ,field: 'csv'
		    ,done: function(res){
		      if(res.code == 0){
            layer.msg(res.msg);
          }
          if(res.code == 1){
            layer.msg(res.msg);
          }
		    }
		    ,error: function(){
		      //请求异常回调
		    }
	  	});
	    
	    //执行一个laydate实例
	    laydate.render({
	      elem: '#start' //指定元素
	    });

	    //执行一个laydate实例
	    laydate.render({
	      elem: '#end' //指定元素
	    });
  });


  /*用户-删除*/
  function update_vip(obj,id){
      layer.confirm('确认要更新vip等级吗？',function(index){
          //发异步删除数据
           $.ajax({
              url:'/admin/member/'+id,
              data:'',
              dataType:'json',
              type:'get',
              headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
              },
              success:function(res){
                if(res.code == '1'){
                    layer.msg(res.data.data+'更新ok!');
                }
                if(res.code == '422'){
                    layer.msg(res.msg,{icon:5})
                }
                if(res.code == '0'){
                    layer.msg(res.msg,{icon:5})
                }
              }
            })
         
      });
  }

</script>
@endsection