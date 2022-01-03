<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Utils {

    public static function uploadPic($blogUrl, $name, $pic,$type,$suffix){
        $DIRECTORY_SEPARATOR = "/";
        $childDir = $DIRECTORY_SEPARATOR.'usr'.$DIRECTORY_SEPARATOR.'uploads' . $DIRECTORY_SEPARATOR .'time' .$DIRECTORY_SEPARATOR;
        $dir = __TYPECHO_ROOT_DIR__ . $childDir;
        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
        $fileName = $name. $suffix;
        $file = $dir .$fileName;
        //TODO:支持图片压缩
        if ($type == "web"){
            //开始捕捉
            $img = self::getDataFromWebUrl($pic);
        }else{
            $img = $pic;//本地图片直接就是二进制数据
        }
        $fp2 = fopen($file , "a");
        fwrite($fp2, $img);
        fclose($fp2);

        //压缩图片
        (new Imgcompress($file,1))->compressImg($file);

        return $blogUrl.$childDir.$fileName;
    }

    public static  function getDataFromWebUrl($url){
        $file_contents = "";
        if (function_exists('file_get_contents')) {
            $file_contents = @file_get_contents($url);
        }
        if ($file_contents == "") {
            $ch = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
    
        /**
     * 替换默认的preg_replace_callback函数
     * @param $pattern
     * @param $callback
     * @param $subject
     * @return string
     */
    public static function handle_preg_replace_callback($pattern, $callback, $subject){
        return self::handleHtml($subject,function ($content) use ($callback, $pattern) {
            return preg_replace_callback($pattern,$callback, $content);
        });
    }


    public static function handle_preg_replace($pattern, $replacement, $subject){
        return self::handleHtml($subject,function ($content) use ($replacement, $pattern) {
            return preg_replace($pattern,$replacement, $content);
        });
    }

        /**
     * 处理 HTML 文本，确保不会解析代码块中的内容
     * @param $content
     * @param callable $callback
     * @return string
     */
    public static function handleHtml($content, $callback) {
        $replaceStartIndex = array();
        $replaceEndIndex = array();
        $currentReplaceId = 0;
        $replaceIndex = 0;
        $searchIndex = 0;
        $searchCloseTag = false;
        $contentLength = strlen($content);
        while (true) {
            if ($searchCloseTag) {
                $tagName = substr($content, $searchIndex, 4);
                if ($tagName == "<cod") {
                    $searchIndex = strpos($content, '</code>', $searchIndex);
                    if (!$searchIndex) {
                        break;
                    }
                    $searchIndex += 7;
                } elseif ($tagName == "<pre") {
                    $searchIndex = strpos($content, '</pre>', $searchIndex);
                    if (!$searchIndex) {
                        break;
                    }
                    $searchIndex += 6;
                } elseif ($tagName == "<kbd") {
                    $searchIndex = strpos($content, '</kbd>', $searchIndex);
                    if (!$searchIndex) {
                        break;
                    }
                    $searchIndex += 6;
                } elseif ($tagName == "<scr") {
                    $searchIndex = strpos($content, '</script>', $searchIndex);
                    if (!$searchIndex) {
                        break;
                    }
                    $searchIndex += 9;
                } elseif ($tagName == "<sty") {
                    $searchIndex = strpos($content, '</style>', $searchIndex);
                    if (!$searchIndex) {
                        break;
                    }
                    $searchIndex += 8;
                } else {
                    break;
                }


                if (!$searchIndex) {
                    break;
                }
                $replaceIndex = $searchIndex;
                $searchCloseTag = false;
                continue;
            } else {
                $searchCodeIndex = strpos($content, '<code', $searchIndex);
                $searchPreIndex = strpos($content, '<pre', $searchIndex);
                $searchKbdIndex = strpos($content, '<kbd', $searchIndex);
                $searchScriptIndex = strpos($content, '<script', $searchIndex);
                $searchStyleIndex = strpos($content, '<style', $searchIndex);
                if (!$searchCodeIndex) {
                    $searchCodeIndex = $contentLength;
                }
                if (!$searchPreIndex) {
                    $searchPreIndex = $contentLength;
                }
                if (!$searchKbdIndex) {
                    $searchKbdIndex = $contentLength;
                }
                if (!$searchScriptIndex) {
                    $searchScriptIndex = $contentLength;
                }
                if (!$searchStyleIndex) {
                    $searchStyleIndex = $contentLength;
                }
                $searchIndex = min($searchCodeIndex, $searchPreIndex, $searchKbdIndex, $searchScriptIndex, $searchStyleIndex);
                $searchCloseTag = true;
            }
            $replaceStartIndex[$currentReplaceId] = $replaceIndex;
            $replaceEndIndex[$currentReplaceId] = $searchIndex;
            $currentReplaceId++;
            $replaceIndex = $searchIndex;
        }

        $output = "";
        $output .= substr($content, 0, $replaceStartIndex[0]);
        for ($i = 0; $i < count($replaceStartIndex); $i++) {
            $part = substr($content, $replaceStartIndex[$i], $replaceEndIndex[$i] - $replaceStartIndex[$i]);
            if (is_array($callback)) {
                $className = $callback[0];
                $method = $callback[1];
                $renderedPart = call_user_func($className.'::'.$method, $part);
            } else {
                $renderedPart = $callback($part);
            }
            $output.= $renderedPart;
            if ($i < count($replaceStartIndex) - 1) {
                $output.= substr($content, $replaceEndIndex[$i], $replaceStartIndex[$i + 1] - $replaceEndIndex[$i]);
            }
        }
        $output .= substr($content, $replaceEndIndex[count($replaceStartIndex) - 1]);
        return $output;
    }
    
    /**
     * 输出相对主题目录路径，用于静态文件
     * @param string $path
     * @return mixed
     */
    public static function indexTheme($path = '')
    {
        Helper::options()->themeUrl($path);
    }
    
    /**
     * 编辑界面添加Button
     *
     * @return void
     */
    public static function addButton()
    {
        echo '<script src="https://at.alicdn.com/t/font_2497854_nt28ee7w5q.js"></script>';
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.min.css"/>';
        echo '<script src="';self::indexTheme('/assets/js/editor.js');echo '"></script>';
        echo '<script src="https://cdn.jsdelivr.net/gh/zetheme/pigeon/OWO/OwO.js"></script>';
        echo '<style>#custom-field textarea,#custom-field input{width:100%}
        @media screen and (max-width:767px){	
            .comment-info-input{flex-direction:column;}
            .comment-info-input input{max-width:100%;margin-top:5px}
            #comments .comment-author .avatar{
                width: 2.5rem;
                height: 2.5rem;
            }
        }
        .wmd-button-row{height:unset}
        .icon {
           width: 1.3em; height: 1.3em;
           vertical-align: -0.15em;
           fill: currentColor;
           overflow: hidden;
        }
        .wmd-button {color: #9e9e9e;}
        .OwO span {
            background: none!important;
            width: unset!important;
            height: unset!important;
        }
        </style>';
    }
}