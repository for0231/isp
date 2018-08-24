/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {


        // tansitionEnd事件名称获取
        var transitionEnd = function () {
            var el = document.createElement('div');

            var transEndEventNames = {
                transition: 'transitionend',
                WebkitTransition: 'webkitTransitionEnd',
                MozTransition: 'transitionend',
                OTransition: 'oTransitionEnd otransitionend'
            };

            for (var name in transEndEventNames) {
                if (el.style[name] !== undefined) {
                    return transEndEventNames[name]
                }
            }

            return false; // explicit for ie8 (  ._.)
        }();

        /* 函数防抖 */
        var debounce = function (defaultTime) {
            var timeoutIndex;
            return function (callback, time) {
                if (typeof time !== 'number') {
                    time = defaultTime;
                }

                if (typeof timeoutIndex === 'number') {
                    clearTimeout(timeoutIndex);
                }

                timeoutIndex = setTimeout(callback, time);
            }
        };

        // 鼠标轨迹记录，计算移动角度
        var mouseLocus = [];
        var MOUSE_LOCUS_LENGTH = 3;

        for(var i = 0; i < MOUSE_LOCUS_LENGTH; i++) {
            mouseLocus.push({x:0,y:0});
        }

        $(document).mousemove(function (e) {
            var mousePoint = {
                x: e.pageX,
                y: e.pageY
            };

            mouseLocus.push(mousePoint);

            if (mouseLocus.length > MOUSE_LOCUS_LENGTH) {
                mouseLocus.shift();
            }
        });

        // 获取方向角
        var getDirectionAngle = function (startX, startY, endX, endY) {
            var diffY = endY - startY,
                diffX = endX - startX,
                angle = Math.atan(diffY / diffX) / Math.PI * 180;

            if (diffX < 0 && diffY > 0) {
                angle = 180 + angle;
            } else if (diffX < 0 && diffY < 0) {
                angle = angle - 180;
            }

            return angle
        };

        // 获取鼠标移动角度
        var getMoveAngle = function () {
            var startPoint = mouseLocus[0],
                endPoint = mouseLocus[mouseLocus.length - 1];

            if(!startPoint) {
                return 0
            }

            return getDirectionAngle(startPoint.x, startPoint.y, endPoint.x, endPoint.y)
        };

        /* 主菜单“更多”的显示 */
        var $header = $('#header');
        var $nav = $header.find('.header-nav');
        var $navItems = $nav.find('>ul>li');
        var $navItems_notMore = $navItems.not('.header-nav-item-more');
        var $navItemMore = $navItems.filter('.header-nav-item-more');

        $(window).resize(function () {
            resetMainMenu();
        });

        resetMainMenu();

        function resetMainMenu() {
            $nav.removeClass('overflow-visible');
            $navItems_notMore.removeClass('header-nav-item-hide');
            $navItemMore.addClass('header-nav-item-hide');

            if ($nav.height() >= $nav[0].scrollHeight) {
                return;
            }

            // 有菜单隐藏的情况
            $navItemMore.removeClass('header-nav-item-hide');

            hideLastNavItem($navItems_notMore);

            function hideLastNavItem($navItems_notMore) {
                if ($navItems_notMore.length === 0) return;

                $navItems_notMore.last().addClass('header-nav-item-hide');
                if ($nav.height() < $nav[0].scrollHeight) {
                    hideLastNavItem($navItems_notMore.not(':last'))
                }
            }

            $nav.addClass('overflow-visible');
        }

        var DELAY_NAV = 300;
        var LOW_DELAY_NAV = 150;
        var mainNavDebounce = debounce(DELAY_NAV);// 主导航菜单防抖
        var $headerDrop = $('.header-dropdown');
        var $headerDropList = $('.header-dropdown-list');
        var $headerDropItem = $headerDropList.children();

        // 获取主菜单延时角度范围
        var getDelayAngleRange_nav = function (startX, startY) {
            var $showDrop = $headerDropItem.filter('.show');

            if ($showDrop.length === 0) {
                return {
                    min: 90,
                    max: 90
                }
            }

            var margin = 0, // 下拉内容边界安全裕量
                offset = $showDrop.offset(),
                left = offset.left - margin,
                top = offset.top,
                right = offset.left + $showDrop.outerWidth() + margin,

                leftTopPoint = {
                    x: left,
                    y: top
                },
                rightTopPoint = {
                    x: right,
                    y: top
                },
                directionAngle_leftTop = getDirectionAngle(startX, startY, leftTopPoint.x, leftTopPoint.y),
                directionAngle_rightTop = getDirectionAngle(startX, startY, rightTopPoint.x, rightTopPoint.y);

            return {
                min: directionAngle_rightTop,
                max: directionAngle_leftTop
            }
        };


        /*
         * 主菜单hover切换下拉菜单，并触发下拉菜单的自定义事件
         * 下拉菜单（.header-dropdown-list>li）切换消失前后分别触发“beforehide”和“afterhide”事件
         * 下拉菜单切换显示前后分别触发“beforeshow”和“aftershow”事件
         */

        var setDropItemState = function ($drop, state) {
            if (state !== 'show' && state !== 'hide') return;

            var isShow = state === 'show';
            var eventFix = isShow ? 'show' : 'hide';

            $drop.triggerHandler('before' + eventFix);
            $drop.toggleClass('show', isShow);
            $drop.triggerHandler('after' + eventFix);
        };

        var tabDropItem = function ($drop) {
            if ($drop.hasClass('show')) return;

            var $drop_close = $headerDropItem.siblings('.show');

            setDropItemState($drop_close, 'hide');
            setDropItemState($drop, 'show');
        };


        /**
         * 主菜单下拉菜单的显示和隐藏
         * 下拉菜单（.header-dropdown）触发事件：beforehide, beginhide, afterhide, beforeshow, beginshow, aftershow
         */
        var setDropState = function (state) {
            var dropDuration = 350;

            if (state === 'show') {
                if ($header.hasClass('show-dropdown') &&　!$headerDropList.hasClass('hiding')) return;

                $headerDrop.triggerHandler('beforeshow');
                $header.addClass('show-dropdown');
                $headerDropList.height(0).addClass('expanding show-text');

                setTimeout(function () {
                    var innerHeight = $headerDropList.children('.show').outerHeight();

                    $headerDropList.height(innerHeight);
                    $headerDrop.triggerHandler('beginshow');

                    var called = false;
                    $headerDropList.one(transitionEnd, function () {
                        called = true;
                        $(this).removeClass('expanding').height('');
                        $headerDrop.triggerHandler('aftershow');
                    });

                    setTimeout(function () {
                        if (!called) {
                            $headerDropList.trigger(transitionEnd)
                        }
                    }, dropDuration);
                },0);

            } else if (state === 'hide') {
                if (!$header.hasClass('show-dropdown')) return;

                $headerDrop.triggerHandler('beforehide');

                var innerHeight = $headerDropList.children('.show').outerHeight();
                $headerDropList.removeClass('show-text').height(innerHeight);

                setTimeout(function () {
                    $headerDropList.height(0).addClass('hiding');
                    $headerDrop.triggerHandler('beginhide');

                    var called = false;
                    $headerDropList.one(transitionEnd, function () {
                        called = true;
                        setDropItemState($headerDropItem.filter('.show'), 'hide');
                        $header.removeClass('show-dropdown');
                        $headerDropList.removeClass('hiding');
                        $headerDrop.triggerHandler('afterhide');
                    });

                    setTimeout(function () {
                        if (!called) {
                            $headerDropList.trigger(transitionEnd)
                        }
                    }, dropDuration);
                }, 0);
            }
        };

        $headerDropItem.hover(function () {
            $(this).addClass('hover');
        }, function () {
            var $this = $(this);
            $this.removeClass('hover');

            setTimeout(function () {
                if (!$nav.hasClass('item-hover')) {
                    setDropState('hide');
                }
            }, 0);
        });

        var $navLine = $('.header-nav-hover-line');
        // 设置主导航下划线方法
        var setNavLine = {
            // 按对应菜单激活下划线
            active: function ($activeNavItem) {
                if($activeNavItem.length === 0 || !$activeNavItem.is(':visible')) {
                    this.fold();
                    return
                }
                var left = $activeNavItem.position().left;
                var width = $activeNavItem.width();

                // $activeNavItem.addClass('active').siblings().removeClass('active');

                $navLine.css({
                    left: left,
                    width: width
                });
            },
            // 折叠下划线
            fold: function () {
                $navLine.css({
                    width: 0
                });
            },
            // 复位下划线
            reset: (function () {
                var host = location.host,
                    site = host.split('.')[0],
                    pathname = location.pathname.split(/[\/.]/)[1], // 服务公告url用“.”分割目录，如 /notice.beian.html
                    url = host + location.pathname,
                    mainNavMap = {
                        pathnameMatch: {
                            'product': 'product',
                            'solution': 'solution',
                            'partners': 'partner',
                            'ei': 'ei',
                            'notice': 'support'
                        },
                        siteMatch: {
                            'activity': 'activity',
                            'support': 'support'
                        }
                    },
                    activeNav = '';

                if(activeNav === '') {
                    $navItems_notMore.each(function(){
                        var $this = $(this);
                        var $href = $this.find('a');
                        var menuUrl = $href.attr('href').replace(/(http:|https:|\/\/)/g, '');

                        if(url === menuUrl) {
                            activeNav = $this.attr('data-key');
                            return false
                        }

                    });
                }

                if(activeNav === '' &&　!(site === 'www' && location.pathname === '/')) { // 若不是www站点首页
                    // 用url匹配导航上的链接来匹配当前页面所属导航
                    $headerDropItem.not('.header-dropdown-more').each(function(){
                        var $this = $(this);
                        var htmlStr = $this.html();

                        if(htmlStr.indexOf(url) !== -1) {
                            activeNav = $this.attr('data-name');
                            return activeNav === 'product'
                        }
                    });
                }

                if(activeNav === '') {
                    // 用手工映射表匹配当前页面所属导航
                    if (site === 'www') {
                        activeNav = mainNavMap.pathnameMatch[pathname] || '';

                    } else {
                        activeNav = mainNavMap.siteMatch[site] || ''
                    }
                }

                if (!activeNav) return function () {
                    this.fold();
                };

                var $activeNavItem = $header.find('[data-key="' + activeNav + '"]');

                return function () {
                    this.active($activeNavItem);
                }
            }())
        };

        setNavLine.reset();
        $(window).resize(function(){
            setNavLine.reset();
        });

        $navItems.hover(function () {
            var $this = $(this);
            var moveAngle = getMoveAngle();
            var delayAngleRange = getDelayAngleRange_nav(mouseLocus[mouseLocus.length - 1].x, mouseLocus[mouseLocus.length - 1].y);
            var delay = (moveAngle <= delayAngleRange.max && moveAngle >= delayAngleRange.min) ? DELAY_NAV : LOW_DELAY_NAV;

            $this.addClass('hover');
            $nav.addClass('item-hover');

            setNavLine.active($this);

            mainNavDebounce(function () {
                var index = $this.attr('data-key');
                var $targetDropdown = $headerDropItem.filter('[data-name="' + index + '"]');
                $this.addClass('active').siblings().removeClass('active');
                tabDropItem($targetDropdown);
                setDropState('show');
            }, delay);
        }, function () {
            var $this = $(this);
            var $dropdowns_show = $headerDropItem.filter('.show');

            $this.removeClass('hover');
            $nav.removeClass('item-hover');


            mainNavDebounce(function () {
                if ($dropdowns_show.hasClass('hover') || $nav.hasClass('item-hover')){
                    return;
                }
                if (!$header.hasClass('show-dropdown')) {
                    setNavLine.reset();
                }
                setDropState('hide');
            }, 200);
        }).mousemove(function(){
            var $this = $(this);
            var key = $this.attr('data-key');
            var $targetDropItem = $headerDropItem.filter('[data-name="' + key + '"]');
            setTimeout(function(){
                if(($targetDropItem.length !== 0 && !$targetDropItem.is(':visible')) || $navLine.width() === 0 ) {
                    $this.trigger('mouseenter');
                }
            }, 0);
        });

        $headerDrop
            .on('beginhide', function () {
                setNavLine.fold();
            })
            .on('afterhide', function () {
                if($navItems_notMore.filter('.hover').length === 0) {
                    setNavLine.reset();
                }
            })
            .on('mousemove', function(e){
                var $target = $(e.target);

                if($target.closest('.header-dropdown-list').length === 0 && !$headerDropList.hasClass('hiding')) {
                    setDropState('hide');
                }
            });

        // 鼠标进入下拉菜单时用空函数取消主导航菜单的触发
        $headerDropList.hover(function () {
            setNavLine.active($navItems.filter('.active'));
            mainNavDebounce(function () {
            });
        }, function () {

        });

        /* “更多”下拉的菜单显示逻辑 */
        $headerDropList.children('[data-name="more"]').on('beforeshow', function () {
            var $headerDropMore = $('.header-dropdown-more');
            var $headerMoreItems = $headerDropMore.find('>ul>li');
            var left = $('.header-nav-item-more').offset().left;

            // 设置显示位置
            $headerDropMore.css('margin-left', left);

            // 显示项目
            $headerMoreItems.addClass('header-more-item-hide');

            $navItems.filter('.header-nav-item-hide').each(function () {
                var index = $(this).attr('data-key');
                $headerMoreItems.filter('[data-key="' + index + '"]').removeClass('header-more-item-hide');
            });

        });

        /* 产品下拉菜单文字溢出时隐藏“new”和“beta”标签 */
        var $dropProduct = $('.header-dropdown-product');
        var $products = $dropProduct.find('dt>a>span,dd>a>span');

        $dropProduct.on('aftershow', function () {
            $products.each(function () {
                var $this = $(this);
                var $tag = $this.nextAll('.new,.beta');
                $tag.toggleClass('hide', $this.width() < this.scrollWidth);
            });
        });

        /* 解决方案下拉菜单三级解决方案列表溢出时隐藏 */
        var $dropSolution = $('.header-dropdown-solution');
        var $subSolutionList = $dropSolution.find('.dropdown-solution-sub');

        $dropSolution.on('aftershow', function () {
            $subSolutionList.each(function () {
                var $this = $(this);
                var $children = $this.children().not('.header-icon-double-arrow-right');
                $children.removeClass('hide');

                if ($this.height() >= this.scrollHeight - 1) return;


                var hideOverflowChild = function (children) {
                    if (children.length === 0) return;

                    children.last().addClass('hide');

                    if ($this.height() < $this[0].scrollHeight - 1) {
                        hideOverflowChild(children.not(':last'));
                    }
                };

                hideOverflowChild($children);
            });
        });


        /*
         * 导航条menu按钮hover显示“所有导航”， 并触发“所有导航”自定义事件
         * “所有导航”显示前后分别触发'beforeshow'和'aftershow'事件
         * “所有导航”隐藏前后分别触发'beforehide'和'afterhide'事件
         */

        var DELAY_ALLNAV = 300; // 鼠标进入次级菜单的反应延时
        var LOW_DELAY_ALLNAV = 0; // 鼠标同级菜单内移动的反应延时
        var $headerMenu = $('.header-menu');
        var $allNav = $('.header-allnav');
        var $allNavWrapper = $allNav.children();

        // allnav导航防抖
        var allNavDebounce = debounce(DELAY_ALLNAV);

        var setAllNavState = function (state) {
            if (state !== 'show' && state !== 'hide') return;

            var isShow = state === 'show';
            var eventFix = isShow ? 'show' : 'hide';

            $allNav.triggerHandler('before' + eventFix);
            $header.toggleClass('show-allnav', isShow);
            $allNav.toggleClass('show', isShow);
            $allNav.triggerHandler('after' + eventFix);
        };

        $allNavWrapper.hover(function () {
            $(this).addClass('hover');
        }, function () {
            $(this).removeClass('hover');
        });

        // 获取allnav导航需要延时的角度范围
        var getDelayAngleRange_allnav = function (startX, startY, $targetNav) {
            if (!$targetNav.is(':visible')) {
                return {
                    min: 0,
                    max: 0
                }
            }

            var margin = 30, // 次级菜单边界安全裕量
                navOffset = $targetNav.offset(),
                navHeight = $targetNav.outerHeight(),
                left = navOffset.left,
                top = navOffset.top - margin,
                bottom = navOffset.top + navHeight + margin,
                leftTopPoint = {
                    x: left,
                    y: top
                },
                leftBottomPoint = {
                    x: left,
                    y: bottom
                },
                directionAngle_leftTop = getDirectionAngle(startX, startY, leftTopPoint.x, leftTopPoint.y),
                directionAngle_leftBottom = getDirectionAngle(startX, startY, leftBottomPoint.x, leftBottomPoint.y);

            return {
                min: directionAngle_leftTop,
                max: directionAngle_leftBottom
            }
        };

        var inDelayAngleRange_allnav = function($targetNav){
            var moveAngle = getMoveAngle();
            var delayAngleRange = getDelayAngleRange_allnav(mouseLocus[mouseLocus.length - 1].x, mouseLocus[mouseLocus.length - 1].y, $targetNav);

            // 如果鼠标移动目标为次级菜单则使用高延时反应时间
            return moveAngle <= delayAngleRange.max && moveAngle >= delayAngleRange.min
        };

        /*
         * allnav导航菜单hover展开子级导航，切换子级菜单内容，并触发子级导航及子级导航内容的自定义事件
         * 子级导航展开前后分别触发'beforeshow'和'aftershow'
         * 子级导航内容显示前后分别触发'beforeshow'和'aftershow'事件
         * 子级导航内容隐藏前后分别触发'beforehide'和'afterhide'事件
         */
        var $allnavLevel = $('.header-allnav-level');
        var $allnavInner = $allnavLevel.find('.header-allnav-inner');
        var $allnavList = $allnavInner.find('.header-allnav-common-list, [data-define="allnav-list"]');
        var $allnavItem = $allnavList.find('.header-allnav-common-item, .header-allnav-common-split, [data-define="allnav-item"]');


        // 设置层级导航显示隐藏的状态
        var setLevelnavState = function ($el, state) {
            var setState = function ($el, state) {
                if (state !== 'show' && state !== 'hide') return;
                var duration = 300;
                var isShow = state === 'show';
                var eventFix = isShow ? 'show' : 'hide';
                $el.triggerHandler('before' + eventFix);
                $el.addClass('sliding');

                setTimeout(function () {
                    $el.toggleClass('show', isShow);
                    var called = false;

                    $el.one(transitionEnd, function () {
                        called = true;
                        $el.removeClass('sliding');
                        $el.triggerHandler('after' + eventFix);
                    });

                    setTimeout(function () {
                        if (!called) {
                            $el.trigger(transitionEnd)
                        }
                    }, duration);
                }, 0);
            };

            var setStateStrategy = {};

            setStateStrategy.show = function () {
                setState($el, 'show')
            };

            setStateStrategy.hide = function () {
                var $willHideLevel = $el.add($el.nextAll('.header-allnav-level.show'));
                var $lastShowLevel = $willHideLevel.last();
                var willHideNumber = $willHideLevel.length;

                // 去除菜单项激活效果
                $willHideLevel.find('.header-allnav-common-item,[data-define="allnav-item"]').removeClass('active');

                // 从后往前依次隐藏层级菜单
                setState($lastShowLevel, 'hide');

                $willHideLevel.one('afterhide', function () {
                    willHideNumber--;

                    if (willHideNumber <= 0) return;

                    $lastShowLevel = $lastShowLevel.prev('.header-allnav-level');

                    setState($lastShowLevel, 'hide');
                });
            };

            setStateStrategy[state]();
        };

        // 为层级导航，导航菜单列表，导航菜单对应的dom添加和删除.hover来标识当前鼠标经过的位置。
        $allnavLevel.add($allnavList).add($allnavItem)
            .hover(function () {
                var $this = $(this);

                $this.addClass('hover');
            }, function () {
                var $this = $(this);

                $this.removeClass('hover');
            });

        // 导航内菜单项鼠标移入移出
        $allnavItem.hover(function (e) {
            var $this = $(this);
            var index = $this.attr('data-key');
            var $thisNav = $this.closest('.header-allnav-level');
            var $targetNav = $thisNav.next('.header-allnav-level');
            var $targetInner = $targetNav.find('.header-allnav-inner[data-name="' + index + '"]');
            var $currentTargetNavInner = $targetNav.find('.header-allnav-inner.show');

            // 如果鼠标移动目标为次级菜单则使用高延时反应时间
            var delay = $currentTargetNavInner.length > 0 && inDelayAngleRange_allnav($targetNav) ? DELAY_ALLNAV : LOW_DELAY_ALLNAV;

            if($thisNav.hasClass('sliding')) {
                return;
            }

            allNavDebounce(function () {
                $this.siblings().removeClass('active');
                $this.addClass('active');
                if ($targetInner.length === 0) {
                    if ($targetNav.hasClass('show')) {
                        setLevelnavState($targetNav, 'hide');
                    }

                    return
                }

                var $hideSibling = $targetInner.siblings('.show');

                // 子级导航显示
                if (!$targetNav.hasClass('show')) {
                    setLevelnavState($targetNav, 'show')
                }

                // 子级导航内容切换（隐藏）
                if ($hideSibling.hasClass('show')) {
                    setLevelnavState($hideSibling, 'hide')
                }

                // 子级导航内容切换（显示）
                if (!$targetInner.hasClass('show')) {
                    setLevelnavState($targetInner, 'show');
                }
            }, delay);

        }, function () {});

        // 导航菜单列表鼠标移入移出
        $allnavList.hover(function () {

        }, function () {
            // 鼠标移出本级导航内容区，但还在本级导航内的时候隐藏下一级菜单，消除本级菜单项的激活效果
            var $this = $(this);
            var $thisNav = $this.closest('.header-allnav-level');
            var $targetNav = $thisNav.next('.header-allnav-level');
            var $activeItem = $thisNav.find('.header-allnav-common-item, [data-define="allnav-item"]').filter('.active');
            var delay = inDelayAngleRange_allnav($targetNav) ? DELAY_ALLNAV : LOW_DELAY_ALLNAV;

            allNavDebounce(function () {
                if ($thisNav.hasClass('hover')) {
                    if ($targetNav.hasClass('show')) {
                        setLevelnavState($targetNav, 'hide');
                    }

                    $activeItem.removeClass('active');
                }
            }, delay);
        });

        // 菜单按钮移入显示整个下拉菜单，移出隐藏第一级菜单
        var allnavLevel1 = $('.header-allnav-level1');
        var allnavLevel2 = $('.header-allnav-level2');

        // 某些情况下鼠标进入菜单按钮会莫名依次触发"mouseenter-mouseleave-mouseenter"事件，需添加防抖
        var menuDebounce = debounce(100);
        $headerMenu.hover(function () {
            $(this).addClass('hover');
            menuDebounce(function(){
                setAllNavState('show');
            });

        }, function () {
            $(this).removeClass('hover');
            menuDebounce(function(){
                if (!$allNavWrapper.hasClass('hover')) {
                    setLevelnavState(allnavLevel1, 'hide');
                }
            });
        });

        // 整个下拉导航显示后显示第一级导航, 第一级导航隐藏后隐藏整个下拉导航
        $allNav.on('aftershow', function () {
            // 因为菜单移出隐藏一级菜单的函数使用了setTimeout, 这里也使用setTimeout保证显示函数能隐藏函数之后执行
            setTimeout(function(){
                setLevelnavState(allnavLevel1, 'show');
            }, 0);
        });

        allnavLevel1.on('afterhide', function () {
            if(!$headerMenu.hasClass('hover')) {
                setAllNavState('hide');
            }
        });

        // 层级导航鼠标移入移出
        $allnavLevel.hover(function () {
            var $this = $(this);
            var $next = $this.next();
            var $item = $this.find('.header-allnav-common-item,[data-define="allnav-item"]');
            var $activeItem = $item.filter('.active');

            //　本级导航鼠标移入时，如果没有放在导航内容上，下一级导航需隐藏
            if (!$this.find('.header-allnav-common-list, [data-define="allnav-list"]').filter(':visible').hasClass('hover') && $next.hasClass('show')) {
                setLevelnavState($next, 'hide');
                $activeItem.removeClass('active');
            }

        }, function () {});

        // 鼠标移出导航（且未放在menu上）收起整个导航 否则收起2级导航
        var DELAY_ALLNAV_WRAPPER = 300;
        var $allnavWrapper = $('.header-allnav-wrapper');
        var allNavWrapperDebounce = debounce(DELAY_ALLNAV_WRAPPER);

        $allnavWrapper.hover(function(){
            allNavWrapperDebounce(function(){},0);
        },function(){
            var $this = $(this);

            allNavWrapperDebounce(function () {
                /* 鼠标移出导航（且未放在menu上）收起整个导航 否则收起2级导航 */
                var activeNavItem = $this.find('.header-allnav-common-item,[data-define="allnav-item"]').filter('.active');
                activeNavItem.removeClass('active');
                if ($allnavLevel.filter('.hover').length === 0 && !$headerMenu.hasClass('hover')) {
                    setLevelnavState(allnavLevel1, 'hide');
                } else {
                    setLevelnavState(allnavLevel2, 'hide');
                }
            });
        });

        // 导航显示前清除选中项
        $allnavLevel.on('beforeshow', function () {
            var $this = $(this);
            $this.find('.header-allnav-common-item,[data-define="allnav-item"]').removeClass('active');
        });

        // 本级导航内容隐藏前隐藏下一级导航
        $allnavInner.on('beforehide', function () {
            var $this = $(this);
            var $next = $this.closest('.header-allnav-level').next();

            if ($next.length === 0 || !$next.hasClass('show')) return;

            setLevelnavState($next, 'hide');
        });

        // 导航显示前清除选中项
        $allnavLevel.children().on('beforeshow', function () {
            $(this).find('.header-allnav-common-item,[data-define="allnav-item"]').removeClass('active');
        });

        // 三级导航显示前设置宽度
        $('.header-allnav-level3').on('beforeshow', function () {
            $(this).css('width', $(window).width() - 3 * 240);
        });

        /*
         * 移动端导航下拉
         */

        //
        var $mbnav = $('.header-mbnav');
        $(document).on('click', '.header-menu-mb', function () {
            var isShow = $mbnav.hasClass('show');

            $mbnav.toggleClass('show', !isShow);
            $(this).toggleClass('show-nav', !isShow);
        });

        // todo 统一导航展开方式

        // 移动端导航折叠功能
        $('.header-collapse-head > a').on('click', function (event) {
            if (event.target.tagName !== 'H2') {
                event.preventDefault();
            } else if (this.href) {
                return;
            }

            var duration = 350;
            var $this = $(this);
            var $container = $this.closest('.header-collapse');
            var $body = $container.children('.header-collapse-body');
            var $content = $body.children('.header-collapse-content');
            var flag_open = $container.hasClass('open');

            if (flag_open) {
                $body.height($content.outerHeight());
                $body.height(0);
                $container.removeClass('open');
            } else {
                $container.removeClass('close');
                $body.height($content.outerHeight());
                $container.addClass('open');
            }

            var called = false;
            $body.one(transitionEnd, function () {
                called = true;
                if (!$container.hasClass('open')) $container.addClass('close');
                $(this).height('');
            });

            setTimeout(function () {
                if (!called) {
                    $body.trigger(transitionEnd);
                }
            }, duration);
        });

        // 鼠标在导航内滚动时，不滚动窗口
//        $('.dropdown-product-container,.dropdown-common-container,.header-allnav-level,.header-allnav-level1>.header-allnav-inner,.header-mbnav').not('.header-allnav-level1').scrollUnique();

        /*
         * 导航搜索功能
         */
        // 点击放大镜展开搜索框
        var $search = $('.header-search-pc');
        var $searchInput = $search.find('.search-input');
        var $searchSwitch = $('.header-search-switch');

        $searchSwitch.on('click', function () {
            var $this = $(this);
            var isShow = $this.hasClass('show-search');

            $this.toggleClass('show-search', !isShow);
            $search.toggleClass('show', !isShow);

            if (!isShow) {
                $searchInput.focus();
            }
        });

        // 菜单展开时隐藏搜索框
        $headerMenu.add('.header-lang').hover(function () {
            if ($searchSwitch.hasClass('show-search')) {
                $searchSwitch.click();
            }
        }, function () {
        });

        $headerDropItem.on('beforeshow', function () {
            if ($searchSwitch.hasClass('show-search')) {
                $searchSwitch.click();
            }
        });

        // 搜索框
        var $searchBar = $header.find('.head-search-panel .search-bar'),
            $searchBtn = $searchBar.find('.search-btn'),
            searchBaseUrl = $searchBtn.data("href");

        /**
         * TODO 改函数在生产环节应该替换为从后台获取数据
         */
        function getSuggest(val) {
            return ''
        }

        // 创建提示dom
        function showSuggestion(sug) {
            var html = '';
            for (var i = 0; i < sug.length; i++) {
                html += '<li class="sugg-item">' + sug[i] + '</li>'
            }
            $searchBar.find('.search-suggestion').empty().append(html);
        }

        // 输入更新按钮链接（兼顾pc和移动端）
        $searchInput.add('.header-search-mb .search-input').on('input', function () {
            var val = $(this).val();
            $(this).closest('.search-input-box').toggleClass('inputing', val.length > 0);
            $searchBtn.attr('href', searchBaseUrl + $.base64.urlSafeEncode(val, true))
            var suggestion = getSuggest(val);
            $searchBar.toggleClass('show-suggest', suggestion.length > 0);
            showSuggestion(suggestion);
        });
        $searchInput.on('blur', function () {
            setTimeout(function () {
                $searchBar.removeClass('show-suggest');
            }, 200)
        });
        $searchInput.on("keydown", function (e) {
            if (e.keyCode == 13) {
                $searchBtn[0].click();
            }
            if (e.keyCode == 38 || e.keyCode == 40) {
                e.preventDefault();
                var $selSugg = $searchBar.find('.search-suggestion .sugg-item');
                var index = 0;
                if ($selSugg.filter('.on').length < 0) {
                    if (e.keyCode == 40) {
                        index = 0
                    }
                    if (e.keyCode == 38) {
                        index = $selSugg.length - 1
                    }
                } else {
                    index = $selSugg.filter('.on').index();
                    if (e.keyCode == 40) {
                        index++
                    }
                    if (e.keyCode == 38) {
                        index--
                    }
                    index = index % $selSugg.length;
                }
                var val = $selSugg.removeClass('on').eq(index).addClass('on').text();
                $searchInput.val(val);
                $searchBtn.attr('href', searchBaseUrl + $.base64.urlSafeEncode(val, true))
            }
        });
        $searchBar.on('click', '.search-clear-btn', function () {
            $(this).siblings('.search-input').val('');
            $(this).closest('.search-input-box').removeClass('inputing');
            $searchBtn.attr('href', searchBaseUrl);
            $searchBar.removeClass('show-suggest');
            $searchInput.focus();
        });
        $searchBar.on('click', '.sugg-item', function () {
            var val = $(this).text();
            $(this).siblings('.search-input').val(val);
            $searchBtn.attr('href', searchBaseUrl + $.base64.urlSafeEncode(val, true));
            $searchBtn[0].click();
        });

        // 点击推荐关键字
        $('.search-recommend').on('click', 'a', function(){
            var $this = $(this);
            var keyword = $this.text();
            $searchInput.val(keyword).trigger('input');


            var href = $searchBtn.attr('href');

            if($searchBtn.attr('target') === '_blank') {
                window.open(href)
            } else {
                location.href = href
            }
        });

        function headerFun() {
            $header.addClass('loaded');
            // 设置每个子菜单初始top值
            if (win_width < 1024) {
                $(".help-header .navigation .nav .nav-item").removeClass("hide");
                //$(".help-header .navigation .nav-item.search-item").removeClass("search-acting");
            }

            var selIndex = String($header.data('on')).split(",");
            $header.find('.nav-item').eq(selIndex[0]).addClass('action').find('.sub-item').eq(selIndex[1]).addClass('action');

            $('.compatibility .close-large').on('click', function (event) {
                $('body').removeClass('Compatible');
                localStorage.setItem("hideCompatible", true);
            });

            if ($('.header-banner').length > 0) {
                var imgSrc = '';
                if (win_width >= 800) {
                    imgSrc = $('.header-banner-bg img.pc-bg').attr('src');
                } else {
                    imgSrc = $('.header-banner-bg img.mb-bg').attr('src');
                }
                $('.header-banner .header-banner-bg').css('background-image', 'url(' + imgSrc + ')');
                $('.header-banner .close-large').on('click', function (event) {
                    $('body').removeClass('has-header-banner');
                });
            }

            $(window).scroll();
            $(".poster-actions-btns").clone().appendTo('.head-tools');

            /* 新版菜单 2017-05-31 */
            var $navMain = $("#nav-main"),
                $headMenu = $(".headmenu"),
                navLine = $(".nav .line"),
                navTime, navHover;
            if (win_width >= 1024) {
                $navMain.find('.menu-boxs').scrollUnique();
            }
            $(".nav .nav-item").mouseenter(function () {
                var self = $(this),
                    w = self.width(),
                    navleft = self.closest(".nav").offset().left,
                    left = self.offset().left,
                    cur = self.attr("navdown"),
                    target = self.attr("index");
                $header.addClass('show-menu');
                $navMain.find('.menu-boxs').scrollTop(0);
                $header.find(".tool-item.search").removeClass('show-search').find('.i-search').removeClass('on');
                clearTimeout(navTime);
                navHover = setTimeout(function () {
                    navLine.css({
                        left: left - navleft + "px",
                        width: w
                    });
                    $headMenu.removeClass('active');
                    self.addClass("selected").siblings("").removeClass("selected")
                    if (cur == "show") {
                        $navMain.removeClass().addClass("show " + target + "").find(".menu-boxs." + target + "").addClass("show").siblings(".menu-boxs").removeClass("show");
                    } else {
                        $navMain.removeClass("show");
                    }
                }, 200);
            }).mouseleave(function () {
                clearTimeout(navHover);
                var self = $(this);
                navTime = setTimeout(function () {
                    navLine.css({width: 0});
                    self.removeClass("selected");
                    $navMain.removeClass("show");
                    $header.removeClass('show-menu');
                }, 200);
            });

            //start 语言切换
            var langTime;
            $header.find('.tool-item.tool-lang, .tool-item.user-info').mouseenter(function (e) {
                clearTimeout(langTime);
                var $this = $(this);
                langTime = setTimeout(function () {
                    $this.addClass('show');
                    $header.find(".tool-item.search").removeClass('show-search').find('.i-search').removeClass('on');
                    $navMain.removeClass("show");
                    $header.removeClass('show-menu');
                }, 200);
            }).mouseleave(function (e) {
                var $this = $(this);
                clearTimeout(langTime);
                setTimeout(function () {
                    $this.removeClass('show');
                }, 200);
            });
            //end 语言切换

            // 移动端设置菜单
            if (win_width > 1023) {
                $navMain.find(".nav-ing, .menu-boxs").mouseenter(function (e) {
                    clearTimeout(navTime);
                    clearTimeout(menuTime);
                    $header.addClass('show-menu');
                }).mouseleave(function (e) {
                    if (!$navMain.hasClass('search') && ($(this).hasClass('nav-ing') || ($(this).hasClass('menu-boxs') && !$navMain.hasClass('all-nav')))) {
                        $navMain.removeClass("show")
                        $(".nav .nav-item").removeClass("selected");
                        $(".nav .line").css({width: 0});
                        $headMenu.removeClass('active');
                        $header.removeClass('show-menu');
                        $header.find('.i-search').removeClass('on');
                    }
                });

                var menuTime, hoverTime;
                $headMenu.mouseenter(function (event) {
                    $navMain.find('.menu-boxs').scrollTop(0);
                    $header.addClass('show-menu');
                    clearTimeout(menuTime);
                    $navMain.find(".menu-boxs").removeClass("show").siblings(".menu-boxs.product").addClass("show");
                    $navMain.find(".topbar-list .nav-inner").removeClass("active").eq(0).addClass("active");
                    $navMain.find(".nav-ing").removeClass('ing')

                    hoverTime = setTimeout(function () {
                        $headMenu.toggleClass('active');
                        $navMain.removeClass().addClass("all-nav").toggleClass("show");
                    }, 300);
                }).mouseleave(function () {
                    clearTimeout(hoverTime);
                    menuTime = setTimeout(function () {
                        $headMenu.removeClass('active');
                        $navMain.removeClass("show");
                        $header.removeClass('show-menu');
                    }, 200)
                });

            } else {
                $headMenu.click(function (event) {
                    $(this).toggleClass('active');
                    $navMain.addClass("all-nav").toggleClass('show');
                    $navMain.find(".nav-ing").removeClass("ing");
                    // $("#header .wrapper").outerHeight()  46
                    var mh = win_height - 46;
                    if ($navMain.hasClass('show')) {
                        $navMain.height(mh);
                        $navMain.find(".nav-ing").height(mh);
                        $frame.height(win_height).addClass('overflow-hide');
                    } else {
                        $frame.height("auto").removeClass('overflow-hide');
                        $navMain.height("0");
                        $navMain.find(".nav-ing").height("100%");
                    }
                });
                $('.menu-boxs').on('click', ".nav-title,.sub-title", function (event) {
                    event.stopPropagation()
                    $(this).toggleClass('unfold');
                    $(this).siblings(".panel-box,.menu-panel-list").slideToggle();
                });
                $("#footer").on('click', ".wechatCode", function (event) {
                    var src = $(this).attr("class");
                    $(this).addClass('active');
                    var wechat = $(".wechat-pop-wrapper"),
                        src = wechat.find("img").data("src");
                    if ($(this).hasClass('active')) {
                        wechat.removeClass("hide").addClass("show");
                        wechat.find("img").attr("src", src)
                        $frame.height($(window).innerHeight()).addClass('overflow-hide');
                    } else {
                        $(this).removeClass('active');
                        $frame.height("auto").removeClass('overflow-hide');
                        wechat.addClass("hide").removeClass("show")
                    }
                });
                $("#footer").on('click', ".wechat-pop-wrapper", function (event) {
                    $(".wechatCode").removeClass('active');
                    $(this).addClass("hide").removeClass("show");
                    $frame.height("auto").removeClass('overflow-hide');
                });
            }

            $(".topbar-list li").hover(function () {
                var _this = $(this),
                    target = _this.data("target"),
                    $con = _this.closest(".all-nav");
                _this.addClass('active').siblings('li').removeClass('active');
                if (target) {
                    $con.find(".menu-boxs." + target + "").addClass("show").siblings(".menu-boxs").removeClass("show");
                    $con.find(".nav-ing").removeClass("ing");
                } else {
                    $con.find(".nav-ing").addClass("ing").find(".menu-boxs").removeClass("show");
                }
            });
        }

  // Hello World.
  Drupal.behaviors.helloWorld = {
    attach: function (context) {
      headerFun();




    }
  }

})(jQuery);
