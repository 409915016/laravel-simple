![laravel](https://laravel.com/assets/img/components/logo-laravel.svg)




几个月前，作为前端开发者，尝试用 koa2(Node.js) 开发项目，不用过多在意语法语，数据库操作基于 LeanCloud，功能简单，开发难度较低。但 koa2 自身功能集成不高，常用功能需安装各种中间件和社区包得到支持。

PHP 作为 Web开发的热门语言，可以全球说过半数网站都使用了它。 Laravel 作为优雅的 PHP 框架，一直有所耳闻。近些日子阅读了社区翻译的文档，逐渐上手了如何使用这款优质的开源后端框架。

---

# 起步

## 开发环境

在这之前需要一套开发的基础环境，至少包括：

- PHP 及它的包管理工具 Composer
- HTTP 服务器 Nginx
- 关系型数据库 MySQL 

这里我用的是 [PhpStudy  Windows 2016 版本](https://www.xp.cn/wenda/407.html) ，当然你也可以自行搭建。

---

## 创建新项目

传统的方式是从 Git 仓库中克隆到本地。像前端 Vue CLI 一样，优雅的 Laravel 也有自家的手脚架，可快速地创建新项目.

使用 composer 命令安装一个全局安装器：

```cmd
composer global require laravel/installer
```

当前路径下创建新项目:

```cmd
laravel new laravel-project
```

---

## 项目配置

### HTTP 服务器 

> [重装后恢复 phpstudy 提供的开发环境](https://misaka.im/index.php/archives/49/)


### 环境变量文件 .env

独立的环境配置文件，在这里可以修改数据库驱动，与线上环境区分开。
连接本地的 MySQL 服务：

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

> [Windows 下更新 MySQL 至 5.7.22]( https://misaka.im/index.php/archives/20/)



## Artisan 命令行

学习编程的前期，我们还在手动创建源文件。 Laravel 命令行工具带来了一套全新的操作，创建模型、控制器、数据库种子文件，并将有关的功能关联起来，省去了手动新建重命名文件的麻烦。
而在后面会用到更多类似的命令：

创建 `TestController` 的控制器：

```cmd
php artisan make:controller TestController 
// will be created TestController.pnp in /app/Http/Controllers
```
创建 `Test` 的模型，和对应的数据库迁移文件：

```cmd
php artisan make:model Test -m
```

---

# 入门

一些必不可少的功能被抽象成路由、模板、表单验证等 API 提供给开发者实用，其互相独立又不可分割，组成了现今 Web 后端框架的基础功能。

## 路由

Nginx 将浏览器请求的 [URL](https://zh.wikipedia.org/wiki/%E7%BB%9F%E4%B8%80%E8%B5%84%E6%BA%90%E5%AE%9A%E4%BD%8D%E7%AC%A6) 转发到 Laravel 里，这样就能针对不同的路径和查询参数，处理结果给客户端。

默认的路由声明位于 `/routes` 文件夹中，`routes/web.php` 中约定了由模板渲染的路由结果：

```php
Route::view('contact', 'contact.create');
```

`view()` 函数渲染 `resources/views/contact/create.blade.php` 模板文件得到 HTML 格式的文档，最后返回给浏览器。

当系统功能过多，路由文件就变得冗余，不妨将资源约定成 [RESTFul 风格](http://www.ruanyifeng.com/blog/2018/10/restful-api-best-practices.html)，Laravel 将自动将其解析成若干个路由：

```php
Route::resource('customers', 'CustomersController');
```

HTTP Method      | URI                  | Aciton       | Route name
----------|-----------------------|--------------|---------------------
GET       | `/customers`              | index        | customers.index
GET       | `/customers/create`       | create       | customers.create
POST      | `/customers`              | store        | customers.store
GET       | `/customers/{id}`      | show         | customers.show
GET       | `/customers/{id}/edit` | edit         | customers.edit
PUT/PATCH | `/customers/{id}`      | update       | customers.update
DELETE    | `/customers/{id}`      | destroy      | customers.destroy

---

## 控制器

我们可以在路由文件中处理所有的请求逻辑，随着时间的推移，路由会变得十分拥挤。


```php
Route::get('test', function (){
	return 'hello world!';
});
```

一般控制器文件约定被存放在 `app/Http/Controllers`目录中。

同样，使用 Artisan 助手创建控制器文件：

```cmd
php artisan make:controller CustomersController 
```

将逻辑代码迁移到控制器中：

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index() {
	    $customers = [
		    'John Doe',
		    'Jane Doe',
		    'Bob The Builder',
	    ];

	    return view('internals.customers',[
		    'customers' => $customers
	    ]);
    }
}
```

```php
Route::get('customers', 'CustomersController@index')
    ->name('customers.index');
```

当 GET 请求与路由 URI 匹配，`CustomersController` 控制器中的 `index` 方法将会被执行，将数据渲染到对应的视图。



> `Customers` 控制器继承框架提供的 `Controller` 基类，这样可以使用 Laravel 提供的控制器功能。

---

## 表单验证

有段时间，我在编写前端代码，使用了若干个流程控制语句 `if` 来判断用户输入的内容是否为空，是否符合正则或其他格式，最终达到表单校验的需求。

在控制器中我们可以渲染对应的视图，也可获取从客户端发来的 HTTP 请求，一般称为表单数据。

如上一小节所说，继承了 `Controller` 控制器基类的 `BooksController`，它提供了一系列方法去验证请求：

```cmd
php artisan make:controller BooksController -m -r
```

同样，在路由文件声明到达控制器的路径和方法：

```php
Route::post('books', 'BooksController@store');
```

除了控制器，还需要使用 **模型** 与数据库建立关系，并创建数据库迁移文件：

```cmd
php artisan make:model Book -m
```

Book 模型配置 `$guarded` 属性类似于黑名单机制，经过 **模型**  过滤后再写入数据库

```php
//app/Book.php
protected $guarded = [];
```

> *较难理解的是 MVC 模型在经典模式下的存在价值。*
> *网路请求经由 Nginx 转发到 PHP-FPM ，被框架路由过滤，执行控制器内对应的函数，查询数据表，将结果同步回调到页面渲染函数，返回页面给客户端。*
> ![laravel](https://images0.cnblogs.com/blog/191097/201307/17143535-5195579a0fa54d5bb472a5138a4a26a3.png)

**数据库迁移文件**替代了我们手动在数据库中添加字段，改变结构。创建关于 `Books` 表的字段描述，书名和作者：

```php
//database/migrations/2019_09_26_152922_create_books_table.php
class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('author');
            $table->timestamps();
        });
    }
}

```

别忘了创建完后刷新数据表：

```cmd
php artisan migrate
```

同时，为了不让复杂的验证逻辑堆积在 `Controller` 中，创建一个 `StoreCustomer` **表单请求**类来处理：

```cmd
php artisan make:request StoreBook
```

### 验证规则

对于表单校检验证规则，Laravel 提供了非常详尽的验证规则，配置 `rules` 函数返回它们：

- `title` `author` 为必填项，
- 当 `type` 项为 `ebook` 时 `file` 项为必填

```php
class StoreBook extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
	        'title'  => 'required|min:3',
	        'author' => 'required',
	        'type'   => '',
	        'file'   => 'required_if:type,ebook'
        ];
    }
    
    public function messages()
	{
		return [
			'title.required'   => 'A title is required',
			'author.required'  => 'A author is required',
		];
	}
}
```
校验失败时，可知自定义 `messages` 函数返回字段提示信息，默认情况下也有提示。

将表单校检分离至 `Requests/StoreBook.php`，无需在控制器中写任何验证逻辑。

当数据验证成功后，即可操作 **Book 模型** 内的 **Eloquent ORM** API ，完成数据记录。

使用 `Book` 模型的 `create` 方法，将数据新增到数据库中：

```php
class BooksController extends Controller
{
	public function store(StoreBook $request)
	{
        $book = Book::create($request ->validated());

        return response()->json(['code' => '200', 'msg'=> 'ok']);
	}
	
}
```

使用 Postman 发出 POST 请求，请求内容为 `{ "title": "CSAPP": "author": "Randal E.Bryant"}` 。返回结果：

```json
{
    "code": "200",
    "msg": "ok"
}
```

显然请求通过了 `rules()` 校验，将内容经过直接 `protected $guarded` 过滤，再使用 **ORM**  API 写入 `books` 数据表，返回 `ok` 。


### 错误处理

那提交的内容不符合规则呢？把校验器错误收集起来，经 JSON 格式化后返回给客户端。

在 `Requests/StoreBook.php` 创建 `failedValidation` 函数，优化验证失败的返回结果：

```php
//app/Http/Requests/StoreBook.php

