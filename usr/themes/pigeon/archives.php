<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 文章归档
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>
<?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
            
            
<?= Plate::archivehead($this) ?>


            <div class="content_top">
            <article class="public">
                    <div class="tags_culd">
                        <div class="tags_culd_title">标签云</div>
                        <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags); ?>
                        <div class="tags_culd_list">
                        <?php if($tags->have()): ?>
                            <?php while ($tags->next()): ?>
                            <li><a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a></li>
                            <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>



                    
                    <div class="file">
                        <div class="file_title">归档</div>

                        <div class="file_list">
                        <?php $archives = feature::archives($this); $index = 0; foreach ($archives as $year => $posts): ?>
                            <div class="archive_head <?= Plate::archive_zd($this) ?>">
                                <div class="archive_year"><?php echo $year; ?></div>
                            </div>
                            
                            <ul class="file_list_ul <?= Plate::archive_zdul($this) ?>">
                            <?php foreach($posts as $created => $post ): ?>
                                <li class="file_list_li">
                                    <a href="<?php echo $post['permalink']; ?>">
                                        <div class="file_list_body">
                                            <div class="file_list_name"><?php echo $post['title']; ?></div>
                                            <div class="file_list_time"><?php echo date('m-d', $created); ?></div>
                                        </div>
                                        <div class="file_list_info"><?php echo $post['commentsNum']; ?> COMMENTS / <?php echo $post['views']; ?> VIEW</div>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>

            </article>


            </div>

<?php $this->need('common/footer.php'); ?>