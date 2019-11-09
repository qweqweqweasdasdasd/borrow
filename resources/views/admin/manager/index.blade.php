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
                            <div class="layui-inline layui-show-xs-block">
                                <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start" value="{{$whereData['start']}}">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end" value="{{$whereData['end']}}">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="k"  placeholder="请输入管理员名" autocomplete="off" class="layui-input" value="{{$whereData['k']}}" style="width: 200px;">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                    </div>
                    <div class="layui-card-header">
                        <button class="layui-btn" onclick="xadmin.open('添加用户','/admin/manager/create',600,800,true)"><i class="layui-icon"></i>添加管理员</button>
                    </div>
                    <div class="layui-card-body ">
                        <table class="layui-table layui-form">
                          <thead>
                            <tr>
                             
                              <th>ID</th>
                              <th>管理员名</th>
                              <th>IP</th>
                              <th>邮箱</th>
                              <th>登陆次数</th>
                              <th>所属角色</th>
                              <th>最后登录时间</th>
                              <th>状态</th>
                              <th>操作</th>
                          </thead>
                          <tbody>
                            @foreach($managers as $k => $v)
                            <tr>  
                              <td>{{$v->mg_id}}</td>
                              <td>{{$v->mg_name}}</td>
                              <td>{{$v->ip}}</td>
                              <td>{{$v->email}}</td>
                              <td>{{$v->login_count}}</td>
                              <td>
                                @foreach($v->roles as $vv)
                                  <span class="layui-badge @if($vv->role_status == 1) layui-bg-green @else layui-bg-gray @endif">{{$vv->role_name}}</span>
                                @endforeach
                              </td>
                              <td>{{$v->last_login_time}}</td>
                              <td class="td-status">
                                {!! common_reset_status($v->mg_status) !!}  
                              </td>
                              <td class="td-manage">
                                
                                <a title="编辑"  onclick="xadmin.open('编辑','/admin/manager/{{$v->mg_id}}/edit',600,800,true)" href="javascript:;">
                                  <i class="layui-icon">&#xe642;</i>
                                </a>
                                <a title="删除" onclick="member_del(this,'{{$v->mg_id}}')" href="javascript:;">
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
                            {{ $managers->appends(['start'=>$whereData['start'],'end'=>$whereData['end'],'k'=>$whereData['k'] ])->links() }}
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

  /*管理员-修改状态*/
  $('.reset').on('click',function(){
      var status = $(this).attr('status');
      var id = $(this).parents('tr').find('td:eq(0)').html();

      // ajax
      $.ajax({
        url:'/admin/manager/'+id,
        data:{status:status},
        dataType:'json',
        type:'get',
        headers:{
          'X-CSRF-TOKEN':"{{csrf_token()}}"
        },  
        success:function(res){
            if(res.code == '1'){
                window.location.reload();
            }
            if(res.code == '1004'){
                layer.msg(res.msg,{icon:5})
            }
        }
      })
  });

  /*用户-删除*/
  function member_del(obj,id){
      layer.confirm('确认要删除吗？',function(index){
          var id = $(obj).parents('tr').find('td:eq(0)').html();
          //发异步删除数据
          $.ajax({
            url:'/admin/manager/'+id,
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
                if(res.code == '1006'){
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