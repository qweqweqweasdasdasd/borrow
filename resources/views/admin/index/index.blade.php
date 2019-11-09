@extends('admin.common.layout')

@section('content')
<body class="index">
    <!-- 顶部开始 -->
   	@include('admin.common.container')
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
   	@include('admin.common.left-nav')
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
   	@include('admin.common.page-content')
</body>
@endsection