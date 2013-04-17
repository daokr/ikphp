/**
 * Author: gaocheng@douban.com
 *
 */

~function(factory){
    if (window.define === undefined) {
        factory(jQuery);
    } else {
        define('imap', ['jquery', 'google_map'], factory);
    }
}(function($){

    var dui = window.dui || {};

    dui.log = function(obj) {
        if (typeof(console) != 'undefined' && typeof(console.log) == 'function') {
            console.log(obj);
        }
    };

    dui.iMap = (function() {
        // 地图的默认设置
        var mapDefault = {
            width: 500,      // 地图宽
            height: 400,     // 地图高
            lat: 39.92,      // 中心纬度
            lng: 116.46,     // 中心经度
            zoom: 8,         // 缩放级别
            type: 'ROADMAP', // 地图类型 ROADMAP SATELLITE HYBRID TERRAIN
            callback: ''     // 地图创建之后的回调函数
        },
        // 地标的默认设置
        markerDefault = {
            lat: mapDefault.lat,
            lng: mapDefault.lng,
            latLng: function(){ return new google.maps.LatLng(mapDefault.lat, mapDefault.lng) }(),
            draggable: false,
            handleDragStart: function() {},  // 地标的拖拽开始后事件
            handleDragEnd: function() {},  // 地标的拖拽结束后事件
            handleDrag: function() {},  // 地标的拖拽事件
            clickable: false,
            handleClick: function() {}, // 地标的点击事件
            visible: true
        },
        // 地图的默认控制元件
        controlDefault = {
            disableDefaultUI: false,
            panControl: true,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            },
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
            },
            scaleControl: true,
            streetViewControl: false,
            overviewMapControl: false,
            searchControl: false,
            searchCallback: ''
        },
        // 地图默认中心
        centerDefault = {
            lat: mapDefault.lat,
            lng: mapDefault.lng,
            latLng: function(){ return new google.maps.LatLng(mapDefault.lat, mapDefault.lng) }()
        },
        defaults = $.extend(mapDefault, controlDefault),
        markers = [],
        infowindows = [];

        // 设置地图中心
        function _setCenter(map, options) {
            var opt = $.extend(centerDefault, options || {});

            map.setCenter(opt.latLng);
        }

        // 判断是否是函数
        // from John Resig
        function _isFunction(fn) {
            return !! fn && ! fn.nodeName && fn.constructor != String && fn.constructor != RegExp && fn.constructor != Array && /function/i.test(fn + "");
        }

        /**
         * 创建地图
         * @$ele 用来包裹地图的 jQuery 对象
         * @options 地图的参数
         */
        function _createMap($ele, options) {
            var opt = $.extend(defaults, options || {});

            $ele.css({
                'width': opt.width,
                'height': opt.height
            });

            opt.mapTypeId = google.maps.MapTypeId[opt.type];

            var map = new google.maps.Map($ele.get(0), opt),
                latlng = new google.maps.LatLng(opt.lat, opt.lng);

            map.setCenter(latlng);

            if(_isFunction(opt.callback)){
                opt.callback(map);
            }

            // 显示搜索控件
            if (opt.searchControl) {
                _customControlSearch(map, opt.searchControlOptions, opt.searchCallback);
            }

            return map;
        }

        /**
         * 创建 Marker
         */
        function _createMarker(map, options) {
            var opt = $.extend(markerDefault, options || {});
            var markerOptions = {
                    position: opt.latLng,
                    map: map,
                    draggable: opt.draggable,
                    cilckable: opt.clickable
            };
            if (options.icon) {
               markerOptions.icon = new google.maps.MarkerImage(options.icon.url,
                  new google.maps.Size(options.icon.size[0], options.icon.size[1]),
                  new google.maps.Point(0,0),
                  new google.maps.Point(options.icon.size[0]/3, options.icon.size[1]));
            }
            var marker = new google.maps.Marker(markerOptions);

            // 如果可拖拽，且有拖拽事件
            if (opt.draggable && opt.handleDrag && _isFunction(opt.handleDrag)) {
                google.maps.event.addListener(marker, 'drag', opt.handleDrag);
            }
            if (opt.draggable && opt.handleDragStart && _isFunction(opt.handleDragStart)) {
                google.maps.event.addListener(marker, 'dragstart', opt.handleDragStart);
            }
            if (opt.draggable && opt.handleDragEnd && _isFunction(opt.handleDragEnd)) {
                google.maps.event.addListener(marker, 'dragend', opt.handleDragEnd);
            }

            // 如果可点击，且有点击事件
            if (opt.clickable && opt.handleClick && _isFunction(opt.handleClick)) {
                google.maps.event.addListener(marker, 'click', opt.handleClick);
            }

            markers.push(marker);

            return marker;
        }

        /**
         * 删除 overlay
         * @overlay 是一个包含marker/infowindow的数组
         */
        function _removeOverlay(overlay){
            for(var i=0; i<overlay.length; i++){
                overlay[i].setMap(null);
            }
        }

        /**
         * 事件绑定
         * @ele 可以是 map 对象，也可以是 marker 对象
         * @events
         */
        function _bind(ele, events, handle) {
            switch (events) {
                case 'click':
                    google.maps.event.addListener(ele, 'click', handle);
                    break;
                case 'zoom':
                    google.maps.event.addListener(ele, 'zoom_changed', handle);
                    break;
                case 'drag':
                    google.maps.event.addListener(ele, 'drag', handle);
                    break;
                case 'dragstart':
                    google.maps.event.addListener(ele, 'dragstart', handle);
                    break;
                case 'dragend':
                    google.maps.event.addListener(ele, 'dragend', handle);
                    break;
                default:
                    // code
            }
        }

        /**
         * 自定义搜索控件
         *
         */
        function _customControlSearch(map, options, callback) {
            var $search = $('<div id="search-control"></div>'),
                $searchUI = $('<div id="search-control-ui"></div>'),
                $txt = $('<input type="text" name="search-txt" id="search-txt" />'),
                $btn = $('<input type="button" id="btn-search" value="' + (options.text || '搜索') + '" />');

            $searchUI.append($txt).append($btn);
            $search.append($searchUI);

            if (options.targetNode) {
              // 参加到指定位置
              options.targetNode.empty().append($search);
            } else {
              map.controls[google.maps.ControlPosition.TOP_LEFT].push($search.get(0));
            }
            google.maps.event.addDomListener($btn.get(0), 'click', function() {
                _search({ 
                   map: map, 
                   address: $txt.val(), 
                   city: options.city || '',
                   district: options.district || '', 
                   success: options.callback_search
                });
            });

            // 回车搜索
            $txt.bind('keydown', function(e){
                if(e.keyCode == '13'){
                  _search({ 
                     map: map, 
                     address: $txt.val(), 
                     city: options.city || '',
                     district: options.district || '', 
                     success: options.callback_search
                  });
                }
            });


            // 地址提示
            $txt.autocomplete({
                source: function(request, response) {
                    var geocoder = new google.maps.Geocoder();
                    // 限制在某个城市查找
                    var term = (options.city || '') + ' ' + (options.district || '') + ' ' + request.term;

                    geocoder.geocode( {'address': term }, function(results, status) {
                        response($.map(results, function(item) {
                            return {
                                label:  item.formatted_address,
                                value: item.formatted_address,
                                latitude: item.geometry.location.lat(),
                                longitude: item.geometry.location.lng()
                            }
                        }));
                    })
                },
                select: function(event, ui) {
                    if (options.callback_search) {
                       var loc = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                       options.callback_search(map, 
                       {
                          geometry: {
                            location: loc
                          }
                       });
                       return;
                    }
                    if(markers.length){
                        $.each(markers, function(i, v){
                            v.setMap(null);
                        });
                    }

                    var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude),
                        marker = _createMarker(map, {latLng: location});

                    _setCenter(map, {latLng: location});
                    map.setZoom(15);
                }
            });

            options.callback_inited && options.callback_inited();
        }

        /**
         * 搜索
         *
         */
        function _search(options) {
            var defaults = {
                    ele: '',     // 包裹地图的容易，用来存储标记的地标的经纬度
                    map: '',
                    address: '',
                    zoom: 15,
                    success: '', // 搜索成功后的回调函数
                    fail: ''     // 搜索失败后的回调函数
                },
                opts = $.extend(defaults, options || {});

            // 清除之前地图上存在的 marker infowindow
            if(markers && markers.length && !opts.success){
                _removeOverlay(markers);
            }
            if(infowindows && infowindows.length && !opts.success){
                _removeOverlay(infowindows);
            }

            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                    address: (opts.city || '') + (opts.district || '') + opts.address
                },
                function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        opts.map.setZoom(opts.zoom);
                        if(_isFunction(opts.success)){
                            opts.success(opts.map, results[0]);
                        }else{
                            var latLng = results[0].geometry.location,
                                marker = _createMarker(opts.map, {draggable: false, latLng: latLng}),
                                content = '<div class="info-window"><div class="info-win-hd">' + results[0].formatted_address + '</div><div class="info-win-bd"><a target="_blank" href="http://ditu.google.cn/maps?hl=zh-CN&ie=UTF8&dirflg=r&f=d&daddr=' + results[0].formatted_address + '">驾车/公交路线</a></div></div>',
                                infowindow = dui.iMap.infowindow(opts.map, marker, {content: content});

                            _setCenter(opts.map, {latLng: latLng});
                            infowindow.open(opts.map, marker);
                        }

                        $(opts.ele).data('latLng', results[0].geometry.location);
                    } else {
                        // 查找不到的处理
                        if(_isFunction(opts.fail)){
                            opts.fail(opts.map);
//                        }else{
//                            alert("难道你是火星人吗，在地球上没找到你要找的地方。");
                        }
                    }
            });
        }

        /**
         * info window
         */
        function _infowindow(map, marker, options){
            var defaults = {
                    content: '',
                    maxWidth: 200,
                    maxHeight: 100,
                    autoScroll: true
                },
                opts = $.extend(defaults, options || {}),
                infowindow = new google.maps.InfoWindow({content: opts.content, maxWidth: opts.maxWidth, maxHeight: opts.maxHeight, autoScroll: opts.autoScroll});

            infowindows.push(infowindow);
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });

            return infowindow;
        }

        /**
         * Reverse Geocoding
         * 根据经纬度返回详细地址
         */
        function _addressLookup(options){
            var defaults = {
                    latLng: '',
                    callback: function(){}
                },
                opts = $.extend(defaults, options || {}),
                coder = new google.maps.Geocoder();

            coder.geocode({ 'latLng': opts.latLng }, function(results, status){
                if(status === google.maps.GeocoderStatus.OK && _isFunction(opts.callback)){
                    opts.callback(results[0]);
                }
            });
        }

        /**
         * static map
         * @return 静态地图的 jQuery img 对象
         */
        function _static(options){
            var defaults = {
                    center: 'beijing', // 中心
                    size: '400x300',   // 尺寸
                    zoom: '16',        // 缩放级别
                    maptype: 'roadmap' // 地图类型
                },
                opts = $.extend(defaults, options || {}),
                url = 'http://maps.google.cn/maps/api/staticmap?center=' + opts.center + '&size=' + opts.size + '&zoom=' + opts.zoom + '&markers=' + opts.center + '&maptype=' + opts.maptype +'&sensor=false',
                $img = $('<img src="' + url + '" alt="google static map" />');

            return $img;
        }

        return {
            createMap: function($element, options) {
                return _createMap($element, options);
            },
            setCenter: function(map, options) {
                _setCenter(map, options);
            },
            createMarker: function(map, options) {
                return _createMarker(map, options);
            },
            removeOverlay: function(overlay) {
                _removeOverlay(overlay);
            },
            bind: function(map, events, handle) {
                _bind(map, events, handle);
            },
            search: function(options) {
                return _search(options);
            },
            infowindow: function(map, marker, options){
                return _infowindow(map, marker, options);
            },
            addressLookup: function(options){
                _addressLookup(options);
            },
            staticMap: function(options){
                return _static(options);
            }
        };
    })();

    window.dui = dui;

});
