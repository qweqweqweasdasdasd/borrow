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
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" id="table">
                            	<div class="layui-input-inline layui-show-xs-block">
                                    <select name="status">
                                        <option value="">账单状态</option>
                                        <option value="1" @if($whereData['status'] == 1) selected @endif>申请中</option>
                                        <option value="2">已收货</option>
                                        <option value="3">已取消</option>
                                        <option value="4">已完成</option>
                                        <option value="5">已作废</option></select>
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userAccount" placeholder="会员账号" autocomplete="off" class="layui-input" value="{{$whereData['userAccount']}}">
                                </div>  

                                
							    <div class="layui-input-inline" style="width: 120px;">
							      <input type="text" name="borrow_start" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_start']}}">
							    </div>
							    -
							    <div class="layui-input-inline" style="width: 120px;">
							      <input type="text" name="borrow_end" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_end']}}">
							    </div>
							  
					
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="search">
                                       查询</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="layui-card-body">
                            <table class="layui-table layui-form">
                                <thead>

                                    <tr>  
                                        <th>ID</th>
                                        <th>会员账号</th>
                                        <th>真实姓名</th>
                                        <th>VIP名</th>
                                        <th>申请时间</th>
                                        <th>还贷时间</th>
                                        <th>借款金额</th>
                                       	<th>状态</th>
                                        <th>备注</th>
                                        <th>操作</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($bills as $v) 
                                    <tr>
                                        <td>{{$v->b_id}}</td>
                                        <td>{{$v->userAccount}}</td>
                                        <td>{{$v->userName}}</td>
                                        <td>{{$v->vipName}}</td>
                                        <td>{{$v->apply_time}}</td>
                                        <td>{{$v->repayment_time}}</td>
                                        <td>{{$v->borrow_money}}</td>
                                        <td>{!! bill_show_status($v->status) !!}</td>
                                        <td>{{$v->desc}}</td>
                                        <td class="td-manage">
                                      
                                            <a title="删除" onclick="member_del(this,'{$v->ba_id}')" href="javascript:;">
                                                <i class="layui-icon">&#xe609;</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <!-- 分页 -->          	
								{{ $bills->appends($whereData)->links() }}
                                <!-- 分页 -->
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
    layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#test10'
                ,type: 'datetime'
                ,range: '~'
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#test11'
                ,type: 'datetime'
                ,range: '~'
            });
    });

    /*laravel使用blade ajax 分页*/
    

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？',function(index) {
            //发异步删除数据

            $.ajax({
                url:'/admin/borrowapply/'+id,
                data:{status:status},
                dataType:'json',
                type:'DELETE',
                headers:{
                  'X-CSRF-TOKEN':"{csrf_token()}"
                },  
                success:function(res){
                    if(res.code == '1'){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                    if(res.code == '5000'){
                        layer.msg(res.msg,{icon:5})
                    }
                }
            })
        });
    }

</script>
@endsection