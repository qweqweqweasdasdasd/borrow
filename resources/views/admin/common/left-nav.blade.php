<-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
           <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="会员管理">&#xe6b8;</i>
                    <cite>会员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('会员列表','/admin/member')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表</cite></a>
                    </li>
                </ul>
            </li>
             <li>
                <a href="javascript:;">
                    <i class="layui-icon" lay-tips="借呗管理">&#xe659;</i>
                    <cite>借呗管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('借款总览','/admin/pandect')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>借款总览</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('详情账单','/admin/bill')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>详情账单</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('还款列表','/admin/hkbill')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>还款列表</cite></a>
                    </li>
                   <!--  <li>
                        <a onclick="xadmin.add_tab('逾期未还','order-list1.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>逾期未还</cite></a>
                    </li> -->
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="VIP管理">&#xe735;</i>
                    <cite>VIP管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('vip列表','/admin/vip')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>vip列表</cite></a>
                    </li>
                </ul>
            </li>
           <!--  <li>
                <a href="javascript:;">
                    <i class="layui-icon" lay-tips="前台管理">&#xe638;</i>
                    <cite>栏目管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('多级分类','cate.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>多级分类</cite></a>
                    </li>
                </ul>
            </li> -->
             <li>
                <a href="javascript:;">
                    <i class="layui-icon" lay-tips="令牌管理">&#xe631;</i>
                    <cite>令牌管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('重置令牌','/admin/platform/token')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>重置令牌</cite></a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="RBAC">&#xe726;</i>
                    <cite>RBAC</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('管理员列表','/admin/manager')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('角色管理','/admin/role')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite></a>
                    </li>
                   <!--  <li>
                        <a onclick="xadmin.add_tab('权限分类','admin-cate.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限分类</cite></a>
                    </li> -->
                    <li>
                        <a onclick="xadmin.add_tab('权限管理','/admin/permission')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite></a>
                    </li>
                </ul>
            </li>
           <!--  <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="系统统计">&#xe6ce;</i>
                    <cite>系统统计</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('拆线图','echarts1.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>拆线图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('拆线图','echarts2.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>拆线图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('地图','echarts3.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>地图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('饼图','echarts4.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>饼图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('雷达图','echarts5.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>雷达图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('k线图','echarts6.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>k线图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('热力图','echarts7.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>热力图</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('仪表图','echarts8.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>仪表图</cite></a>
                    </li>
                </ul>
            </li> -->
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="系统管理">&#xe6b4;</i>
                    <cite>系统管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('信用额度','/admin/credit')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>信用额度</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('网站设置','/admin/webset/1')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>网站设置</cite></a>
                    </li>
                </ul>
            </li>
           <!--  <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="其它页面">&#xe6b4;</i>
                    <cite>其它页面</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="login.html" target="_blank">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>登录页面</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('错误页面','error.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>错误页面</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('示例页面','demo.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>示例页面</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('更新日志','log.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>更新日志</cite></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="第三方组件">&#xe6b4;</i>
                    <cite>layui第三方组件</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('滑块验证','https://fly.layui.com/extend/sliderVerify/')" target="">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>滑块验证</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('富文本编辑器','https://fly.layui.com/extend/layedit/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>富文本编辑器</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('eleTree 树组件','https://fly.layui.com/extend/eleTree/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>eleTree 树组件</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('图片截取','https://fly.layui.com/extend/croppers/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>图片截取</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('formSelects 4.x 多选框','https://fly.layui.com/extend/formSelects/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>formSelects 4.x 多选框</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('Magnifier 放大镜','https://fly.layui.com/extend/Magnifier/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Magnifier 放大镜</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('notice 通知控件','https://fly.layui.com/extend/notice/')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>notice 通知控件</cite></a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>
<!-- 左侧菜单结束