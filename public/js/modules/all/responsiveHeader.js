(function(){define([],function(){var n,e,u,i,o,t;i={lnkMenu:".menu-movil .lnk-mmenu",ctnMenu:".menu-movil",menu:".ctn-mmovil"};e={};t=null;n=function(){e.lnkMenu=$(i.lnkMenu);e.ctnMenu=$(i.ctnMenu);e.menu=$(i.menu);e.win=$(window)};o=function(){e.lnkMenu.on("click",u.openMenu);e.win.on("resize",u.resize);e.win.trigger("resize")};u={openMenu:function(){if(e.ctnMenu.hasClass("open")){e.ctnMenu.removeClass("open")}else{e.ctnMenu.addClass("open")}},resize:function(){var n;n=e.win.height();if(t){clearTimeout(t);t=null}t=setTimeout(function(){e.menu.css("height",n)},600)}};n();o()})}).call(this);