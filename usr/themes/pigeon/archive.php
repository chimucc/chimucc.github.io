<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('common/header.php'); ?>

<div class="communal <?= Plate::communal_card($this) ?>">
<?php if ($this->options->categorybg):?> 
    <div class="communal_box">
        <div class="communal_box_img">
            <?php if($this->is('category')): ?>
            <img src="<?php $this->options->themeUrl('images/category/' . $this->categories[0]['slug'] . '.jpg'); ?>">
            <?php else : ?>
            <img src="<?php $this->options->themeUrl('images/category/other.jpg'); ?>">
            <?php endif; ?>
        </div>
        <div class="communal_filter"></div>
        <div class="communal_box_text">
            <h1 class="communal_box_tetle"><?php Plate::Categorytitle($this)?></h1>
            <div class="communal_box_qm"><?php echo $this->getDescription(); ?></div>
        </div>
    </div>
<?php else : ?>
    <div class="stor">
        <h1 class="stor_name"><?php Plate::Categorytitle($this)?></h1>
        <div class="stor_qm"><?php echo $this->getDescription(); ?></div>
    </div>
<?php endif; ?>
</div>


<?php $this->need('common/list.php'); ?>
<?php $this->need('common/paging.php'); ?>
<?php $this->need('common/footer.php'); ?>