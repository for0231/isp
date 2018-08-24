!function ($) {
    /***
     * 支持检测浏览器及版本信息
     * Chrome/Safari/Firefox/IE
     ***/
    window.BO = {
        wekit: true,
        Chrome: false,
        Safari: false,
        Firefox: false,
        Opera: false,
        IE: false, //IE9-10
        oldIE: false, //IE6~-8
        newIE: false, //IE11
        iDevice: false,
        iPhone: false,
        iPad: false,
        android: false,
        name: 'unkonwn',
        version: ''
    };

    (function () {
        "use strict";

        var uaInfo = navigator.userAgent;
        BO.getUAInfo = function () {
            return uaInfo;
        }
        BO.init = function () {
            BO.detectBrowser();
            BO.detectDevice();
        };

        BO.detectBrowser = function () {
            var regF = /Firefox[\/\s](\d+\.\d+)/, //Firefox
                regO = /Opera|OPR[\/\s](\d+\.\d+)/, //Opera
                regI = /MSIE[\/\s](\d+\.\d+)/, //IE6-10
                regC = /Chrome[\/\s](\d+\.\d+)/, //Chrome
                regS = /Safari[\/\s](\d+\.\d+)/, //Safari
                regIn = /rv[\:\s](\d+\.\d+).*like Gecko/; //IE11
            BO.Firefox = regF.test(uaInfo);
            BO.Opera = regO.test(uaInfo);
            BO.Chrome = regC.test(uaInfo);
            BO.Safari = !BO.Chrome && regS.test(uaInfo);

            BO.newIE = regIn.test(uaInfo);
            BO.IE = BO.newIE || regI.test(uaInfo);
            BO.oldIE = BO.IE && !BO.newIE && Number(uaInfo.match(regI)[1]) < 9;

            var regSV = /Version\/(\d+.\d+.\d+)/;
            BO.Chrome && (BO.name = 'Chrome') && (BO.version = uaInfo.match(regC) && uaInfo.match(regC)[1]);
            BO.Firefox && (BO.name = 'Firefox') && (BO.version = uaInfo.match(regF) && uaInfo.match(regF)[1]);
            BO.Safari && (BO.name = 'Safari') && (BO.version = uaInfo.match(regSV) && uaInfo.match(regSV)[1]);
            BO.Opera && (BO.name = 'Opera') && (BO.version = uaInfo.match(regO) && uaInfo.match(regO)[1]);
            BO.IE && (BO.name = 'IE') && (BO.version = BO.newIE ? (uaInfo.match(regIn) && uaInfo.match(regIn)[1]) : (uaInfo.match(regI) && uaInfo.match(regI))[1]);

            BO.webkit = !(BO.Firefox || BO.Opera || BO.IE);

        };
        BO.detectDevice = function () {
            var ua = uaInfo.toLowerCase();
            BO.android = ua.indexOf('android') > -1;

            (/iPad/i).test(uaInfo) && (BO.iPad = true) && (BO.iDevice = true);
            (/iPhone|iPod/i).test(uaInfo) && (BO.iPhone = true) && (BO.iDevice = true);
        }

    })();
// 子元素scroll父元素容器不跟随滚动
    $.fn.scrollUnique = function () {
        return $(this).each(function () {
            var eventType = 'mousewheel';
            // 火狐是DOMMouseScroll事件
            if (document.mozHidden !== undefined) {
                eventType = 'DOMMouseScroll';
            }
            $(this).on(eventType, function (event) {
                // 一些数据
                var scrollTop = this.scrollTop,
                    scrollHeight = this.scrollHeight,
                    height = this.clientHeight;

                var delta = (event.originalEvent.wheelDelta) ? event.originalEvent.wheelDelta : -(event.originalEvent.detail || 0);
                delta = delta / 5;
                if ((delta > 0 && scrollTop <= delta) || (delta < 0 && scrollHeight - height - scrollTop <= -1 * delta)) {
                    // IE浏览器下滚动会跨越边界直接影响父级滚动，因此，临界时候手动边界滚动定位
                    this.scrollTop = delta > 0 ? 0 : scrollHeight;
                    // 向上滚 || 向下滚
                    event.preventDefault();
                }
            });
        });
    };
    (function () {
        var lastTime = 0;
        var vendors = ['webkit', 'moz'];
        for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
            window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
            window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || // Webkit中此取消方法的名字变了
                window[vendors[x] + 'CancelRequestAnimationFrame'];
        }

        if (!window.requestAnimationFrame) {
            window.requestAnimationFrame = function (callback, element) {
                var currTime = new Date().getTime();
                var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
                var id = window.setTimeout(function () {
                    callback(currTime + timeToCall);
                }, timeToCall);
                lastTime = currTime + timeToCall;
                return id;
            };
        }
        if (!window.cancelAnimationFrame) {
            window.cancelAnimationFrame = function (id) {
                clearTimeout(id);
            };
        }
    }());
    jQuery.extend(jQuery.easing, {
        easeOutSine: function (x, t, b, c, d) {
            return c * Math.sin(t / d * (Math.PI / 2)) + b;
        }
    });
    $(function () {
        // 浏览器、终端检测
        BO.init();
        BO.oldIE && $("body").addClass('oldIE');
        BO.iDevice && $("body").addClass('Mobile');
        // IE8及以下浏览器提示升级信息

        if (BO.oldIE && !localStorage.getItem("hideCompatible")) {
            $("body").addClass('Compatible');
        }
        ;

        var win_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
            win_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

        var $frame = $("body");
        $(window).scroll(function (event) {
            if (!$("#header").hasClass('loaded')) {
                return
            }
            ;
            var currTop = $(window).scrollTop();
            if (currTop <= 30) {
                $frame.removeClass('scrolled')
            } else {
                $frame.addClass('scrolled')
            }

            if (currTop > win_height) {
                $(".float-sidebar").addClass('show-totop');
            } else {
                $(".float-sidebar").removeClass('show-totop');
            }
            $(".float-sidebar").removeClass('show');
        });
        if (win_width < 1024) {
            $(".float-sidebar").on('click', '.shown-btn', function (event) {
                $(this).closest('.float-sidebar').addClass('show');
            });
            $(".help-header").addClass("hide");
            //$(".help-header .navigation .nav-item.search-item").removeClass("search-acting");

        }
        var $header = $("#header");

        //设置每个子菜单初始top值
        function setSubNav() {
            $(".subnav-layer").each(function (index, el) {
                $(this).css('top', $(this).height() * -1);
            });
        }






        /* 页脚二维码区鼠标经过显示 */

        // old footer
        $(".code-2-box").hover(function () {
            $(this).addClass('show').siblings('.code-2-box').removeClass('show')
        }, function () {
            /* Stuff to do when the mouse leaves the element */
        });

        // new footer
        $('.footer-nav-about>dd').hover(function () {
            $(this).addClass('show').siblings('dd').removeClass('show');
        }, function () {
        });


        //$('#service').load('pages/service.html', function() {});

        $frame.on('click', 'a[href="#toTop"]', function (event) {
            event.preventDefault();
            $('body,html').stop().animate({'scrollTop': 0}, 500, 'easeOutSine', function () {
                href_click = false;
            });
        });
        $frame.on('click', 'a[href^="#"]', function (event) {
            var target = $(this).attr("href").substr(1);
            var top = 0;
            if($("#"+target).length > 0){
                top = $("#"+target).offset().top - 60;
            }
            else if($("[name='"+target+"']").length > 0){
                top = $("[name='"+target+"']").offset().top - 60;
            }
            event.preventDefault();
            $('body,html').stop().animate({'scrollTop': top}, 500, 'easeOutSine', function () {
                href_click = false;
            });
        });

        $(document).on('mouseenter', '.js-title', function () {
            // 增加当文字溢出再出现title属性
            if (this.scrollWidth > this.offsetWidth || this.scrollHeight > this.offsetHeight) {
                $(this).attr('title', $.trim($(this).text()));
            } else {
                $(this).attr('title', '');
            }
        });

        // 禁用的链接禁止跳转功能
        $frame.on('click', ".aui-button[disabled]", function (e) {
            e.preventDefault();
        });

        //页面右侧导航
        //var dom= document.createElement("div");
        //    $pageNav = $(dom);
        //$pageNav.load("pages/page-nav.html",function(){
        //    $(this).children("li").appendTo(".float-sidebar .float-bar-nav");
        //});


    });

    /* 分页组件插件 */
    !function ($, undefined) {
        'use strict';

        var langMap = {
            en: {
                'total': 'Total ',
                'items': ' items',
                'goto': 'Go to',
                'pages': '',
                'go': 'Go'
            },
            cn: {
                'total': '共',
                'items': '条',
                'goto': '到第',
                'pages': '页',
                'go': '确定'
            }
        };

        // 构造函数定义
        // ===========
        var Pagination = function (selector, options) {
            this.$element = $(selector);
            this.options = {};

            var defaults = {
                lang: 'cn',
                current: 0,
                total: 0,
                items: 0,
                hrefs: []
            };

            for (var key in defaults) {
                if (options[key] === undefined) {
                    this.options[key] = defaults[key];
                } else {
                    this.options[key] = options[key]
                }
            }

            if (this.options.total === 0) return this;

            this._buildHTML();
            this._addEvent();

        };

        // 构造函数方法
        // ===========

        // 创建HTML结构
        Pagination.prototype._buildHTML = function () {
            var that = this;

            var lang = langMap[that.options.lang],
                current = that.options.current,
                total = that.options.total,
                items = that.options.items,
                hrefs = that.options.hrefs;

            var HTML = '';

            // 移动端gotoHTML
            var HTML_mbGoto = '<li class="pagination-goto-mb"><label><input type="text" class="goto-mb-input" value="' + current + '">/<span>' + total + '</span></label></li>';

            // 左、右工具栏HTML
            var HTML_leftTool = '<span class="pagination-text">' + lang.total + items + lang.items + '</span><a class="pagination-toFirst' + (current === 1 ? ' disabled' : ('" href="' + hrefs[0])) + '"></a>';
            var HTML_rightTool = '<a class="pagination-toLast' + (current === total ? ' disabled' : ('" href="' + hrefs[total - 1])) + '"></a><span class="pagination-text">' + lang.goto + '</span><input type="text" class="pagination-to">' + (that.options.lang === 'cn' ? '<span class="pagination-text">页</span>' : '') + '<input type="submit" class="pagination-submit" value="' + lang.go + '">';

            // 页码列表HTML左、右部分
            var HTML_list_before = (current === 1) ? '<ul class="pagination"><li class="disabled"><a></a></li>' : '<ul class="pagination"><li><a href="' + hrefs[current - 2] + '"></a></li>';
            var HTML_lsist_after = (current === total) ? '<li class="disabled"><a></a></li></ul>' : '<li><a href="' + hrefs[current] + '"></a></li></ul>';

            // 页码列表HTML主要部分
            var buildPageItem = function () {

                var buildStrategy = {
                    // 少于8页
                    lt: function () {
                        var HTML = '';
                        for (var i = 1; i <= total; i++) {
                            HTML += '<li' + (current === i ? ' class="active"' : '') + '><a' + (current === i ? '' : (' href="' + hrefs[i - 1]) + '"') + '>' + i + '</a></li>'
                        }

                        return HTML;
                    },
                    // 大于等于8页
                    mte: function () {
                        var i = 0,
                            max = 0;

                        var HTML_start = '',
                            HTML_center = '',
                            HTML_end = '';

                        var flag_leftEllipsis = current > 4,
                            flag_rightEllopsis = current < total - 3;

                        if (flag_leftEllipsis) {
                            HTML_start = '<li><a href="' + hrefs[0] + '">1</a></li><li class="ellipsis"><a>...</a></li>'
                        }

                        if (flag_rightEllopsis) {
                            HTML_end = '<li class="ellipsis"><a>...</a></li><li><a href="' + hrefs[total - 1] + '">' + total + '</a></li>'
                        }

                        if (flag_leftEllipsis && flag_rightEllopsis) {
                            i = current - 1;
                            max = current + 1;
                        } else if (flag_leftEllipsis && !flag_rightEllopsis) {
                            i = total - 4;
                            max = total;
                        } else if (!flag_leftEllipsis && flag_rightEllopsis) {
                            i = 1;
                            max = 5;
                        }

                        for (; i <= max; i++) {
                            HTML_center += '<li' + (current === i ? ' class="active"' : '') + '><a' + (current === i ? '' : (' href="' + hrefs[i - 1]) + '"') + '>' + i + '</a></li>'
                        }

                        return HTML_start + HTML_center + HTML_end;
                    }
                }

                if (total < 8) {
                    return buildStrategy.lt()
                } else {
                    return buildStrategy.mte()
                }
            }

            HTML = HTML_leftTool + HTML_list_before + buildPageItem() + HTML_mbGoto + HTML_lsist_after + HTML_rightTool;

            that.$element.html(HTML);
        };

        // 添加事件
        Pagination.prototype._addEvent = function () {
            var that = this;

            this.$element
            // 跳转页码
                .on('submit', function (e) {
                    e.preventDefault();

                    var pages = parseInt($(this).find('.pagination-to,.goto-mb-input').filter(':visible').val());

                    that.goto(pages);
                })
                // 移动端输入框聚焦添加样式
                .on('focus', '.goto-mb-input', function () {
                    $(this).closest('.pagination-goto-mb').addClass('on-focus');
                })
                .on('blur', '.goto-mb-input', function () {
                    $(this).closest('.pagination-goto-mb').removeClass('on-focus');
                });
        }

        // 页数跳转
        Pagination.prototype.goto = function (pages) {
            pages = parseInt(pages);

            if (isNaN(pages) || pages < 1) {
                pages = 1;
            } else if (pages > this.options.total) {
                pages = this.options.total;
            }

            location.href = this.options.hrefs[pages - 1];
        }

        // 插件
        // ====
        $.fn.pagination = function (method, options) {
            return this.each(function () {
                var $this = $(this);
                var plugin = $this.data('hw.pagination');

                if (typeof method == 'object') {
                    options = method;
                }

                if (!plugin) {
                    $this.data('hw.pagination', (plugin = new Pagination(this, options)));
                }

                if (typeof method == 'string') {
                    plugin[method](options);
                }
            });
        }
    }(jQuery);

    window.changeLang = function (lang) {
        var index = "https://www.huaweicloud.com/en-us/";
        var zh = "zh-cn";
        var en = "en-us";
        var href = window.location.href;
        var host = window.location.protocol + "//" + window.location.hostname;
        var pathname = window.location.pathname;

        var url = "";
        if (lang == en) {
            if (pathname.indexOf(zh) === 1) {
                url = href.replace(zh, en);
            } else {
                url = host + "/" + en + pathname;
            }
        } else {
            if (pathname.indexOf(en) === 1) {
                url = href.replace("/" + en, "");
            } else {
                url = index;
            }
        }

        if (url) {
            $.ajax({
                url: url,
                type: "get",
                success: function () {
                    window.location.href = url;
                },
                error: function (data) {
                    window.location.href = index;
                }
            });
        } else {
            window.location.href = index;
        }
    }
