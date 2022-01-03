<?php if ($this->options->分页样式=='序列号分页'):?>
    <div class="paging">
    <?php $this->pageNav('<i class="iconfont icon-icon-test"></i>', '<i class="iconfont icon-icon-test1"></i>', 3, '...', array('wrapTag' => 'ol', 'wrapClass' => 'page-navigator', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
    </div>
<?php endif; ?>

<?php if ($this->options->分页样式=='Ajax翻页'):?>
<div class="paging_ajax">
    <span class="paging_next">
        <?php $this->pageLink('加载更多','next'); ?>
    </span>
</div>
<?php endif; ?>