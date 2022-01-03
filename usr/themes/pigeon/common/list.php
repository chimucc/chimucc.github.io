<div class="content_top pigeon_ajax">
    <?php while($this->next()): ?>
    <?php if ($this->fields->Pictype == 1) { ?>
    <article class="index_list <?= Plate::index_card($this) ?> match_bg">
        <h2 class="index_list_name"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
        <div class="index_list_album">
            <div class="index_album_img">
                <a href="<?php $this->permalink() ?>"><img class="lazy" data-src="<?= feature::showThumbnail($this,0) ?>"></a>
            </div>
            
            <div class="index_album_img">
                <a href="<?php $this->permalink() ?>"><img class="lazy" data-src="<?= feature::showThumbnail($this,1) ?>"></a>
            </div>   

            <div class="index_album_img">
                <a href="<?php $this->permalink() ?>"><img class="lazy" data-src="<?= feature::showThumbnail($this,2) ?>"></a>
            </div>   

            <div class="index_album_img">
                <a href="<?php $this->permalink() ?>"><img class="lazy" data-src="<?= feature::showThumbnail($this,3) ?>"></a>
            </div>   
        </div>
        <div class="index_list_foot">
            <div class="index_list_footbox">
                <div class="index_list_info">
                    <time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time><i class="text-primary">•</i><span><?php $this->category(' , '); ?></span><?php $this->sticky(); ?>
                </div>
                <div class="index_list_comment"><i class="iconfont icon-xiaoxi"></i><?php $this -> commentsNum('%d'); ?></div>
            </div>
        </div>
    </article>
    <?php } elseif ($this->fields->Pictype == 2) { ?>
    <article class="index_list <?= Plate::index_card($this) ?> match_bg">
        <a href="<?php $this->permalink() ?>">
            <div class="index_list_remark">
                <div class="index_list_word"><i class="iconfont icon-yinhao"></i></div>
                <div class="index_remark_excerpt">
                <?php echo feature::excerpt($this->content,180); ?>
                </div>
            </div>
            <div class="index_remark_foot">
                <div class="index_remark_right">
                    <div class="index_remark_avatar">
                        <img src="<?php echo feature::avatarHtml($this->author); ?>">
                    </div>
                    <h2 class="index_remark_title"><?php $this->title() ?><?php $this->sticky(); ?></h2>
                </div>

                <time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time>
            </div>
        </a>
    </article>
    <?php } else {?>
    <?php if($this->fields->banner){ ?>

    <article class="index_list <?= Plate::index_card($this) ?> <?= Plate::list_img($this) ?> match_bg">
        <div class="index_list_box">
            <div class="index_list_left">
                <div class="index_list_pic">
                    <a href="<?php $this->permalink() ?>"><img class="lazy" data-src="<?php $this->fields->banner(); ?>"></a>
                </div>
            </div>

            <div class="index_list_right">
                <div class="index_list_body">
                    <h2 class="index_list_name"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
                    <div class="index_list_excerpt">         
                    <?php echo feature::excerpt($this->content,80); ?>            
                    </div>
                </div>

                <div class="index_list_foot">
                    <div class="index_list_footbox">
                        <div class="index_list_info">
                            <time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time><i class="text-primary">•</i><span><?php $this->category(' , '); ?></span><?php $this->sticky() ?>
                        </div>
                        <div class="index_list_comment"><i class="iconfont icon-xiaoxi"></i><?php $this -> commentsNum('%d'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <?php } else { ?>
    <article class="index_list <?= Plate::index_card($this) ?> match_bg">
        <h2 class="index_list_name"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
        <div class="index_list_excerpt">         
         <?php echo feature::excerpt($this->content,120); ?>            
        </div>

        <div class="index_list_foot">
            <div class="index_list_footbox">
                <div class="index_list_info">
                    <time datetime="<?php $this->date('c'); ?>"><?php echo feature::formatTime($this->created); ?></time><i class="text-primary">•</i><span><?php $this->category(' , '); ?></span><?php $this->sticky(); ?>
                </div>
                <div class="index_list_comment"><i class="iconfont icon-xiaoxi"></i><?php $this -> commentsNum('%d'); ?></div>
            </div>
        </div>
    </article>
    <?php } ?>
    <?php }?>
    <?php endwhile; ?> 
</div>