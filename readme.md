##安装

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


###在Windows
```
https://getcomposer.org/Composer-Setup.exe
```

----------
##composer.json：项目安装

##包版本

在前面的例子中，我们引入的 monolog 版本指定为 `1.0.*`。这表示任何从 `1.0` 开始的开发分支，它将会匹配 `1.0.0`、`1.0.2` 或者 `1.0.20`。
> 版本约束可以用几个不同的方法来指定

名称　| 实例　|描述
:----------------------- | ---|-----
确切的版本号 | `1.0.2` | 你可以指定包的确切版本。
范围 | `>=1.0` <br> `>=1.0,<2.0` <br> `>=1.0,<1.1\|>=1.2` | 通过使用比较操作符可以指定有效的版本范围。<br> 有效的运算符：`>`、`>=`、`<`、`<=`、`!=`。 <br> 你可以定义多个范围，用逗号隔开，这将被视为一个**逻辑AND**处理。　<br>一个管道符号`\|`将作为**逻辑OR**处理。<br>　**AND** 的优先级高于 **OR**
通配符 | `1.0.*` | 你可以使用通配符`*`来指定一种模式。`1.0.*`与`>=1.0,<1.1`是等效的。
赋值运算符 | `~1.2` | 这对于遵循语义化版本号的项目非常有用。`~1.2`相当于`>=1.2,<2.0`
###波浪号运算符
> `~` 最好用例子来解释： `~1.2` 相当于 `>=1.2,<2.0`，而 `~1.2.3` 相当于 `>=1.2.3,<1.3`。正如你所看到的这对于遵循  [语义化版本号](http://semver.org/lang/zh-CN/)的项目最有用。一个常见的用法是标记你所依赖的最低版本，像 ~1.2 （允许1.2以上的任何版本，但不包括2.0）。由于理论上直到2.0应该都没有向后兼容性问题，所以效果很好。你还会看到它的另一种用法，使用 ~ 指定最低版本，但允许版本号的最后一位数字上升。

##composer.lock - 锁文件

##配置
选项 | 描述
--------------- | ---
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