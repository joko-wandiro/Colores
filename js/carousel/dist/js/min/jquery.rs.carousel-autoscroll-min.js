/*! jquery.rs.carousel-min.js | 1.0.1 | 2013-04-30 | http://richardscarrott.github.com/jquery-ui-carousel/ */
(function(t){"use strict";var e=t.rs.carousel.prototype;t.widget("rs.carousel",t.rs.carousel,{options:{pause:8e3,autoScroll:!1},_create:function(){e._create.apply(this),this.options.autoScroll&&(this._bindAutoScroll(),this._start())},_bindAutoScroll:function(){if(!this.autoScrollInitiated){var e=this.eventNamespace;this.element.bind("mouseenter"+e,t.proxy(this,"_stop")).bind("mouseleave"+e,t.proxy(this,"_start")),this.autoScrollInitiated=!0}},_unbindAutoScroll:function(){var t=this.eventNamespace;this.element.unbind("mouseenter"+t).unbind("mouseleave"+t),this.autoScrollInitiated=!1},_start:function(){var t=this;this._stop(),this.interval=setInterval(function(){t.next()},this.options.pause)},_stop:function(){clearInterval(this.interval)},_setOption:function(t,i){e._setOption.apply(this,arguments),("autoScroll"===t||"pause"===t)&&(i?(this._bindAutoScroll(),this._start()):(this._unbindAutoScroll(),this._stop()))},destroy:function(){this._stop(),e.destroy.apply(this)}})})(jQuery);