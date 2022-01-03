<?php
/**
 * Author: 山卜方
 * CreateTime: 2020/9/29 19:08
 * 隐私评论 相册 回复可见
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class core{

    /**
     * 私密内容正则替换回调函数
     * @param $matches
     * @return bool|string
     */
    public static function secretContentParseCallback($matches)
    {
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        return '<div class="hideContent">' . $matches[5] . '</div>';
    }
    public static function parseContentPublic($content)
    {
        return $content;
    }

    /**
     * 解析时光机页面的评论内容
     * @param $content
     * @return string
     */
    public static function timeMachineCommentContent($content)
    {
        return core::parseContentPublic($content);
    }

    /**
     * 解析文章页面的评论内容
     * @param $content
     * @param boolean $isLogin 是否登录
     * @param $rememberEmail
     * @param $currentEmail
     * @param $parentEmail
     * @param bool $isTime
     * @return mixed
     */
    public static function postCommentContent($content, $isLogin, $rememberEmail, $currentEmail, $parentEmail, $isTime = false)
    {
        $flag = true;
        if (strpos($content, '[secret]') !== false) {
            $pattern = self::get_shortcode_regex(array('secret'));
            $content = preg_replace_callback("/$pattern/", array('core', 'secretContentParseCallback'), $content);
            if ($isLogin || ($currentEmail == $rememberEmail && $currentEmail != "") || ($parentEmail == $rememberEmail && $rememberEmail != "")) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        if ($flag) {
            $content = core::parseContentPublic($content);
            
            return $content;
        } else {
            if ($isTime) {
                return '<div class="hideContent">此条为私密说说，仅发布者可见</div>';
            } else {
                return '<div class="hideContent"><div class="hideContent_box">哎呦喂，瞧给你聪明的！</div><div class="hideContent_text">此条为私密说说，仅发布者可见</div></div>';
            }
        }
        
    }



    
    /**
     * 输入内容之前做一些有趣的替换+输出文章内容
     *
     * @param $obj
     * @param $status
     * @return string
     */
    public static function postContent($obj, $status)
    {
        $content = $obj->content;
        $isImagePost = self::isImageCategory($obj->categories);


        if ($isImagePost) {//照片文章
            $content = self::postImagePost($content, $obj);
        } else {//普通文章
            if ($obj->hidden == true && trim($obj->fields->lock) != "") {//加密文章且没有访问权限
                echo '<p class="text-muted protected"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;' . ("密码提示") . '：' . $obj->fields->lock . '</p>';
            }

            $db = Typecho_Db::get();
            $sql = $db->select()->from('table.comments')
                ->where('cid = ?', $obj->cid)
                ->where('status = ?', 'approved')
                ->where('mail = ?', $obj->remember('mail', true))
                ->limit(1);
            $result = $db->fetchAll($sql);//查看评论中是否有该游客的信息

            //文章中部分内容隐藏功能（回复后可见）
            if ($status || $result) {
                $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="reply2view">$1</div>', $content);
            } else {
                $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="signview"><div class="signview_box"><img src="https://cdn.jsdelivr.net/gh/novcu/picture/hidden.png"></div><div class="signview_text"><div class="signview_text_title">' . ("此处内容需要评论<a href='#comments'>回复</a>后（审核通过）方可阅读。") . '</div></div></div>', $content);
            }
            
            $content = core::parseContentPublic($content);
        }
        return trim($content);
    }

    /**
     * 判断是否是相册分类
     * @param $data
     * @return bool
     */
    public static function isImageCategory($data)
    {
        //print_r($data);
        if (is_array($data)) {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]["slug"] == "image") {
                    return true;
                }
            }
        }
        return false;

    }

    /**
     * @param $content
     * @param $obj
     * @return string
     */
    public static function postImagePost($content, $obj)
    {
        if ($obj->hidden === true) {//输入密码访问
            return $content;
        } else {
            return core::parseContentToImage($content,"album");
        }
    }

       /**
     * 解析文章内容为图片列表（相册）
     * @param $content
     * @return string
     */
    public static function parseContentToImage($content,$type)
    {
        preg_match_all('/<img.*?src="(.*?)"(.*?)(alt="(.*?)")??(.*?)\/?>/', $content, $matches);
        $html = "";
            $html .= "<div class='photos_album'>";
        if (is_array($matches)) {
//            print_r($matches);
            if (count($matches[0]) == 0) {
                $html .= '<small class="text-muted letterspacing indexWords">相册无图片</small>';
            } else {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $info = trim($matches[0][$i]);
                    preg_match('/src="(.*?)"/', $info, $info);
                    $infos = trim($matches[5][$i]);
                    preg_match('/alt="(.*?)"/', $infos, $infos);
                    if (is_array($info) && count($info) >= 2) {
//                        print_r($info);
                        $info = @$info[1];
                    } else {
                        $info = "";
                    }
                    if (is_array($infos) && count($infos) >= 2) {
                        $infos = @$infos[1];
                    } else {
                        $infos = "";
                    }
                        $html .= <<<EOF
<div class="post_album_list"><a class="lazyload-container" data-fancybox="gallery" href="{$info}">{$matches[0][$i]}</a><figcaption>{$infos}</figcaption></div>


EOF;
                  
                }
            }
        }
        $html .= "</div>";

        return $html;
}


    /**
     * 获取匹配短代码的正则表达式
     * @param null $tagnames
     * @return string
     * @link https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L254
     */
    public static function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
        // phpcs:enable
    }

}