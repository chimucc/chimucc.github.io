<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

//主题静态资源的绝对地址

@define('StaticPath', '' . Helper::options()->themeUrl . '/assets/');

function themeConfig($form)
{
    feature::BackSet();
    $zetheme = '<link rel="stylesheet" href="' . StaticPath . 'css/admin.css">';
    $zetheme .= '<script src="' . StaticPath . 'js/admin.js"></script>';
    $zetheme .= '<div class="tip"><span class="tip-var">Var ' . $GLOBALS['config']['version'] . ' </span><div class="tip-header">';
    $zetheme .= '<h1>Pigeon ' . $GLOBALS['config']['version'] . ' 设置面板</h1></div>';
    $zetheme .= '<p>作者：<a href="https://novcu.com">山卜方</a></p><p>欢迎您使用Pigeon主题，如有疑问进群咨询。</p>';
    $zetheme .= '<form class="protected home col-mb-12" action="?Pigeonbf" method="post">';
    $zetheme .= '<div class="typecho-option"><label class="typecho-label">主题设置项备份：' . feature::CheckSetBack() . '</label></div>';
    $zetheme .= '<input type="submit" name="type" class="btn lan" value="备份" />&#160;&#160;';
    $zetheme .= '<input type="submit" name="type" class="btn lan" value="还原" />&#160;&#160;';
    $zetheme .= '<input type="submit" name="type" class="btn hong" style="float:right" value="删除" />';
    $zetheme .= '</form></div>';
    echo $zetheme; 

    //侧边导航
    $form->addItem(new EchoHtml('<div class="allTab"><div class="tab">'));
    $form->addItem(new EchoHtml('<div class="tabLinks">基础设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">外观设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">个性设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">导航设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">高级设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">社交设置</div>'));
    $form->addItem(new EchoHtml('<div class="tabLinks">其他设置</div>'));
    $form->addItem(new EchoHtml('</div>'));




    //基础设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));

    $tyepcho_bb = new Typecho_Widget_Helper_Form_Element_Radio('Typecho版本',array('ty正式版' => 'ty正式版','ty开发板' => 'ty开发板'),'ty正式版',_t('Typecho版本'),_t('请正确选择程序版本'));
    $form->addInput($tyepcho_bb);

    //站标设置
    $iconurl = new Typecho_Widget_Helper_Form_Element_Text('iconurl', NULL, NULL, _t('博客ICO'), _t('请输入博客ICO地址'));
    $form->addInput($iconurl);
    //普通模式logo
    $avatarUrl = new Typecho_Widget_Helper_Form_Element_Text('头像地址', NULL, NULL, _t('站点 LOGO 地址'), _t('请填写 logo 样式'));
    $form->addInput($avatarUrl);
    //站点 LOGO 跳转地址
    $logotz = new Typecho_Widget_Helper_Form_Element_Text('头像跳转', NULL, NULL, _t('站点 LOGO 跳转地址'), _t('点击头像跳转地址默认跳转为首页'));
    $form->addInput($logotz);
    //头部背景
    $picUrl = new Typecho_Widget_Helper_Form_Element_Text('头部背景', NULL, NULL, _t('头部背景'), _t('在这里填入一个图片 URL 地址'));
    $form->addInput($picUrl);
    //个性签名
    $webshuoshuo = new Typecho_Widget_Helper_Form_Element_Text('个性签名', NULL, NULL, _t('头部个性签名'), _t('头部个性签名'));
    $form->addInput($webshuoshuo);
    //网站副标题
    $subTitle = new Typecho_Widget_Helper_Form_Element_Text('subTitle', NULL, NULL, _t('自定义站点副标题'), _t('浏览器副标题，仅在当前页面为首页时显示，显示格式为：<b>标题 - 副标题</b>，留空则不显示副标题'));
    $form->addInput($subTitle);
    //归档背景图片
    $archiveimg = new Typecho_Widget_Helper_Form_Element_Text('归档背景图', NULL, NULL, _t('归档背景图'), _t('请输入归档背景图片'));
    $form->addInput($archiveimg);
    //相册背景图片
    $albumimg = new Typecho_Widget_Helper_Form_Element_Text('相册背景图', NULL, NULL, _t('相册背景图'), _t('请输入相册背景图片'));
    $form->addInput($albumimg);
    //版权
    $footcopy = new Typecho_Widget_Helper_Form_Element_Textarea('网站版权', NULL, NULL, _t('网站版权说明'), _t('博客底部说明 如：©樗顾 2019 - 2021'));
    $form->addInput($footcopy);

    $webbeian = new Typecho_Widget_Helper_Form_Element_Textarea('网站备案', NULL, NULL, _t('网站备案'), _t('网站备案'));
    $form->addInput($webbeian);


    $form->addItem(new EchoHtml('</div>'));

     //外观设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));
    //主题样式
    $card_theme = new Typecho_Widget_Helper_Form_Element_Radio('主题风格',array('普通风格' => '普通风格','卡片风格' => '卡片风格'),'普通风格',_t('主题风格'),_t('请选择主题风格'));
    $form->addInput($card_theme);
    //主题皮肤
    $skin_theme = new Typecho_Widget_Helper_Form_Element_Radio('主题皮肤',array('默认皮肤' => '默认皮肤','新拟物皮肤' => '新拟物皮肤'),'默认皮肤',_t('默认皮肤'),_t('请选择主题皮肤'));
    $form->addInput($skin_theme);
    //主题列表图片位置
    $themeimg = new Typecho_Widget_Helper_Form_Element_Radio('列表图片位置',array('图片在左' => '图片在左','图片在右' => '图片在右','图片交叉' => '图片交叉'),'图片在左',_t('列表图片位置'),_t('<span style="color:red">图片交叉仅在单图列表有效</span>'));
    $form->addInput($themeimg);
    //主题列表图片位置
    $pagingtheme = new Typecho_Widget_Helper_Form_Element_Radio('分页样式',array('序列号分页' => '序列号分页','Ajax翻页' => 'Ajax翻页'),'序列号分页',_t('分页样式'),_t('请选择分页样式'));
    $form->addInput($pagingtheme);
    //分页样式
    $commentajax = new Typecho_Widget_Helper_Form_Element_Radio('commentajax',array('1' => '分页式','0' => 'Ajax式'),'0',_t('时光机分页'),_t('请选择时光机分页样式'));
    $form->addInput($commentajax);
    
    $form->addItem(new EchoHtml('</div>'));

    //个性设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));
    //归档年份
    $gdnf = new Typecho_Widget_Helper_Form_Element_Checkbox('归档年份',array('归档年份' => '是否以年份归档，默认以月份归档'), null, '归档年份');
    $form->addInput($gdnf->multiMode());

    $gdss = new Typecho_Widget_Helper_Form_Element_Checkbox('归档折叠',array('归档折叠' => '是否开启归档折叠'), null, '归档折叠');
    $form->addInput($gdss->multiMode());
    //文章图片名称
    $wztp = new Typecho_Widget_Helper_Form_Element_Checkbox('图片说明',array('图片说明' => '是否添加文章图片说明'), null, '文章图片说明');
    $form->addInput($wztp->multiMode());

    $headgd = new Typecho_Widget_Helper_Form_Element_Checkbox('头部过度',array('头部过度' => '是否开启头部过度'), null, '头部过度');
    $form->addInput($headgd->multiMode());
    //文章首行缩进
    $crater = new Typecho_Widget_Helper_Form_Element_Checkbox('crater',array('crater' => '<span style="color:red">如果不是全站都需要此功能不建议开启<span>'), null, '文章首行缩进');
    $form->addInput($crater->multiMode());
    //站标阴影
    $header_show = new Typecho_Widget_Helper_Form_Element_Checkbox('博客名称阴影',array('博客名称阴影' => '博客名称阴影'), null, '博客名称阴影');
    $form->addInput($header_show->multiMode());
    //分类背景
    $categorybg = new Typecho_Widget_Helper_Form_Element_Checkbox('categorybg',array('categorybg' => '分类背景<a href="https://pigeondocs.vercel.app/#/settings/sy?id=%e5%bd%92%e6%a1%a3%e5%88%86%e9%a1%b5%e5%92%8c%e5%88%86%e7%b1%bb%e8%83%8c%e6%99%af%e5%9b%be%e7%89%87%e6%b7%bb%e5%8a%a0">设置方法</a>'), null, '分类背景');
    $form->addInput($categorybg->multiMode());
    //自定义主色
    $cust_color = new Typecho_Widget_Helper_Form_Element_Text('自定主色', NULL, NULL, _t('自定主色'), _t('填入自定的主色调 如 #f1404b'));
    $form->addInput($cust_color);

    $body_color = new Typecho_Widget_Helper_Form_Element_Text('背景颜色', NULL, NULL, _t('背景颜色'), _t('填入自定的背景颜色 如 #FFF'));
    $form->addInput($body_color);

    $body_img = new Typecho_Widget_Helper_Form_Element_Text('网站背景图片', NULL, NULL, _t('网站背景图片'), _t('填入自定的背景图片地址'));
    $form->addInput($body_img);

    $header_gd = new Typecho_Widget_Helper_Form_Element_Text('头部高度', NULL, NULL, _t('头部高度'), _t('请填写头部图片高度'));
    $form->addInput($header_gd);

    $header_tx = new Typecho_Widget_Helper_Form_Element_Text('头像高度', NULL, NULL, _t('头像高度'), _t('请填写头像高度'));
    $form->addInput($header_tx);
    
    $form->addItem(new EchoHtml('</div>'));


    //导航设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));
    //前后顺序
    $pageortags = new Typecho_Widget_Helper_Form_Element_Radio('pageortags', array('pageortags' => '独立页面在前，分类在后', '分前独后' => '分类在前，独立页面在后',), '0', '分类与独立页面顺序', '默认为独立页面在前，分类在后');
    $form->addInput($pageortags);
    //合并分类
    $sortalls = new Typecho_Widget_Helper_Form_Element_Radio('sortalls', array('展开分类' => '展开分类', '合并分类' => '合并分类','关闭分类' => '关闭分类',), '展开分类', '分类选项', '请选择分类样式');
    $form->addInput($sortalls);
    //分类合并显示名称
    $sortallstit = new Typecho_Widget_Helper_Form_Element_Text('sortallstit', NULL, NULL, _t('分类合并分类显示名称'), _t('在这里输入导航栏页面下拉菜单的显示名称'));
    $form->addInput($sortallstit);
    //独立页面合并
    $pagealls = new Typecho_Widget_Helper_Form_Element_Checkbox('pagealls', array('pagealls' => '启用后独立页面将合并到一起'), null, '独立页面合并');
    $form->addInput($pagealls->multiMode());
    //独立页面合并显示名称
    $pageallstit = new Typecho_Widget_Helper_Form_Element_Text('pageallstit', NULL, NULL, _t('独立页面合并显示名称'), _t('在这里输入导航栏页面下拉菜单的显示名称'));
    $form->addInput($pageallstit);
    //自定义页面合并
    $lonelyalls = new Typecho_Widget_Helper_Form_Element_Checkbox('lonelyalls', array('lonelyalls' => '启用后自定页面将合并到一起'), null, '自定义页面合并');
    $form->addInput($lonelyalls->multiMode());
    //自定义页面合并显示名称
    $lonelyallstit = new Typecho_Widget_Helper_Form_Element_Text('lonelyallstit', NULL, NULL, _t('自定义页面合并菜单显示名称'), _t('在这里输入导航栏页面下拉菜单的显示名称'));
    $form->addInput($lonelyallstit);
    //自定义导航链接
    $urltext = new Typecho_Widget_Helper_Form_Element_Textarea('urltext', NULL, NULL, _t('自定义导航栏链接'), _t('格式为：&lt;a href="地址"&gt;名称&lt;/a&gt;一行请填写一个，将直接渲染在独立页面后'));
    $form->addInput($urltext);
    
    $form->addItem(new EchoHtml('</div>'));

    //高级设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));

    $compressHtml = new Typecho_Widget_Helper_Form_Element_Checkbox('Html压缩输出', array('compressHtml' => '默认关闭，启用则会对HTML代码进行压缩，可能与部分插件存在兼容问题，请酌情选择开启或者关闭'), null, 'HTML压缩');
    $form->addInput($compressHtml->multiMode());

    $pjax_switch = new Typecho_Widget_Helper_Form_Element_Checkbox('pjax_switch',array('pjax_switch' => '是否开启PJAX'), null, 'PJAX');
    $form->addInput($pjax_switch->multiMode());
    //自选音乐
    $music_play = new Typecho_Widget_Helper_Form_Element_Checkbox('music_play',array('music_play' => '是否开启音乐播放器'), null, '音乐播放器');
    $form->addInput($music_play->multiMode());

    $musicurl = new Typecho_Widget_Helper_Form_Element_Text('musicurl', NULL, NULL, _t('音乐链接'), _t('支持网易云音乐、QQ音乐的歌单解析，请直接填写歌单地址，不支持专辑、VIP、无版权歌曲，请注意歌单里不要包含以上类型的音乐。'));
    $form->addInput($musicurl);

    $sticky = new Typecho_Widget_Helper_Form_Element_Text('sticky', NULL,NULL, _t('文章置顶'), _t('置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔'));
    $form->addInput($sticky);

    $dark_btn = new Typecho_Widget_Helper_Form_Element_Checkbox('夜间开关',array('夜间模式' => '是否开启夜间模式'), null, '夜间模式');
    $form->addInput($dark_btn->multiMode());

    $dark_time = new Typecho_Widget_Helper_Form_Element_Text('开夜间模式', NULL,NULL, _t('自动开启夜间模式的时间'), _t('请输入 24 时间单位且只能填写整数'));
    $form->addInput($dark_time);

    $light_time = new Typecho_Widget_Helper_Form_Element_Text('关闭夜间模式', NULL,NULL, _t('自动关闭夜间模式的时间'), _t('请输入 24 时间单位且只能填写整数'));
    $form->addInput($light_time);

    $kaqids = new Typecho_Widget_Helper_Form_Element_Checkbox('打赏',array('打赏' => '是否开启打赏'), null, '打赏');
    $form->addInput($kaqids->multiMode());

    $dashangsro = new Typecho_Widget_Helper_Form_Element_Text('微信打赏二维码', NULL,NULL, _t('二维码地址'), _t('请输入微信二维码地址'));
    $form->addInput($dashangsro);

    $dashangzfb = new Typecho_Widget_Helper_Form_Element_Text('支付宝打赏二维码', NULL,NULL, _t('二维码地址'), _t('请输入支付宝二维码地址'));
    $form->addInput($dashangzfb);
    
    $swiper = new Typecho_Widget_Helper_Form_Element_Checkbox('swiper',array('swiper' => '是否开启幻灯片'), null, '幻灯片');
    $form->addInput($swiper->multiMode());

    $lunfan = new Typecho_Widget_Helper_Form_Element_Textarea('轮番图',NULL,NULL,'轮番图','格式：图片地址 || 跳转链接 || 标题 （中间使用两个竖杠分隔）');
    $form->addInput($lunfan);
     
    $form->addItem(new EchoHtml('</div>'));

    //社交设置
    $form->addItem(new EchoHtml('<div class="tabContent">'));
    $twitter = new Typecho_Widget_Helper_Form_Element_Text('twitter', NULL, NULL, _t('twitter'), _t('在这里填入你的twitter链接'));
    $form->addInput($twitter);
    $weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('微博'), _t('在这里填入你的微博链接'));
    $form->addInput($weibo);
    $github = new Typecho_Widget_Helper_Form_Element_Text('github', NULL, NULL, _t('Github'), _t('在这里填入你的Github链接'));
    $form->addInput($github);
    $telegram = new Typecho_Widget_Helper_Form_Element_Text('telegram', NULL, NULL, _t('telegram'), _t('在这里填入你的telegram链接'));
    $form->addInput($telegram);
    $mastodon = new Typecho_Widget_Helper_Form_Element_Text('mastodon', NULL, NULL, _t('mastodon'), _t('在这里填入你的mastodon链接'));
    $form->addInput($mastodon);
    $bilibili = new Typecho_Widget_Helper_Form_Element_Text('bilibili', NULL, NULL, _t('bilibili'), _t('在这里填入你的bilibili链接'));
    $form->addInput($bilibili);
    $rss = new Typecho_Widget_Helper_Form_Element_Text('rss', NULL, NULL, _t('rss'), _t('在这里填入你的RSS链接'));
    $form->addInput($rss);
    $douban = new Typecho_Widget_Helper_Form_Element_Text('douban', NULL, NULL, _t('douban'), _t('在这里填入你的豆瓣链接'));
    $form->addInput($douban);
    $zhihu = new Typecho_Widget_Helper_Form_Element_Text('zhihu', NULL, NULL, _t('zhihu'), _t('在这里填入你的知乎链接'));
    $form->addInput($zhihu);
    $form->addItem(new EchoHtml('</div>'));
 
     //其他设置
     $form->addItem(new EchoHtml('<div class="tabContent">'));

     $_var_44 = new Typecho_Widget_Helper_Form_Element_Text('time_code', NULL, 'default', '时光机身份验证编码', '用于微信公众号发送时光机验证个人身份的编码，请勿告诉任何人。如果编码泄露，别人可以通过该编码在微信公众号向的博客添加说说。你可以随时更新此编码，以便不被别人使用。');
     $form->addInput($_var_44);
 
     $footerjs = new Typecho_Widget_Helper_Form_Element_Textarea('footerjs', NULL, NULL, _t('自定义代码添加'), _t('添加自己所需求的代码'));
     $form->addInput($footerjs);
 
     $hdhs = new Typecho_Widget_Helper_Form_Element_Textarea('hdhs', NULL, NULL, _t('pjax回调函数'), _t('如果不知道干什么的，不用填写！'));
     $form->addInput($hdhs);
 
     $zdycss = new Typecho_Widget_Helper_Form_Element_Textarea('自定义CSS', NULL, NULL, _t('自定义CSS'), _t('直接写CSS即可'));
     $form->addInput($zdycss);
 
 
 
     $form->addItem(new EchoHtml('</div>'));

    //结束
    $form->addItem(new EchoHtml('</div>'));
    
}
