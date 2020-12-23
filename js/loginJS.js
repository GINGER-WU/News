$(document).ready(function () {
    let len = $('.titleList li').length //li的个数
    let titleList = document.getElementsByClassName('titleList')
    let titleLi = titleList[0].children
    let liHeight = titleLi[0].clientHeight//获取每个li的高度
    let backBox = $('.backBox');
    let flag =len > 0 ? Math.ceil((len-1)/2) : 0;  //初始化中间显示
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
        }else{
            $(this).stop().animate({
                'top': (len - 1) * liHeight,
                'left':'0'
            })
        }
    })
})