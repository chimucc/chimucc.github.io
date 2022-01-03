<?php
$sticky = $this->options->sticky; //置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔
if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));//分割文本 
    $sticky_html = "<span style='color:red'><i class='text-primary match_color_z'>•</i>置顶</span>"; //置顶标题的 html
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    //清空原有文章的列队
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
        if($i == 0) $select1->where('cid = ?', $cid);
        else $select1->orWhere('cid = ?', $cid);
        $order .= " when $cid then $i";
        $select2->where('table.contents.cid != ?', $cid); //避免重复
    }
    if ($order) $select1->order('', "(case cid$order end)");
    if ($this->currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){
        $sticky_post['sticky'] = $sticky_html;
        $this->push($sticky_post); //压入列队
    }
$uid = $this->user->uid; //登录时，显示用户各自的私密文章
    if($uid) $select2->orWhere('authorId = ? && status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); //压入列队
    $this->setTotal($this->getTotal()-count($sticky_cids)); //置顶文章不计算在所有文章内
}	?>