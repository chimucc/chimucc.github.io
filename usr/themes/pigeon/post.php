<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('common/header.php'); ?>
            <div class="content_top">
                <article class="post match_bg">
                <?php if (core::isImageCategory($this->categories)): ?>
                    <div class="palbum">
                        <div class="palbum_img">
                                <?php if($this->fields->banner){ ?>
                                    <img class="lazy poster-zoom" data-src="<?php $this->fields->banner(); ?>">
                                <?php } else { ?>
                                    <img class="lazy poster-zoom" data-src="<?php echo feature::getPostImg($this); ?>">
                                <?php } ?>
                        </div>
                        <div class="palbum_filter"></div>
                        <div class="palbum_box">
                            <h1 class="palbum_box_title"><?php $this->title() ?></h1>
                            <span class="palbum_box_line"></span>
                            <div class="palbum_box_info">
                                <span><i class="iconfont icon-shijian-xianxing"></i><?php echo feature::formatTime($this->created); ?></span>
                                <span><i class="iconfont icon-xiangce"></i><?php echo ''.feature::imgNum($this->content).''; ?></span>
                                <span><i class="iconfont icon-liulan"></i><?php feature::get_post_view($this) ?></span>
                                <span><i class="iconfont icon-pinglun"></i><?php $this -> commentsNum('%d'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <?php if($this->fields->banner){ ?>
                    <div class="post_pic">
                        <div class="post_pic_img">
                            <img class="poster-zoom" src="<?php $this->fields->banner(); ?>">
                        </div>
                        <div class="post_pic_filter"></div>
                        <div class="post_pic_box">
                            <h1 class="post_pic_title"><?php $this->title() ?></h1>
                            <hr>
                            <div class="post_pic_info">
                            <time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time><i class="text-primary">•</i><span><?php $this->category(' , '); ?></span><i class="text-primary">•</i><span><?php feature::get_post_view($this) ?> 阅</span><i class="text-primary">•</i><span><?php $this -> commentsNum('%d'); ?> 评</span>
                             </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="post_text">
                        <h1 class="post_text_title"><?php $this->title() ?></h1>
                        <div class="post_text_box">
                            <div class="post_text_frame">
                                <div><time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time><i class="text-primary">•</i><span><?php $this->category(' , '); ?></span></div>
                                
                                <div class="post_text_right">
                                    <span><i class="iconfont icon-liulan"></i><?php feature::get_post_view($this) ?></span>
                                    <span><i class="iconfont icon-pinglun"></i><?php $this -> commentsNum('%d'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php endif; ?>
                <?php if ($this->fields->articleCopyright == 'show') {?>
                <div id="toc_container"><div class="toc_container"><div id="TOC-text" class="TOC-text toc"></div></div></div>
                <?php } ?>
                    <div class="post_left">
                    <div class="song words ">
                    <?php if($this->hidden||$this->titleshow): ?>
                        <form class="protected" action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>" method="post">
                            <div class="form-group">
                            <div>请输入密码访问</div>
                            <div class="input-group">
                            <input  type="password" class="text" name="protectPassword" class="form-control" placeholder="请输入密码" aria-label="请输入密码">
                            <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
                            <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="iconfont icon-sousuo"></i></button>
                            </div>
                            </div>
                            </div>
                        </form>
                    <?php else: ?>
                    <?php echo core::postContent($this,$this->user->hasLogin());?>
                    <?php endif;?>
                    </div>
                    </div>

                    <div class="post_tags">
                    <?php $this->tags(' ', true); ?>
                    </div>

                    <div class="post_praise">
                        <button class="post_praise_btn zan_btn" id="agree-btn" data-action="like" data-id="<?php $this->cid(); ?>">赞<small class="smanll">(<span class="agree-num"><?php likeup($this->cid,'kkb'); ?></span>)</small></button>
                    </div>

                    <div class="post_tools">
                        <div><button class="share_btn" for="share" onclick="share()"><i class="iconfont icon-fenxiang1"></i>分享</button></div>
                        <div class="post_foot_tool">
                            <div class="post_lastup">
                                <button class="lastup_btn"><i class="iconfont icon-dian1"></i></button>
                                <div class="post_foot_tz"><small></small>最后更新&thinsp;<?php echo date('Y-m-d' , $this->modified); ?></div>
                            </div>
                            <?php if($this->options->打赏): ?>
                            <div class="post_reward">
                                <button class="post_lastup_btn" onclick="reward()"><i class="iconfont icon-qianbao1"></i></button>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>

                </article>

                <div class="post_comments">
                    <div class="line">
                        <div class="line_name">评论 <small>( <?php $this -> commentsNum('%d'); ?> )</small></div>
                    </div>
                    <?php $this->need('common/comments.php'); ?>
                </div>

            </div>

            <script>
                function weixin(){
                    message_box.message_box('<div class="weixin_title">微信扫一扫 分享朋友圈</div><img class="weixin_img" src="//api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=<?php $this->permalink() ?>">')
                };
                function share(){
                    message_share.message_share('<?php if($this->fields->banner){ ?><div class="share_head"><div class="share_head_img"><img src="<?php $this->fields->banner(); ?>"></div><div class="share_head_filter"></div><div class="share_head_info"><div class="share_head_title"><?php $this->title() ?></div></div></div><?php } ?><div class="share_foot"><a href="//service.weibo.com/share/share.php?url=<?php $this->permalink() ?>&type=button&language=zh_cn&title=<?php $this->title() ?>"><span><i class="iconfont icon-weibo"></i></span></a><a href="https://twitter.com/intent/tweet?url=<?php $this->permalink() ?>"><span><i class="iconfont icon-ttww"></i></span></a><a href="https://connect.qq.com/widget/shareqq/index.html?url=<?php $this->permalink() ?>&amp;title=<?php $this->title() ?>"><span><i class="iconfont icon-QQ"></i></span></a><a href="javascript:" onclick="weixin()"><span><i class="iconfont icon-weixin"></i></span></a></div>');
                };
                function reward(){
                    message_box.message_box('<div class="reward_box"><input type="radio"name="tab"id="reward_weixin"class="reward_none"checked=""><input type="radio"name="tab"id="reward_zfb"class="reward_none"><div class="reward_title">感谢打赏</div><div class="reward_body"><div class="reward_body_weixin reward_none"><img src="<?php $this->options->微信打赏二维码(); ?>"></div><div class="reward_body_zfb reward_none"><img src="<?php $this->options->支付宝打赏二维码(); ?>"></div></div><div class="reward_option"><div class="reward_ul"><label for="reward_weixin"><span class="reward_option_weixin">微信打赏</span></label><label for="reward_zfb"><span class="reward_option_zfb">支付宝打赏</span></label></div></div></div>');
                };
            </script>

<script>
		$.each($("div.song figure:not(.size-parsed)"), function(t, n) {
			var a = new Image;
			a.onload = function() {
				var t = parseFloat(a.width),
					e = parseFloat(a.height);
				$(n).addClass("size-parsed"), $(n).css("width", t + "px"), $(n).css("flex-grow", 50 * t / e), $(n).find("a").css("padding-top", e / t * 100 + "%")
			}, a.src = $(n).find("img").attr("data-src")
		});
        (function(){
		var pres = document.querySelectorAll('pre');
		var lineNumberClassName = 'line-numbers';
		pres.forEach(function (item, index) {
			item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
		});
	})();
</script>

<?php if ($this->fields->articleCopyright == 'show') {?>
<script>
    if ($('.toc').length > 0) {
    var headerEl = 'h1,h2,h3,h4',  
        content = '.song',
        idArr = {}; 
    $(content).children(headerEl).each(function () {
        var headerId = $(this).text().replace(/[\s|\~|`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\=|\||\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\<|\.|\>|\/|\?|\：|\，|\。]/g, '');
        headerId = headerId.toLowerCase();
        if (idArr[headerId]) {
            $(this).attr('id', headerId + '-' + idArr[headerId]);
            idArr[headerId]++;
        }
        else {
            idArr[headerId] = 1;
            $(this).attr('id', headerId);
        }
    });
 
    tocbot.init({
        tocSelector: '.toc',
        contentSelector: content,
        headingSelector: headerEl,
        scrollSmooth: true,
        scrollSmoothOffset: 0,
        headingsOffset: 0
    });
};

jQuery(document).ready(function() {
    jQuery('.post_left, .toc_container').theiaStickySidebar({
      // Settings
      additionalMarginTop: 30
    });
  });

</script>
<?php } ?>       
<?php $this->need('common/footer.php'); ?>