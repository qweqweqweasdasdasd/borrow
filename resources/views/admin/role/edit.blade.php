@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<input type="hidden" name="role_id" value="{{$role->role_id}}">
              <div class="layui-form-item">
                  <label for="role_name" class="layui-form-label">
                      <span class="x-red">*</span>角色名
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="role_name" name="role_name" required="" 
                      autocomplete="off" class="layui-input" value="{{$role->role_name}}">
                  </div>
              </div>
              <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>角色状态
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="role_status" value="1" title="启用" @if($role->role_status == 1) checked @endif>
      				      <input type="radio" name="role_status" value="2" title="停用" @if($role->role_status == 2) checked @endif>
      				   </div>
      			  </div>
              <div class="layui-form-item">
                <label class="layui-form-label">
                  <span class="x-red">*</span>选择角色
                </label>
                <div class="layui-input-block">
                  @foreach($allocationManagerData as $k => $v)
                  <input type="checkbox" name="mg_ids[]" title="{{$v->mg_name}}" lay-skin="primary" value="{{$v->mg_id}}" @if($v->mg_status == 2) disabled @endif @if(in_array($v->mg_id,$in_role_mg_id)) checked @endif>
                  @endforeach
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
      			    <label class="layui-form-label">
      			    	<span class="x-red">*</span>描述
      			    </label>
      			    <div class="layui-input-block">
      			      <textarea name="desc" placeholder="角色描述" class="layui-textarea">{{$role->desc}}</textarea>
      			    </div>
      			  </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <button  class="layui-btn" lay-filter="update" lay-submit="">
                      更新
                  </button>
              </div>
          </form>
        </div>
    </div>
   
</body>
@endsection

@section('my-js')
 <script>
    layui.use(['form', 'layer'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
            layer = layui.layer;

    //监听提交
    form.on('submit(update)',function(data) {
            //发异步，把数据提交给php
            var id = $('input[type="hidden"]').val();

            $.ajax({
            	url:'/admin/role/'+id,
            	data:data.field,
            	dataType:'json',
            	type:'PATCH',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
            			layer.alert("更新成功",{icon:6},function(){
            				//关闭当前frame
			                xadmin.close();
			                // 可以对父窗口进行刷新 
			                xadmin.father_reload();
            			})
            		}
	                if(res.code == '422'){
	                    layer.msg(res.msg,{icon:5})
	                }
	                if(res.code == '2002'){
	                    layer.msg(res.msg,{icon:5})
	                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection
