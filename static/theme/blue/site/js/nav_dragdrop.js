$(function(){

    var nav = $('.nav-items').disableSelection(),
    more = $('#room-more ul:first'),
    maxWidth = 650,
    refreshTabs = function(){
      var total = 0, item, citem, ul;
      item = more.find('li:first');
      citem = item.clone().css('visibility', 'hidden');
      ul = nav.find('ul:first').append(citem);
      nav.find('ul:first>li:not(.opt)').each(function(i,e){
        total += e.offsetWidth;
      });
      citem.remove();
      if (total < maxWidth) {
        item.insertBefore(more.parent());
      }
    },

    refreshConfig = function(){
      $('li:not(.opt)', nav).draggable('option', 'cursorAt', false);
      $('#room-more ul li').each(function(i, e){
        $(e).draggable('option', 'cursorAt', {right: Math.floor($(e).text().replace(/\s/g,'').length * 12 / 2)});
      });
    },

    saveTabs = function(){
	  var roomID = [], hideRoomID = [], 
	  	  api = siteUrl+'index.php?app=site&a=admins&ik=layout&siteid={ID}',
		  siteId; 

	 	siteId =  globalsiteid; //全局小站id 只针对room 使用

      //siteId = typeof mine_page_url === 'undefined' ? self.location.href.match(/\/([^/]+)\/room/)[1] : mine_page_url.match(/site\/([^/]+)/)[1];
	  
      nav.find('ul:first>li:not(.opt)>a').each(function(i, e){
          roomID.push(e.getAttribute('roomid'));
      });
	  	 //console.log(roomID.slice(0, roomID.length-1));
		 //console.log(api.replace('{ID}', siteId))
	
	 //更多房间
     /** more.find('li>a').each(function(i, e){
          hideRoomID.push(e.getAttribute('href').match(/room\/(\d+|[^/]+)/)[1]);
      });
	 **/
      $.post(api.replace('{ID}', siteId), 
      {
          //tabs: roomID.slice(0, roomID.length-1).join(',') + ',' + hideRoomID.join(','),
		  tabs: roomID.slice(0, roomID.length-1).join(','),
          ck: get_cookie('ck')
      });
	  
    };

    $('li:not(.opt)', nav).draggable({
      helper: 'clone',
      axis: 'x',
      opacity: 0.8,
      appendTo: '.nav-items ul:first',
      refreshPositions: true,
      start: function(e, ui){
        var that = $(this), x = e.clientX;
        that.css({'opacity': 0, 'whiteSpace': 'nowrap'});
        if (more.length > 0 && $.contains(more[0], this)) {
          that.draggable('option', 'axis', false);
        }
        ui.helper.css({'zIndex': 999, 'border': 'none', 'whiteSpace': 'nowrap'});
      },
      stop: function(){
        $(this).css({opacity: 1, width: 'auto'}).draggable('option', 'axis', 'x');
        saveTabs();
        refreshConfig();
      }
      })
    .droppable({
      over: function(e, ui){
        //ui.draggable.insertBefore(this);
        var li = $('#nav-items-mark'),
        duration = 200,
        w = ui.helper.width();

        if (li.length === 0) {
          li = $('<li id="nav-items-mark" style="width:0;overflow:hidden;visibility:hidden;">'); 
        }

        li.stop().css('width', 0).show();
        ui.draggable.css('opacity', 0).stop();

        if (more.length > 0 && $.contains(more[0], ui.draggable[0])) {
          li.hide();
          ui.draggable.insertBefore(this);
          return;
        }

        ui.draggable.animate({width: 0}, duration);
        if (ui.draggable.offset().left < $(this).offset().left) {
          // back
          li.insertAfter(this).animate({width: w}, duration, function(){
            ui.draggable.css('width', 'auto').insertBefore(this);
            this.style.display = 'none';
          });
        } else {
        // forward
          li.insertBefore(this).animate({width: w}, duration, function(){
            ui.draggable.css('width', 'auto').insertBefore(this);
            this.style.display = 'none';
          });
        }

      },
      /*
      out: function(e, ui){
        ui.draggable.insertAfter(this);
      },
      */
      drop: function(e, ui){
        var total = 0, lastItem;
        nav.find('ul:first>li:not(.opt)').each(function(i,e){
          total += e.offsetWidth;
        });
        if (total > maxWidth) {
          lastItem = more.parent().prev();
          if (lastItem.hasClass('on')) {
              lastItem = lastItem.prev();
          }
          lastItem.insertBefore(more.find('li:first'));
        }
      }
    });

    $('#room-more').droppable({
      tolerance: 'touch',
      over: function(e, ui){
        $(this).css('opacity', 0.8);
      },
      out: function(){
        $(this).css('opacity', 1);
      },
      drop: function(e, ui){
        var dragItem = ui.draggable, 
        that = $(this);

        that.css('opacity', 1);
        if (dragItem.hasClass('on') || ui.helper.offset().left < $(this).offset().left) {
          return;
        }
        that.find('ul:first').append(dragItem);
        refreshTabs();
      }
    });

    $('#room-admin li').draggable('option', 'disabled', true);
    refreshConfig();


}); 
