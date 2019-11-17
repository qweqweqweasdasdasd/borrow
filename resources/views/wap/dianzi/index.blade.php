@extends('wap.common.layout')
@section('content')

	<body>

		@include('wap/common/header')

		@include('wap/common/nav')

		<div class="content">
			<div class="box3">
				<div class="title">
					<h5>电子信用额度</h5>
				</div>
				<div class="txt-box">
					<p>
					</p>
					<p>
						<span style="font-family: 微软雅黑, Arial, Helvetica, sans-serif; font-size: 15px; text-indent: 30px; white-space: normal;color:#000000">在 {{$webset->web_name}} 投注的每一笔电子游艺，有效投注将永久累计！累计有效投注越多，电子等级越高，电子信用额度越高，可借款的额度也将越多，账号交易价值也越高，账号买卖估值随之提升。具体详情如下表：</span>
					</p>
					<p>
					</p>
					<div class="box-ge">
						<table class="box3-table" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<th scope="col" width="25%">
										电子等级
									</th>
									<th scope="col" width="25%">
										周俸禄
									</th>
									<th scope="col" width="25%">
										月俸禄
									</th>
									<th scope="col" width="25%">
										电子信用额度
									</th>
								</tr>
							</tbody>
							<tbody id="deals">
								@foreach($dianzi as $v)
								<tr>
									<td width="25%">{{$v->credit_name}}</td>
									<td width="25%">{{$v->week_salary}}</td>
									<td width="25%">{{$v->month_salary}}</td>
									<td width="25%">{{$v->amount}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $dianzi->links() }}
						<!-- <div class="paging" id="page_index">
							<div class="paging_l">
								<div>
								 <span class="current">1</span>
								 <a class="num" href="/www-php4.com/20190606xpj-jiebei/index.php?s=/Wap/Index/dianzi/p/2.html">2</a>
								 <a class="num" href="/www-php4.com/20190606xpj-jiebei/index.php?s=/Wap/Index/dianzi/p/3.html">3</a>
								 <a class="next" href="/www-php4.com/20190606xpj-jiebei/index.php?s=/Wap/Index/dianzi/p/2.html">>></a>
								 <span class="rows">共 {{$dianzi->total()}} 条记录</span>
								</div>
							</div>
						<span class="rows">共 {{$dianzi->total()}} 条记录</span>
			
						</div> -->
					</div>
				</div>
			</div>
		</div>


		<!-- /主体 -->

		<!-- 底部 -->


		@include('wap/common/foot',['data'=>$webset])
	</body>
@endsection
@section('my-js')

@endsection
