# NAS-Nav-iCloud

NAS-Nav导航仿iCloud风格 效果[访问Demo](https://asundust.github.io/nav/)

同步[github.com](https://github.com/asundust/NAS-Nav-iCloud)和[gitee.com](https://gitee.com/asundust/NAS-Nav-iCloud)

## 引用介绍

- 我只是一个搬运工，这是我找到的最早的文章地址，如果不对请指出

- 本项目搬运的是`仿iCloud界面_3.7z`

- 原文链接：[https://wrdan.com/share/nas_cloud.html](https://wrdan.com/share/nas_cloud.html) (好像已经失联)

## 说明

在原作者的基础上做了一点更新

- 更新了在手机设备上浏览的优化
- 在引入资源的位置添加了可以使用CDN资源的提示，有两处，详情见文件`index.html`
- 其他一些说明在`index.html`文件和`lan.php`里已指出，调整参数只需要更改参数值即可
- 增加了内外网自动切换的功能(使用的是 [https://ifconfig.me/ip](https://ifconfig.me/ip) 的服务，内置还加入了其他逻辑条件来判断是否在内网，详情见文件`index.html`)

## 自动内外网切换的PHP套件相关设置

- 群晖（我这边是DSM7.2）的设置方法，去套件中心安装PHP，理论上支持任意版本的，我这边装了PHP8.0，以下按照PHP8.0来说明
- `Web Station` - `网页服务` - `(双击打开“默认服务”)` - `(PHP选项选择PHP8.0)` - `保存`
- `Web Station` - `脚本语言设置` - `(双击PHP8.0)` - `扩展名` - `(找到curl并打上勾)` - `保存`

## 下载&使用

- 下载后只留下`web`文件夹下的文件，其他文件都可以删除掉。

## 图标制作
- 里面的`112-128-空白模板.psd`是用于制作图标的，默认的demo图片规则是112*112留边6px，可以用无留边图标塞入到这个模板里，快速制作
- 无图标来源? [~~好孩子看不见1~~](http://zhangweijie.cn/hq-icon/) [好孩子看不见2](https://bendodson.com/projects/itunes-artwork-finder/) [好孩子看不见3](http://submit.icoicon.com/)
- 一些[图标提取方法网站](https://sspai.com/post/40682)
- 提取的图片是非圆角的，怎么办?（待更新）

## 教程
- 太懒了，自己不想写，随便找了一篇：[https://post.smzdm.com/p/adwlg5rn](https://post.smzdm.com/p/adwlg5rn/?send_by=8069883039)

## License
[The MIT License (MIT)](https://opensource.org/licenses/MIT)
