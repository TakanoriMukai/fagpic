$(function(){
    $('.twitter-tweet').css('display','none');
    $('.spinner-grow').css('display','block');
});


$(window).on('load', function(){
    $('.spinner-grow').fadeOut(1600).remove();
    $('.twitter-tweet').fadeIn(1600);

});

// 10秒待っても読み込みが終わらない時は強制的にローディング画面をフェードアウト
function stopload(){
    $('.spinner-grow text-primary').delay(1000).fadeOut(700);
    $('.twitter-tweet').delay(1500).fadeIn(300);
}
setTimeout('stopload()',10000);