protected function failedValidation(Validator $validator)
{

	$data = [
		'code' => 422,
		'msg'  => $validator->errors()->first(),
	];
	
	$response = new Response(json_encode($data), 422);
	throw (new ValidationException($validator, $response))
		->errorBag($this->errorBag)
		->redirectTo($this->getRedirectUrl());
}

```

当 title 字段少于 3个英文字符：

```json
{
    "code": 422,
    "msg": "The title must be at least 3 characters."
}
```

当 type 字段为 ebook 时，没有提交 file 字段：

```json
{
    "code": 422,
    "msg": "The file field is required when type is ebook."
}
```

Laravel **Validator** 实例支持非常多验证规则，从常规格式到业务逻辑，复杂规则可以使用 `Illuminate\Validation\Rule` 类来构造规则，好处在于不用手动地编写验证函数或规则字符串。如图片的尺寸比：

```php
use Illuminate\Validation\Rule;

Validator::make($data, [
    //'avatar' => 'dimensions:ratio=3/2' 
    'avatar' => [
        'required',
        Rule::dimensions()->maxWidth(1000)->maxHeight(500)->ratio(3 / 2),
    ],
]);
```

*在不熟悉框架的前提下，虽有强大的校检规则，部分开发者仍会通过自行编写的校检函数来解决问题。随着时间推移，加大了后期代码维护难度。所以在大型项目中，代码审核显得尤为重要，保证了项目的良性发展。*

---

## HTTP 单元测试

刚入门的开发者，使用各种软件来制造 HTTP 请求，并观察编写的函数是否正常输出。

就像上面的表单校验往往需要调试数次，面对堆积如山的需求时，调试难以保证产出率。如果可以使用编程方式，按照需求编写若干完整请求和结果验证器，便事半功倍。

Laravel 结合了 PHPUnit 并提供一些便利的辅助函数，能很好地编写测试用例，比如上一节 `Books` 接口。

别忘了修改测试功能的配置文件 `phpunit.xml`。使用 `laravel_test` 数据库，这样能避免与开发数据库内容冲突：

```xml
<php>
    <server name="TELESCOPE_ENABLED" value="false"/>
    <server name="DB_CONNECTION" value="mysql"/>
    <server name="DB_DATABASE" value="laravel_test"/>
