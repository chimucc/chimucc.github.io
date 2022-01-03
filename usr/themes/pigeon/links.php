<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 友情链接
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>

            <div class="content_top">

                <article class="public">
                    <input type="radio" name="tab" id="link_info" class="reward_none" checked="">
                    <input type="radio" name="tab" id="link_friend" class="reward_none">
                    <input type="radio" name="tab" id="link_recom" class="reward_none">

                    <div class="link_tab">
                        <div class="link_tab_list">
                            <label for="link_info"><span class="douban_option_info">友链申请</span></label>
                            <label for="link_friend"><span class="douban_option_friend">友情链接</span></label>
                        </div>
                    </div>

                    <div class="link_body links reward_none">
                        <div class="song">
                        <?php echo core::postContent($this,$this->user->hasLogin());?>
                        </div>
                    </div>

                    <div class="links_body_friend links reward_none">

                        <div class="link_body_friend">
                        <?php
$mypattern = <<<eof
                            <a href="{url}" target="_blank" >
                                <div class="link_body_list">
                                    <div class="link_body_img">
                                        <img src="{image}">
                                    </div>
                                    <div class="link_body_name">
                                    {name}
                                    </div>
                                </div>
                            </a>
                            eof;
                            Links_Plugin::output($mypattern, 0, "");
                            ?>
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

            <?php $this->need('common/footer.php'); ?>