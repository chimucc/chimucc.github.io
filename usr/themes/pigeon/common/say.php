<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
 $GLOBALS['isLogin'] = $this->user->hasLogin();
function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    if ($comments->url) {
        $author = '<a href="' . $comments->url . '"' . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment comment-body cross-body<?php
                                                                if ($comments->levels > 0) {
                                                                    echo ' comment-child';
                                                                    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
                                                                } else {
                                                                    echo ' comment-parent comment_ajax';
                                                                }
                                                                $comments->alt(' comment-odd', ' comment-even');
                                                                echo $commentClass;
                                                                ?>">
        <div id="<?php $comments->theId(); ?>">
            <div class="cross-box">
                <div class="cross_left">
                <img class="cross-avatar" src="<?php echo feature::avatarHtml($comments); ?>" alt="<?php echo $comments->author; ?>" />
                </div>
                <div class="cross_right">
                    <div class="cross_right_header">
                        <div class="cross-author"><?php echo $author ?></div>
                        <div class="cross_right_time"><?php echo feature::formatTime($comments->created); ?></div>
                    </div>
                <div class="cross-excerpt"> <?php  echo core::postCommentContent(core::timeMachineCommentContent($comments->content),$GLOBALS['isLogin'] ,"","","",true); ?></div>
                <div class="cross_right_foot">
                <?php feature::getBrowser($comments->agent); ?>
                </div>
                </div>
                
            </div>
            
        </div>
        <?php if ($comments->children) { ?><div class="comment-children"><?php $comments->threadedComments($options); ?></div><?php } ?>
    </li>
<?php } ?>

<div id="comments" class="gen">
    <?php $this->comments()->to($comments); ?>
    <?php if ($this->allow('comment')) : ?>
            <?php if($this->user->hasLogin()): ?>
            <div class="cross_box">
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" class="new_comment_form">
                <div class="cross_frame">
                <div class="cross_frame_avatar">
                    <img src="<?php echo feature::avatarHtml($this->author); ?>">
                </div>
                <div class="comment-editor">
                    <textarea name="text" id="textarea" placeholder="何事呻吟！" class="textarea textarea_box OwO-textarea" required onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};"><?php $this->remember('text'); ?></textarea>
                </div>
                </div>

                <div class="cross_tools">
                <div class="cross_tools_right">
                <div class="rko"><div class="OwO">OωO</i></div></div>
                <div class="privacy">
                <div class="privacy_btn">
                    <input type="checkbox" id="inset_3" name="secret" />
                    <label for="inset_3" class="green"></label>
                </div>
                <div class="privacy_text">隐私说说</div>
                </div>
                </div>
                <button id="submitComment" type="submit" class="submit match_color_b"><?php _e('发射'); ?></button>
                </div>
                
            </form>
            </div>
            <?php endif ; ?>

    <?php endif; ?>
    <div class="comments_lie">
    <?php if ($comments->have()) : ?>
        <?php $comments->listComments(); ?>
        <?php if ($this->options->commentajax==1):?>
        <div class="paging nav-page">
        <?php $comments->pageNav('<i class="iconfont icon-icon-test"></i>', '<i class="iconfont icon-icon-test1"></i>', 3, '...', array('wrapTag' => 'ol', 'wrapClass' => 'page-navigator', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
        </div>
        <?php endif; ?>
        <?php if ($this->options->commentajax==0):?>
        <div class="cross_nav-page">
            <center>    <?php $comments->pageNav('','加载更多',0,'',
        array(
            'wrapTag' => 'div',
            'wrapClass' => 'page-navigator',
            'itemTag' => '',
            'nextClass' => 'commentslistnext'
            )
    ); ?></center>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
</div>
<?php if($this->user->hasLogin()): ?>
<script>
      var OwO_demo = new OwO({
        logo: 'OωO表情',
        container: document.getElementsByClassName('OwO')[0],
        target: document.getElementsByClassName('OwO-textarea')[0],
        api: 'https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.json',
        position: 'down',
        width: '100%',
        maxHeight: '250px'
    });
</script>
<?php endif; ?>