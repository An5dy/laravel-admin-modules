<h1 align="center"> laravel-admin-modules </h1>

<p align="center"> laravel-admin-modules 用于简单地按模块来拆分基于 laravel-admin 开发的后台项目，也支持模块的按需载入。</p>

![StyleCI build status](https://github.styleci.io/repos/254318217/shield) 

## 安装
```shell
composer require an5dy/laravel-admin-modules --dev -vvv
```
> 💡 建议安装的 dev 下，正式线不需要安装。

## 使用

### 首先新建一个模块
```shell
php admin:module:make {name}
```
- **name**：模块名

#### 模块初始目录结构
```
app/{模块名}
├── Controllers
├── Models
├── Providers
│   └── {模块名}ServiceProvider.php
└── routes.php
```
- **app/{模块名}**：目录用于存放相关模块文件。
- **app/{模块名}/Controllers**：目录用于存放模块控制器文件。
- **app/{模块名}/Models**：目录用于存放模块模型文件。
- **app/{模块名}/Providers**：目录用于存放模块服务提供者文件，**{模块名}ServiceProvider.php** 文件是当前模块的 **Laravel** 服务提供者类，用于加载模块路由等功能，需手动注册到 **config/app.php** 配置文件中。
- **app/{模块名}/routes.php**：文件用于配置模块路由。

### 创建指定模块控制器类
```shell
php artisan admin:module:controller {module} {model} {--title=} {--stub= : Path to the custom stub file. } {--output}
```
- **module**：需创建控制器的模块名。
- **model**：当前模块 **Models** 目录下的模型名，可通过 **php artisan make:model App\\{模块名}\\Models\\{模型名}** 来生成。
- 其它参数与 **laravel-admin admin:make** 一致。

### 创建指定模块表单请求类
```shell
php artisan admin:module:request {module} {name}
```
- **module**：需创建表单请求类的模块名。
- **name**：表单请求类名称。

### 创建指定模块服务提供者类
```shell
php artisan admin:module:provider {module} {name}
```
- **module**：需创建服务提供者类的模块名。
- **name**：服务提供者类名称。

### 创建指定模块 **bootstrap.php** 配置文件
```shell
php artisan admin:module:bootstrap {module}
```
- **module**：需创建 **bootstrap.php** 的模块名。

#### 以上命令执行后的模块目录结构
```
app/{模块名}
├── Controllers
├── Middleware
│   └── ModuleBootstrap.php
├── Models
├── Providers
│   └── {模块名}ServiceProvider.php
├── bootstrap.php
└── routes.php
```
- **app/{模块名}/Middleware/ModuleBootstrap.php**：当前模块的 **bootstrap.php** 文件重载中间件，需配置在 {模块名}ServiceProvider.php 中，具体代码如下所示。
```php
...
use App\{模块名}\Middleware\ModuleBootstrap;

class {模块名}ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app('router')->aliasMiddleware('admin.bootstrap', ModuleBootstrap::class);
    }
    ...
}
```
- **app/{模块名}/bootstrap.php**：当前模块 bootstrap.php 文件，不受 laravel-admin 和其他模块 bootstrap.php 的影响，功能与 laravel-admin bootstrap.php 一致，具体参考[官网](https://laravel-admin.org/docs/zh/1.x/configuration#app/Admin/bootstrap.php)。

## License

MIT