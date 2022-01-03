
<?php
					$swipers = [];
					$swipers_text = $this->options->轮番图;
					if ($swipers_text) {
						$swipers_arr = explode("\r\n", $swipers_text);
						if (count($swipers_arr) > 0) {
							for ($i = 0; $i < count($swipers_arr); $i++) {
								$img = explode("||", $swipers_arr[$i])[0];
								$url = explode("||", $swipers_arr[$i])[1];
								$title = explode("||", $swipers_arr[$i])[2];
								$swipers[] = array("img" => trim($img), "url" => trim($url), "title" => trim($title));
							};
						}
					}
					?>

<div class="index_slide <?= Plate::slide_cards($this) ?>">
  <div class="swiper-container">
    <div class="swiper-wrapper">
    <?php foreach ($swipers as $items) : ?>
      <div class="swiper-slide">
        <div class="index_slide_box">
          <a href="<?php echo $items['url'] ?>">
            <div class="index_slide_img">
              <img src="<?php echo $items['img'] ?>"></div>
            <div class="index_slide_filter"></div>
            <div class="index_slide_frame">
              <h5 class="index_slide_title"><?php echo $items['title'] ?></h5></div>
          </a>
        </div>
      </div>
    <?php endforeach; ?>


    </div>
    <div class="swiper-pagination"></div>
    <div class="slide_button-next"><i class="iconfont icon-icon-test"></i></div>
    <div class="slide_button-prev"><i class="iconfont icon-icon-test1"></i></div>
  </div>
</div>