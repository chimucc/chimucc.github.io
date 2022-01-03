<?php
$this->widget('Widget_Metas_Category_List')->to($categorys);
$this->widget('Widget_Contents_Page_List')->to($pages);
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" name=viewport>
        <?php if($this->options->iconurl): ?>
        <link rel="icon" href="<?php $this->options->iconurl(); ?>" />
        <?php endif; ?>
        <title><?= Plate::EchoTitle($this); ?></title>
        <meta itemprop="name" content="<?= Plate::EchoTitle($this); ?>"/>
        <?php if($this->is('index') || $this->is('archive')): ?>
        <meta itemprop="image" content="<?php $this->options->iconurl(); ?>" />
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <?php if($this->fields->banner){ ?>
        <meta itemprop="image" content="<?php $this->fields->banner(); ?>" />
        <?php } else { ?>
        <meta itemprop="image" content="<?php $this->options->iconurl(); ?>" />
        <?php } ?>
        <?php endif; ?>
        <?php if($this->is('index') || $this->is('archive')): ?>
        <meta name="description" content="<?php $this->options->description() ?>" />
        <meta name="description" itemprop="description" content="<?php $this->options->description() ?>" />
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <meta name="description" content="<?php echo feature::excerpt($this->content,120); ?>" />
        <meta name="description" itemprop="description" content="<?php echo feature::excerpt($this->content,120); ?>" />
        <?php endif; ?>
        <meta name="author" content="<?php $this->author(); ?>" />
        <meta property="og:title" content="<?= Plate::EchoTitle($this); ?>" /> 
        <?php if($this->is('index') || $this->is('archive')): ?>
        <meta property="og:description" content="<?php $this->options->description() ?>" />
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <meta property="og:description" content="<?php echo feature::excerpt($this->content,120); ?>" />
        <?php endif; ?>
        <meta property="og:site_name" content="<?php Helper::options()->title(); ?>" />
        <meta property="og:type" content="<?php if($this->is('post') || $this->is('page')) echo 'article'; else echo 'website'; ?>" />
        <meta property="og:url" content="<?php $this->permalink(); ?>" />
        <?php if($this->is('index') || $this->is('archive')): ?>
            <meta property="og:image" content="<?php $this->options->iconurl(); ?>" />  
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <?php if($this->fields->banner){ ?>
        <meta property="og:image" content="<?php $this->fields->banner(); ?>" />
        <?php } else { ?>
        <meta property="og:image" content="<?php $this->options->iconurl(); ?>" />   
        <?php } ?>
        <?php endif; ?>
        <meta property="article:published_time" content="<?php echo date('c', $this->created); ?>" />
        <meta property="article:modified_time" content="<?php echo date('c', $this->modified); ?>" />
        <meta name="twitter:title" content="<?= Plate::EchoTitle($this); ?>" />
        <?php if($this->is('index') || $this->is('archive')): ?>
        <meta name="twitter:description" content="<?php $this->options->description() ?>" />
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <meta name="twitter:description" content="<?php echo feature::excerpt($this->content,120); ?>" />
        <?php endif; ?>
        <meta name="twitter:card" content="summary" />
        <?php if($this->is('index') || $this->is('archive')): ?>
            <meta name="twitter:image" content="<?php $this->options->iconurl(); ?>" /> 
        <?php endif; ?>
        <?php if($this->is('post') || $this->is('page')): ?>
        <?php if($this->fields->banner){ ?>
        <meta name="twitter:image" content="<?php $this->fields->banner(); ?>" />
        <?php } else { ?>
            <meta name="twitter:image" content="<?php $this->options->iconurl(); ?>" />
        <?php } ?>
        <?php endif; ?>
        

        <link rel=stylesheet href="<?php $this->options->themeUrl('/assets/css/style.css?v4.0.1'); ?>">
        <link rel=stylesheet href="<?php $this->options->themeUrl('/assets/css/message.min.css'); ?>">
        <link rel=stylesheet href="https://at.alicdn.com/t/font_2775295_ju4gvxginvn.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox/dist/jquery.fancybox.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/novcu/static/css/mp.min.css" />
        <?php if ($this->options->swiper):?>
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/swiper-bundle.css'); ?>" />
        <?php endif; ?>
        <script type="text/javascript" src="<?php $this->options->themeUrl('/assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/js/tocbot.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/theia-sticky-sidebar@1.7.0/dist/theia-sticky-sidebar.min.js"></script>
    <?php $this->header('keywords=&description=','commentReply='); ?>
<style>
    <?= Plate::color_body($this) ?>
       <?= Plate::style_cust($this) ?>
       <?= Plate::img_body($this) ?>
       <?= Plate::headergd($this) ?>
       <?= Plate::headertx($this) ?>
    <?php $this->options->自定义CSS(); ?>
</style>
    
    </head>

    
    <body class="<?= Plate::theme_skin($this) ?> match <?php echo($_COOKIE['night'] == '1' ? 'dark' : ''); ?>">
        <div class="content">
            <header id="header" class="match_bg">
            <?= Plate::pigeon_header($this) ?>
                <div class="navbar">
                    <div class="meun_list">
                        <ul class="meun_ul">
                            <li class="meun_li"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                            <?= feature::OrderSet($pages, $categorys) ?>
                        </ul>
                    </div>
                    <div class="search_btn" onclick="search_show()" ><i id="sou_block" class="iconfont icon-sousuo"></i><i id="sou_none" class="iconfont icon-guanbi"></i></div>
                </div>

                <div id="search_bar">
                    <form method="post" action="">
                        <div id="search" class="search_frame"><input type="text" name="s" class="text search_input" size="32" placeholder="请输入搜索内容..."> <input type="submit" class="submit" value="Search"></div>
                    </form>
                </div>
            </header>
            <div id="pjax">
<script>
    Config = {
        homeUrl: '<?php $this->options->siteUrl(); ?>',
        themeUrl: '<?=feature::ThemeUrl()?>',
        Pjax: '<?php if ($this->options->pjax_switch):?>true<?php else: ?>off<?php endif; ?>',
        swiper:'<?php if ($this->options->swiper):?>true<?php else: ?>off<?php endif; ?>',
        post_id:'<?php if ($this->is('post')){$this->cid();}else{echo '0';} ?>',
        ajax_url:'<?php Typecho_Widget::widget('Widget_Security')->to($security); $security->index('?'); ?>',
        dark:'<?php if ($this->options->夜间开关):?>true<?php else: ?>off<?php endif; ?>',
        darktime:'<?php $this->options->开夜间模式(); ?>',
        lighttime:'<?php $this->options->关闭夜间模式(); ?>',
        musicId: '<?=feature::ParseMusic($this->options->musicurl)['id']?>',
        musicMedia: '<?=feature::ParseMusic($this->options->musicurl)['media']?>',
    };
</script>