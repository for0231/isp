<div class="widthLimit" ui-view="content"><div id="loginAdv" class="ng-scope"><a href="https://activity.huaweicloud.com/sa_freetest/index.html" mate_data_ts="www_china_zh-cn_index.click.banner_login" target="_blank"> <img src="https://res-img2.huaweicloud.com/content/dam/cloudbu-site/archive/china/zh-cn/banner/53kf/SA.png" alt=""></a></div>
  <div id="loginForm" class="ng-scope">

    <div class="loginTypeDiv">
      <!-- ngIf: !model.isCompany --><span ng-if="!model.isCompany" class="loginTypeNoSelected ng-scope ng-binding" ng-bind="model.personageUser">账号登录</span><!-- end ngIf: !model.isCompany -->
      <!-- ngIf: model.isCompany -->
    </div>

    <ul>
      <li class="errorTip">
        <!-- ngIf: !model.isCookieEnable --><!-- ngIf: !model.isCookieEnable -->
        <div id="checkError" style="display: none;">
          <span id="checkErrorInfo" style="color:red;margin-left:0px;" ng-bind="model.checkErrorInfo" class="ng-binding"></span>
        </div>
        <div id="serverError">
          <span style="font-size:small;color:red;margin-left:0px;" ng-bind="model.serverError" class="ng-binding"></span>
          <span id="goLogin" class="ng-binding" ng-bind="model.goLogin"></span>
          <span style="font-size:small;color:red;margin-left:0px;" ng-bind="model.goLogin1" class="ng-binding"></span>
        </div>
      </li>
      <li ng-show="model.isCompany" class="inputField ng-hide" id="accountNameLiId">
        <input focused="true" type="text" class="tiny-input-text" validator="true" id="accountNameId" placeholder="账号名" style="width: 320px; height: 48px;">
      </li>
      <!-- ngIf: model.isNeedPhoneCode -->
      <!-- 国内站主账户 -->
      <!-- ngIf: !model.isNeedPhoneCode && !model.isCompany && !model.isHongKongDomain && !model.accountIsPhone --><li class="inputField ng-scope" style="margin-bottom:10px" ng-if="!model.isNeedPhoneCode &amp;&amp; !model.isCompany &amp;&amp; !model.isHongKongDomain &amp;&amp; !model.accountIsPhone">
        <input type="text" class="tiny-input-text" validator="true" id="userNameId" placeholder="账号名/邮箱/手机" style="width: 320px; height: 48px;">
        <!-- <span class="isPhoneLogin" ng-bind="model.mobileNumberLogin" ng-click="model.accountIsPhone = ! model.accountIsPhone"></span> -->
      </li><!-- end ngIf: !model.isNeedPhoneCode && !model.isCompany && !model.isHongKongDomain && !model.accountIsPhone -->
      <!-- ngIf: !model.isNeedPhoneCode && !model.isCompany && !model.isHongKongDomain && model.accountIsPhone -->
      <!-- 国内站子账户 -->
      <!-- ngIf: !model.isNeedPhoneCode && model.isCompany && !model.isHongKongDomain && !model.accountIsPhone -->
      <!-- ngIf: !model.isNeedPhoneCode && model.isCompany && !model.isHongKongDomain && model.accountIsPhone -->
      <!-- ngIf: !model.isNeedPhoneCode && !model.isCompany && model.isHongKongDomain -->
      <!-- ngIf: !model.isNeedPhoneCode && model.isCompany && model.isHongKongDomain -->

      <li class="inputField" style="margin-bottom: 5px">
        <input type="password" style="display: none">
        <input type="password" class="tiny-input-text" validator="true" id="pwdId" placeholder="密码" style="width: 320px; height: 48px;">
      </li>
      <!-- ngIf: model.isNeedVerifyCode -->
    </ul>
    <div>
      <div id="buttonArea" ng-show="!model.isUniportal || model.isHongKongDomain" class="">
        <div id="checkArea">
          <span id="model.chkId" text="model.chkTxt" checked="checked" style="display:inline-block;" change="model.chkCheckedChange()" class="ng-isolate-scope"><div class="tiny-checkbox" id="chkId" style="min-width: 50px;"><div class="tiny-checkbox-mark"><div class="tiny-checkboxIcon tiny-checkbox-unchecked"></div><label class="tiny-checkbox-content"><label class="tiny-text">记住登录名</label></label></div></div></span>
          <a href="/authui/findPwd.html?locale=zh-cn&amp;UserType=p&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F#/fpwd" class="loginBottomColor ng-binding" style="float: right;margin-top: 1px;" ng-bind="i18n('forgetPwd')" ng-click="BiEvent('send','event','button','click','login_fpwd',model.fpwdURI)">忘记密码?</a>
        </div>
        <div id="loginBtn" ng-click="loginClick()" class="loginBtn" tabindex="0">
          <span id="btn_submit" ng-bind="model.submitBtnText" class="ng-binding">登录</span>
        </div>
        <div id="bottomBtns">
          <a target="_blank" rel="noopener noreferrer" href="https://reg.huaweicloud.com/registerui/public/custom/register.html?locale=zh-cn&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F" style="float: left;" class="loginBottomColor ng-binding" ng-bind="i18n('freeRegister')" ng-click="BiEvent('send','event','button','click','login_freeRegister',model.registUrl)">免费注册</a>

          <span id="ownerLogin" class="loginswap loginBottomColor ng-binding ng-hide" ng-bind="model.personageUser" ng-show="model.isCompany">账号登录</span>
          <div class="helptipfather" style="display:inline-block;width:16px;height:16px;float:right;" ng-show="!model.isCompany" tiny-tip="model.iamUserTip"><img style="max-width:100%;max-height:100%;vertical-align:baseline;" src="/authui/public/custom/images/b8d0bb3.helpquestmark.png">
            <span class="helptipchild ng-binding">IAM用户：由管理员在IAM中创建的用户，是云服务的使用人员，可对应员工、系统或应用程序。</span></div>
          <span id="subUserLogin" class="loginswap loginBottomColor ng-binding" style="margin-right:5px;" ng-bind="model.enterpriseUser" ng-show="!model.isCompany">IAM用户登录</span>
        </div>
        <div id="otherAccounts">
          <span ng-bind="i18n('usingOtherWaysLogin')" class="otherLoginColor ng-binding">使用其他账号登录</span>
        </div>
        <div id="otherLoginWays">
          <ul class="clearfix">
            <li>
              <img style="max-width:100%;max-height:100%;vertical-align:baseline;" src="/authui/public/custom/images/hwportal.svg">
              <!-- ngIf: !model.isHongKongDomain --><a ng-if="!model.isHongKongDomain" href="/authui/saml/login?xAccountType=hwportal&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F" ng-bind="i18n('hwportal')" class="otherLoginColor ng-scope ng-binding" ng-click="BiEvent('send', 'event', 'button', 'click', 'login_hwportal', model.hwportalUrl)">华为网站账号</a><!-- end ngIf: !model.isHongKongDomain -->
            </li>
            <li>
              <a href="/authui/saml/login?xAccountType=eChannel&amp;service=https%3A%2F%2Faccount.huaweicloud.com%2Fusercenter%2F%23%2Fuserindex%2Fallview" ng-bind="i18n('eChannelName')" class="otherLoginColor ng-binding" ng-click="BiEvent('send','event','button','click','login_enchannel',model.eChannelUrl)">华为企业业务合作伙伴</a>
            </li>
            <li>
              <!-- ngIf: !model.isHongKongDomain --><a ng-if="!model.isHongKongDomain" href="/authui/saml/login?xAccountType=hwdeveloper&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F" ng-bind="i18n('HWICTdeveloper')" class="otherLoginColor ng-scope ng-binding" ng-click="BiEvent('send','event','button','click','login_ICT',model.hwdeveloperUrl)">华为ICT开发者</a><!-- end ngIf: !model.isHongKongDomain -->
            </li>
            <li>
              <!-- ngIf: !model.isHongKongDomain --><a ng-if="!model.isHongKongDomain" href="https://hwid1.vmall.com/CAS/remoteLogin?lang=zh-cn&amp;validated=true&amp;submit=true&amp;service=https%3A%2F%2Fauth.huaweicloud.com%2Frest%2Fauthui%2Fvmall%2Fotherlogin%3Fservice%3Dhttps%253A%252F%252Fwww.huaweicloud.com%252F&amp;loginUrl=https%3A%2F%2Fhwid1.vmall.com%2Foauth2%2Fportal%2Flogin.jsp&amp;loginChannel=53000000&amp;reqClientType=53" ng-bind="i18n('HWSdeveloper')" class="otherLoginColor ng-scope ng-binding" ng-click="BiEvent('send', 'event', 'button', 'click', 'login_vmall', model.vmallUrl)">华为终端开发者</a><!-- end ngIf: !model.isHongKongDomain -->
            </li>
          </ul>
        </div>
      </div>
      <div id="buttonArea" ng-show="model.isUniportal &amp;&amp; !model.isHongKongDomain" class="ng-hide">
        <div id="loginBtn" ng-click="loginClick()" class="loginBtn" tabindex="0">
          <span id="btn_submit" ng-bind="model.submitBtnText" class="ng-binding">登录</span>
        </div>
        <div id="checkArea">
          <span id="model.chkId" text="model.chkTxt" checked="checked" class="ng-isolate-scope"><div class="tiny-checkbox" style="min-width: 50px;"><div class="tiny-checkbox-mark"><div class="tiny-checkboxIcon tiny-checkbox-unchecked"></div><label class="tiny-checkbox-content"><label class="tiny-text">记住登录名</label></label></div></div></span>
          <a target="_blank" rel="noopener noreferrer" href="https://reg.huaweicloud.com/registerui/public/custom/register.html?locale=zh-cn&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F" class="registUrl ng-binding" ng-bind="i18n('freeRegister')" onclick="ga('send', 'event', 'button', 'click', 'login_freeRegister', 1)">免费注册</a>
          <span class="shuXianSpan">|</span>
          <a href="/authui/findPwd.html?locale=zh-cn&amp;UserType=p&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F#/fpwd" class="forgetPWDUrl ng-binding" ng-bind="i18n('forgetPwd')">忘记密码?</a>

        </div>
        <div id="bottomBtns">
          <span ng-bind="i18n('otherWaysLogin')" class="loginBottomColor otherLogin ng-binding">其他账号登录</span>
        </div>
        <div id="bottomBtns" style="margin-top: -60px;">
            <span class="index-uniportal loginBottomColor">
                 <a href="/authui/saml/login?xAccountType=uniportal&amp;service=https%3A%2F%2Fwww.huaweicloud.com%2F" ng-bind="i18n('uniportalName')" class="loginBottomColor ng-binding" style="float:left;margin-top: 30px;" tiny-tip="model.uniportalTip">华为网站账号</a>
                 <div class="uniportalTip">
                     <span class="ng-binding">
                         华为官网用户，华为企业业务合作伙伴，华为员工，ICT开发者等
                     </span>
                 </div>
             </span>
          <a href="https://hwid1.vmall.com/CAS/remoteLogin?lang=zh-cn&amp;validated=true&amp;submit=true&amp;service=https%3A%2F%2Fauth.huaweicloud.com%2Frest%2Fauthui%2Fvmall%2Fotherlogin%3Fservice%3Dhttps%253A%252F%252Fwww.huaweicloud.com%252F&amp;loginUrl=https%3A%2F%2Fhwid1.vmall.com%2Foauth2%2Fportal%2Flogin.jsp&amp;loginChannel=53000000&amp;reqClientType=53" ng-bind="i18n('HWSdeveloper')" class="loginBottomColor ng-binding" onclick="ga('send', 'event', 'button', 'click', 'login_vmall', 1)" style="float:right;margin-top: 30px;">华为终端开发者</a>
        </div>
      </div>

    </div>
    <input type="hidden" name="hwmeta" id="hwmeta" value="JxEAEQAuBGoAAAAAANefAAQBABLEwA0NBwYEHf2Q4Ljes/Sc6YUWAQAEzczLygQBABDKyg4NW1pYRF4+Uj9KLEUwBAEACc3PRUTCwcHRWQQBAAnNz1hXw8LArxEEAQAJzc+kozk4NjrlBAEACc3PvbxiYWFuVAQBAAnNz93cOjk5NVsEAQAJzc+Yl3JxcXo3BAEAE8fFFBP49/f/egx4EmMsSiRGDG8FAQAWx8Lp6B0cGxoZ7IGACnocaSZELkgOaQQBABPHwujnHBsa7fKE8Ir7tNK83pT3BwEAEMfHxsVOEHoKbBlWNF44fhkHAQAQx8fGxUaX45H1hsurx6PrjgcBABDHx8bFRov/jema17fbv/eSBwEAEMfGxcRDdwNxFWYrSydDC24HAQAQx8fGxbqv26nNvvOT/5vTtgYBABHHnZybmuFGMFw+TwCe8IrA2wcBABDHx8bFxLXBs9ek7Y3hhc2oFgEABM3My8oLAQCfzb69lfyP+on7wJCg/ojzmrfeqMay1LratduvyueF64epyb3Ir9uznfCAGH4TLUBQLEolQX0GbUEjTG0fewhxGXsfI0o9SDdFYVJkUA4oFSESV3NACjt8DHwMJUw+XCxOJEBTPUksBWcJZUFyRHE2FjpVO101WjFEN0Y2DyEPeQ95Vj1JKV87UzFcNEYhDm4CbER8F3kbexZwUitCbAhpDAEAVZmqmaySopfzlqaSo8SimPKTpZSnkvTE8cbwjL2J7tXlgbSFvd7o3riOuYGx0eSCstLl0P3L85Oqzf7PqJWnx6OTq5z5nqvJrc6pnajG9sKlwfPK+c4CAQB5zbv3meKI64bkzP7T4sHoqsikyqfSvs6ln770neiC7cyG5IBfEUNiORgmFUt7SRcgNhVVJFM+WACa+7HZrIS1hLabq4SyhKOKwoncltn0077UuNLxt9Ox27WdvO2J+orgsMHv3+/AjqOQr/2d+pjljaOUo5e4hqubrwEBAAjNzMqs2rmuGhQBABjNzKrKqsawwbTUpsSx1JPTvMKF4Zb8mPIXAQAEzczKyQMBACDNzMvdI90j3dzb339+fX9OTUxO7ezr6WxramzLysnLpwQBABDKzZWUHRwbbnQQYDFEJks+BAEAEsTHiYghIB9qgu2D5Y3ip8m61AQBAAnNyI6NT05NNAEWAQAEzczLygcBABDHxsXEuCldL0s4eRl1EVk8BwEAEMfHxsW6qNKixLH+nPaQxqEHAQAQx8bFxEsgahp8CUYkTihuCQcBABDHx8bFThRmFnAdUjBCJGoNBAEACc3Il5ZAPz7PTwQBABPHwvv6FBMS4rLEsMq79JL8ntS3FgEABM3My8oEAQAJzc/p6Dg3Nz0kBAEACc3PmJcrKigoNQQBABDKykVEIB8fDFg0XDVAWjdCBQEAE8rKAQCop6alpbC9vNi42azOo9YFAQATysoBAKilpKOjtaCf/ZP8j+uE9xYBAATNzMvKBAEACc3PoJ6sq6uKUgQBABDKykpJERAOO2MBbwCL74AL"></div>
  <script type="text/javascript" src="/authui/public/custom/js/0874e1c.acctguard.js" class="ng-scope"></script></div>