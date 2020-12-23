<?php
function page($total_records,$page_size,$page_current,$url,$id){
    $total_pages = ceil($total_records/$page_size);
    $page_previous=($page_current<1)?1:$page_current-1;
    $page_next=($page_current>=$total_pages)?$total_pages:$page_current+1;
    $page_next=($page_next==0)?1:$page_next;//没有记录时，$page_next的最小值为1
    $navigator = "<a class='file' href=$url?id=$id&page_current=$page_previous>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $page_start = ($page_current-5>0)?$page_current-5:0;
    $page_end = ($page_start+10<$total_pages)?$page_start+10:$total_pages;
    $page_start = $page_end-10;
    if($page_start<0) $page_start = 0;
    for($i=$page_start;$i<$page_end;$i++){
        $j = $i+1;
        $navigator.="<a href='$url?id=$id&page_current=$j'><font color='#3e8cff' size='5px'>$j</font></a>";
    }
    $navigator.="&nbsp;&nbsp;&nbsp;&nbsp;<a class='file' href=$url?id=$id&page_current=$page_next>下一页</a><br/>";
    $navigator.="共".$total_records."条留言，共".$total_pages."页，当前是第".$page_current."页";
    echo"<div style='margin-top: 5%;text-align: center'>";
    echo "<font color='white' size='4px'>";
    echo $navigator;
    echo"</font>";
    echo "</div>";
}
?>