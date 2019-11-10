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
                                    <input type="text" name="userAccount" placeholder="请输入会员账号" autocomplete="off" class="layui-input" style="width:200px">
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userName" placeholder="请输入真实姓名" autocomplete="off" class="layui-input" style="width:200px">
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userId" placeholder="请输入平台id" autocomplete="off" class="layui-input" style="width:200px">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header"> 
                            <button type="button" class="layui-btn" id="test1">
              							  <i class="layui-icon">&#xe67c;</i>上传csv表格
              							</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                 
                                <tr>
                                  <th>ID</th>
                                  <th>登录名</th>
                                  <th>手机</th>
                                  <th>邮箱</th>
                                  <th>角色</th>
                                  <th>加入时间</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                                 
                                <tr>
                                  <td>1</td>
                                  <td>admin</td>
                                  <td>18925139194</td>
                                  <td>113664000@qq.com</td>
                                  <td>超级管理员</td>
                                  <td>2017-01-01 11:11:42</td>
                                  <td class="td-status">
                                    <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                                  <td class="td-manage">
                                    <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
                                      <i class="layui-icon">&#xe601;</i>
                                    </a>
                                    <a title="编辑"  onclick="xadmin.open('编辑','admin-edit.html')" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
                                      <i class="layui-icon">&#xe640;</i>
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                  <a class="prev" href="">&lt;&lt;</a>
                                  <a class="num" href="">1</a>
                                  <span class="current">2</span>
                                  <a class="num" href="">3</a>
                                  <a class="num" href="">489</a>
                                  <a class="next" href="">&gt;&gt;</a>
                                </div>
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
  function member_del(obj,id){
      layer.confirm('确认要删除吗？',function(index){
          //发异步删除数据
          $(obj).parents("tr").remove();
          layer.msg('已删除!',{icon:1,time:1000});
      });
  }

</script>
@endsection