</php>
```

同样，创建测试文件 `php artisan make:test BooksTest`，并填充一些基本的表单数据：

```php
class BooksTest extends TestCase
{
    private function data()
	{
		return [
			'title' => 'Test book title',
			'author' => 'Test author',
		];
	}
}
```

TestCase 类提供了测试 JSON 的函数，用来发出 HTTP 请求，配合 `assert` 断言方法，判断请求结果是否符合预期，
比如提交 `title` `author` 字段，正常情况下 Laravel 会返回 `200` 响应头和对应的 JSON：

```php
public function test_a_book_can_be_added_through_post()
{
	$response = $this->json('POST', '/books', $this->data());
	$response
		->assertStatus(200)
		->assertJson([
			'code' => '200'
		]);
}
```

进入项目根目录，敲入：

```cmd
.\vendor\bin\phpunit --filter test_a_book_can_be_added_through_post

.                                                                   1 / 1 (100%)

Time: 316 ms, Memory: 16.00 MB

OK (1 test, 2 assertions)
```

进入 `laravel_test` 数据库，查询 `books` 表所有内容：

```cmd
mysql> SELECT * FROM books;
+----+-----------------+-------------+---------------------+---------------------+
| id | title           | author      | created_at          | updated_at          |
+----+-----------------+-------------+---------------------+---------------------+
|  1 | Test book title | Test author | 2019-09-29 08:52:26 | 2019-09-29 08:52:26 |
+----+-----------------+-------------+---------------------+---------------------+
1 rows in set (0.00 sec)
```

假如提交 `title` 字段缺失，我们可以建立这样的测试案例：

```php
public function test_a_title_is_required()
{
	$response = $this->json('POST', '/books', array_merge($this->data(), ['title' => '']) );

	$response
		->assertStatus(422)
		->assertJson([
			'code' => '422'
		]);
}
```

断言返回的 `JSON` 含有 `code: 422` 内容，切响应头的状态为 `422`。

还有当 `type` 项为 `ebook` 时 `file` 项为必填，可以这么编写：

```php
public function test_the_file_field_is_required_when_type_is_ebook()
{
	$response = $this->json('POST', '/books', array_merge($this->data(),[
		'title'  => '123',
		'author' => '123',
		'type'   => 'ebook'
	]));
	$response
		->assertStatus(422)
		->assertJson([
			'code' => '422'
		]);
}
```

HTTP 单元测试的颗粒度根据项目内测试压力进行调整，如果前端、测试人员充足，保证表单校验和业务流程。

---

## 模板引擎（视图）

它支撑了页面渲染，在修改 blade 文件后编译并缓存起来。如多数前端框架的视图层一样，具有模板继承、扩展、逻辑判断等基础功能。

在前端框架突飞猛进地时代，Laravel 的模板引擎 Blade ，它提供更多后端逻辑功能，使得后端无需转向前后分离的协作模式，也能轻易地实现提交表单、权限控制、布局组件化。

下面展示了典型 Blade 内容：

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('nav')

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
```

就像 Vue 一样，在双重 `{{ }}` 花括号内可以使用表达式，通过编译后最终得到 PHP 文件，缓存在 `storage/framework/views` 目录。

需要注意常用指令的使用方法：

