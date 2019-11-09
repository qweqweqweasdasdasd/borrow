@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
             <div class="layui-form-item">
      			    <label class="layui-form-label">父级权限</label>
      			    <div class="layui-input-block">
      			      <select name="pid" lay-verify="required">
      			        <option value="0">\</option>
      			        @foreach($psTree as $k => $v)
                    <option value="{{$v['ps_id']}}">{{$v['ps_name_item']}}</option>
                    @endforeach
      			      </select>
      			    </div>
      			  </div>
              <div class="layui-form-item">
                  <label for="ps_name" class="layui-form-label">
                      <span class="x-red">*</span>权限名称
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="ps_name" name="ps_name" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="route" class="layui-form-label">
                      <span class="x-red">*</span>路由
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="route" name="route" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
               <div class="layui-form-item">
                  <label for="ps_c" class="layui-form-label">
                      <span class="x-red">*</span>控制器
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="ps_c" name="ps_c" required=""
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="ps_a" class="layui-form-label">
                      <span class="x-red">*</span>方法
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="ps_a" name="ps_a" required=""
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              
              <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>是否显示
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="is_show" value="1" title="显示" checked>
      				      <input type="radio" name="is_show" value="2" title="隐藏" >
      				   </div>
      			  </div>
      			  <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>是否验证
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="is_verfy" value="1" title="验证" checked>
      				      <input type="radio" name="is_verfy" value="2" title="不验证" >
      				   </div>
      			  </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <button  class="layui-btn" lay-filter="add" lay-submit="">
                      保存
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
    form.on('submit(add)',function(data) {
            //发异步，把数据提交给php

            $.ajax({
            	url:'/admin/permission',
            	data:data.field,
            	dataType:'json',
            	type:'post',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
            			layer.alert("添加成功",{icon:6},function(){
            				//关闭当前frame
			                xadmin.close();
			                // 可以对父窗口进行刷新 
			                xadmin.father_reload();
            			})
            		}
                if(res.code == '422'){
                    layer.msg(res.msg,{icon:5})
                }
                if(res.code == '3000'){
                    layer.msg(res.msg,{icon:5})
                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection
