# TrainCenterManageSys

该项目基于 Laravel 用于开发钉钉内部微应用

相关支持来源于 [EasyDingTalk](https://learnku.com/laravel/t/27989)

## 项目运行前提

- 配置 `.env`  数据库链接
- 运行 `composer update`

## 相关公共方法

超级管理员后台管理 - PC端 获取当前用户信息

```php
// 回调页面统一使用如下方法来获取用户信息：
$app = getApp();
$user = $app->oauth->use('app-01')->user();
```

Mobile端 获取当前用户信息

```php
$app = getApp();
$app->user->getUserByCode($code);
```

### 相应返回值



## 组织架构权限

超级管理员

- 实验室中心主任

管理员

- 借用部门负责人
- 实验室借用管理员
- 实验室中心主任
- 设备管理员

用户

- 普通用户