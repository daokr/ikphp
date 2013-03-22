jQuery.extend({
    createUploadIframe: function(id, uri)
    {
      var frameId = 'jUploadFrame' + id, src = "";
      if(window.ActiveXObject) {
        if(typeof uri== 'boolean'){
            src = 'javascript:false';
        }   
        else if(typeof uri== 'string'){
            src = uri; 
        }   
      }   
      return $('<iframe src="' + src + '" id="' + frameId + '" name="' + frameId + '" style="position:absolute;top:-1000em;left:-1000em;"></iframe>').appendTo('body');               }, 
    createUploadForm: function(id, fileElementId,extra)
    {
        var formId = 'jUploadForm' + id;
        var fileId = 'jUploadFile' + id;
        var form = $('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');	
        var oldElement = $('#' + fileElementId);
        var newElement = $(oldElement).clone();
        $(oldElement).attr('id', fileId);
        $(oldElement).before(newElement);
        $(oldElement).appendTo(form);
        if(extra != 'undefined'){
            for (var fieldName in extra){
                if (extra.hasOwnProperty(fieldName)) {
                    $('<input />')
                        .attr({
                            type: "hidden",
                            name: fieldName,
                            value: extra[fieldName]
                        })
                        .appendTo(form);
                }
            }
        }
        $(form).css('position', 'absolute').css('top', '-1200px').css('left', '-1200px');
        $(form).appendTo('body');	
        return form;
    },

    ajaxFileUpload: function(s) {
        s = jQuery.extend({}, jQuery.ajaxSettings, s);
        var ename = $('#'+s.fileElementId)[0].value.split('.');
        ename = ename[ename.length-1].toLowerCase();
        if(! new RegExp(s.allowType).test(ename)){
            if(s.begin){
                s.begin(12);
            }else{
                s.error(null,'error',12);
            }
            return false;
        }
        var id = new Date().getTime();
        var form = jQuery.createUploadForm(id, s.fileElementId,s.extra);
        var io = jQuery.createUploadIframe(id, s.secureuri);
        var frameId = 'jUploadFrame' + id;
        var formId = 'jUploadForm' + id;		
        if ( s.global && ! jQuery.active++ )
        {
            jQuery.event.trigger( "ajaxStart" );
        }
        if (s.begin) {
            s.begin('');
        }
        var requestDone = false;
        var xml = {};
        if ( s.global ) {
            jQuery.event.trigger("ajaxSend", [xml, s]);
        }
        var uploadCallback = function(isTimeout) {			

            var io = document.getElementById(frameId);
            if(io.contentWindow)
            {
                xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
                xml.responsePar = paras(io.contentWindow.location.href);
            }else if(io.contentDocument) {
                xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
                xml.responsePar = paras(io.contentDocument.location.href);
            }						

            if ( xml || isTimeout == "timeout")
			{				
                requestDone = true;
                var status;
                    status = isTimeout != "timeout" ? "success" : "error";
                    if ( status != "error" ) {
                        var data = jQuery.uploadHttpData( xml, s.dataType );
                        if ( s.success )
                            s.success( data, status );
                        if( s.global )
                            jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                    } else{
                        jQuery.handleError(s, xml, status, 'timeout');
                        $(io).remove();
                        $(form).remove();
                    }

                if( s.global )
                    jQuery.event.trigger( "ajaxComplete", [xml, s] );

                if ( s.global && ! --jQuery.active )
                    jQuery.event.trigger( "ajaxStop" );

                if ( s.complete )
                    s.complete(xml, status);

                jQuery(io).unbind();

                setTimeout(function() {
                    if($(io) != []) {
                        $(io).remove();
                    }
                    if($(form) != []) {
                        $(form).remove();
                    }
			    }, 200);
                xml = null;
            }
        };

        if ( s.timeout > 0 )
		{
            var timeoutHandler = setTimeout(function(){
                if( !requestDone ) uploadCallback( "timeout" );
            }, s.timeout);
        }
        try {
            var io = $('#' + frameId);
            var form = $('#' + formId);
            $(form).attr('action', s.url);
            $(form).attr('method', 'POST');
            $(form).attr('target', frameId);
            if(form.encoding)
            {
                form.encoding = 'multipart/form-data';				
            }
            else
            {				
                form.enctype = 'multipart/form-data';
            }			
            $(form).submit();

        } catch(e)
		{			
            jQuery.handleError(s, xml, null, e);
        }
        if(window.attachEvent){
            document.getElementById(frameId).attachEvent('onload', uploadCallback);
        }
        else{
            document.getElementById(frameId).addEventListener('load', uploadCallback, false);
        }
        return {abort: function (){
            try{
                $(io).remove();$(form).remove();
                clearTimeout(timeoutHandler);
            }catch(e){}
        }};

    },

    uploadHttpData: function( r, type ) { 
        var data = !type;
        data = type == "xml" || data ? r.responseXML : r.responseText;
        if ( type == "script" ) {
            jQuery.globalEval( data );
        }
        if ( type == "json" ) {
            eval( "data = " + data );
        }
        if ( type == "html" ) {
            jQuery("<div>").html(data).evalScripts();
        }
        if ( type == 'redir') {
            data = r.responsePar;
        }
        return data;
    }
});