// $(function () {
//     $(".header-lang-item a").attr("href","javascript:changeLang('en-us');");
// });


    $(function () {
        var win_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if (win_width < 1024) {
            $(".weixin-sh").on("click", function () {
                $('.wx-pop-wrapper img').fadeIn(300);
                $('.wx-pop-wrapper').fadeIn(300);
            })
            $(document).on("click", ".wx-pop-wrapper", function () {
                $('.wx-pop-wrapper img').fadeOut(300);
                $('.wx-pop-wrapper').fadeOut(300);
            })

        }
    });
// TODO:新版导航20180414
    $(document).ready(function () {

    });

    /* region 底部立即试用条 */
    !function () {
        var $register = $('.register-area');

        if($register.length === 0) return;

        var $registerBg = $('.register-area-bg');
        var registerHeight = $register.outerHeight();
        var maxBgMoveLength = $registerBg.outerHeight() - registerHeight;
        var maxDiff = $('body').height() - ($register.offset().top + registerHeight);
        var moveRatio = maxBgMoveLength / maxDiff;

        var setBgPosition = function () {
            var offset = $register.offset();
            var topToWindow = offset.top - $(window).scrollTop();
            var windowHeight = $(window).height();
            var diff = windowHeight - topToWindow;
            var bgMoveLength = moveRatio * diff;

            bgMoveLength = bgMoveLength < 0 ? 0 : bgMoveLength;
            bgMoveLength = bgMoveLength > maxBgMoveLength ? maxBgMoveLength : bgMoveLength;

            $registerBg.css('margin-bottom', -bgMoveLength + 'px');
        };

        setBgPosition();

        $(window).scroll(function(){
            setBgPosition();
        })
    }();
    /* endregion 底部立即试用条 */
}(jQuery);
