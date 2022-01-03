<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Author: 山卜方
 * CreateTime: 2021/9/26
 * 主题功能
 */
class feature {
    public static function ThemeUrl($path = '') {
		return Helper::options()->themeUrl . $path;
	}
    
	  //解析歌单url
	  public static function ParseMusic($url)
	  {
		  $media = null;
		  $id = null;
		  $type = null;
		  if (empty($url)) {
			  return array('media' => 'media', 'id' => 'id', 'type' => 'type');
		  }
		  if (strpos($url, '163.com') !== false) {
			  $media = 'netease';
			  if (preg_match('/playlist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
			  elseif (preg_match('/toplist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
			  elseif (preg_match('/album\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'album');
			  elseif (preg_match('/song\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'song');
			  elseif (preg_match('/artist\?id=(\d+)/i', $url, $id)) list($id, $type) = array($id[1], 'artist');
		  } elseif (strpos($url, 'qq.com') !== false) {
			  $media = 'tencent';
			  if (preg_match('/playlist\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'playlist');
			  elseif (preg_match('/album\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'album');
			  elseif (preg_match('/song\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'song');
			  elseif (preg_match('/singer\/([^\.]*)/i', $url, $id)) list($id, $type) = array($id[1], 'artist');
		  }
		  return array('media' => $media, 'id' => $id, 'type' => $type);
	  }
    /**
     * 内容归档
     * @return array
     */
    public static function archives($widget, $excerpt = false)
    {
        $db = Typecho_Db::get();
        $rows = $db->fetchAll($db->select()
                    ->from('table.contents')
                    ->order('table.contents.created', Typecho_Db::SORT_DESC)
                    ->where('table.contents.type = ?', 'post')
                    ->where('table.contents.status = ?', 'publish')
                    ->where('table.contents.created < ?', time()));

        $stat = array();
        foreach ($rows as $row) {
            $row = $widget->filter($row);
            $arr = array(
                'title' => $row['title'],
                'permalink' => $row['permalink'],
                'commentsNum' => $row['commentsNum'],
                'views' => $row['views'],
            );
            
            if($excerpt){
                $arr['excerpt'] = substr($row['content'], 30);
            }
            if (Helper::options()->归档年份 ) {
            $stat[date('Y', $row['created'])][$row['created']] = $arr;
        } else{
            $stat[date('Y-n', $row['created'])][$row['created']] = $arr;
        }
        }
        return $stat;
    }
    //浏览器输出
    public static function getBrowser($agent)
    {
        if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
            $outputer = '<i class="iconfont icon-edge"></i> 来自 Edge 浏览器';
        } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
          $str1 = explode('Firefox/', $regs[0]);
    $FireFox_vern = explode('.', $str1[1]);
            $outputer = '<i class="iconfont icon-firefox"></i> 来自 Firefox 浏览器';
        } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
          $str1 = explode('Maxthon/', $agent);
    $Maxthon_vern = explode('.', $str1[1]);
            $outputer = '<i class="iconfont icon-edge"></i> 来自 Edge 浏览器';
        } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
            $str1 = explode('Edge/', $regs[0]);
    $Edge_vern = explode('.', $str1[1]);
            $outputer = '<i class="iconfont icon-edge"></i> 来自 Edge 浏览器';
        } else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
            $outputer = '<i class="iconfont icon-opera"></i> 来自 Opera 浏览器';
        } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
    $str1 = explode('Chrome/', $agent);
    $chrome_vern = explode('.', $str1[1]);
            $outputer = '<i class="iconfont icon-chrome"></i> 来自 Chrome 浏览器';
        } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
             $str1 = explode('Version/',  $agent);
    $safari_vern = explode('.', $str1[1]);
            $outputer = '<i class="iconfont icon-safari"></i> 来自 Safari 浏览器';
        } else{
            $outputer = '<i class="iconfont icon-xingzhuangjiehe"></i> 来自微信时光机';
        }
        echo $outputer;
    }
//留言墙

public static function getFriendWall()
{
	$_var_121 = Typecho_Widget::widget('Widget_Options');
	$_var_122 = Typecho_Db::get();
	$_var_123 = time() - 604800;
	$_var_127 = $_var_122->select('COUNT(author) AS cnt', 'author', 'max(url) url', 'max(mail) mail')->from('table.comments')->where('status = ?', 'approved')->where('created > ?', $_var_123)->where('type = ?', 'comment')->where('authorId = ?', '0')->where('mail != ?', $_var_121->socialemail)->group('author')->order('cnt', Typecho_Db::SORT_DESC)->limit('51');
	$_var_128 = $_var_122->fetchAll($_var_127);
	$_var_130 = 0;
	if (count($_var_128) > 0) {
		foreach ($_var_128 as $_var_131) {
			$_var_132 = '';
			if ($_var_130 < 3) {
				$_var_132 = $_var_126[$_var_130 % 3];
			}
			$_var_124 = feature::getAvator($_var_131['mail'], 65);
			if (trim($_var_131['url']) == '') {
				$_var_125 =('这是一位非常神秘的人');
			} else {
				$_var_125 = $_var_131['url'];
			}

    $_var_129 .= <<<EOF
    <div class="talk_list"><a href="{$_var_131['url']}" target="_blank" ><div class="talk_list_img"><img src="{$_var_124}"></div><div class="talk_list_right"><div class="talk_list_body"><div class="talk_list_name">{$_var_131['author']}</div></div><div class="talk_address">{$_var_125}</div></div><div class="talk_count">{$_var_131['cnt']}</div></a></div>
EOF
;
			$_var_130++;
		}

		echo $_var_129;
	} 
}
    //文章内第一张照片做封面图
    public static function getPostImg($archive){
        $img = array();
        preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $archive->content, $img);
        if (count($img) > 0 && count($img[0]) > 0) {
            return $img[1][0];
        } else {
            return $img="/usr/themes/pigeon/assets/img/".rand(0,$rand_num).".jpg";;
        }
    }

    //文章内照片数量
    public static function imgNum($content){
        $output = preg_match_all('#<img(.*?) data-src="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#',$content,$s);
        $cnt = count( $s[1] );
        return $cnt;
    }
    //隐私评论
    public static function get_comment_at($_var_108)
    {
        $_var_109 = Typecho_Db::get();
        $_var_110 = $_var_109->fetchRow($_var_109->select('parent,status')->from('table.comments')->where('coid = ?', $_var_108));
        $_var_111 = '';
        $_var_112 = @$_var_110['parent'];
        if ($_var_112 != '0') {
            $_var_113 = $_var_109->fetchRow($_var_109->select('author,status,mail')->from('table.comments')->where('coid = ?', $_var_112));
            @($_var_114 = @$_var_113['author']);
            $_var_111 = @$_var_113['mail'];
            if (@$_var_114 && $_var_113['status'] == 'approved') {
                if (@$_var_110['status'] == 'waiting') {}
            } else {
                if (@$_var_110['status'] == 'waiting') {
                } else {
                    echo '';
                }
            }
        } else {
            if (@$_var_110['status'] == 'waiting') {
            } else {
                echo '';
            }
        }
        return $_var_111;
    }

    //隐私评论
    public static function insertSecret($comment)
    {
        if ($_POST['secret']) {
            $comment['text'] = '[secret] &nbsp;' . $comment['text'] . '[/secret]';
        }
        return $comment;
    }
	//评论加@
    public static function reply($parent) {
        if ($parent == 0) {
            return '';
        }
        $db = Typecho_Db::get();
        $commentInfo = $db->fetchRow($db->select('author,status,mail')->from('table.comments')->where('coid = ?', $parent));
        $link = '<a class="parent" href="#comment-' . $parent . '">@' . $commentInfo['author'] .  '</a>';
        return $link;
    }

    public static function ImageEcho($options)
    {
            if (Helper::options()->随机图) {
                $text = Helper::options()->随机图;
                $img_arr = explode("\n", $text);
                $rand_num = rand(1, count($img_arr));
                return $img_arr[$rand_num - 1];
            } 
    }
    


	//表情解析
    public static function parseContent($text, $widget, $lastResult)
    {
        $text = empty($lastResult) ? $text : $lastResult;
        if ($widget instanceof Widget_Abstract_Comments) {
            $text = Shortcode::parseBiaoQing($text);
        }
        return $text;
    }

    /**
     * 泡泡表情回调函数
     *
     * @return string
     */
    public static function parsePaopaoBiaoqingCallback($match)
    {
        return '<img class="biaoqing paopao" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/paopao/') . str_replace('%', '', urlencode($match[1])) . '_2x.png" height="30" width="30">';
    }

    /**
     * 阿鲁表情回调函数
     *
     * @return string
     */
    public static function parseAruBiaoqingCallback($match): string
    {
        return '<img class="biaoqing alu" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/aru/') . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }

    /**
     * 蛆音娘表情回调函数
     *
     * @return string
     */
    public static function parseQuyinBiaoqingCallback($match): string
    {
        return '<img class="biaoqing quyin" src="' . ('https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/biaoqing/quyin/') . str_replace('%', '', urlencode($match[1])) . '.png">';
    }

    //HTML压缩
    public static function compressHtml($html_source)
{
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

    //分类输出
    private static function ArchiverSort($var)
    {
        $sort = null;
        $i = 0;
        if (Helper::options()->sortalls == '展开分类') {
            while ($var->next()) {
                if ($var->levels === 0) {
                    $children = $var->getAllChildren($var->mid);
                    if (empty($children)) {
                            $sort .= '<li class="meun_li"><a href="' . $var->permalink . '">'. $var->name . '</a></li>';
                    } else {
                        $sort .= '<li class="meun_li level">';
                        $sort .= '<a href="javascript:;">'. $var->name . '</a>';
                        $sort .= '<ul class="level_ul">';
                        foreach ($children as $mid) {
                            $child = $var->getCategory($mid);
                            $sort .= '<li class="level_li"><a href="' . $child['permalink'] . '">' . $child['name'] . '</a></li>';
                            $i--;
                        }
                        $sort .= '</ul></li>';
                    }
                }
                $i++;
            }
        }elseif (Helper::options()->sortalls == '合并分类') {
            $sortTitle = Helper::options()->sortallstit ? Helper::options()->sortallstit : '分类';
            $sort .= '<li class="meun_li level">';
            $sort .= '<a href="javascript:;">' . $sortTitle . '</a>';
            $sort .= '<ul class="level_ul">';
            while ($var->next()) {
            $sort .= '<li class="level_li"><a href="' . $var->permalink . '">'. $var->name . '</a></li>';
            }
            $sort .= '</ul></li>';

        }elseif (Helper::options()->sortalls == '关闭分类') {

        }
        return $sort;
    }

    //页面输出
  private static function EchoPages($var)
  {
      $page = null;
      $i = 0;
      if (empty(Helper::options()->pagealls)) {
          while ($var->next()) {
            $page .= '<li class="meun_li"><a href="' . $var->permalink . '">' . $var->title . '</a></li>';
              $i++;
          }
      } else {
          $pagesTitle = Helper::options()->pageallstit ? Helper::options()->pageallstit : '页面';
        $page .= '<li class="meun_li level">';
        $page .= '<a href="javascript:;">' . $pagesTitle . '</a>';
        $page .= '<ul class="level_ul">';
          while ($var->next()) {
            $page .= '<li class="level_li"><a href="' . $var->permalink . '">' . $var->title . '</a></li>';
          }
          $page .= '</ul></li>';
      }
      return $page . self::MyPageUrl();
  }

      //自定义导航链接
      private static function MyPageUrl()
      {
          $lonely = null;
          if (empty(Helper::options()->lonelyalls)) {
            if (!empty(Helper::options()->urltext)) {
                $text = explode("\n", Helper::options()->urltext);
                foreach ($text as $url) {
                    $lonely .= '<li class="meun_li">' . $url . '</li>'; 
                }
            }
          }else {
            $lonelyTitle = Helper::options()->lonelyallstit ? Helper::options()->lonelyallstit : '页面';
            $lonely .= '<li class="meun_li level">';
            $lonely .= '<a href="javascript:;">' . $lonelyTitle . '</a>';
            $lonely .= '<ul class="level_ul">';
            if (!empty(Helper::options()->urltext)) {
                $text = explode("\n", Helper::options()->urltext);
                foreach ($text as $url) {
                    $lonely .= '<li class="level_li">' . $url . '</li>'; 
                }
            }
            $lonely .= '</ul></li>';
            
          }
    
          return $lonely;
      }


        //分类和独立页面顺序设置
  public static function OrderSet($p, $c)
  {
      if (Helper::options()->pageortags == '独前分后') {
          return self::EchoPages($p) . self::ArchiverSort($c);
      } elseif (Helper::options()->pageortags == '分前独后') {
          return self::ArchiverSort($c) . self::EchoPages($p);
      } else {
          return self::ArchiverSort($c) . self::EchoPages($p);
      }
  }

  	//首页调取多张缩略图
	public static function showThumbnail($widget,$imgnum) {
		$rand = rand(4,20);
		$attach = $widget->attachments(1)->attachment;
		$pattern = '/\<img.*? data-src\=\"(.*?)\"[^>]*>/i';
		$patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png))/i';
		if (preg_match_all($pattern, $widget->content, $thumbUrl)) {
			echo $thumbUrl[1][$imgnum];
		} else if ($attach && $attach->isImage) {
			echo $attach->url;
		} else if (preg_match_all($patternMD, $widget->content, $thumbUrl)) {
			echo $thumbUrl[3][$imgnum];
		}
	}

        //友好时间化
    public static function formatTime($time){
        $text = '';
        $time = intval($time);
        $ctime = time();
        $t = $ctime - $time; //时间差
        if ($t < 0) {
            return date('Y-m-d', $time);
        }
        $y = date('Y', $ctime) - date('Y', $time);//是否跨年
        switch ($t) {
            case $t == 0:
                $text = '刚刚';
                break;
            case $t < 60://一分钟内
                $text = $t . '秒前';
                break;
            case $t < 3600://一小时内
                $text = floor($t / 60) . '分钟前';
                break;
            case $t < 86400://一天内
                $text = floor($t / 3600) . '小时前'; // 一天内
                break;
            case $t < 2592000://30天内
                if($time > strtotime(date('Ymd',strtotime("-1 day")))) {
                    $text = '昨天';
                } elseif($time > strtotime(date('Ymd',strtotime("-2 days")))) {
                    $text = '前天';
                } else {
                    $text = floor($t / 86400) . '天前';
                }
                break;
            case $t < 31536000 && $y == 0://一年内 不跨年
                $m = date('m', $ctime) - date('m', $time) -1;
                if($m == 0) {
                    $text = floor($t / 86400) . '天前';
                } else {
                    $text = $m . '个月前';
                }
                break;
            case $t < 31536000 && $y > 0://一年内 跨年
                $text = (11 - date('m', $time) + date('m', $ctime)) . '个月前';
                break;
            default:
                $text = (date('Y', $ctime) - date('Y', $time)) . '年前';
                break;
        }
        return $text;
    }

        //阅读次数
        public static function get_post_view($archive)
        {
        $cid    = $archive->cid;
        $db     = Typecho_Db::get();
        $prefix = $db->getPrefix();
        if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
            $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
            echo 0;
            return;
        }
        $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
        if ($archive->is('single')) {
     $views = Typecho_Cookie::get('extend_contents_views');
            if(empty($views)){
                $views = array();
            }else{
                $views = explode(',', $views);
            }
    if(!in_array($cid,$views)){
           $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    array_push($views, $cid);
                $views = implode(',', $views);
                Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
            }
        }
        echo $row['views'];
    }

    //评论头像
    public static function getAvator($email,$size){
        
            $str = explode('@', $email);
            if (@$str[1] == 'qq.com' && @ctype_digit($str[0]) && @strlen($str[0]) >=5
                && @strlen($str[0])<=11) {
                $avatorSrc = 'https://q.qlogo.cn/g?b=qq&nk='.$str[0].'&s=100';
            }else{
                $avatorSrc = feature::getGravator($email,$cdnUrl,$size);
            }
        return $avatorSrc;
    }
    public static function avatarHtml($obj){
        $email = $obj->mail;
        $avatorSrc = feature::getAvator($email,65);
        return ''.$avatorSrc.'';
    }
    public static function getGravator($email,$host,$size){
        $default = '';
        if (strlen($options->defaultAvator) > 0){
            $default = $options->defaultAvator;
        }
        $url = '/';
        $rating = Helper::options()->commentsAvatarRating;
        $hash = md5(strtolower($email));
        $avatar = '//sdn.geekzu.org/avatar' . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
        return $avatar;
    }


    public static function excerpt($content, $limit)
    {

        if ($limit == 0) {
            return "";
        } else {
            $content = self::returnExceptShortCodeContent($content);
            if (trim($content) == "") {
                return ("暂时无可提供的摘要");
            } else {
                return Typecho_Common::subStr(strip_tags($content), 0, $limit, "...");
            }
        }
    }

    //短代码排除
    public static function returnExceptShortCodeContent($content)
    {
        $v = array(
            'button', 'cid', 'login', 'hide', 'tabs', 'collapse', 'tip', 'photos', 'mp3',
            'video', 'bilibili', 'colour'
        );

        foreach ($v as $l) {
            if (strpos($content, '[' . $l) !== false) {
                $pattern = core::get_shortcode_regex(array($l));
                $content = preg_replace("/$pattern/", '', $content);
            }
        }
        $content = preg_replace('/\$\$[\s\S]*\$\$/sm', '', $content);
        return $content;
    }

    


	//后台设置项备份
	public static function BackSet() {
		$name = $GLOBALS['config']['theme'];
		$db = Typecho_Db::get();
		$sjdq = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name));
		$ysj = $sjdq['value'];
		if (isset($_POST['type'])) {
			if ($_POST["type"] == "备份") {
				if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
					$update = $db->update('table.options')->rows(array('value' => $ysj))->where('name = ?', 'theme:' . $name . 'bf');
					$updateRows = $db->query($update);
					exit("<script type='text/javascript'>alert('主题备份已更新！');history.go(-1);</script>");
				} else {
					if ($ysj) {
						$insert = $db->insert('table.options')
						                              ->rows(array('name' => 'theme:' . $name . 'bf', 'user' => '0', 'value' => $ysj));
						$insertId = $db->query($insert);
						exit("<script type='text/javascript'>alert('主题备份完成！');history.go(-1);</script>");
					}
				}
			}
			if ($_POST["type"] == "还原") {
				if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
					$sjdub = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'));
					$bsj = $sjdub['value'];
					$update = $db->update('table.options')->rows(array('value' => $bsj))->where('name = ?', 'theme:' . $name);
					$updateRows = $db->query($update);
					exit("<script type='text/javascript'>alert('检测到模板备份数据，恢复完成！');history.go(-1);</script>");
				} else {
					exit("<script type='text/javascript'>alert('无备份数据，恢复失败！');history.go(-1);</script>");
				}
			}
			if ($_POST["type"] == "删除") {
				if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $name . 'bf'))) {
					$delete = $db->delete('table.options')->where('name = ?', 'theme:' . $name . 'bf');
					$deletedRows = $db->query($delete);
					exit("<script type='text/javascript'>alert('删除成功！');history.go(-1);</script>");
				} else {
					exit("<script type='text/javascript'>alert('无数据，删除失败！');history.go(-1);</script>");
				}
			}
		}
    }
	
	public static function CheckSetBack() {
		$db = Typecho_Db::get();
		$res = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $GLOBALS['config']['theme'] . 'bf'));
		if ($res) {
			return '<span style="color: #1462ff">模板已备份</span>';
		} else {
			return '<span style="color: red">未备份任何数据</span>';
		}
	}

}

//后台标签文本
class EchoHtml extends Typecho_Widget_Helper_Layout {
	public function __construct($html) {
		$this->html($html);
		$this->start();
		$this->end();
	}
	public function start() {
	}
	public function end() {
	}
}