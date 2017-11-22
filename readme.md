## 安装

### *nix

_局部安装_

```
curl -sS https://getcomposer.org/installer | php
```
> 注意： 如果上述方法由于某些原因失败了，你还可以通过 php 下载安装器：

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
_or_
```
php -r "readfile('https://getcomposer.org/installer');" | php
```
_or 直接下载composer执行文件_
```
https://getcomposer.org/composer.phar
```
> 你可以通过 --install-dir 选项指定 Composer 的安装目录（它可以是一个绝对或相对路径）：
```
curl -sS https://getcomposer.org/installer | php -- --install-dir=bin
```
_全局安装_
>你可以执行这些命令让 composer 在你的系统中进行全局调用：
```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

----------


### 在Windows
```
https://getcomposer.org/Composer-Setup.exe
```

----------
## __composer.json：项目安装__
>你只需要一个 composer.json 文件。该文件包含了项目的依赖和其它的一些元数据。
```
composer init
```
关于composer.json 的结构请参考[composer.json 架构](http://docs.phpcomposer.com/04-schema.html#autoload)

### __关于 require Key__

你需要在 composer.json 文件中指定 require key 的值。你只需要简单的告诉 Composer 你的项目需要依赖哪些包。
```
{
    "require": {
        "monolog/monolog": "1.0.*"
    }
}
```

```
composer install
```
### __包名称__
包名称由提供者名称和其项目名称构成。通常容易产生相同的项目名称，而提供者名称的存在则很好的解决了命名冲突的问题。它允许两个不同的人创建同名的库
```
composer require nesbot/carbon
composer require citco/carbon
```
### __包版本__

在前面的例子中，我们引入的 monolog 版本指定为 `1.0.*`。这表示任何从 `1.0` 开始的开发分支，它将会匹配 `1.0.0`、`1.0.2` 或者 `1.0.20`。
> 版本约束可以用几个不同的方法来指定

名称　| 实例　|描述
:--- | ---|-----
确切的版本号 | `1.0.2` | 你可以指定包的确切版本。
范围 | `>=1.0` <br> `>=1.0,<2.0` <br> `>=1.0,<1.1\|>=1.2` | 通过使用比较操作符可以指定有效的版本范围。<br> 有效的运算符：`>`、`>=`、`<`、`<=`、`!=`。 <br> 你可以定义多个范围，用逗号隔开，这将被视为一个**逻辑AND**处理。　<br>一个管道符号`\|`将作为**逻辑OR**处理。<br>　**AND** 的优先级高于 **OR**
通配符 | `1.0.*` | 你可以使用通配符`*`来指定一种模式。`1.0.*`与`>=1.0,<1.1`是等效的。
赋值运算符 | `~1.2` | 这对于遵循语义化版本号的项目非常有用。`~1.2`相当于`>=1.2,<2.0`

_波浪号运算符_
> `~` 最好用例子来解释： `~1.2` 相当于 `>=1.2,<2.0`，而 `~1.2.3` 相当于 `>=1.2.3,<1.3`。正如你所看到的这对于遵循  [语义化版本号](http://semver.org/lang/zh-CN/)的项目最有用。一个常见的用法是标记你所依赖的最低版本，像 ~1.2 （允许1.2以上的任何版本，但不包括2.0）。由于理论上直到2.0应该都没有向后兼容性问题，所以效果很好。你还会看到它的另一种用法，使用 ~ 指定最低版本，但允许版本号的最后一位数字上升。

----------

## __命令行__
>为了从命令行获得帮助信息，请运行 composer 或者 composer list 命令，然后结合 --help 命令来获得更多的帮助信息。

更多信息请参考[命令行](http://docs.phpcomposer.com/03-cli.html#composer-home)

----------

## __composer.lock - 锁文件__

>在安装依赖后，`Composer` 将把安装时确切的版本号列表写入 `composer.lock` 文件。这将锁定改项目的特定版本。

__请提交你应用程序的 <kbd>composer.lock</kbd>（包括 <kbd>composer.json</kbd>）到你的版本库中__

这是非常重要的，因为 `install` 命令将会检查锁文件是否存在，如果存在，它将下载指定的版本（__忽略 `composer.json` 文件中的定义__）。

这意味着，任何人建立项目都将下载与指定版本完全相同的依赖。你的持续集成服务器、生产环境、你团队中的其他开发人员、每件事、每个人都使用相同的依赖，从而减轻潜在的错误对部署的影响。即使你独自开发项目，在六个月内重新安装项目时，你也可以放心的继续工作，即使从那时起你的依赖已经发布了许多新的版本。

如果不存在 `composer.lock` 文件，`Composer` __将读取 `composer.json` 并创建锁文件__。

这意味着如果你的依赖更新了新的版本，你将不会获得任何更新。此时要更新你的依赖版本请使用 `update` 命令。这将获取最新匹配的版本（根据你的 `composer.json` 文件）并将新版本更新进锁文件。

```
composer update
```
如果只想安装或更新一个依赖，你可以白名单它们：

```
composer update monolog/monolog [...]
```

----------


## __repositories__
使用自定义的包资源库。

默认情况下 `composer` 只使用 `packagist`作为包的资源库。通过指定资源库，你可以从其他地方获取资源包。

>`Repositories` 并不是递归调用的，只能在 __“Root包”__ 的 `composer.json` 中定义。附属包中的 `composer.json` 将被忽略。

支持以下类型的包资源库：

类型|说明 
----|----
composer| 一个 `composer` 类型的资源库，是一个简单的网络服务器（`HTTP`、`FTP`、`SSH`）上的 `packages.json` 文件，它包含一个 `composer.json` 对象的列表，有额外的 `dist` 和`/`或 `source` 信息。这个 `packages.json` 文件是用一个 PHP 流加载的。你可以使用 `options` 参数来设定额外的流信息。
vcs| 从 `git`、`svn` 和 `hg` 取得资源。
pear| 从 `pear` 获取资源。
package| 如果你依赖于一个项目，它不提供任何对 `composer` 的支持，你就可以使用这种类型。你基本上就只需要内联一个 `composer.json` 对象。
_实例_
```
{
    "repositories": [
        {
            "type": "composer",
            "url": "http://packages.example.com"
        },
        {
            "type": "composer",
            "url": "https://packages.example.com",
            "options": {
                "ssl": {
                    "verify_peer": "true"
                }
            }
        },
        {
            "type": "vcs",
            "url": "https://github.com/Seldaek/monolog"
        },
        {
            "type": "pear",
            "url": "http://pear2.php.net"
        },
        {
            "type": "package",
            "package": {
                "name": "smarty/smarty",
                "version": "3.1.7",
                "dist": {
                    "url": "http://www.smarty.net/files/Smarty-3.1.7.zip",
                    "type": "zip"
                },
                "source": {
                    "url": "http://smarty-php.googlecode.com/svn/",
                    "type": "svn",
                    "reference": "tags/Smarty_3_1_7/distribution/"
                }
            }
        }
    ]
}
```
更多相关内容，请查看 [资源库](http://docs.phpcomposer.com/05-repositories.html)。

>__注意__： 顺序是非常重要的，当 Composer 查找资源包时，它会按照顺序进行。默认情况下 Packagist 是最后加入的，因此自定义设置将可以覆盖 Packagist 上的包。

----------

## __自动加载__
`Composer` 生成了一个 `vendor/autoload.php` 文件。你可以简单的引入这个文件，你会得到一个免费的自动加载支持。这使得你可以很容易的使用第三方代码。
>你可以在 `composer.json` 的 `autoload` 字段中增加自己的 `autoloader`。

_实例_

```
{
    "autoload": {
    "psr-4": {
      "Psr4\\": "app/psr4/src/"
    },
    "psr-0": {
      "Psr0\\Psr0_Demo": "app/psr0"
    },
    "classmap": [
      "src/",
      "lib/",
      "ClassMapDemo3.php"
    ],
    "files": [
      "support/MyLibrary/functions-one.php",
      "support/MyLibrary/functions-two.php"
    ]
  }
}
```

>`PSR-4`和`PSR-0`最大的区别是对下划线（`underscore`)的定义不同。`PSR-4`中，在类名中使用下划线没有任何特殊含义。而`PSR-0`则规定类名中的下划线_会被转化成目录分隔符。

关于psr-4和psr-0规范请参考[psr-0规范](http://www.php-fig.org/psr/psr-0/)和[psr-4规范](http://www.php-fig.org/psr/psr-4/)

----------

## __配置__

选项 | 描述
--- | ---
process-timeout | 默认为 `300`。处理进程结束时间，例如：git 克隆的时间。Composer 将放弃超时的任务。如果你的网络缓慢或者正在使用一个巨大的包，你可能要将这个值设置的更高一些。
use-include-path    | 默认为 `false`。如果为 true，Composer autoloader 还将在 PHP include path 中继续查找类文件
preferred-install    | 默认为 `auto`。它的值可以是 source、dist 或 auto。这个选项允许你设置 Composer 的默认安装方法。
github-protocols | 默认为 `["git", "https", "ssh"]`。从 github.com 克隆时使用的协议优先级清单，因此默认情况下将优先使用 git 协议进行克隆。你可以重新排列它们的次序，例如，如果你的网络有代理服务器或 git 协议的效率很低，你就可以提升 https 协议的优先级。
github-oauth | 一个域名和 oauth keys 的列表。 例如：使用 {"github.com": "oauthtoken"} 作为此选项的值， 将使用 oauthtoken 来访问 github 上的私人仓库，并绕过 low IP-based rate 的 API 限制。 [关于如何获取 GitHub 的 OAuth token](http://docs.phpcomposer.com/articles/troubleshooting.html#api-rate-limit-and-oauth-tokens) 。
vendor-dir | 默认为 `vendor`。通过设置你可以安装依赖到不同的目录。
bin-dir | 默认为 `vendor/bin`。如果一个项目包含二进制文件，它们将被连接到这个目录。
cache-dir | unix 下默认为 `$home/cache`，Windows 下默认为 `C:\Users\<user>\AppData\Local\Composer`。用于存储 `composer` 所有的缓存文件。相关信息请查看[COMPOSER_HOME](http://docs.phpcomposer.com/03-cli.html#composer-home)。
cache-files-dir | 默认为 `$cache-dir/files`。存储包 zip 存档的目录。
cache-repo-dir | 默认为 `$cache-dir/repo`。存储 composer 类型的 VCS（svn、github、bitbucket） repos 目录。
cache-vcs-dir |  默认为 `$cache-dir/vcs`。此目录用于存储 VCS 克隆的 git/hg 类型的元数据，并加快安装速度。
cache-files-ttl |默认为 `15552000`（6个月）。默认情况下 Composer 缓存的所有数据都将在闲置6个月后被删除，这个选项允许你来调整这个时间，你可以将其设置为0以禁用缓存。
cache-files-maxsize | 默认为 `300MiB`。Composer 缓存的最大容量，超出后将优先清除旧的缓存数据，直到缓存量低于这个数值。
prepend-autoloader | 默认为 `true`。如果设置为 false，composer autoloader 将不会附加到现有的自动加载机制中。这有时候用来解决与其它自动加载机制产生的冲突。
autoloader-suffix | 默认为 `null`。Composer autoloader 的后缀，当设置为空时将会产生一个随机的字符串。
optimize-autoloader | Defaults to `false`. Always optimize when dumping the autoloader.
github-domains | 默认为 `["github.com"]`。一个 github mode 下的域名列表。这是用于GitHub的企业设置。
notify-on-install | 默认为 `true`。Composer 允许资源仓库定义一个用于通知的 URL，以便有人从其上安装资源包时能够得到一个反馈通知。此选项允许你禁用该行为。
discard-changes | 默认为 `false`，它的值可以是 true、false 或 stash。这个选项允许你设置在非交互模式下，当处理失败的更新时采用的处理方式。true 表示永远放弃更改。"stash" 表示继续尝试。


----------

## __Demo地址__
https://github.com/turncypher/composer-demo.git