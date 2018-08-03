$(function(){
  //计算右侧内容宽度
  window.onresize = function () {//浏览器窗口改变事件
    calWidth();
  };
  calWidth();
  function calWidth(){  
    var winWidth = $(window).width(),
    rw = winWidth - 96,
    winHeight = $(window).height(),
    main = $("#main"),
    mainHeight = winHeight - 59;
    main.css("height", mainHeight + 'px');
    $(".livelists").width(rw);
  };
    // 弹出左侧导航数据
    $(".navBox li").click(function () {
      var index = $(this).index();
      if (index == 0) {
        $('.moneyDatafixed').fadeIn();
      } else {
        alert('敬请期待！')
      }
    });
})