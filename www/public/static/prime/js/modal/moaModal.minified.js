(function(c){
	var q,n,w,r={speed:500,easing:"linear",position:"0 auto",animation:"none",on:"click",escapeClose:!0,overlayColor:"#000",overlayOpacity:0.7,overlayClose:!0};
	c(document).ready(function(){q=c("<div></div>").css({width:"100%",height:c(document).height(),position:"fixed",backgroundColor:"#000",overflow:"hidden",opacity:0.7,top:0,left:0,display:"none",zIndex:"999996"})
		.appendTo("body");n=c("<div></div>").css({width:"100%",height:c(document).height(),position:"absolute",display:"none",overflow:"hidden",top:0,left:0,zIndex:"999998"})
		.appendTo("body");w=c("<div></div>").css({position:"relative",width:"100%",zIndex:"999997",top:0,left:0,visibility:"hidden"})
		.appendTo(n)});
	
	var x=function(h,a){a=c.extend({},r,a);var b=c(a.modal);if(b.length){a.position=a.position.replace(/(\d+)(\s|$)/g,"$1px$2");
	var g=w,s=a.position.split(" ")[1],t={position:"relative",overflow:"hidden",display:"block",zIndex:"999999",margin:a.position},p=b.clone(),u,k;p.appendTo("body").css({maxWidth:window.screen.width,maxHeight:window.screen.height});
	u=p.outerWidth();k=p.outerHeight();0==k&&(k="1%");p.remove();for(var f={},p=a.animation.split(" "),v=0;v<p.length;v++)f[p[v]]=!0;!1!==a.overlayClose&&n.click(function(a){this!=a.target&&a.target!=g[0]||b.trigger("close.modal")});
	
	if(a.escapeClose)c(document).on("keydown.modal",function(a){27===a.which&&b.trigger("close")});a.close&&c(a.close).click(function(){b.trigger("close.modal");return!1});
	h.on(a.on,function(d){q.css({backgroundColor:a.overlayColor,opacity:a.overlayOpacity});
	
	if("click"!==a.on)c(document).one("mouseup",
	function(a){});
	
	if("center"==a.position){var e=c(window).height()/2-k/2;t.margin=e+"px auto"}else"bottom"==a.position&&(e=c(window).height()-k,t.margin=e+"px auto");g.children(":first").hide().appendTo("body");b.appendTo(g);n.css({height:c(document).height(),width:"100%",display:"block"});var l=0,m=c(window).scrollTop();b.css(t);!0==f.top?m=-(k+parseInt(b.css("marginTop"))-c(window).scrollTop()):!0==f.bottom&&(m=c(window).height()+c(window).scrollTop());!0==f.left?(e=parseInt(b.css("marginLeft")),
	isNaN(e)&&(e=g.width()/2-b.width()/2),l=-(b.width()+e)):!0==f.right&&(e=parseInt(b.css("marginLeft")),isNaN(e)&&(e=g.width()/2-b.width()/2),l=g.width()-e);f.zoom&&(m=d.pageY,l=d.pageX,e=b.css("marginLeft"),d=parseFloat(e),e=e.replace(d,""),!s||0==d&&"0px"!==s||"auto"==s?d=g.width()/2:0===d||isNaN(d)||"%"==e&&(d=c(document).width()*d/100),l-=d,e=b.css("marginTop"),d=parseFloat(e),e=e.replace(d,""),0===d||isNaN(d)||("%"==e&&(d=g.innerHeight()*d/100),m-=d),f.width=!0,f.height=!0);var h=function(){};
	
	if(!0==f.width||!0==f.height)d={},!0==f.height&&(d.height=0),!0==f.width&&(d.width=0),b.css(d),d=a.speed,isNaN(m)&&isNaN(l)&&(d=0),setTimeout(function(){b.animate({width:u,height:k},{easing:a.easing,duration:a.speed,complete:function(){}})},d),h=function(){b.stop().animate({width:0,height:0},{duration:a.speed,complete:function(){c(this).css({width:u,height:k})}})};b.on("close.modal",function(){h();g.stop().animate({top:m,left:l,opacity:0},{duration:a.speed,easing:"linear",complete:function(){n.css({top:0,
	position:"absolute"})}});q.fadeOut(a.speed+100,function(){g.css({visibility:"hidden",top:0,left:0});n.hide()});b.off("close.modal")});q.stop().fadeIn(a.speed,function(){});g.css({top:m,left:l,opacity:0,visibility:"visible"}).stop().animate({opacity:1,top:c(window).scrollTop(),left:0},{easing:a.easing,duration:a.speed,complete:function(){n.css({top:-c(window).scrollTop(),position:"fixed"});a.complete&&"function"===typeof a.complete&&a.complete()}});return!1})}};"function"===typeof Sweefty&&Sweefty().trigger("modal",
	x);c.fn.modal=function(h,a){a||"object"!==typeof h||(a=h,h=void 0);
	
	var b=c.extend({},r,a);b.modal=b.target;if("view"==h)b.modal=this,b.on="view.modal";else if("close"==h)return this.trigger("close.modal"),!1;return this.each(function(){var a=c(this);a[0]==c(document)[0]?r=b:(x(a,b),a.trigger("view.modal"))})}})(jQuery);
