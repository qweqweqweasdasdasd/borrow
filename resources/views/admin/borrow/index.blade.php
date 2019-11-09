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
                         		<div class="layui-inline">
								    <label class="layui-form-label">会员账号</label>
								    <div class="layui-input-inline" style="width: 250px;">
								      <input type="text" name="nickname" placeholder="会员账号" autocomplete="off" class="layui-input" value="{{$whereData['nickname']}}">
								    </div>   
							  	</div>   
                                <div class="layui-inline">
								    <label class="layui-form-label">真实姓名</label>
								    <div class="layui-input-inline" style="width: 250px;">
								      <input type="text" name="u_name" placeholder="真实姓名" autocomplete="off" class="layui-input" value="{{$whereData['u_name']}}">
								    </div>   
							  	</div>
                                <div class="layui-inline">
								    <label class="layui-form-label">申请时间</label>
								    <div class="layui-input-inline" style="width: 250px;">
                                       <input type="text" name="apply_time" class="layui-input" id="test10" placeholder=" 申请时间" value="{{$whereData['apply_time']}}">
								    </div>   
							  	</div>
                                <div class="layui-inline">
								    <label class="layui-form-label">还款时间</label>
								    <div class="layui-input-inline" style="width: 250px;">
								      <input type="text" name="repayment_time" placeholder="还款时间" autocomplete="off" class="layui-input" id="test11" value="{{$whereData['repayment_time']}}">

								    </div>
							  	</div>
                                <div class="layui-inline">
								    <label class="layui-form-label">借款总额</label>
								    <div class="layui-input-inline" style="width: 120px;">
								      <input type="text" name="borrow_start" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_start']}}">
								    </div>
								    -
								    <div class="layui-input-inline" style="width: 120px;">
								      <input type="text" name="borrow_end" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_end']}}">
								    </div>
							  	</div>
							  	<div class="layui-inline">
								    <label class="layui-form-label">还款总额</label>
								    <div class="layui-input-inline" style="width: 120px;">
								      <input type="text" name="repayment_start" placeholder="还款总额" autocomplete="off" class="layui-input" value="{{$whereData['repayment_start']}}">
								    </div>
								    -
								    <div class="layui-input-inline" style="width: 120px;">
								      <input type="text" name="repayment_end" placeholder="还款总额" autocomplete="off" class="layui-input" value="{{$whereData['repayment_end']}}">
								    </div>
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
                                        <th>我的余额</th>
                                        <th>申请时间</th>
                                        <th>还贷时间</th>
                                        <th>借款总额</th>
                                        <th>还款总额</th>
                                        <th>欠款</th>
                                        <th>借款笔数</th>
                                        <th>操作</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($borrowApply as $v) 
                                    <tr>
                                        <td>{{$v->ba_id}}</td>
                                        <td>username</td>
                                        <td>{{$v->u_name}}</td>
                                        <td>{{$v->me_limit}}</td>
                                        <td>{{$v->apply_time}}</td>
                                        <td>{{$v->repayment_time}}</td>
                                        <td>{{$v->borrow_total_money}}</td>
                                        <td>{{$v->repayment_total_money}}</td>
                                        <td><span style="color:#F00">{{$v->arrearage}}</span></td>
                                        <td>{{$v->total_count}}</td>
                                        <td class="td-manage">
                                            <a title="更新vip" onclick="xadmin.open('更新vip','order-view.html')" href="javascript:;">
                                                <i class="layui-icon">&#xe615;</i></a>
                                            <a title="删除" onclick="member_del(this,'{{$v->ba_id}}')" href="javascript:;">
                                                <i class="layui-icon">&#xe640;</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <!-- 分页 -->
                                {{ $borrowApply->appends(array_except($whereData,['apply_time','repayment_time']))->links() }}
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
                  'X-CSRF-TOKEN':"{{csrf_token()}}"
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