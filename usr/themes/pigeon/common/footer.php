</div>
<footer id="footer" class="match_bg">
    <div class="links">
              <?php if ($this->options->twitter): ?>
              <a href="<?php $this->options->twitter(); ?>" title="twitter" target="_blank"><i class="iconfont icon-ttww"></i></a>
              <?php endif; ?>
              <?php if ($this->options->weibo): ?>
              <a href="<?php $this->options->weibo(); ?>" title="微博" target="_blank"><i class="iconfont icon-weibo"></i></a>
              <?php endif; ?>
              <?php if ($this->options->github): ?>
              <a href="<?php $this->options->github(); ?>" title="Github" target="_blank"><i class="iconfont icon-github"></i></a>
              <?php endif; ?>
              <?php if ($this->options->telegram): ?>
              <a href="<?php $this->options->telegram(); ?>" title="telegram" target="_blank"><i class="iconfont icon-telegram"></i></a>
              <?php endif; ?>
              <?php if ($this->options->mastodon): ?>
              <a rel="me" href="<?php $this->options->mastodon(); ?>" title="长毛象" target="_blank"><i class="iconfont icon-mastodon"></i></a>
              <?php endif; ?>
              <?php if ($this->options->bilibili): ?>
              <a href="<?php $this->options->bilibili(); ?>" title="哔哩哔哩" target="_blank"><i class="iconfont icon-bilibili"></i></a>
              <?php endif; ?>
              <?php if ($this->options->rss): ?>
              <a href="<?php $this->options->rss(); ?>" title="Rss" target="_blank"><i class="iconfont icon-rss"></i></a>
              <?php endif; ?>
              <?php if ($this->options->douban): ?>
              <a href="<?php $this->options->douban(); ?>" title="豆瓣" target="_blank"><i class="iconfont icon-douban"></i></a>
              <?php endif; ?>
              <?php if ($this->options->zhihu): ?>
              <a href="<?php $this->options->zhihu(); ?>" title="知乎" target="_blank"><i class="iconfont icon-zhihu"></i></a>
              <?php endif; ?>
    </div>

    <div class="synopsis"><?php $this->options->网站版权(); ?></div>

    <span><?php if($this->options->网站备案): ?><a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener"><?php $this->options->网站备案(); ?>.<?php endif; ?></a>Theme <a href="https://novcu.com/post/typecho-notes/" title="pigeon" target="_blank">Pigeon</a></span>
</footer>

<div class="tools">
    <?php if($this->is('post')): ?>
    <?php if($this->user->hasLogin()):?>
    <div class="tools_edit"><a target="_blank" href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid;?>"><i class="iconfont icon-pinglun1"></i></a></div>
    <?php endif;?>
    <?php endif; ?>
    <?php if ($this->options->夜间开关):?>
    <div class="tools_night"><a href="javascript:switchNightMode()"><i class="iconfont icon-taiyang"></i></a></div>
    <?php endif; ?>
    <div class="tools_top" id="top_to" ><i class="iconfont icon-top1"></i></div>
</div>
<?php if ($this->options->music_play):?>
    <div style="position: fixed;top:50px;right:2%; z-index:9999;"><div id="CTPlayer" class="relative flex items-center"></div></div>
<?php endif; ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/novcu/static/js/jquery.pjax.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>
<script src="<?php $this->options->themeUrl('/assets/js/prism.min.js'); ?>"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/js/jquery.lazyload.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.js"></script>
<?php if ($this->options->music_play):?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/js/Player.js"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('/assets/js/message.min.js'); ?>"></script>
<?php if ($this->options->swiper):?>
<script type="text/javascript" src="<?php $this->options->themeUrl('/assets/js/swiper-bundle.min.js'); ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('/assets/js/pigeon.js?v4.0.1'); ?>"></script>


</div>
<?php $this->footer(); ?>

<script type="text/javascript">
	$(document).on('pjax:complete', function() {
        if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = 'line-numbers'; }
        Prism.highlightAll(true,null);
    }
        <?php $this->options->hdhs(); ?>
});
</script>
<?php $this->options->footerjs(); ?>
</body>
</html>

<?php if ($this->options->Html压缩输出) : $html_source = ob_get_contents();
    ob_clean();
    print feature::compressHtml($html_source);
    ob_end_flush();
endif; ?>