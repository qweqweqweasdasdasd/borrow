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
                    <div class="layui-card-header">
                        <button class="layui-btn" onclick="xadmin.open('添加用户','/admin/permission/create',600,800,true)"><i class="layui-icon"></i>添加权限</button>
                    </div>
                    <div class="layui-card-body ">
                        <table class="layui-table layui-form">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>权限名称</th>
                              <th>权限路由</th>
                              <th>控制器</th>
                              <th>方法</th>
                              <th>是否显示</th>
                              <th>是否验证</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($psTree as $k => $v) 
                            <tr>
                              <td>{{$v['ps_id']}}</td>
                              <td>{{$v['ps_name_item']}}</td>
                              <td>{{$v['route']}}</td>
                              <td>{{$v['ps_c']}}</td>
                              <td>{{$v['ps_a']}}</td>
                              <td>{!! common_show_status($v['is_show'],'显示','隐藏') !!}</td>
                              <td>{!! common_show_status($v['is_verfy'],'验证','不验') !!}</td>
                              <td class="td-manage">
                                
                                <a title="编辑"  onclick="xadmin.open('编辑','/admin/permission/{{$v['ps_id']}}/edit',600,800,true)" href="javascript:;">
                                  <i class="layui-icon">&#xe642;</i>
                                </a>
                                <a title="删除" onclick="member_del(this,'{{$v['ps_id']}}')" href="javascript:;">
                                  <i class="layui-icon">&#xe640;</i>
                                </a>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                    <div class="layui-card-body ">
                        <div class="page">
                           
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
  layui.use(['laydate','form'], function(){
    var laydate = layui.laydate;
    var form = layui.form;
    
    //执行一个laydate实例
    laydate.render({
      elem: '#start' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
      elem: '#end' //指定元素
    });
  });

   /*用户-停用*/
  function member_stop(obj,id){
      layer.confirm('确认要停用吗？',function(index){

          if($(obj).attr('title')=='启用'){

            //发异步把用户状态进行更改
            $(obj).attr('title','停用')
            $(obj).find('i').html('&#xe62f;');

            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
            layer.msg('已停用!',{icon: 5,time:1000});

          }else{
            $(obj).attr('title','启用')
            $(obj).find('i').html('&#xe601;');

            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
            layer.msg('已启用!',{icon: 5,time:1000});
          }
          
      });
  }

  /*用户-删除*/
  function member_del(obj,id){
      layer.confirm('确认要删除吗？',function(index){
          //发异步删除数据
          $.ajax({
            url:'/admin/permission/'+id,
            data:{status:status},
            dataType:'json',
            type:'DELETE',
            headers:{
              'X-CSRF-TOKEN':"{{csrf_token()}}"
            },  
            success:function(res){
                if(res.code == '1'){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
                if(res.code == '3002'){
                    layer.msg(res.msg,{icon:5})
                }
            }
          })
  
      });
  }



  function delAll (argument) {

    var data = tableCheck.getData();

    layer.confirm('确认要删除吗？'+data,function(index){
        //捉到所有被选中的，发异步进行删除
        layer.msg('删除成功', {icon: 1});
        $(".layui-form-checked").not('.header').parents('tr').remove();
    });
  }
</script>
@endsection