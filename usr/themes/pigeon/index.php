<?php
/**
 * 享受多面人生。
 * @package Pigeon
 * @author 山卜方
 * @version 4.0.1
 * @link https://novcu.com/
 */
 if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('common/header.php');
?>

<?php if ($this->options->Typecho版本 == 'ty正式版'):?> 
    <?php $this->need('common/sticy11.php'); ?>  
<?php else : ?>
    <?php $this->need('common/sticy12.php'); ?>
<?php endif; ?>

<?php if ($this->options->swiper):?>
<?php if ($this->options->Typecho版本 == 'ty正式版'):?> 
<?php if($this->is('index') && $this->_currentPage == 1): ?>
<?php $this->need('common/slide.php'); ?>
<?php endif; ?>
<?php else : ?>
<?php if($this->is('index') && $this->currentPage == 1): ?>
<?php $this->need('common/slide.php'); ?>
<?php endif; ?>   
<?php endif; ?>
<?php endif; ?>
<?php $this->need('common/list.php'); ?>
<?php $this->need('common/paging.php'); ?>
<?php $this->need('common/footer.php'); ?>

