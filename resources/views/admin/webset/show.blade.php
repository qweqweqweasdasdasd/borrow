@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
             <form class="layui-form layui-form-pane" action="">
              <div class="layui-form-item">
		          <label class="layui-form-label">网站名称</label>
		          <div class="layui-input-block" style="width:300px">
		            <input type="text" name="web_name" required="" lay-verify="required"  value="{{$webset->web_name}}" autocomplete="off" class="layui-input">
		          </div>
        	  </div>

              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目一</label>
                  <div class="layui-input-inline">
                    <input type="text" name="web_index_name" autocomplete="off" class="layui-input" value="{{$webset->web_index_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="web_index_url" autocomplete="off" class="layui-input" value="{{$webset->web_index_url}}">
                  </div>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目二</label>
                  <div class="layui-input-inline">
                    <input type="text" name="dianzi_name" autocomplete="off" class="layui-input" value="{{$webset->dianzi_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="dianzi_url" autocomplete="off" class="layui-input" value="{{$webset->dianzi_url}}">
                  </div>
                </div>
              </div>

              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目三</label>
                  <div class="layui-input-inline">
                    <input type="text" name="zhenren_name" autocomplete="off" class="layui-input" value="{{$webset->zhenren_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="zhenren_url" autocomplete="off" class="layui-input" value="{{$webset->zhenren_url}}">
                  </div>
                </div>
              </div>
              
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目四</label>
                  <div class="layui-input-inline">
                    <input type="text" name="app_load" autocomplete="off" class="layui-input" value="{{$webset->app_load}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="app_url" autocomplete="off" class="layui-input" value="{{$webset->app_url}}">
                  </div>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目五</label>
                  <div class="layui-input-inline">
                    <input type="text" name="diandai_name" autocomplete="off" class="layui-input" value="{{$webset->diandai_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="diandai_url" autocomplete="off" class="layui-input" value="{{$webset->diandai_url}}">
                  </div>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目六</label>
                  <div class="layui-input-inline">
                    <input type="text" name="youhui_name" autocomplete="off" class="layui-input" value="{{$webset->youhui_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="youhui_url" autocomplete="off" class="layui-input" value="{{$webset->youhui_url}}">
                  </div>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">栏目七</label>
                  <div class="layui-input-inline">
                    <input type="text" name="kefu_name" autocomplete="off" class="layui-input" value="{{$webset->kefu_name}}">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">地址</label>
                  <div class="layui-input-inline">
                    <input type="text" name="kefu_url" autocomplete="off" class="layui-input" value="{{$webset->kefu_url}}">
                  </div>
                </div>
              </div>
              <div class="layui-form-item layui-form-text"  style="width: 700px;">
		          <label class="layui-form-label">滚动信息</label>
		          <div class="layui-input-block">
		            <textarea placeholder="请输入滚动信息" name="desc" class="layui-textarea">{{$webset->desc}}</textarea>
		          </div>
		        </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit="" lay-filter="update">确认更新</button>
                </div>
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

            $.ajax({
            	url:'/admin/webset/1',
            	data:data.field,
            	dataType:'json',
            	type:'PATCH',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
            			layer.alert("更新成功",{icon:6},function(){
            				location.reload()
            			})
            		}
                if(res.code == '422'){
                    layer.msg(res.msg,{icon:5})
                }
                if(res.code == '7000'){
                    layer.msg(res.msg,{icon:5})
                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection
