<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 留言板
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>
            <div class="content_top">
            <article class="public">
                    <div class="talk">
                    <?php feature::getFriendWall(); ?>
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