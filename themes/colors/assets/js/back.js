    var portalDomain = "https://portal.huaweicloud.com",
            ssoDomain = "https://auth.huaweicloud.com";
    var isVerified=false;//定义实名认证变量
    var isLogin = false; //定义登录变量
    function showMenu(data){
        data = data || [];
        var isVendor = data.isVendor || false;
        var isIsv = data.isIsv || false;
        var $_target = $(".user-info-layer ul.account-nav");
        if(isVendor) {
            $_target.find("li").hide();
            $_target.find(".isVendor,.logout").show();
        }
        else if(isIsv){
            $_target.find(".isIsv").show();
            $_target.find(".isVendor").show();
        }
    }

       function removeTicket(uri) {
        var index = uri.indexOf('?');
        if (index === -1) {
            return uri;
        }
        var path = uri.substring(0, index), q = uri.substring(index+1) || '';
        q = q.replace(/ticket=[^&]*&?/, '').replace(/locale=[^&]*&?/, '');
        if (q) {
            return path + '?' + q;
        }
        return path;
    }

    var jsonParamInit={};
    var jsonParamView={};
    var jsonParamEvent={};
    jsonParamInit['UserAccount'] = 'host';
    function loginCallback(data) {
        if (data.flag == 1) {
            var username = data.username;
            isLogin = true;
            jsonParamInit['UserAccount'] = data.userId;

          //  $("#register_footera").attr("href","http://activity.huaweicloud.com/developer_plan/index.html");
          //  $("#register_footera").html("立即参与");
          	window.changeBtnAfterLogin && window.changeBtnAfterLogin();

            var image_url = data.image_url;
            if(image_url && image_url.small){
                getAvatarCallback(image_url);
            }else{
				        getAvatar();
			}
			getMessage(data.domainId);
		    isGrayuser();
            $("#header").addClass('logined');
            $(".user-info").find('.my-acct').text(username);
            $(".user-info").find('.my-acct').attr("title",username);
            showMenu(data);
            getUserverified();
        }
    }

    function getAvatarCallback(data){
		var image_url = data;
		if(image_url && image_url.small){
                $(".account-pic").attr("src",image_url.small);
        }
	}
	function getMessage (domain_id) {
       var url = portalDomain + '/api/mc/user/mc/v1/'+domain_id+'/messages/envelope/unread' ;
        $.ajax({
        dataType:"json",
        timeout:10000,
        type:'get',
        url:url,
        xhrFields: {
			withCredentials: true
		},
        success:function(data){
	         if(data.total>0){
		            $('.user-info').addClass('msg');
		            if(data.total < 10) {
		            $('.user-info').addClass('msg1');
		            $('.message span').text(data.total);
		            }else if(data.total < 100){
		            $('.user-info').addClass('msg2');
		            $('.message span').text(data.total);
		            }else{
		            $('.user-info').addClass('msg3');
		            $('.message span').text("99+");
	            }
	          }
        },
        error:function(data){

        }
        })
   }
	function getAvatar(){
		var get_account_pic = portalDomain +  '/user/avatar?callback=getAvatarCallback';
		getScript(window, document, "script", get_account_pic, function() {
        });
	}

	function isGrayuser() {
		var is_gray_user =portalDomain +  '/index/isgrayuser';
		getScript(window, document, "script", is_gray_user, function() {
        });
	}

    function getScript(win, doc, tag, src, always) {
        var script = doc.createElement(tag),
                h = doc.getElementsByTagName(tag)[0];
        script.async = 1;
        script.src = src;

        if(script.addEventListener) {
            script.addEventListener("load", always, false);
        }else if(script.attachEvent){
            script.attachEvent("onreadystatechange", function(){
                var target = window.event.srcElement;
                if(target.readyState == "loaded" || target.readyState == "complete"){
                    always.call(target);
                }
            });
        }
        h.parentNode.insertBefore(script, h)
    }

    jQuery(function() {
        var href = encodeURIComponent( removeTicket(window.location.href));

        //登陆之后回到本页面
        $("[data-login-href]").each(function(){
            $(this).attr("href",$(this).data('login-href')+href);
        });
        $("[href='"+ssoDomain+"/authui/auth.html?locale=zh-cn#/register']").attr("href",
                ssoDomain + "/authui/auth.html?locale=zh-cn&service="+href+"#/register");
        $("[href='"+ssoDomain+"/authui/auth.html#/register']").attr("href",
                ssoDomain+"/authui/auth.html?locale=zh-cn&service="+href+"#/register");

        window.raw_onerror = window.onerror;
        window.onerror = function(errorMsg, url, lineNumber) {
            return true;
        }

        var check_login_url =portalDomain +  '/index/islogin?callback=loginCallback';
        getScript(window, document, "script", check_login_url, function() {
            try {
                if(typeof initBi === "function") {
                    initBi(jsonParamInit,jsonParamView,jsonParamEvent);
                }
            } catch(e) {}
            window.onerror = window.raw_onerror;
        });
    });
    var ua = navigator && navigator.userAgent;
    function getUserverified(){
        var url = portalDomain + "/api/bss/userverified?callback=?";
        jQuery.getJSON(url, function(data) {
            if(data){
                if(data.retCode == "0"){
                    if(data.isVerified){
                        isVerified = true;
                        $(".account-item .account-verification").show().addClass("active");
                        $(".phone-acct").find(".account-pic").show();
                        $(".account-pic-no-ident").hide();
                        $(".true-name-li").hide();
                    }else{
                        $(".account-item .account-verification").show().removeClass("active");
                        if(!data.isShow){
                            if (ua.toLowerCase().indexOf('android') > -1 || (/iPad/i).test(ua) || (/iPhone/i).test(ua)) {
                                $("body").removeClass("autShow");
                            }else{
                                $("body").addClass("autShow");
                                over=setInterval(settime,1000);//1000毫秒

                            };
                        }else{
                            $("body").removeClass("autShow");
                        };
                        $(".phone-acct").find(".account-pic").hide();
                        $(".account-pic-no-ident").show();
                        $(".true-name-li").show();
                    }
                }else{
                    $(".phone-acct").find(".account-pic").show();
                    $(".account-pic-no-ident").hide();
                    $(".true-name-li").hide();
                }

            }else{
                $(".phone-acct").find(".account-pic").show();
                $(".account-pic-no-ident").hide();
                $(".true-name-li").hide();
            }
        });
    }
    time = 10;
    function settime(){
        time--;
        if(time==0){
            clearInterval(over);
            //倒计时结束
            $("body").removeClass("autShow");
        }
    }

    $(".Authentication").on('click', '.close', function(event) {
        $("body").removeClass("autShow");
    });







    $(".float-sidebar:not(.last)").each(function(index){
        $(this).children(".float-bar-nav").children(".item").insertBefore($(".float-sidebar.last .float-bar-nav").children(".item").eq(0));
        $(this).remove();
    });
    var robot ={};

    robot.staticURL = '//static.huaweicloud.com';
    robot.portalURL = 'https://portal.huaweicloud.com';





  <script src="//res-static3.huaweicloud.com/etc/clientlibs/cloudbu-site/clientlib-basic-footer/js/mateInfoDeal.js?sttl=20180808211547"></script>
{##}
  {#<!-- Joey: fix activity migrate template load these js twice -->#}
{##}
{##}
  <script src="//static.huaweicloud.com/static/js/v2/global.js?sttl=20180808211547"></script>
  <script src="//static.huaweicloud.com/static/js/v1/jquery.base64.js?sttl=20180808211547"></script>
{##}
{##}
{##}
  <script src="https://bi.huaweicloud.com/sdk/cloudbi.js?sttl=20180808211547"></script>
  <script src="//res-static3.huaweicloud.com/etc/clientlibs/cloudbu-site/clientlib-basic-footer/js/bi.js?sttl=20180808211547"></script>
  <script src="//static.huaweicloud.com/static/js/v2/recommend.js?sttl=20180808211547"></script>
  <script src="//img.huaweicloud.com/static/js/v2/appCustom.js?sttl=20180808211547"></script>
{##}
  <script src="//res-static2.huaweicloud.com/etc/clientlibs/cloudbu-site/clientlib-basic-footer/js/gray.js?sttl=20180808211547"></script>

