### 什么是依赖注入
文章转自: [http://www.cnblogs.com/restart/p/4402087.html](http://www.cnblogs.com/restart/p/4402087.html), 由`codelighter`重新整理.
> 依赖注入（Dependency Injection）是设计模式的一种。名字比较抽象，但是，要解决的问题却是比较明确。对于给定的应用程序，需要借助一些相对独立的组件来完成功能。一般来说，使用这些组件的过程就包含在应用程序的逻辑语句之中。问题是，当这些组件想要做成类似插件功能，以达到应用程序的业务逻辑不变就能随意的更改组件的实现的效果。这种灵活性取决于应用程序如何组装这些组件。如果说应用程序依赖于这些组件的话，依赖注入就是把这些依赖关系从应用程序的逻辑中剥离，放到插件的实现中去的一种方法。

一个简单的例子是： 一个用户类表类，依赖于一个`finder`类来生成这个列表。而这个`finder`类呢，依赖于某个`db`来获取数据。在不考虑依赖注入的时候，程序可能会这样写：
```php
$db = new \yii\db\Connection(['dsn' => '...']);
$finder = new UserFinder($db);
$lister = new UserLister($finder);
```
可是，当`db`的实现发生变化的时候，会引起应用程序的变化，`finder`类的实现发生变化的时候，会引起应用程序的变化。如果把`db`，`finder`看做插件，就需要一套机制来告诉应用程序，`lister`依赖于`finder`和`db`。

**依赖注入的基本理就是用一个独立的对象作为组装器，该组装器用一个合适的实例提供给应用程序来使用。**

-  构造函数注入:  就是在构造函数的参数中提供组件的实现，在构造函数中把这种实现固化到应用程序中。
-  Setter 注入:  专门通过`setter`函数实现以上的注入，
-  接口注入:  通过接口的实现，达到依赖注入。有关依赖注入的详细的信息，请参考 Martin Flower 2004年的文章 [Inversion of Control Containers and the Dependency Injection pattern](https://martinfowler.com/articles/injection.html)

### Yii2中的依赖注入
在yii2中，我们可以发现第一和第二种类型应用，也就是构造函数注入和`setter`注入。yii2中的组装器是容器类（`Container`）。依赖的声明和依赖的注入是通过调用容器类的`set`和`get`方法来实现的。
    
1.  是类的声明，在类的构造函数中，声明依赖关系。  
2.  是容器参数的载入，告诉容器，要生成某个对象时，是用哪些参数，以及类来实现的。这个过程通过调用 `set`来完成
3.  实例的获取。调用容器的`get`函数，获取新创建的实例。
用容器来实现上面的用户列表的例子，可能是这样的。
```php
 //创建容器
 $container = new Container;

 //指定如何生成yii\db\Connection，其中，yii\db\Connection 是类的名字
 $container->set('yii\db\Connection', [
      'dsn' => '...',
 ]);

 //指定如何生成 app\models\UserFinderInterface， 所用的类是userFinder
 $container->set('app\models\UserFinderInterface', [
      'class' => 'app\models\UserFinder',
 ]);

 //指定如何生成 UserLister
 $container->set('userLister', 'app\models\UserLister');

 //生成lister
 $lister = $container->get('userLister');
```
  看起来最后生成`lister`跟前面`db`和`UserFinderInterface` 没有任何关系。这里面的秘密在于每个类的构造函数隐式地声明了类之间的依赖关系。
```php
 //首先声明一个接口类
 interface UserFinderInterface
 {
      function findUser();
 }

//UserFinder 实现这个接口类
class UserFinder extends Object implements UserFinderInterface
{
      public $db;
      //注意，第一个参数是Connection $db, 包含类的名字的
      public function __construct(Connection $db, $config = [])
      {
          $this->db = $db;
          parent::__construct($config);
      }
    
      public function findUser()
      {
      }
}

//UserLists 类， 构造函数的第一个参数声明了它依赖于UserFinderInterface.
class UserLister extends Object
{
      public $finder;
    
      public function __construct(UserFinderInterface $finder, $config = [])
      {
          $this->finder = $finder;
          parent::__construct($config);
      }
}
```
#### 容器的作用就是
    set，指明实例的生成类和参数
    在get的时候，根据构造函数分析依赖，根据依赖关系，生成相应的对象。
#### 容器类的内部实现 
    数据结构：容器类有几个比较重要的内部数组
```php
/**
 * @var array singleton objects indexed by their types
 */
private $_singletons = [];
/**
 * @var array object definitions indexed by their types
 */
private $_definitions = [];
/**
 * @var array constructor parameters indexed by object types
 */
private $_params = [];
/**
 * @var array cached ReflectionClass objects indexed by class/interface names
 */
private $_reflections = [];
/**
 * @var array cached dependencies indexed by class/interface names. Each class name
 * is associated with a list of constructor parameter types or default values.
 */
private $_dependencies = [];
```
####  容器的重要函数
```php
public function set($class, $definition = [], array $params = []);
public function get($class, $params = [], $config = []);
```
`set`函数的作用是把一个类注册到容器中，这样容器就知道生成一个类的实例时，应该如何找依赖信息了。 `set`函数可以注册一个类名字，一个接口名字， 一个别名。注册的时候，还可以指定相应的配置信息 （配置信息的目的是把这些信息赋给生成的类实例）


最基本的就是，第一个参数就是键值，可以是类的名字，接口的名字，别名。而第二个参数是定义，可以是字符串，比如一个类的名字，接口的名字或者是别名；可以是数组，表示相应的配置信息；还可以可以是一个PHP的可调用对象，该对象的参数为

    function ($container, $params,$config)
该对象在`get()` 调用的时候被执行。`$params` 是构造函数的参数，`$config`  是对象的配置信息，常常是个数组。 而 `$container` 是容器对象。 返回值是生成的对象，被 `get()` 返回。 `set` 函数的第三个参数是生成对象的时候提供给构造函数的参数。

从`set` 函数的源代码可以看出，第一个参数，即 `class`，是作为前文提到的几个关键数组的键值的。定义放在 `_definitions` 中，参数放在 `_params` 中。

```php
public function set($class, $definition = [], array $params = [])
{
    $this->_definitions[$class] = $this->normalizeDefinition($class, $definition);
    $this->_params[$class] = $params;
    unset($this->_singletons[$class]);
    return $this;
}
```
 `get`函数负责根据`set`设置的依赖关系生成响应的对象实例。其中第一个参数`class`是用来访问容器中不同数组的键值，第二个参数是$params，跟set中提供的`params`合并以后，提供给类的构造函数。第三个参数`config`是配置信息(注 配置就是要给新生成的对象赋一些属性，而参数是类的构造函数处理要处理的参数）

`get`函数首先从`_definition`中取出定义，根据其类型，做不同的处理，比如，如果它是一个函数，则把参数合并以后，调用set提供的函数。

新创建的对象实例是调用`build`方法来构建的。在这个`build`函数中， 首先要获取依赖。那么这个依赖从哪里来呢?


依赖从类的构造函数的反射分析中来。


方法是根据类的名字空间创建反射对象，取得构造函数，逐个分析构造函数的参数。某个参数有缺省的值，则把缺省值记录到依赖中来。如果一个参数有类，则根据类的名字，生成一个 `Instance` 对象，记录类的名字，为后面依赖的解析作准备。

生成的反射信息放到 `_reflection` 数组中，依赖放到 `_dependency` 数组中。依赖需要解析，解析的过程就是生成实例的过程，递归调用get的过程。
处理过的依赖数组，作为参数，传给反射对象的`newInstanceArgs`，进而生成类的实例。其实质就是把带有类的指示的参数实例化了，而实例化是根据set函数预先定义的方法。

以上介绍的整个过程就是Yii2中利用 `container` 实现依赖注入的过程。可以看到，对依赖的注入是通过分析类的构造函数参数来实现的。 
#### 依赖注入的使用
 在yii中，主程序的配置就使用了这种基于容器的依赖注入。

在 `yii/config/web.php` 中 `config` 数组中组件 (`components`) 就是在指定元素的定义。在`application`的 `preInit`方法中，用户指定的这些`components`会跟系统的核心`components`融合。
这些组件可以通过 `\Yii\:\:$app->componentID` 的形式访问， 比如 `\Yii:: $app->cache.` (这属于`service locator` 概念了) 组件在第一次访问的时候通过`Yii::createObject`静态函数实例化，实例化的过程就遵循了上文所说的依赖注入的过程。
当然了，如果你指定要`bootstrap`某个组件, 比如下面。这样每一个请求来的时候，都会实例化该`log`组件。
```php
'bootstrap' => [
        'log',
 ],   
```
 以下是配置中components中的内容示例。
 ```php
 'components' => [
                    'request' => [
                        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                        'cookieValidationKey' => '...',
                    ],
                    'cache' => [
                        'class' => 'yii\caching\FileCache',
                    ],
                    'user' => [
                        'identityClass' => 'app\models\User',
                        'enableAutoLogin' => true,
                    ],
                    'errorHandler' => [
                        'errorAction' => 'site/error',
                    ],
                    'mailer' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        // send all mails to a file by default. You have to set
                        // 'useFileTransport' to false and configure a transport
                        // for the mailer to send real emails.
                        'useFileTransport' => true,
                    ],
                    'log' => [
                        'traceLevel' => YII_DEBUG ? 3 : 0,
                        'targets' => [
                            [
                                'class' => 'yii\log\FileTarget',
                                'levels' => ['error', 'warning','profile'],
                            ],
                        ],
                    ],
                    'db' => require(__DIR__ . '/db.php'),
        ]
 ```