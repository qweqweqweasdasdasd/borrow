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
                    <div class="layui-card-body">
                        <form class="layui-form layui-col-space5">
                            <div class="layui-input-inline layui-show-xs-block">
                                  <select name="cate_id">
                                      <option value="0">选择信用额度</option>
                                      <option value="1" @if($whereData['cate_id'] == 1) selected @endif>电子信用额度</option>
                                      <option value="2" @if($whereData['cate_id'] == 2) selected @endif>真人信用额度</option>
                                  </select>
                              </div>
                              <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="search">
                                       查询</button>
                              </div>
                        </form>
                    </div>
                    <div class="layui-card-header">
                        <button class="layui-btn" onclick="xadmin.open('添加信用','/admin/credit/create',600,800,true)"><i class="layui-icon"></i>添加信用</button>
                    </div>
                    <div class="layui-card-body ">
                        <table class="layui-table layui-form">
                          <thead>
                            <tr>
                             
                              <th>ID</th>
                              <th>类别</th>
                              <th>信用等级</th>
                              <th>周俸禄</th>
                              <th>月俸禄</th>
                              <th>额度</th>
                              <th>操作</th>
                          </thead>
                          <tbody>
                            @foreach($credits as $k => $v)
                            <tr>
                              <td>{{$v->c_id}}</td>
                              <td>{{show_credit_cate($v->cate_id)}}</td>
                              <td>{{$v->credit_name}}</td>
                              <td>{{$v->week_salary}}</td>
                              <td>{{$v->month_salary}}</td>
                              <td>{{$v->amount}}</td>
                              <td class="td-manage">
                               
                                <a title="编辑"  onclick="xadmin.open('编辑','/admin/credit/{{$v->c_id}}/edit',600,800,true)" href="javascript:;">
                                  <i class="layui-icon">&#xe642;</i>
                                </a>
                                <a title="删除" onclick="member_del(this,'{{$v->c_id}}')" href="javascript:;">
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
                          {{ $credits->appends($whereData)->links() }}
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

  /*角色-修改状态*/
  $('.reset').on('click',function(){
      var status = $(this).attr('status');
      var id = $(this).parents('tr').find('td:eq(0)').html();

      // ajax
      $.ajax({
        url:'/admin/role/'+id,
        data:{status:status},
        dataType:'json',
        type:'get',
        headers:{
          'X-CSRF-TOKEN':"{csrf_token()}"
        },  
        success:function(res){
            if(res.code == '1'){
                window.location.reload();
            }
            if(res.code == '2001'){
                layer.msg(res.msg,{icon:5})
            }
        }
      })
  });

  /*用户-删除*/
  function member_del(obj,id){
      layer.confirm('确认要删除吗？',function(index){
          //发异步删除数据
          var id = $(obj).parents('tr').find('td:eq(0)').html();
          //发异步删除数据
          $.ajax({
            url:'/admin/credit/'+id,
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
                if(res.code == '9002'){
                    layer.msg(res.msg,{icon:5})
                }
            }
          })
      });
  }

</script>
@endsection
