## 安装
- [Laravel](#laravel)
- [Lumen](#lumen)

### Laravel

该软件包可用于 Laravel 5.6 或更高版本。

您可以通过 composer 安装软件包：

``` bash
composer require starrysea/arrays
```

在 Laravel 5.6 中，服务提供商将自动注册。在旧版本的框架中，只需在 config/app.php 文件中添加服务提供程序：

```php
'providers' => [
    // ...
    Starrysea\Arrays\ArraysServiceProvider::class,
];

'aliases' => [
    // ...
    'Arrays' => Starrysea\Arrays\Arrays::class,
];
```

### Lumen

您可以通过 composer 安装软件包：

``` bash
composer require starrysea/arrays
```

注册服务提供者和门面：

```bash
$app->register(Starrysea\Arrays\ArraysServiceProvider::class); // 注册 Arrays 服务提供者

class_alias(Starrysea\Arrays\Arrays::class, 'Arrays'); // 添加 Arrays 门面
```

## 用法

```php
use Starrysea\Arrays\Arrays;

class ArraysGatherTest
{
    public static function is_types()
    {
        $data = [
            'test1', // delete this is false
            '123'
        ];
        return Arrays::is_types($data,'is_numeric'); // true
    }

    public static function iconv()
    {
        $data = [
            '你好',
            'Laravel'
        ];
        return Arrays::iconv($data); // ['浣犲ソ', 'Laravel']
//        return Arrays::iconv(Arrays::iconv($data), 'UTF-8', 'GBK'); // ['你好', 'Laravel']
    }

    public static function htmlspecialchars()
    {
        $data = [
            'title'   => '你好 Laravel',
            'content' => '<script>alert("我是蔡星月,很高兴认识你")</script>'
        ];
        return Arrays::htmlspecialchars($data); // ['title'=>'你好 Laravel', 'content'=>'&lt;script&gt;alert(&quot;我是蔡星月,很高兴认识你&quot;)&lt;/script&gt;']
//        return Arrays::htmlspecialchars($data, 'content'); // ['你好 Laravel', '<script>alert("我是蔡星月,很高兴认识你")</script>']
//        return Arrays::htmlspecialchars($data, ['title', 'content']); // ['你好 Laravel', '<script>alert("我是蔡星月,很高兴认识你")</script>']
    }

    public static function merging()
    {
        $data = [
            [
                'order' => '10000',
                'title' => '你好'
            ],
            [
                'order' => '20000',
                'title' => 'Laravel'
            ],
            [
                'order' => '10000',
                'title' => '我是蔡星月,很高兴认识你'
            ]
        ];
        return Arrays::merging($data, 'order'); // ['10000'=>[['order'=>'10000', 'title'=>'你好'],['order'=>'10000', 'title'=>'我是蔡星月,很高兴认识你']], '20000'=>[['order'=>'20000', 'title'=>'Laravel']]]
    }

    public static function extract_field()
    {
        $data = [
            [
                'order' => '10000',
                'title' => '你好'
            ],
            [
                'order' => '20000',
                'title' => 'Laravel'
            ]
        ];
        return Arrays::extract_field($data, 'title'); // ['你好', 'Laravel']
    }

    public static function count()
    {
        $data = [
            [
                [
                    'order' => '10000',
                    'title' => '你好'
                ],
                [
                    [
                        'order' => '10000',
                        'title' => '你好'
                    ],
                    [
                        'order' => '20000',
                        'title' => '88888'
                    ]
                ]
            ],
            [
                'order' => '20000',
                [
                    'order' => '10000',
                    'title' => '你好'
                ],
                [
                    'order' => '20000',
                    'title' => 'Laravel'
                ]
            ]
        ];
        return Arrays::count($data, 'order'); // 0
//        return Arrays::count($data, 'title'); // 0
//        return Arrays::count($data, 'order', true); // 90000
//        return Arrays::count($data, ['order', 'title'], true); // ['order'=>90000, 'title'=>88888]
//        return Arrays::count($data, ['order', 'title'], 2); // ['order'=>30000, 'title'=>0]
    }

    public static function unsets()
    {
        $data = [
            [
                [
                    'order' => '10000',
                    'title' => '你好'
                ]
            ]
        ];
        return Arrays::unsets($data, 'order'); // [[['order'=>'10000', 'title'=>'你好']]]
//        return Arrays::unsets($data, 'order', 2); // [[['title'=>'你好']]]
//        return Arrays::unsets($data, ['order', 'title'], 2); // [[[]]]
    }

    public static function collision()
    {
        $dataOne = [
            '10000',
            '你好'
        ];
        $dataTwo = [
            '10000',
            'Laravel'
        ];
        return Arrays::collision($dataOne, $dataTwo); // ['survivedata'=>['你好','Laravel'], 'crashedsum'=>1]
    }

    public static function filter()
    {
        $data = [
            '你好',
            'Laravel'
        ];
        return Arrays::filter($data, ['你好']); // ['1'=>'Laravel']
    }

    public static function only()
    {
        $data = [
            [
                'order' => '10000',
                'title' => '你好'
            ],
            [
                'order' => '20000',
                'title' => 'Laravel'
            ]
        ];
        return Arrays::only($data, 'order'); // [['order'=>'10000'], ['order'=>'20000']]
    }

    public static function toArray()
    {
        $data = '你好, Laravel';
//        $data = ['你好, Laravel'];
        return Arrays::toArray($data); // ['你好, Laravel']
    }

    public static function OneToTwo()
    {
        $data = ['你好', 'Laravel'];
//        $data = [['你好', 'Laravel']];
        return Arrays::OneToTwo($data); // [['你好', 'Laravel']]
    }

    public static function composite()
    {
        $data = [
            'title'   => '你好',
            'content' => 'Laravel'
        ];
        return Arrays::composite($data); // ['title:你好', 'content:Laravel']
    }
}
```
