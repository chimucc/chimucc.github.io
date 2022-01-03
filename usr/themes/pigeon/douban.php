<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 豆瓣清单
 *
 * @package custom
 *
 */$this->need('common/header.php');
?>

<?php
require 'libs/ParserDom.php';


//获取豆瓣清单数据
function getDoubanData($userID,$type){

    $dataList = [];
    $filePath = __DIR__.'/assets/cache/'.$type.'.json';

    $fp = fopen($filePath, 'r');
    if ($fp) {
        $contents = fread($fp, filesize($filePath));
        fclose($fp); 
        $data = json_decode($contents);
        if (time() - $data->time > 60 * 60 * 72) {//缓存文件过期
            $dataList = updateData($userID,$filePath,$type);
        }else{
            $lastUpdateTime = date('Y-m-d', $data->time); //H 24小时制 2017-08-08 23:00:01
            if ($data->user!=null && $data->user !== $userID){//用户名有修改
                $dataList = updateData($userID,$filePath,$type);
            }else {
                if ($data->data == null || $data->data == ""){//缓存文件中的电影数据为空
                    $dataList = updateData($userID,$filePath,$type);
                }else{//读取缓存文件中的数据
                    $dataList = $data->data;
                    echo '';
                }
            }
        }
    } else {//目录下无movie.json，此时需要创建文件，并且更新信息
        $dataList = updateData($userID,$filePath,$type);
    }
    return $dataList;
}

function curl_get_contents($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


function updateData($doubanID = 'shanbufun',$filePath,$type)
{
    $url = "https://".$type.".douban.com/people/$doubanID/collect"; //最多取100条数据，后面考虑支持分页获取，因为不知道分页按钮怎么写比较好看……
    $p1 = getHTML($url);
    $movieList=[];
    $p1 = getMoviesAndNextPage($p1,$type);
    $movieList = array_merge($p1['data']);
    $num = 0;
    while ($p1['next']!=null && $num <= 3) {
        $p1          = getHTML($p1['next']);
        $p1          = getMoviesAndNextPage($p1,$type);
        $movieList = array_merge($movieList, $p1['data']);
        $num ++;

    }
    if ($movieList == null || $movieList == ""){
        $function = "";
        if(!function_exists('json_decode')) {
            $function .= "服务器不支持json_decode()方法";
        }
        if(!function_exists('curl_init')) {
            $function .= " 服务器没有curl扩展";
        }
        $info =  "获取豆瓣数据失败，可能原因是：1. ip被豆瓣封锁（修改140行代码的cookie） 2. 豆瓣id配置错误（检查该地址是否能够打开".$url."）3. ".$function;
        echo '<script>$(function(){$(".douban_tips").text('.$info.')})</script>';
    }else{
        echo '<script>$(function(){$(".douban_tips").html("添加缓存数据成功，请刷新一次页面查看最新数据（如果一直提示刷新，请勿将全站静态缓存和检查主题下是否存在<code>assets/cache</code>目录）")})</script>';
    }
    $data = fopen($filePath, "w");
    fwrite($data, json_encode(['time' => time(), 'user' => $doubanID , 'data' => $movieList]));
    fclose($data);
    return [];
}

function getMoviesAndNextPage($html = '',$type)
{
    $selector = [];
    if ($type == "movie"){
        $selector["item"] = "div.item";
        $selector["title"] = "li.title";
        $selector["img"] = "div.pic a img";
        $selector["href"] = "a";
        $selector["next"] = "span.next a";

    }else{
        $selector["item"] = ".subject-item";
        $selector["title"] = ".info h2";
        $selector["img"] = "div.pic a img";
        $selector["href"] = "a";
        $selector["next"] = "span.next a";
    }
    if ($html != "" && $html != null){
        $doc       = new \HtmlParser\ParserDom($html);
        $itemArray = $doc->find($selector["item"]);
        $movieList = [];
        foreach ($itemArray as $v) {
            $t = $v->find($selector['title'], 0);
            $movie_name = trimall($t->getPlainText());
            $movie_img  = $v->find($selector["img"], 0)->getAttr("src");
            $movie_url  = $t->find($selector["href"], 0)->getAttr("href");
            //已经读过的电影
            $movieList[] = array("name" => $movie_name, "img" => $movie_img, "url" => $movie_url);
        }

        $t = $doc->find($selector["next"], 0);
        if ($t) {
            $t = "https://".$type.".douban.com" .$t->getAttr("href");
        }else{
            $t = null;
        }
        return ['data' => $movieList, 'next' =>  $t];
    }else{
        return ['data' => [], 'next' => null];
    }


}

function getHTML($url = '')
{
    $ch = curl_init();
    $cookie = 'bid=Km3ZGpkEE00; ap_v=0,6.0; _pk_ses.100001.3ac3=*; __utma=30149280.1672442383.1554254872.1554254872.1554254872.1; __utmc=30149280; __utmz=30149280.1554254872.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt_douban=1; __utma=81379588.1887771065.1554254872.1554254872.1554254872.1; __utmc=81379588; __utmz=81379588.1554254872.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt=1; ll="108288"; _pk_id.100001.3ac3=88bbbc1a1f571a42.1554254872.1.1554254939.1554254872.; __utmb=30149280.7.10.1554254872; __utmb=81379588.7.10.1554254872';

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');

    $output = curl_exec($ch);

    if (FALSE === $output)
        throw new Exception(curl_error($ch), curl_errno($ch));

    curl_close($ch);
    return $output;
}

function trimall($str)
{
    $qian = array(" ", "　", "\t", "\n", "\r");
    $hou  = array("", "", "", "", "");
    return str_replace($qian, $hou, $str);
}

?>

            <div class="content_top">

                <article class="public">
                    <input type="radio" name="tab" id="douban_book" class="reward_none" checked="">
                    <input type="radio" name="tab" id="douban_movie" class="reward_none">
                    <div class="douban_tab">
                        <div class="douban_tab_list">
                            <label for="douban_book"><span class="douban_option_book">阅读</span></label>
                            <label for="douban_movie"><span class="douban_option_movie">观影</span></label>
                        </div>
                    </div>

                    <div class="douban douban_box_book reward_none">
                    <?php $readList = getDoubanData($this->fields->doubanID,"book"); foreach($readList as $v):?>
                        <div class="douban_list">
                            <a href="<?php echo $v->url;?>">
                                <div class="douban_cover">
                                    <img class="lazy" data-src="<?php $img = "https://images.weserv.nl/?url=" . str_replace('img1','img3',$v->img); echo $img; ?>">
                                </div>
                                <h5 class="douban_name"><?php echo $v->name;?></h5>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="douban douban_box_movie reward_none">
                    <?php $movieList = getDoubanData($this->fields->doubanID,"movie"); foreach ($movieList as $v): ?>
                        <div class="douban_list">
                            <a href="<?php echo $v->url; ?>">
                                <div class="douban_cover">
                                    <img class="lazy" data-src="<?php $img = "https://images.weserv.nl/?url=" . str_replace('img1','img3',$v->img); echo $img; ?>">
                                </div>
                                <h5 class="douban_name"><?php echo $v->name;?></h5>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                </article>

                
                <div class="post_comments">
                    <div class="line">
                        <div class="line_name">评论 <small>( <?php $this -> commentsNum('%d'); ?> )</small></div>
                    </div>
                    <?php $this->need('common/comments.php'); ?>
                </div>

            </div>
<?php $this->need('common/footer.php'); ?>