!function(e){var n=e(window),o=e("body"),a={speed:4,fadeIn:!0,fadeDelay:250};breakpoints({wide:["1281px","1680px"],normal:["961px","1280px"],narrow:["841px","960px"],narrower:["737px","840px"],mobile:[null,"736px"]}),n.on("load",function(){window.setTimeout(function(){o.removeClass("is-preload")},100)}),e("#nav > ul").dropotron({mode:"fade",speed:350,noOpenerFade:!0,alignment:"center"}),e(".scrolly").scrolly(),e('<div id="navButton"><a href="#navPanel" class="toggle"></a></div>').appendTo(o),e('<div id="navPanel"><nav>'+e("#nav").navList()+"</nav></div>").appendTo(o).panel({delay:500,hideOnClick:!0,hideOnSwipe:!0,resetScroll:!0,resetForms:!0,target:o,visibleClass:"navPanel-visible"}),e(".carousel").each(function(){var o,l,i,r,d=e(this),t=e('<span class="forward"></span>'),s=e('<span class="backward"></span>'),c=d.children(".reel"),p=c.children("article"),v=0;a.fadeIn&&(p.addClass("loading"),d.scrollex({mode:"middle",top:"-20vh",bottom:"-20vh",enter:function(){var e,o=p.length-Math.ceil(n.width()/void 0);e=window.setInterval(function(){var n=p.filter(".loading"),a=n.first();if(n.length<=o)return window.clearInterval(e),void p.removeClass("loading");a.removeClass("loading")},a.fadeDelay)}})),d._update=function(){v=0,l=-1*i+n.width(),o=0,d._updatePos()},d._updatePos=function(){c.css("transform","translate("+v+"px, 0)")},t.appendTo(d).hide().mouseenter(function(e){r=window.setInterval(function(){(v-=a.speed)<=l&&(window.clearInterval(r),v=l),d._updatePos()},10)}).mouseleave(function(e){window.clearInterval(r)}),s.appendTo(d).hide().mouseenter(function(e){r=window.setInterval(function(){(v+=a.speed)>=o&&(window.clearInterval(r),v=o),d._updatePos()},10)}).mouseleave(function(e){window.clearInterval(r)}),n.on("load",function(){i=c[0].scrollWidth,browser.mobile?(c.css("overflow-y","hidden").css("overflow-x","scroll").scrollLeft(0),t.hide(),s.hide()):(c.css("overflow","visible").scrollLeft(0),t.show(),s.show()),d._update(),n.on("resize",function(){i=c[0].scrollWidth,d._update()}).trigger("resize")})})}(jQuery);