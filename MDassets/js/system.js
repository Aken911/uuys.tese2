var MaDouYm = {
	'fonts': function() {
		function setRootFontSize() {
			var width = window.innerWidth;
			if (width > 961) {
				fontSize = 14;
			} else {
				fontSize = (width / 7.5);
			}
			document.getElementsByTagName('html')[0].style['font-size'] = fontSize + 'px';
		}
		setRootFontSize();
		window.addEventListener('resize', function() {
			setRootFontSize();
		}, false);
	},
	'modal': function() {
		$("#menu-open").on("click", function(e) {
			$("#slide-out").animate({
				left: '0%'
			}, 300);
			$(".sidenav-overlay").css("display", "block");
			$(".sidenav-overlay").animate({
				opacity: '1'
			}, 100);
			$("body").css("overflow", "hidden");
			$(document).one("click", function() {
				$(".sidenav-overlay").css("display", "none");
				$(".sidenav-overlay").animate({
					opacity: '0'
				}, 100);
				$("body").css("overflow", "");
				$("#slide-out").animate({
					left: '-80%'
				}, 100);
			});
			e.stopPropagation();
		});
		$("#slide-out").on("click", function(e) {
			e.stopPropagation();
		});
		$("#user-open").on("click", function(e) {
			$("#slide-userInfo-out").animate({
				left: '0%'
			}, 300); 
			$(".sidenav-overlay").css("display", "block");
			$(".sidenav-overlay").animate({
				opacity: '1'
			}, 100);
			$("body").css("overflow", "hidden");
			$(document).one("click", function() {
				$(".sidenav-overlay").css("display", "none");
				$(".sidenav-overlay").animate({
					opacity: '0'
				}, 100);
				$("body").css("overflow", "");
				$("#slide-userInfo-out").animate({
					left: '-80%'
				}, 100);
			});
			e.stopPropagation();
		});
		$("#slide-userInfo-out").on("click", function(e) {
			e.stopPropagation();
		});
		$("#left_close").click(function() {
			$("#slide-out").animate({
				left: '-80%'
			}, 100); 
			$(".sidenav-overlay").css("display", "none");
			$(".sidenav-overlay").animate({
				opacity: '0'
			}, 100);
			$("body").css("overflow", "");
		});
		$("#login_btn,#login_btn").click(function() {
			$("#login").show();
			$("#vips").hide();
		});
		$(".icon-guanbi").click(function() {
			$("#login,#vips").hide();
		});
		$("#user").click(function() {
			$("#user_list").slideToggle(300);
		});
	},
	'swiper': function() {
		$.getScript(maccms.path + "/MDassets/js/swiper.min.js", function() {
			var swiper = new Swiper('.swiper-container', {
				effect: 'coverflow',
				loop: true,
				autoplay: {
					delay: 5000,
					disableOnInteraction: false,
				},
				centeredSlides: true,
				calculateHeight: true,
				slidesPerView: 1.0761,
				spaceBetween: -50,
				pagination: {
					el: '.swiper-pagination',
				},
			});
		})
	},
	'tags': function() {
		var json = {};
		var $div = $(".tag");
		var $diva = $div.find("a");
		$diva.each(function() {
			var key = $(this).html();
			json[key] = key;
		});
		$div.empty();
		for (var key in json) {
			$div.append("<a class='col s4 cate-label-item cate-item-li' href='/index.php/vod/search/tag/" + key + ".html' >" + key + "</a>");
		}
		var json = {};
		var $div = $(".tags");
		var $diva = $div.find("a");
		$diva.each(function() {
			var key = $(this).html();
			json[key] = key;
		});
		$div.empty();
		for (var key in json) {
			$div.append("<a href='/index.php/vod/search/tag/" + key + ".html'><li class='labelListNode'>" + key + "</li></a>");
		}
		var json = {};
		var $div = $(".tagone");
		var $diva = $div.find("a");
		$diva.each(function() {
			var key = $(this).html();
			json[key] = key;
		});
		$div.empty();
		for (var key in json) {
			$div.append("<a class='category-item' href='/index.php/vod/search/tag/" + key + ".html' target='_blank'>" + key + "</a>");
		}

		var json = {};
		var $div = $(".tagtwo");
		var $diva = $div.find("a");
		$diva.each(function() {
			var key = $(this).html();
			json[key] = key;
		});
		$div.empty();
		for (var key in json) {
			$div.append("<a class='category-item' href='/index.php/vod/search/tag/" + key + ".html' target='_blank'><span>" + key + "</span></a>");
		}
	},
	'notice': function() {
		$.fn.extend({
			"slideUper": function(value) {
				var docthis = this;
				//默认参数
				value = $.extend({
					"li_h": "30",
					"time": 2000,
					"movetime": 1000
				}, value)
				//向上滑动动画
				function autoani() {
					$("div:first", docthis).animate({
						"margin-top": -value.li_h
					}, value.movetime, function() {
						$(this).css("margin-top", 0).appendTo(".line");
					})
				}
				//自动间隔时间向上滑动
				var anifun = setInterval(autoani, value.time);
				//悬停时停止滑动，离开时继续执行
				$(docthis).children("div").hover(function() {
					clearInterval(anifun); //清除自动滑动动画
				}, function() {
					anifun = setInterval(autoani, value.time); //继续执行动画
				})
			}
		})
		$(function() {
			$(".line").slideUper();
		})
	},
	'show': function() {
		$("#sort").click(function() {
			if ($("#sort").hasClass("tran")) {
				$("#sort").removeClass("tran");
				$("#sorttwo").slideUp(500);
			} else {
				$("#sort").addClass('tran');
				$("#sorttwo").slideDown(500);
				$("#tag").removeClass("tran");
				$("#tags").slideUp(500);
				$("#order").removeClass("tran");
				$("#ordertwo").slideUp(500);
			}
		});
		$("#tag").click(function() {
			if ($("#tag").hasClass("tran")) {
				$("#tag").removeClass("tran");
				$("#tags").slideUp(500);
			} else {
				$("#tag").addClass('tran');
				$("#tags").slideDown(500);
				$("#sort").removeClass("tran");
				$("#sorttwo").slideUp(500);
				$("#order").removeClass("tran");
				$("#ordertwo").slideUp(500);
			}
		});
		$("#order").click(function() {
			if ($("#order").hasClass("tran")) {
				$("#order").removeClass("tran");
				$("#ordertwo").slideUp(500);
			} else {
				$("#order").addClass('tran');
				$("#ordertwo").slideDown(500);
				$("#sort").removeClass("tran");
				$("#sorttwo").slideUp(500);
				$("#tag").removeClass("tran");
				$("#tags").slideUp(500);
			}
		});
	},
	'slide': function() {
		$('.comment-title-span').click(function() {
			var i = $(this).index();
			$(this).addClass('active').siblings().removeClass('active');
			$('.content-comment').eq(i).hide().siblings().show();
		});
		$("#info").click(function() {
			if ($(".showInfo").hasClass("on")) {
				$(".showInfo").removeClass("on");
				$(".video-description-desc").slideToggle("500");
				$("#info").html("<span>展开</span>");
			} else {
				$(".video-description-desc").slideToggle("500");
				$(".showInfo").addClass("on");
				$("#info").html("<span>收拢</span>");

			}
		});
		$("#opens").click(function() {
			if ($(".star-info-desc").hasClass("isOpen")) {
				$(".star-info-desc").removeClass("isOpen");
				$("#opens").html("<span>展开</span>");
			} else {
				$(".star-info-desc").addClass('isOpen');
				$("#opens").html("<span>收拢</span>");

			}
		});
	},
	'gotop': function() {
		$('#gototop').hide();
		$(window).scroll(function() {
			if ($(window).scrollTop() > 300) {
				$('#gototop').fadeIn(300);
			} else {
				$('#gototop').fadeOut(200);
			}
		});
		$('#gototop').click(function() {
			$('body,html').animate({
				scrollTop: 0
			}, 300);
			return false;
		})
	},	
	'popup': function() {
		var popup = sessionStorage.getItem("popup");
		if (popup == null) {
			$("#popup").show();
			$("#popup-close").click(function() {
				$("#popup").remove();
				sessionStorage.setItem("popup", "1");
			});
		};
	},
}
$(function() {
		MaDouYm.fonts();
		MaDouYm.modal();
		MaDouYm.swiper();
		MaDouYm.tags();
		MaDouYm.notice();
		MaDouYm.show();
		MaDouYm.slide();
		MaDouYm.gotop();
		MaDouYm.popup();
	}
)
