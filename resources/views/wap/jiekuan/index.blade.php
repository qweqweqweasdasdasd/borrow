@extends('wap/common/layout')
@section('content')
<body>
	@include('wap/common/header')
	
	@include('wap/common/nav')

	<div class="content">
		<div class="box2">
			<div class="title">
				<h5>温馨提示</h5>
			</div>
			<div class="txt-box">
				<p>
				</p>
				<p>
					提交成功5分钟后请到<span style="color:#ff0000">“信用额度查询”</span>是否借款成功！若提示借款成功，请到 {{$webset->web_name}} 登入会员账号是否成功加入，如果没有成功加款到会员账号上，请联系借呗在线客服处理！
				</p>
				<p>
				</p>
			</div>
		</div>
		<div class=" se8-top2 sr7-top2">
			<div class="top-h2">
				<h2>我要借款</h2>
			</div>
			<div class="kuan-box kuan-box2">
				<br />
				<br />
				<div id="myform">
					<div class="shu-ru fix">
						<label>会员账号：</label>
						<input type="text" id="userAccount" name="userAccount" value="" style="padding-left:10px;" placeholder="请填写会员账号">
					</div>
					<div class="shu-ru fix">
						<label>会员姓名：</label>
						<input type="text" id="userName" name="userName" style="padding-left:10px;" placeholder="请填写会员姓名">
					</div>
					<div class="shu-ru fix ">
						<label>借款金额：</label>
						<input type="text" id="amount" name="amount" style="padding-left:10px;" placeholder="请填写借款金额">
					</div>
					<div class="shu-ru fix">
						<label class="">还款日期：</label>
						<input type="text" id="hk_time" class="inline laydate-icon" name="hk_time" style="padding-right:0px;padding-left:10px;"
						 placeholder="请选择还款日期">
					</div>

					<div class="shu-ru fix">
						<label class="">&nbsp;</label>
						<input class="sub" name="" type="button" id="postbtn" value="确认提交">
					</div>
					<div class="shu-ru fix">
						<p>
							注意：提交成功5分钟后请到“信用额度查询”是否借款成功！
						</p>
					</div>
					<br />
					<br />
					<br />
				</div>
			</div>
		</div>
	</div>

	@include('wap/common/foot',['data'=>$webset])
</body>
@endsection
@section('my-js')
<script type="text/javascript" src="/wap/js/laydate.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		! function() {
			laydate.skin('molv'); //切换皮肤，请查看skins下面皮肤库
			laydate({
				elem: '#demo'
			}); //绑定元素
		}();
		$("#postbtn").click(function() {
			var userAccount = $("#userAccount").val();
			var userName = $("#userName").val();
			var amount = $("#amount").val();
			var hk_time = $("#hk_time").val();
			
			var data = {userAccount:userAccount,userName:userName,amount:amount,hk_time:hk_time}
			$.ajax({
				url:'/jiekuan/submit',
            	data:data,
            	dataType:'json',
            	type:'post',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
				success: function(res) {
					if(res.code == '1'){
            			layer.msg(res.data.msg);
            		}
	                if(res.code == '422'){
	                    layer.msg(res.msg)
	                }
	                if(res.code == '0'){
	                    layer.msg(res.msg)
	                }
					
				},
				error: function(res) {
					console.log(res)
				}
			})
		})
	})
	laydate({
		elem: '#hk_time',
		min: laydate.now(+2), //-1代表昨天，-2代表前天，以此类推
		max: laydate.now(+60),
	});
</script>
@endsection