(function($) {

    // 从服务端获取address by ajax
    function get_id_address()
    { 
        $.getJSON(get_address_url,
        {
        },
        function(data) {
            if('0' != data) {
                get_latlng(data);
            }
        });
    };
    
    // 从google map获取经纬度
    function get_latlng(data)
    {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': data.address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
                gmap_address = results[0].formatted_address;
                post_id_address(data.pid, lat, lng, gmap_address);
            }
            else {
                lat = '0';
                lng = '0';
                gmap_address = '0';
                post_id_address(data.pid, lat, lng, gmap_address);
            }
        })
    };
    
    // 如果地址成功解析，则返回经纬度给服务器by ajax
    function post_id_address(id, lat, lng, gmap_address)
    {
        $.post_withck(post_address_url,
        {
            "id": id,
            "lat": lat,
            "lng": lng,
            "gmap_address": gmap_address
        },
        function(data) {
        });
    };
    
    get_id_address();
})(jQuery);
