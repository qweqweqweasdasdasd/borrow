@extends('wap.common.layout')
@section('content')

	<body>

		@include('wap/common/header',['data'=>$webset])

		<!-- banner -->
		@include('wap/index/banner')

		<!-- app-list -->
		@include('wap/index/applist',['data'=>$webset])		

		<!-- 搜索 -->
		@include('wap/index/sousou')

		@include('wap/common/nav')

		@include('wap/common/foot',['data'=>$webset])
	</body>
@endsection
@section('my-js')
<script type="text/javascript">
	// 搜索
	$("#findbtn").click(function() {
		var username = $("#userAccount").val();
		if (!username) {
			layer.msg('请输入用户名！', {
				icon: 2,

			})
			return;
		}
		$.ajax({
			url: '/sousou',
			data: {
				userAccount: username
			},
			type: 'post',
			dataType: 'json',
			headers:{
        		'X-CSRF-TOKEN':"{{csrf_token()}}"
        	},
			success: function(res) {
				if (res.ok == true) {
					layer.open({
						type: 2,
						skin: 'layui-layer-demo',
						area: ['600px', '600px'],
						anim: 2,
						title: "",
						shadeClose: true,
						content: '/alert?userAccount='+ username
					});
				} else {
					layer.msg(res.msg, {
						icon: 2
					})
				}
			},
			error: function(res) {
				console.log(res)
			}
		})

	})
	var mySwiper = new Swiper('.swiper-container', {
		slidesPerView: 'auto',
		loop: true,
		speed: 500,
		autoplay: {
			delay: 3500,
			disableOnInteraction: false
		},

	})
</script>
@endsection