`@include` 引入其他模板文件，常用来插入其他一些 HTML 片段

`@section` 常以 `@show` `@stop` `@overwrite` `@append` 指令来结束， 不建议使用已废弃的 `@endsection` 。

`@section` 与 `@yield` 都是在**母版中定义**可替代的区块，在**子模板中使用** `@section` 来扩展区块时，表现并不相同；

#### @yield

@yield 并**不能扩展**原来有母版中的内容，使用 `@parent` 关键字也不能让原有的内容与扩展内容并存

`@yield('title', '默认标题')`

出现在母版中，第二个参数为默认值。

子模板使用：

```php
@extends('master')

@section('title')
    @parent
    新的标题
@stop
```

结果：

```php
新的标题 
```

#### @section

`@section` 用来继承并扩展原有区块的内容。子模板中使用 `@parent` 使得母版中原有的内容被保留，然后融合新的内容。

母版：

```php
@section('content')
    默认的内容
@show
```
子模板：

```php
@extends('master')

@section('content')
    @parent
    扩展的内容
@stop
```
结果：

```php
默认的内容 扩展的内容 
```

#### @show & @stop

- 建议在定义 `@section` 时用 `@show` 结尾，替换或扩展时用 `@stop` 结尾
- 解析子模板时遇到 `@show` 结尾的区块会立即显示内容，然后套用模板继承机制，继续渲染内容


母版：

```php
<div id="zoneA">
    @section('zoneA')
        This is zone A master
    @show
</div>

<div id="zoneB">
    @section('zoneB')
        This is zone B master
    @stop
</div>

<div id="zoneC">
    @section('zoneC')
        This is zone C master
    @show
</div>
```

子模板：

```php
@extends('master')


@section('zoneA')
    This is zone A slave
@stop

@section('zoneB')
    This is zone B slave
@stop

@section('zoneC')
    This is zone C slave
@show
```

结果：
```php
This is zone C slave

<div id="zoneA">
        This is zone A slave
</div>

<div id="zoneB">
</div>

<div id="zoneC">
        This is zone C slave
</div>

```

这种错误的写法导致 `zone B` 区块丢失，并且使扩展的 `This is zone C slave`内容过早出现在页面的首位。


#### @append

`@append` 用于多次将内容添加到对应的区块中

```php
@section('content')
    content A
@append

@section('content')
    content B
@append
```

> @section 的结束指令 @override 在 Laravel 5.8 中没有效果

> 大部分功能 与 [ThinkPHP5 模板引擎 使用备忘](https://misaka.im/index.php/archives/11/) 里描述的相似

模板引擎使得后端开发不用过多地学习现代前端的专业技能，在页面渲染上也能得心应手。



# 总结

Laravel 拥有 Web 后端大部分的基础功能，包括：路由、视图（模板）、数据库操作，还有家喻互晓 MVC 的设计模式。更高级的身份授权、代码调试、等功能，都已提供完善的支持。

根据发展需求，将技术重点放在数据库优化、提供微型服务、自动化部署、促进 DevOps 协作等方面，使后端技术得到提升。

当评估完项目需要时候哪款框架，就必要遵循它的使用方法，甚至了解的设计原理。否则选用框架进行开发，有可能是表面高大上，内部结构不堪入目。

互联网诞生不够50年，其中 Web 发展到了 3.0，为更好服务其他行业，经过无数公司的努力，制定了非常多业界通用的设计和模式，从 RFC 标准到通用协议，除了基本的技术手段，比如 身份验证 JWT、支付系统、订单系统等经典设计，都需要去了解。

掌握基本的提问智慧，大部分目前想要实现的东西，别人已经研究过，通过搜索引擎，能较快能找到思路，不必埋头苦造轮子。站在巨人的肩膀上才能看的更远。

---


# 参考

- [Laravel 5.8 Tutorial From by Coder's Tape Scratch - YouTube](https://www.youtube.com/watch?v=qiMYkrkXJ6k&list=PLpzy7FIRqpGD0kxI48v8QEVVZd744Phi4)
- [Laravel 5.8 中文文档 - LearnKu](https://learnku.com/docs/laravel/5.8)
- [HTTP 测试 - Laravel 5.8 中文文](https://learnku.com/docs/laravel/5.8/http-tests/3938)
- [Run only one unit test from a test suite in laravel](https://stackoverflow.com/questions/38821326/run-only-one-unit-test-from-a-test-suite-in-laravel)
- [Laravel 解决 validate 验证 Ajax 表单请求验证失败报 422 错误](https://learnku.com/articles/28340)
- [解决 Ajax 表单请求验证失败报 422 错误](https://learnku.com/articles/22317)
- [理解一般意义上的MVC模式](https://www.cnblogs.com/xinhuawei/p/5398237.html)
