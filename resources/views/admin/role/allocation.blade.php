@extends('admin/common/layout')

@section('content') 
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form  class="layui-form layui-form-pane">
        	<input type="hidden" name="ps_id" value="{{$role->role_id}}">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required=""
                    autocomplete="off" class="layui-input" value="{{$role->role_name}}" readonly>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有权限
                </label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                    	@foreach($permission_i as $v)
                        <tr>
                            <td>
                                <input type="checkbox" name="ps_ids[]" lay-skin="primary" lay-filter="father" title="{{$v->ps_name}}" value="{{$v->ps_id}}" @if(in_array($v->ps_id,$in_role_permission_id)) checked @endif>
                            </td>
                            <td>
                                <div class="layui-input-block">
                                   	@foreach($permission_ii as $vv)
                                	  @if($vv->pid == $v->ps_id)
                                    <input name="ps_ids[]" lay-skin="primary" type="checkbox" title="{{$vv->ps_name}}" value="{{$vv->ps_id}}" @if(in_array($vv->ps_id,$in_role_permission_id)) checked @endif> 
                                   	@endif
                                   	@endforeach
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button class="layui-btn" lay-submit="" lay-filter="update">更新</button>
          </div>
        </form>
    </div>
</div>
</body>
@endsection

@section('my-js')
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
      var form = layui.form
      ,layer = layui.layer;

      //监听提交
      form.on('submit(update)', function(data){

        //发异步，把数据提交给php
        layer.alert("更新操作", {icon: 6},function () {
            var id = $('input[type="hidden"]').val();
       		
       		// ajax
       		$.ajax({
       			url:'/admin/role/allocation/'+id,
       			data:data.field,
       			dataType:'json',
       			type:'post',
       			headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
       			success:function(res){
       				if(res.code == '1'){
          				  //关闭当前frame
		                xadmin.close();
		                // 可以对父窗口进行刷新 
		                xadmin.father_reload();
            		  }
	                if(res.code == '422'){
	                    layer.msg(res.msg,{icon:5})
	                }
	                if(res.code == '3003'){
	                    layer.msg(res.msg,{icon:5})
	                }
       			}
       		})
        });
        return false;
      });


    form.on('checkbox(father)', function(data){

        if(data.elem.checked){
            $(data.elem).parent().siblings('td').find('input').prop("checked", true);
            form.render(); 
        }else{
           $(data.elem).parent().siblings('td').find('input').prop("checked", false);
            form.render();  
        }
    });
      
      
    });
</script>
@endsection