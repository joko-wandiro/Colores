/*! jquery.rs.carousel-min.js | 1.0.1 | 2013-04-30 | http://richardscarrott.github.com/jquery-ui-carousel/ */
(function(t){"use strict";var e=t.rs.carousel.prototype;t.widget("rs.carousel",t.rs.carousel,{options:{pause:8e3,autoScroll:!1},_create:function(){e._create.apply(this),this.options.autoScroll&&(this._bindAutoScroll(),this._start())},_bindAutoScroll:function(){if(!this.autoScrollInitiated){var e=this.eventNamespace;this.element.bind("mouseenter"+e,t.proxy(this,"_stop")).bind("mouseleave"+e,t.proxy(this,"_start")),this.autoScrollInitiated=!0}},_unbindAutoScroll:function(){var t=this.eventNamespace;this.element.unbind("mouseenter"+t).unbind("mouseleave"+t),this.autoScrollInitiated=!1},_start:function(){var t=this;this._stop(),this.interval=setInterval(function(){t.next()},this.options.pause)},_stop:function(){clearInterval(this.interval)},_setOption:function(t,i){e._setOption.apply(this,arguments),("autoScroll"===t||"pause"===t)&&(i?(this._bindAutoScroll(),this._start()):(this._unbindAutoScroll(),this._stop()))},destroy:function(){this._stop(),e.destroy.apply(this)}})})(jQuery),function(t,e){"use strict";var i=t.rs.carousel.prototype;t.widget("rs.carousel",t.rs.carousel,{options:{continuous:!1},_create:function(){this.options.continuous&&(this.options.loop=!0,this.options.whitespace=!0),i._create.apply(this,arguments)},refresh:function(){i.refresh.apply(this,arguments),this.options.continuous&&(this._addClonedItems(),this._setRunnerWidth(),this.enable(),this.goToPage(this.index,!1,e,!0),this._checkDisabled())},_addClonedItems:function(){if(this.options.disabled)return this._removeClonedItems(),e;var t=this.elements,i=this.widgetFullName+"-item-clone",s=this._getVisibleItems(0);this._removeClonedItems(),t.clonedBeginning=s.clone().add(this.elements.items.slice(s.length).first().clone()).addClass(i).appendTo(t.runner),t.clonedEnd=this.getPage(this.getNoOfPages()-1).clone().addClass(i).prependTo(t.runner)},_removeClonedItems:function(){var t=this.elements;t.clonedBeginning&&(t.clonedBeginning.remove(),t.clonedBeginning=e),t.clonedEnd&&(t.clonedEnd.remove(),t.clonedEnd=e)},_setRunnerWidth:function(){var e=this.elements,s=0;if(this.options.continuous){if(e.runner.width(""),!this.isHorizontal)return;e.runner.width(function(){return e.items.add(e.clonedBeginning).add(e.clonedEnd).each(function(){s+=t(this).outerWidth(!0)}),s})}else i._setRunnerWidth.apply(this,arguments)},_slide:function(t){var s;this.options.continuous&&("carousel:next"===t.type&&0===this.index?s=this.elements.clonedEnd.first().position()[this.isHorizontal?"left":"top"]:"carousel:prev"===t.type&&this.index===this.getNoOfPages()-1&&(s=this.elements.clonedBeginning.first().position()[this.isHorizontal?"left":"top"]),s!==e&&(this.options.translate3d?this.elements.runner.css("transform","translate3d("+(this.isHorizontal?-s+"px, 0, 0":"0, "+-s+"px, 0")+")"):this.elements.runner.css(this.isHorizontal?"left":"top",-s))),i._slide.apply(this,arguments)},_recacheItems:function(){var t=this.widgetFullName;this.elements.items=this.elements.runner.find(this.options.items).not("."+t+"-item-clone").addClass(t+"-item")},add:function(t){return this.elements.items.length?(this.elements.items.last().after(t),this.refresh(),e):(i.add.apply(this,arguments),e)},_setOption:function(t,e){i._setOption.apply(this,arguments),"continuous"===t&&(this.options.loop=!0,this.options.whitespace=!0,e||this._removeClonedItems(),this.refresh())},destroy:function(){this._removeClonedItems(),i.destroy.apply(this)}})}(jQuery),function(t){"use strict";var e=t.Widget.prototype;t.widget("rs.draggable3d",{options:{axis:"x",translate3d:!1},_create:function(){this.eventNamespace=this.eventNamespace||"."+this.widgetName,this._bindDragEvents()},_bindDragEvents:function(){var t=this,e=this.eventNamespace;this.element.unbind(e).bind("dragstart"+e,{axis:this.options.axis},function(e){t._start(e)}).bind("drag"+e,function(e){t._drag(e)}).bind("dragend"+e,function(e){t._end(e)})},_getPosStr:function(){return"x"===this.options.axis?"left":"top"},_start:function(t){this.mouseStartPos="x"===this.options.axis?t.pageX:t.pageY,this.elPos=this.options.translate3d?this.element.css("translate3d")[this.options.axis]:parseInt(this.element.position()[this._getPosStr()],10),this._trigger("start",t)},_drag:function(t){var e="x"===this.options.axis?t.pageX:t.pageY,i=e-this.mouseStartPos+this.elPos,s={};this.options.translate3d?s.translate3d="x"===this.options.axis?{x:i}:{y:i}:s[this._getPosStr()]=i,this.element.css(s)},_end:function(t){this._trigger("stop",t)},_setOption:function(t){e._setOption.apply(this,arguments),"axis"===t&&this._bindDragEvents()},destroy:function(){var t={};this.options.translate3d?t.translate3d={}:t[this._getPosStr()]="",this.element.css(t),e.destroy.apply(this)}})}(jQuery),function(t){"use strict";var e=t.rs.carousel.prototype;t.widget("rs.carousel",t.rs.carousel,{options:{touch:!1,sensitivity:1},_create:function(){e._create.apply(this),this._initDrag()},_initDrag:function(){var t=this;this.elements.runner.draggable3d({translate3d:this.options.translate3d,axis:this._getAxis(),start:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,t._dragStartHandler(e)},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,t._dragStopHandler(e)}})},_destroyDrag:function(){this.elements.runner.draggable3d("destroy"),this.goToPage(this.index,!1,void 0,!0)},_getAxis:function(){return this.isHorizontal?"x":"y"},_dragStartHandler:function(t){this.options.translate3d&&this.elements.runner.removeClass(this.widgetFullName+"-runner-transition"),this.startTime=this._getTime(),this.startPos={x:t.pageX,y:t.pageY}},_dragStopHandler:function(t){var e,i,s,n,o=this._getAxis();this.endTime=this._getTime(),e=this.endTime-this.startTime,this.endPos={x:t.pageX,y:t.pageY},i=Math.abs(this.startPos[o]-this.endPos[o]),s=i/e,n=this.startPos[o]>this.endPos[o]?"next":"prev",s>this.options.sensitivity||i>this._getMaskDim()/2?this.index===this.getNoOfPages()-1&&"next"===n||0===this.index&&"prev"===n?this.goToPage(this.index):this[n]():this.goToPage(this.index)},_getTime:function(){var t=new Date;return t.getTime()},_setOption:function(t,i){switch(e._setOption.apply(this,arguments),t){case"orientation":this._switchAxis();break;case"touch":i?this._initDrag():this._destroyDrag()}},_switchAxis:function(){this.elements.runner.draggable3d("option","axis",this._getAxis())},destroy:function(){this._destroyDrag(),e.destroy.apply(this)}})}(jQuery),function(t,e){"use strict";var i=t.Widget.prototype;t.widget("rs.carousel",{version:"1.0.1",options:{mask:"> div",runner:"> ul",items:"> li",itemsPerTransition:"auto",orientation:"horizontal",loop:!1,whitespace:!1,nextPrevActions:!0,insertPrevAction:function(){return t('<a href="#" class="rs-carousel-action rs-carousel-action-prev">Prev</a>').appendTo(this)},insertNextAction:function(){return t('<a href="#" class="rs-carousel-action rs-carousel-action-next">Next</a>').appendTo(this)},pagination:!0,insertPagination:function(e){return t(e).insertAfter(t(this).find(".rs-carousel-mask"))},speed:"normal",easing:"swing",fx:"slide",translate3d:!1,create:null,before:null,after:null},_create:function(){this.widgetFullName=this.widgetFullName||this.widgetBaseClass,this.eventNamespace=this.eventNamespace||"."+this.widgetName,this.index=0,this._elements(),this._setIsHorizontal(),this._addMask(),this._addNextPrevActions(),this.refresh(!1)},_elements:function(){var t=this.elements={},e=this.widgetFullName;this.element.addClass(e),t.mask=this.element.find(this.options.mask).addClass(e+"-mask"),t.runner=(t.mask.length?t.mask:this.element).find(this.options.runner).addClass(e+"-runner"),t.items=t.runner.find(this.options.items).addClass(e+"-item")},_setIsHorizontal:function(){var t=this.elements,e=this.widgetFullName;this.element.removeClass(e+"-horizontal").removeClass(e+"-vertical"),"horizontal"===this.options.orientation?(this.isHorizontal=!0,this.element.addClass(e+"-horizontal"),t.runner.css("top","")):(this.isHorizontal=!1,this.element.addClass(e+"-vertical"),t.runner.css("left",""))},_addMask:function(){var t=this.elements;t.mask.length||(t.mask=t.runner.wrap('<div class="'+this.widgetFullName+'-mask" />').parent(),this.maskAdded=!0)},_addNextPrevActions:function(){if(this.options.nextPrevActions){var t=this,e=this.elements,i=this.options,s=this.eventNamespace;this._removeNextPrevActions(),e.prevAction=i.insertPrevAction.apply(this.element[0]).bind("click"+s,function(e){e.preventDefault(),t.prev()}),e.nextAction=i.insertNextAction.apply(this.element[0]).bind("click"+s,function(e){e.preventDefault(),t.next()})}},_removeNextPrevActions:function(){var t=this.elements;t.nextAction&&(t.nextAction.remove(),t.nextAction=e),t.prevAction&&(t.prevAction.remove(),t.prevAction=e)},refresh:function(t){t!==!1&&this._recacheItems(),this._setPages(),this._addPagination(),this._setRunnerWidth(),this.index=this._makeValid(this.index),this.goToPage(this.index,!1,e,!0),this._checkDisabled()},_recacheItems:function(){this.elements.items=this.elements.runner.find(this.options.items).addClass(this.widgetFullName+"-item")},_setPages:function(){var t,i=this,s=0,n=isNaN(this.options.itemsPerTransition)?e:this._getLastItemIndex();for(this.pages=[];this.getNoOfItems()>s;)if(isNaN(this.options.itemsPerTransition))this.pages.push(i._getVisibleItems(s)),s+=this.pages[this.pages.length-1].length;else{if(s>=n){this.pages.push(this.elements.items.slice(s));break}t=s,s+=parseInt(this.options.itemsPerTransition,10),this.pages.push(this.elements.items.slice(t,s))}},_getLastItemIndex:function(){return this.options.whitespace?e:this.elements.items.index(this._getVisibleItems(0,!0).last())},_getVisibleItems:function(i,s){var n=this,o=[],a=s?[].reverse.apply(t(this.elements.items)).slice(i):this.elements.items.slice(i),r=this._getMaskDim(),h=0;return a.each(function(){return h+=n.isHorizontal?t(this).outerWidth(!0):t(this).outerHeight(!0),h>r?(0===o.length&&o.push(this),!1):(o.push(this),e)}),t(o)},_getMaskDim:function(){return this.elements.mask[this.isHorizontal?"width":"height"]()},getNoOfItems:function(){return this.elements.items.length},_addPagination:function(){if(this.options.pagination){var e,i=this,s=this.widgetFullName,n=t('<ol class="'+s+'-pagination" />'),o=[],a=this.getNoOfPages();for(this._removePagination(),e=0;a>e;e++)o[e]='<li class="'+s+'-pagination-link"><a href="#page-'+e+'">'+(e+1)+"</a></li>";n.append(o.join("")).delegate("a","click"+this.eventNamespace,function(t){t.preventDefault(),i.goToPage(parseInt(this.hash.split("-")[1],10))}),this.elements.pagination=this.options.insertPagination.call(this.element[0],n)}},_removePagination:function(){this.elements.pagination&&(this.elements.pagination.remove(),this.elements.pagination=e)},getNoOfPages:function(){return this.pages.length},_checkDisabled:function(){1>=this.getNoOfPages()?(this.disable(),this._disabled=!0):this._disabled&&(this.enable(),this._disabled=!1)},_setRunnerWidth:function(){var e=this.elements,i=0;e.runner.width(""),this.isHorizontal&&e.runner.width(function(){return e.items.each(function(){i+=t(this).outerWidth(!0)}),i})},next:function(t){var e=this.index+1;this.options.loop&&e>=this.getNoOfPages()&&(e=0),this.goToPage(e,t,"carousel:next")},prev:function(t){var e=this.index-1;this.options.loop&&0>e&&(e=this.getNoOfPages()-1),this.goToPage(e,t,"carousel:prev")},goToPage:function(e,i,s,n){i=i===!1?!1:!0,!this.options.disabled&&this._isValid(e)&&(this.prevIndex=this.index,this.index=e,this["_"+this.options.fx](t.Event(s?s:"carousel:gotopage",{animate:i,speed:i?this.options.speed:0}),n)),this._updateUi()},goToItem:function(e,i){var s,n,o,a;isNaN(e)||(e=this.elements.items.eq(e)),e.jquery&&(e=e[0]);t:for(s=0,n=this.getNoOfPages();n>s;s++)for(o=0,a=this.getPage(s).length;a>o;o++)if(this.getPage(s)[o]===e)break t;return this.goToPage(s,i),t(e)},_isValid:function(t){return this.getNoOfPages()>t&&t>=0?!0:!1},_makeValid:function(t){return 0>t?t=0:t>=this.getNoOfPages()&&(t=this.getNoOfPages()-1),t},_slide:function(t,i){var s,n=this,o={},a=this._getAbsoluteLastPos(),r=this.getPage(),h=r.first().position()[this.isHorizontal?"left":"top"],l=this.eventNamespace,d=this.widgetFullName;return i||this._trigger("before",t,this._getEventData())?(h>a&&(h=a),this.options.translate3d?(s=["transitionend"+l,"webkitTransitionEnd"+l,"oTransitionEnd"+l],t.animate&&this.element.addClass(d+"-transition"),this.elements.runner.unbind(s.join(" ")).on(s.join(" "),function(t){n.element.removeClass(d+"-transition"),i||n._trigger("after",t,n._getEventData())}).css("transform","translate3d("+(this.isHorizontal?-h+"px, 0, 0":"0, "+-h+"px, 0")+")"),t.animate||(n.element.removeClass(d+"-transition"),i||n._trigger("after",t,n._getEventData()))):(o[this.isHorizontal?"left":"top"]=-h,this.elements.runner.stop().animate(o,t.speed,this.options.easing,function(){i||n._trigger("after",t,n._getEventData())})),e):(this.index=this.prevIndex,e)},_getAbsoluteLastPos:function(){if(!this.options.whitespace){var t,i=this.elements.items.eq(this.getNoOfItems()-1),s=i.position()[this.isHorizontal?"left":"top"],n=i[this.isHorizontal?"outerWidth":"outerHeight"](!0);return t=s+n-this._getMaskDim(),0>t?e:t}},getPage:function(i){return this.pages[i!==e?i:this.index]||t([])},getPages:function(){return this.pages},_getEventData:function(){return{page:this.getPage(),prevPage:this.getPage(this.prevIndex),elements:this.elements}},_getCreateEventData:function(){return this._getEventData()},_updateUi:function(){this._updateActiveItems(),this.options.pagination&&this._updatePagination(),this.options.nextPrevActions&&this._updateNextPrevActions()},_updateActiveItems:function(){var t=this.widgetFullName,e=t+"-item-active";this.elements.items.removeClass(e),this.getPage().addClass(e)},_updatePagination:function(){var t=this.widgetFullName,e=t+"-pagination-link-active",i=t+"-pagination-disabled",s=this.elements.pagination.removeClass(i);this.options.disabled&&s.addClass(i),s.children("."+t+"-pagination-link").removeClass(e).eq(this.index).addClass(e)},_updateNextPrevActions:function(){var t=this.elements,e=t.nextAction.add(t.prevAction),i=this.index,s=this.widgetFullName,n=s+"-action-active",o=s+"-action-disabled";e.addClass(n).removeClass(o),this.options.disabled&&e.addClass(o),this.options.loop||(i===this.getNoOfPages()-1&&t.nextAction.removeClass(n),0===i&&t.prevAction.removeClass(n))},_setOption:function(t,e){switch(i._setOption.apply(this,arguments),t){case"orientation":this._setIsHorizontal(),this.refresh();break;case"pagination":e?(this._addPagination(),this._updateUi()):this._removePagination();break;case"nextPrevActions":e?(this._addNextPrevActions(),this._updateUi()):this._removeNextPrevActions();break;case"loop":case"disabled":this._updateUi();break;case"itemsPerTransition":case"whitespace":this.refresh()}},add:function(t){this.elements.runner.append(t),this.refresh()},remove:function(t){this.getNoOfItems()>0&&(this.elements.items.filter(t).remove(),this.refresh())},getIndex:function(){return this.index},getPrevIndex:function(){return this.prevIndex},destroy:function(){var t=this.elements,e=this.widgetFullName,s={};this.element.removeClass(e).removeClass(e+"-horizontal").removeClass(e+"-vertical"),t.mask.removeClass(e+"-mask"),t.runner.removeClass(e+"-runner"),t.items.removeClass(e+"-item"),this.maskAdded&&t.runner.unwrap(),s[this.isHorizontal?"left":"top"]="",s[this.isHorizontal?"width":"height"]="",s.transform="",t.runner.css(s),this._removePagination(),this._removeNextPrevActions(),t.runner.unbind(this.eventNamespace),i.destroy.apply(this,arguments)}})}(jQuery);