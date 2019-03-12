/**
 * @file
 * Base utilities.
 */
(function ($, Drupal, drupalSettings, document, window) {
  'use strict';

  // Variables
  var smartadmin;
  smartadmin = {
    colors: {
      "blue": "#3276b1",
      "blue-sky":  "#0091d9",
      "bg-blue": "#57889c",
      "blue-light": "#92a2a8",
      "blue-dark": "#4c4f53",
      "green": "#356e35",
      "green-light": "#71843f",
      "green-dark": "#496949",
      "green-bright": "#40ac2b",
      "green-bright-1": "#aafaaf",
      "red": "#a90329",
      "yellow": "#b09b5b",
      "orange" : "#c79121",
      "orange-dark": "#a57225",
      "orange-bright":  "#ffc40d",
      "pink": "#ac5287;",
      "pink-dark": "#a8829f",
      "purple": "#6e587a",
      "offwhite": "#f8f8f8",
      "darken": "#404040",
      "lighten":   "#d5e7ec",
      "white": "#ffffff",
      "grey-dark": "#525252",
      "magenta": "#6e3671;",
      "primary": "#3276b1",
      "success": "#739e73",
      "danger": "#a90329",
      "teal": "#568a89",
      "red-light": "#a65858",
      "red-bright": "#ed1c24",
      "teal-light": "#0aa66e",
      "warning": "#c09853",
      "blue-light2": "#058dc7",
      "btnBlue": "#57889c",
      "light": "#fff",
      "dark": "#494949",
      "lightYellow": "#FFFFE0",
      "light-grey": "#A0A0A0",
      "brown": "#797979"
    },
    classesName: {
      fullScreen: 'sa-full-screen',
      shortcutsSection: 'sa-shortcuts-section'
    },

    toggleReloadButton : {

      resetHTML 	: "<i class=\"fa fa-refresh\"></i>",
      loadingHTML : "<i class=\"fa fa-refresh fa-spin\"></i> Loading..."
    },

    trunOnFullScreen: function(){

      if (document.documentElement.requestFullScreen) {

        document.documentElement.requestFullScreen();

      } else if (document.documentElement.mozRequestFullScreen) {

        document.documentElement.mozRequestFullScreen();

      } else if (document.documentElement.webkitRequestFullScreen) {

        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);

      }
      $('body').addClass(smartadmin.classesName.fullScreen);

    },

    trunOffFullScreen: function(){

      if (document.cancelFullScreen) {

        document.cancelFullScreen();

      } else if (document.mozCancelFullScreen) {

        document.mozCancelFullScreen();

      } else if (document.webkitCancelFullScreen) {

        document.webkitCancelFullScreen();

      }

      $('body').removeClass(smartadmin.classesName.fullScreen);

    },

    launchFullscreen: function() {

      if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {

        this.trunOnFullScreen();

      } else {
        this.trunOffFullScreen();

      }

    },
    // RESET WIDGETS
    resetWidgets: function($this){

      $.SmartMessageBox({
        title : "<i class='fa fa-refresh' style='color:green'></i> Clear Local Storage",
        content : $this.data('reset-msg') || "Would you like to RESET all your saved widgets and clear LocalStorage?1",
        buttons : '[No][Yes]'
      }, function(ButtonPressed) {
        if (ButtonPressed == "Yes" && localStorage) {
          localStorage.clear();
          location.reload();
        }

      });
    }
  }

  Drupal.behaviors.tarkBase = {
    attach: function (context, settings) {
      /*
       * =======================================================================
       * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
       * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
       * MERCHANTABILITY, IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
       * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
       * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
       * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
       * =======================================================================
       * original filename: app.config.js
       * filesize: 12kb
       * =======================================================================
       *
       * GLOBAL ROOT (DO NOT CHANGE)
       */
      $.root_ = $('body');
      /*
       * APP CONFIGURATION (HTML/AJAX/PHP Versions ONLY)
       * Description: Enable / disable certain theme features here
       * GLOBAL: Your left nav in your app will no longer fire ajax calls, set
       * it to false for HTML version
       */
      $.navAsAjax = false;
      /*
       * GLOBAL: Sound Config (define sound path, enable or disable all sounds)
       */
      $.sound_path = "sound/";
      $.sound_on = true;
      /*
       * SAVE INSTANCE REFERENCE (DO NOT CHANGE)
       * Save a reference to the global object (window in the browser)
       */
      var root = this;
      /*
               * DEBUGGING MODE
               * debugState = true; will spit all debuging message inside browser console.
               * The colors are best displayed in chrome browser.
               */
      var debugState = false;
      var debugStyle = 'font-weight: bold; color: #00f;';
      var debugStyle_green = 'font-weight: bold; font-style:italic; color: #46C246;';
      var debugStyle_red = 'font-weight: bold; color: #ed1c24;';
      var debugStyle_warning = 'background-color:yellow';
      var debugStyle_success = 'background-color:green; font-weight:bold; color:#fff;';
      var debugStyle_error = 'background-color:#ed1c24; font-weight:bold; color:#fff;';
      /*
               * Impacts the responce rate of some of the responsive elements (lower
               * value affects CPU but improves speed)
               */
      var throttle_delay = 350;
      /*
               * The rate at which the menu expands revealing child elements on click
               */
      var menu_speed = 235;
      /*
               * Collapse current menu item as other menu items are expanded
               * Careful when using this option, if you have a long menu it will
               * keep expanding and may distrupt the user experience This is best
               * used with fixed-menu class
               */
      var menu_accordion = true;
      /*
               * Turn on JarvisWidget functionality
               * Global JarvisWidget Settings
               * For a greater control of the widgets, please check app.js file
               * found within COMMON_ASSETS/UNMINIFIED_JS folder and see from line 1355
               * dependency: js/jarviswidget/jarvis.widget.min.js
               */
      var enableJarvisWidgets = true;
      /*
               * Use localstorage to save widget settings
               * turn this off if you prefer to use the onSave hook to save
               * these settings to your datatabse instead
               */
      var localStorageJarvisWidgets = true;
      /*
               * Turn off sortable feature for JarvisWidgets
               */
      var sortableJarvisWidgets = true;
      /*
               * Warning: Enabling mobile widgets could potentially crash your webApp
               * if you have too many widgets running at once
               * (must have enableJarvisWidgets = true)
               */
      var enableMobileWidgets = false;
      /*
               * Turn on fast click for mobile devices
               * Enable this to activate fastclick plugin
               * dependency: js/plugin/fastclick/fastclick.js
               */
      var fastClick = false;
      /*
               * SMARTCHAT PLUGIN ARRAYS & CONFIG
               * Dependency: js/plugin/moment/moment.min.js
               *             js/plugin/cssemotions/jquery.cssemoticons.min.js
               *             js/smart-chat-ui/smart.chat.ui.js
               * (DO NOT CHANGE BELOW)
               */
      var boxList = [];
      var showList = [];
      var nameList = [];
      var idList = [];
      /*
               * Width of the chat boxes, and the gap inbetween in pixel (minus padding)
               */
      var chatbox_config = {
        width: 200,
        gap: 35
      };
      /*
               * These elements are ignored during DOM object deletion for ajax version
               * It will delete all objects during page load with these exceptions:
               */
      var ignore_key_elms = ["#header, #left-panel, #right-panel, #main, div.page-footer, #shortcut, #divSmallBoxes, #divMiniIcons, #divbigBoxes, #voiceModal, script, .ui-chatbox"];
      /*
               * VOICE COMMAND CONFIG
               * dependency: js/speech/voicecommand.js
               */
      var voice_command = true;
      /*
               * Turns on speech as soon as the page is loaded
               */
      var voice_command_auto = false;
      /*
               * 	Sets the language to the default 'en-US'. (supports over 50 languages
               * 	by google)
               *
               *  Afrikaans         ['af-ZA']
               *  Bahasa Indonesia  ['id-ID']
               *  Bahasa Melayu     ['ms-MY']
               *  Català            ['ca-ES']
               *  Čeština           ['cs-CZ']
               *  Deutsch           ['de-DE']
               *  English           ['en-AU', 'Australia']
               *                    ['en-CA', 'Canada']
               *                    ['en-IN', 'India']
               *                    ['en-NZ', 'New Zealand']
               *                    ['en-ZA', 'South Africa']
               *                    ['en-GB', 'United Kingdom']
               *                    ['en-US', 'United States']
               *  Español           ['es-AR', 'Argentina']
               *                    ['es-BO', 'Bolivia']
               *                    ['es-CL', 'Chile']
               *                    ['es-CO', 'Colombia']
               *                    ['es-CR', 'Costa Rica']
               *                    ['es-EC', 'Ecuador']
               *                    ['es-SV', 'El Salvador']
               *                    ['es-ES', 'España']
               *                    ['es-US', 'Estados Unidos']
               *                    ['es-GT', 'Guatemala']
               *                    ['es-HN', 'Honduras']
               *                    ['es-MX', 'México']
               *                    ['es-NI', 'Nicaragua']
               *                    ['es-PA', 'Panamá']
               *                    ['es-PY', 'Paraguay']
               *                    ['es-PE', 'Perú']
               *                    ['es-PR', 'Puerto Rico']
               *                    ['es-DO', 'República Dominicana']
               *                    ['es-UY', 'Uruguay']
               *                    ['es-VE', 'Venezuela']
               *  Euskara           ['eu-ES']
               *  Français          ['fr-FR']
               *  Galego            ['gl-ES']
               *  Hrvatski          ['hr_HR']
               *  IsiZulu           ['zu-ZA']
               *  Íslenska          ['is-IS']
               *  Italiano          ['it-IT', 'Italia']
               *                    ['it-CH', 'Svizzera']
               *  Magyar            ['hu-HU']
               *  Nederlands        ['nl-NL']
               *  Norsk bokmål      ['nb-NO']
               *  Polski            ['pl-PL']
               *  Português         ['pt-BR', 'Brasil']
               *                    ['pt-PT', 'Portugal']
               *  Română            ['ro-RO']
               *  Slovenčina        ['sk-SK']
               *  Suomi             ['fi-FI']
               *  Svenska           ['sv-SE']
               *  Türkçe            ['tr-TR']
               *  български         ['bg-BG']
               *  Pусский           ['ru-RU']
               *  Српски            ['sr-RS']
               *  한국어              ['ko-KR']
               *  中文               ['cmn-Hans-CN', '普通话 (中国大陆)']
               *                    ['cmn-Hans-HK', '普通话 (香港)']
               *                    ['cmn-Hant-TW', '中文 (台灣)']
               *                    ['yue-Hant-HK', '粵語 (香港)']
               *  日本語                         ['ja-JP']
               *  Lingua latīna     ['la']
               */
      var voice_command_lang = 'en-US';
      /*
               * 	Use localstorage to remember on/off (best used with HTML Version
               * 	when going from one page to the next)
               */
      var voice_localStorage = true;


      /*
       * Voice Commands
       * Defines voice command variables and functions
       */
      if (voice_command) {
        var commands = {

          'show dashboard': function () {
            $('nav a[href="dashboard.html"]').trigger("click");
          },
          'show inbox': function () {
            $('nav a[href="inbox.html"]').trigger("click");
          },
          'show graphs': function () {
            $('nav a[href="flot.html"]').trigger("click");
          },
          'show flotchart': function () {
            $('nav a[href="flot.html"]').trigger("click");
          },
          'show morris chart': function () {
            $('nav a[href="morris.html"]').trigger("click");
          },
          'show inline chart': function () {
            $('nav a[href="inline-charts.html"]').trigger("click");
          },
          'show dygraphs': function () {
            $('nav a[href="dygraphs.html"]').trigger("click");
          },
          'show tables': function () {
            $('nav a[href="table.html"]').trigger("click");
          },
          'show data table': function () {
            $('nav a[href="datatables.html"]').trigger("click");
          },
          'show jquery grid': function () {
            $('nav a[href="jqgrid.html"]').trigger("click");
          },
          'show form': function () {
            $('nav a[href="form-elements.html"]').trigger("click");
          },
          'show form layouts': function () {
            $('nav a[href="form-templates.html"]').trigger("click");
          },
          'show form validation': function () {
            $('nav a[href="validation.html"]').trigger("click");
          },
          'show form elements': function () {
            $('nav a[href="bootstrap-forms.html"]').trigger("click");
          },
          'show form plugins': function () {
            $('nav a[href="plugins.html"]').trigger("click");
          },
          'show form wizards': function () {
            $('nav a[href="wizards.html"]').trigger("click");
          },
          'show bootstrap editor': function () {
            $('nav a[href="other-editors.html"]').trigger("click");
          },
          'show dropzone': function () {
            $('nav a[href="dropzone.html"]').trigger("click");
          },
          'show image cropping': function () {
            $('nav a[href="image-editor.html"]').trigger("click");
          },
          'show general elements': function () {
            $('nav a[href="general-elements.html"]').trigger("click");
          },
          'show buttons': function () {
            $('nav a[href="buttons.html"]').trigger("click");
          },
          'show fontawesome': function () {
            $('nav a[href="fa.html"]').trigger("click");
          },
          'show glyph icons': function () {
            $('nav a[href="glyph.html"]').trigger("click");
          },
          'show flags': function () {
            $('nav a[href="flags.html"]').trigger("click");
          },
          'show grid': function () {
            $('nav a[href="grid.html"]').trigger("click");
          },
          'show tree view': function () {
            $('nav a[href="treeview.html"]').trigger("click");
          },
          'show nestable lists': function () {
            $('nav a[href="nestable-list.html"]').trigger("click");
          },
          'show jquery U I': function () {
            $('nav a[href="jqui.html"]').trigger("click");
          },
          'show typography': function () {
            $('nav a[href="typography.html"]').trigger("click");
          },
          'show calendar': function () {
            $('nav a[href="calendar.html"]').trigger("click");
          },
          'show widgets': function () {
            $('nav a[href="widgets.html"]').trigger("click");
          },
          'show gallery': function () {
            $('nav a[href="gallery.html"]').trigger("click");
          },
          'show maps': function () {
            $('nav a[href="gmap-xml.html"]').trigger("click");
          },
          'show pricing tables': function () {
            $('nav a[href="pricing-table.html"]').trigger("click");
          },
          'show invoice': function () {
            $('nav a[href="invoice.html"]').trigger("click");
          },
          'show search': function () {
            $('nav a[href="search.html"]').trigger("click");
          },
          'go back': function () {
            history.back(1);
          },
          'scroll up': function () {
            $('html, body').animate({scrollTop: 0}, 100);
          },
          'scroll down': function () {
            $('html, body').animate({scrollTop: $(document).height()}, 100);
          },
          'hide navigation': function () {
            if ($.root_.hasClass("container") && !$.root_.hasClass("menu-on-top")) {
              $('span.minifyme').trigger("click");
            } else {
              $('#hide-menu > span > a').trigger("click");
            }
          },
          'show navigation': function () {
            if ($.root_.hasClass("container") && !$.root_.hasClass("menu-on-top")) {
              $('span.minifyme').trigger("click");
            } else {
              $('#hide-menu > span > a').trigger("click");
            }
          },
          'mute': function () {
            $.sound_on = false;
            $.smallBox({
              title: "MUTE",
              content: "All sounds have been muted!",
              color: "#a90329",
              timeout: 4000,
              icon: "fa fa-volume-off"
            });
          },
          'sound on': function () {
            $.sound_on = true;
            $.speechApp.playConfirmation();
            $.smallBox({
              title: "UNMUTE",
              content: "All sounds have been turned on!",
              color: "#40ac2b",
              sound_file: 'voice_alert',
              timeout: 5000,
              icon: "fa fa-volume-up"
            });
          },
          'stop': function () {
            smartSpeechRecognition.abort();
            $.root_.removeClass("voice-command-active");
            $.smallBox({
              title: "VOICE COMMAND OFF",
              content: "Your voice commands has been successfully turned off. Click on the <i class='fa fa-microphone fa-lg fa-fw'></i> icon to turn it back on.",
              color: "#40ac2b",
              sound_file: 'voice_off',
              timeout: 8000,
              icon: "fa fa-microphone-slash"
            });
            if ($('#speech-btn .popover').is(':visible')) {
              $('#speech-btn .popover').fadeOut(250);
            }
          },
          'help': function () {
            $('#voiceModal').removeData('modal').modal({
              remote: "ajax/modal-content/modal-voicecommand.html",
              show: true
            });
            if ($('#speech-btn .popover').is(':visible')) {
              $('#speech-btn .popover').fadeOut(250);
            }
          },
          'got it': function () {
            $('#voiceModal').modal('hide');
          },
          'logout': function () {
            $.speechApp.stop();
            window.location = $('#logout > span > a').attr("href");
          }
        };

      };
      /*
       * END APP.CONFIG
       */

      /*
        commonJs
      */

      function SAtoggleClass(element, parentClass, toggleClass, hasClass, className) {

        $(element).parents(parentClass).toggleClass(toggleClass);

        if(hasClass) {

          $(element).toggleClass(className);

        }

        return false;

      }


      function SASetClass(element) {

        if($(element).is(':checked')) {

          localStorage.setItem($(element).attr('id'), true);

          $('body').removeClass($(element).data('remove-class')).addClass($(element).data('add-class'));

        }
        else {

          localStorage.setItem($(element).attr('id'), false);

          $('body').removeClass($(element).data('remove-class'));

        }


        if(!$(element).is(':checked')) {

          if($(element).attr('id') == 'SAFixedHeader'){

            localStorage.setItem('SAFixedHeader', false);
            localStorage.setItem('SAFixedNavigation', false);
            localStorage.setItem('SAFixedRibbon', false);

            $('#SAFixedNavigation, #SAFixedRibbon').prop('checked', false);
          }

          if($(element).attr('id') == 'SAFixedNavigation'){

            $('#SAFixedRibbon').prop('checked', false);
            localStorage.setItem('SAFixedRibbon', false);
          }

          if($(element).attr('id') == 'SAMenuOnTop'){
            localStorage.setItem('SAMenuOnTop', false);
            location.reload();
          }

        }
        else {
          if($(element).attr('id') == 'SAFixedNavigation'){

            $('#SAFixedHeader').prop('checked', true);
            $('#SAFixedNavigation').prop('checked', true);
            localStorage.setItem('SAFixedHeader', true);
            localStorage.setItem('SAFixedNavigation', true);
          }

          if($(element).attr('id') == 'SAFixedRibbon'){

            $('#SAFixedHeader, #SAFixedNavigation').prop('checked', true);
            localStorage.setItem('SAFixedNavigation', true);
            localStorage.setItem('SAFixedHeader', true);
          }

          if($(element).attr('id') == 'SAMenuOnTop'){

            localStorage.setItem('SAMenuOnTop', true);
            location.reload();
          }
        }
      }


      function SAMenuSetupOnTop() {

        // SAMenuOnTop
        if(localStorage) {

          if(localStorage.getItem('SAMenuOnTop') && JSON.parse(localStorage.getItem('SAMenuOnTop'))) {
            $('body').removeClass($('#SAMenuOnTop').data('remove-class')).addClass($('#SAMenuOnTop').data('add-class'));
            $('#SAMenuOnTop').prop('checked', true);
          }
          else {
            $('body').removeClass($('#SAMenuOnTop').data('remove-class'));
            $('#SAMenuOnTop').prop('checked', false);
          }


          // SAFixedHeader

          if(localStorage.getItem('SAFixedHeader') && JSON.parse(localStorage.getItem('SAFixedHeader'))) {
            $('body').removeClass($('#SAFixedHeader').data('remove-class')).addClass($('#SAFixedHeader').data('add-class'));
            $('#SAFixedHeader').prop('checked', true);
          }
          else {
            $('body').removeClass($('#SAFixedHeader').data('remove-class'));
            $('#SAFixedHeader').prop('checked', false);
          }


          // SAFixedNavigation

          if(localStorage.getItem('SAFixedNavigation') && JSON.parse(localStorage.getItem('SAFixedNavigation'))) {
            $('body').removeClass($('#SAFixedNavigation').data('remove-class')).addClass($('#SAFixedNavigation').data('add-class'));
            $('#SAFixedNavigation').prop('checked', true);
          }
          else {
            $('body').removeClass($('#SAFixedNavigation').data('remove-class'));
            $('#SAFixedNavigation').prop('checked', false);
          }


          // SAFixedRibbon

          if(localStorage.getItem('SAFixedRibbon') && JSON.parse(localStorage.getItem('SAFixedRibbon'))) {
            $('body').removeClass($('#SAFixedRibbon').data('remove-class')).addClass($('#SAFixedRibbon').data('add-class'));
            $('#SAFixedRibbon').prop('checked', true);
          }
          else {
            $('body').removeClass($('#SAFixedRibbon').data('remove-class'));
            $('#SAFixedRibbon').prop('checked', false);
          }
        }

      }

      /*
       * INITIALIZE JARVIS WIDGETS
       * Setup Desktop Widgets
       */
      function setup_widgets_desktop() {

        if ($.fn.jarvisWidgets && enableJarvisWidgets) {

          $('#block-mainpagecontent').jarvisWidgets({

            grid : 'article',
            widgets : '.jarviswidget',
            localStorage : localStorageJarvisWidgets,
            deleteSettingsKey : '#deletesettingskey-options',
            settingsKeyLabel : 'Reset settings?',
            deletePositionKey : '#deletepositionkey-options',
            positionKeyLabel : 'Reset position?',
            sortable : sortableJarvisWidgets,
            buttonsHidden : false,
            // toggle button
            toggleButton : true,
            toggleClass : 'fa fa-minus | fa fa-plus',
            toggleSpeed : 200,
            onToggle : function() {
            },
            // delete btn
            deleteButton : true,
            deleteMsg:'Warning: This action cannot be undone!',
            deleteClass : 'fa fa-times',
            deleteSpeed : 200,
            onDelete : function() {
            },
            // edit btn
            editButton : true,
            editPlaceholder : '.jarviswidget-editbox',
            editClass : 'fa fa-cog | fa fa-save',
            editSpeed : 200,
            onEdit : function() {
            },
            // color button
            colorButton : true,
            // full screen
            fullscreenButton : true,
            fullscreenClass : 'fa fa-expand | fa fa-compress',
            fullscreenDiff : 3,
            onFullscreen : function() {
            },
            // custom btn
            customButton : false,
            customClass : 'folder-10 | next-10',
            customStart : function() {
              alert('Hello you, this is a custom button...');
            },
            customEnd : function() {
              alert('bye, till next time...');
            },
            // order
            buttonOrder : '%refresh% %custom% %edit% %toggle% %fullscreen% %delete%',
            opacity : 1.0,
            dragHandle : '> header',
            placeholderClass : 'jarviswidget-placeholder',
            indicator : true,
            indicatorTime : 600,
            ajax : true,
            timestampPlaceholder : '.jarviswidget-timestamp',
            timestampFormat : 'Last update: %m%/%d%/%y% %h%:%i%:%s%',
            refreshButton : true,
            refreshButtonClass : 'fa fa-refresh',
            labelError : 'Sorry but there was a error:',
            labelUpdated : 'Last Update:',
            labelRefresh : 'Refresh',
            labelDelete : 'Delete widget:',
            afterLoad : function() {
            },
            rtl : false, // best not to toggle this!
            onChange : function() {

            },
            onSave : function() {

            },
            ajaxnav : $.navAsAjax // declears how the localstorage should be saved (HTML or AJAX Version)

          });

        }

      }



      function userLogout(e) {
        function t() {
          window.location = e.attr("href")
        }
        $.SmartMessageBox({
          title: "<i class='fa fa-sign-out text-orange-dark'></i> Logout <span class='text-orange-dark'><strong>" + $(".sa-sidebar-shortcut-toggle").text() + "</strong></span> ?",
          content: e.data("logout-msg") || "You can improve your security further after logging out by closing this opened browser",
          buttons: "[No][Yes]"
        }, function(e) {
          "Yes" == e && ($.root_.addClass("animated fadeOutUp"),
            setTimeout(t, 1e3))
        })
      }

      function toggleFullScreen() {
        smartadmin.launchFullscreen();
      }

      $('.sa-theme-settings-toggle').once('sa-theme-settings-toggle').click(function () {
        SAtoggleClass(this, '.sa-theme-settings', 'active');
      });
      
      $('button.sa-toggle-full-screen').once('sa-toggle-full-screen').click(function () {
        toggleFullScreen();
      });

      $(document).keyup(function(e){
        if(e.which==122) {

          smartadmin.launchFullscreen();

        }else if(e.which==27) {

          $('body').removeClass(smartadmin.classesName.fullScreen);
        }

      });

      SAMenuSetupOnTop();
      /*
       * SETUP DESKTOP WIDGET
       */
      setup_widgets_desktop();

      $(".sa-logout-header-toggle").click(function(t) {
        var a = $(this);
        userLogout(a);
        t.preventDefault();
        a = null;
      })

      $('[data-action="userLogout"]').click(function(t) {
        var a = $(this);
        userLogout(a);
        t.preventDefault();
        a = null;
      });

      $('[data-action="toggleMenu"]').click(function(){
        $('body').removeClass('minified');
        SAtoggleClass(this, 'body', 'sa-hidden-menu')
      });

      $('button.sa-sidebar-hidden-toggle').once('sa-sidebar-hidden-toggl').click(function () {
        SAtoggleClass(this, 'body', 'sa-hidden-menu');
      });
      
      $('a.minifyme').once('minifyme').click(function () {
        SAtoggleClass(this, 'body', 'minified');
      });

      $('[data-action="minifyMenu"]').click(function(){
        $('body').removeClass('sa-hidden-menu');
        SAtoggleClass(this, 'body', 'minified')
      });

      $('[data-action="resetWidgets"]').click(function(){
        smartadmin.resetWidgets($(this));
      });
      
      $('a.sa-sidebar-shortcut-toggle').once('sa-sidebar-shortcut-toggle').click(function () {
        SAtoggleClass(this, 'body', 'sa-shortcuts-expanded');
      });

      $('body').once('smart-body').click(function(){
        if($('.'+smartadmin.classesName.shortcutsSection).height()) {
          $(this).removeClass('sa-shortcuts-expanded');
        }
      });

      $('[data-rel="popover-hover"]').popover();
      $('[data-toggle="popover"]').popover();
      $('[rel="tooltip"]').tooltip();

      $('.sa-activity-dropdown-toggle').once('sa-activity-dropdown-toggle').click(function(){
        $(this).find('.badge').removeClass('bg-red');
      });

      $('input[type=checkbox]').once('layout-options').change(function () {
        SASetClass(this);
      });
      $('.sidebar-menu.tree li.header').addClass('label-danger');


      $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function(title) {
          if (!this.options.title ) {
            title.html("&#160;");
          } else {
            title.html(this.options.title);
          }
        }
      }));








    }
  };
}) (jQuery, Drupal, drupalSettings, document, window);