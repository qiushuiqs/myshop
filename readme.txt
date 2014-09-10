跟着燕十八老师自学PHP的进程 myshop 后台项目

一. 框架搭建
参数过滤：GET/POST（递归）
运行日志：sql出错记录 （文件处理）
报错级别：线上以及开发级别控制
数据库类：
读取配置文件：数据库信息，缓存信息，smarty信息。不能多个类都include，config.ini
模型层（model）:含有model.class父类。其他模型继承Model类
自动加载config，init 等class文件。运用魔术function __autoload($class); 
防止非法访问非controller文件。运用defined(ACC)||exit('ACC denied');
二. 后台搭建
用到无限极分类显示栏目
增add 使用MVC模式。 从表单获取数据-》后台数据检验-》调用模型的方法-》显示结果表单
Model层做继承。总类有表名，PK名，以及增删改查功能​​
删除 check不能删除有子栏目的项目（还有前台检验和数据库检验）
update check不能有闭环，父项目的parent_id指向子项目或者不能指向自身（还有前台检验和数据库检验）

备注：
checkbox,radio不选或者默认，不能以空的形式传至$_POST中。Text可以$_POST['字段名']='';方式传入
