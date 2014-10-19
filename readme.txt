自学PHP,myshop 后台项目



一. 框架搭建
参数过滤：GET/POST（递归）
运行日志：sql出错记录 （文件处理）
报错级别：线上以及开发级别控制
数据库类：
读取配置文件：数据库信息，缓存信息，smarty信息。不能多个类都include，config.ini
模型层（model）:含有model.class父类。其他模型继承Model类
自动加载config，init 等class文件。运用魔术function __autoload($class); 
防止非法访问非controller文件。运用defined(ACC)||exit('ACC denied');
辅助类： 文件上传类，图片类，分页类，购物车类。
二. 后台搭建
用到无限极分类显示栏目
增add 使用MVC模式。 从表单获取数据-》后台数据检验-》调用模型的方法-》显示结果表单
Model层做继承。总类有表名，PK名，以及增删改查功能
删除 check不能删除有子栏目的项目（还有前台检验和数据库检验）
update check不能有闭环，父项目的parent_id指向子项目或者不能指向自身（还有前台检验和数据库检验）
自动过滤：按数据库表的字段名格式化请求数组。自动填充：将表单中未提交的字段以默认值的形式加入数据库
helper类建设：包括文件上传类
文件上传实质：a.服务器上有图片文件 b.数据库插入文件地址
购物车类： session+单例 因为购物车类定位为全局对象并且具有唯一性。也可以用SESSION+db(考虑中)
订单model以及订单商品关联model
分页类-》保存地址栏的参数来分析。$url = _SERVER['REQUEST_URI']和parse_url($url),parse_str($url['query'],array())和http_build_query(array())
三：前台
用户登陆：验证用户名，密码匹配，同意协议等
浏览历史功能，用cookie来做
用session做用户登入保留用户信息的功能
记住用户名功能 用cookie来做
header和footer页面分离。
商城首页，栏目页，商品页的完善。
购物车页面-》订单页面。并且订单生成后，清空购物车以及减少商品库存。
四：API
百度Uedit. 
引入编辑器，
个性化整合

备注：
checkbox,radio不选或者默认，不能以空的形式传至$_POST中。Text可以$_POST['字段名']='';方式传入
尽量少用delete：尤其是商品。会有以下影响：1. 影响数据完整性 2.影响搜索效率，影响索引。
中文验证码会从几百到几千个常用汉字来作为random调用的源。
md5加密后无论多长多短，加密后都是char(32)

需求：
RBAC 后台管理员权限管理