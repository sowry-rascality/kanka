!function(t){var e={};function n(i){if(e[i])return e[i].exports;var a=e[i]={i:i,l:!1,exports:{}};return t[i].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)n.d(i,a,function(e){return t[e]}.bind(null,a));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=15)}({15:function(t,e,n){t.exports=n("cT1l")},cT1l:function(t,e){var n,i,a,o;$(document).ready((function(){$(".preview-switch").click((function(t){t.preventDefault();var e=$("#widget-preview-body-"+$(this).data("widget"));e.hasClass("preview")?(e.removeClass("preview").addClass("full"),$(this).html('<i class="fa fa-chevron-up"></i>')):(e.removeClass("full").addClass("preview"),$(this).html('<i class="fa fa-chevron-down"></i>'))})),$.each($('[data-toggle="preview"]'),(function(t){200===$(this).height()?$(this).next().removeClass("hidden"):$(this).removeClass("pinned-entity preview")})),$.each($('[data-widget="remove"]'),(function(t){$(this).click((function(t){$.post({url:$(this).data("url"),method:"POST"}).done((function(t){}))}))})),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),1===$(".campaign-dashboard-widgets").length&&($("#new-widget"),$("#new-widget-preview"),$("#new-widget-calendar"),$("#new-widget-recent"),$("#btn-widget-preview"),$("#btn-widget-calendar"),$("#btn-widget-recent"),n=$("#btn-add-widget"),i=$("#modal-content-buttons"),a=$("#modal-content-target"),o=$("#modal-content-spinner"),$(".btn-lg").click((function(t){var e;e=$(this).data("url"),i.fadeOut(400,(function(){o.fadeIn()})),$.ajax(e).done((function(t){o.hide(),a.html(t),window.initSelect2(),window.initCategories()}))})),n.click((function(t){o.hide(),a.html(""),i.show()})),$("#widgets").sortable({items:".widget-draggable",stop:function(t,e){$.post({url:$("#widgets").data("url"),dataType:"json",data:$('input[name="widgets[]"]').serialize()}).done((function(t){}))}})),function t(){$(".widget-recent-more").click((function(e){e.preventDefault(),$(this).html('<i class="fa fa-spin fa-spinner"></i>'),$.ajax({url:$(this).data("url"),context:this}).done((function(e){$(this).closest(".widget-recent-list").append(e),$(this).remove(),t(),window.ajaxTooltip()}))}))}(),function t(){$(".widget-calendar-switch").click((function(e){console.log("click calendar switch");var n=$(this).data("url"),i=$(this).data("widget");$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$("#widget-date-"+i).addClass("hidden"),$("#widget-loading-"+i).removeClass("hidden").siblings(".row").addClass("hidden"),$.ajax({url:n,method:"POST",context:this}).done((function(e){if(e){var n=$(this).data("widget");$("#widget-body-"+n).html(e),t()}}))}))}(),function(){var t=$("#campaign-follow"),e=$("#campaign-follow-text");if(1!==t.length)return;t.data("following")?e.html(t.data("unfollow")):e.html(t.data("follow"));t.show(),t.click((function(n){n.preventDefault(),$.post({url:$(this).data("url"),method:"POST"}).done((function(n){n.following?e.html(t.data("unfollow")):e.html(t.data("follow"))}))}))}()}))}});