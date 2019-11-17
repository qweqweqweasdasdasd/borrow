@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<input type="hidden" name="c_id" value="{{$credit->c_id}}">	
        	 <div class="layui-form-item">
  			    <label class="layui-form-label">分类</label>
  			    <div class="layui-input-block" style="width:200px;">
  			      <select name="cate_id" lay-verify="required">
  			        <option value="1" @if($credit->cate_id == 1) selected @endif>电子信用</option>
  			        <option value="2" @if($credit->cate_id == 2) selected @endif>真人信用</option>
  			      </select>
  			    </div>
  			  </div>
              <div class="layui-form-item">
                  <label for="credit_name" class="layui-form-label">
                      <span class="x-red">*</span>等级名称
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="credit_name" name="credit_name" required="" 
                      autocomplete="off" class="layui-input" style="width:200px;" value="{{$credit['credit_name']}}">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="week_salary" class="layui-form-label">
                      <span class="x-red">*</span>周俸禄
                  </label>
                  <div class="layui-input-block">
                      <input type="number" id="week_salary" name="week_salary" required="" 
                      autocomplete="off" class="layui-input" style="width:200px;" value="{{$credit['week_salary']}}">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="month_salary" class="layui-form-label">
                      <span class="x-red">*</span>月俸禄
                  </label>
                  <div class="layui-input-block">
                      <input type="number" id="month_salary" name="month_salary" required="" 
                      autocomplete="off" class="layui-input" style="width:200px;" value="{{$credit['month_salary']}}">
                  </div>
              </div>
             <div class="layui-form-item">
                  <label for="amount" class="layui-form-label">
                      <span class="x-red">*</span>信用额度
                  </label>
                  <div class="layui-input-block">
                      <input type="number" id="amount" name="amount" required="" 
                      autocomplete="off" class="layui-input" style="width:200px;" value="{{$credit['amount']}}">
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
            	url:'/admin/credit/'+ id,
            	data:data.field,
            	dataType:'json',
            	type:'PATCH',
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
	                if(res.code == '9001'){
	                    layer.msg(res.msg,{icon:5})
	                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection
