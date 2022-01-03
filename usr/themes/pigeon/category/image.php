<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('common/header.php'); ?>

            <div class="album_public">
                <div class="album_public_img">
                    <img src="<?php $this->options->相册背景图(); ?>">
                </div>
                <div class="album_public_filter"></div>
                <div class="album_public_box">
                    <h1 class="album_public_title"><span>相册</span></h1>
                </div>
            </div>

            <div class="content_top">
                <article class="album_list">
                    <?php while($this->next()): ?>
                    <div class="album_box">
                        <a href="<?php $this->permalink() ?>">
                            <div class="album_box_frame">
                                <div class="album_box_img">
                                <?php if($this->fields->banner){ ?>
                                    <img class="lazy" data-src="<?php $this->fields->banner(); ?>">
                                <?php } else { ?>
                                    <img class="lazy" data-src="<?php echo feature::getPostImg($this); ?>">
                                <?php } ?>

                                </div>
                                <div class="album_box_filter"><i class="iconfont icon-tupian"></i></div>
                            </div>
                            <div class="album_box_title">
                                <h2><?php $this->title() ?></h2>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </article>



            </div>
            <?php $this->need('common/footer.php'); ?>