$(document).ready(function(){c()});function c(){let t=$(".focus-image");t.length!==0&&(t.on("click",function(e){let n=$(this),o=e.pageX-n.offset().left,s=e.pageY-n.offset().top;$(".focus").css("top",s-22).css("left",o-22).show(),$('input[name="focus_x"]').val(parseInt(o)),$('input[name="focus_y"]').val(parseInt(s))}),$(".focus").click(function(){$(".focus").hide(),$('input[name="focus_x"]').val(),$('input[name="focus_y"]').val()}))}
