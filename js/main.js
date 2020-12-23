
$(document).ready(function () {
    let len = $('.titleList li').length //li的个数
    let titleList = document.getElementsByClassName('titleList')
    let titleLi = titleList[0].children
    let liHeight = titleLi[0].clientHeight//获取每个li的高度
    let backBox = $('.backBox');
    let flag =len > 0 ? Math.ceil((len-1)/2) : 0; //初始化中间显示
    let conetnt = $('.contentBox .contentList li');
    
    $('#titleList').css({ //标题ul的高度
        height: ((len * 2) - 1) * liHeight
    });
    backBox.css({ //设置背景盒子的位置和长度
        'top': (len - 1) * liHeight,
        'height': liHeight,
    }) 
    $('.titleList li').css({ //绝对定位
        'position':'absolute',
    })
    $('.titleList li').eq(flag).addClass('current');//初始化第一个显示
    $('.contentBox .contentList li').hide().eq(flag).show();
    $('.titleList li').each(function(index,domElm){ //初始化分布位置
        if(index!=flag){
            $(domElm).stop().animate({
                'top': ((len - 1)+(index - flag)) * liHeight,
                'left':Math.abs(index - flag)*15
            })
        }
        else{
            $(domElm).stop().animate({
            'top': (len - 1) * liHeight,
            'left':'0'
            })
        }
    })
    $('.titleList li').on('click',function(){
        let clkidx = $(this).index();
        if(clkidx!=flag){
            $('.titleList li').removeClass('current');
            $(this).addClass('current');
            $('.titleList li').each(function(index,domElm){
                $(domElm).stop().animate({
                    'top': ((len - 1)+(index - clkidx)) * liHeight,
                    'left':Math.abs(index - clkidx)*15
                })
            })
            conetnt.hide().eq(clkidx).fadeIn();
            flag = clkidx
        }
        else{
            $(this).stop().animate({
                'top': (len - 1) * liHeight,
                'left':'0'
            })
        }
    })
})
    function toggle(id) {
        if(document.getElementById(id).style.display=='block')
        {
            document.getElementById(id).style.display='none';
            document.getElementById('backBox').style.display="none";
            small(document.getElementById('tittleBox'),10,4);
            big(document.getElementById('contentBox'),10,96);
            bcn(document.getElementById('bt'),10,8);
        }
        else
        {
            document.getElementById(id).style.display='block';
            document.getElementById('backBox').style.display="block";
            bcb(document.getElementById('bt'),10,53);
            big(document.getElementById('tittleBox'),10,12);
            small(document.getElementById('contentBox'),10,88);
        }
    }
var tetTimer=null;
function big(dom,time,width_px) {
    var _this=this;
    var width =dom.style.width;
    width=parseInt(width);
    width=width+1;
    $(dom).width(width+"%");
    if(width>width_px){
        dom.style.width=(dom.style.width)+"%";
        return false;
    }
    tetTimer =setTimeout(function () {
        _this.big(dom,time,width_px)
    },time);
}
var tetTimer1=null;
function small(dom,time,width_px) {
    var _this=this;
    var width =dom.style.width;
    width=parseInt(width);
    width=width-1;
    $(dom).width(width+"%");
    if(width<width_px){
        dom.style.width=(dom.style.width)+"%";
        return false;
    }
    tetTimer1 =setTimeout(function () {
        _this.small(dom,time,width_px)
    },time);
}
var tetTimer3=null;
function bcn(dom,time,width_px) {
    var _this=this;
    var position =dom.offsetLeft+1;
    position=parseInt(position);
    position=position-1;
    dom.style.marginLeft="7%";
    if(position<width_px){
        dom.style.marginLeft="7%";
        return false;
    }
    tetTimer3 =setTimeout(function () {
        _this.bcn(dom,time,width_px)
    },time);
    dom.style.backgroundImage="url('images/菜单展开.png')";
    dom.style.width="48px";
}
var tetTimer4=null;
function bcb(dom,time,width_px) {
    var _this=this;
    var position =dom.offsetLeft+1;
    position=parseInt(position);
    position=position+1;
    dom.style.marginLeft=position+"%";
    if(position>width_px){
        dom.style.marginLeft="60%";
        return false;
    }
    tetTimer4 =setTimeout(function () {
        _this.bcb(dom,time,width_px)
    },time);
    dom.style.backgroundImage="url('images/菜单按钮.png')";
    dom.style.width="88px";
}
$(".file").on("change","input[type='file']",function(){
    var filePath=$(this).val();
    if(filePath.indexOf("jpg")!=-1 || filePath.indexOf("png")!=-1){
        $(".fileerrorTip").html("").hide();
        var arr=filePath.split('\\');
        var fileName=arr[arr.length-1];
        $(".showFileName").html(fileName);
    }else{
        $(".showFileName").html("");
        $(".fileerrorTip").html("您未上传文件，或者您上传文件类型有误！").show();
        return false
    }
})
function alter(){
    if(confirm('你确定要进行该操作吗？')){
        return true;
    }else{
        return false;
    }
}

