
<? $this->javascript( '/js/jquery-1.4.3.min.js' ); ?>
<? $this->javascript( '/prettify/prettify.js' ); ?>
<? $this->css( '/prettify/prettify.css' ); ?>

<form id="nav" action="" method="GET">
    <select id="path" name="path">
        <? foreach( $this['controllers'] as $path ): ?>
        <option><?= $path; ?></option>
        <? endforeach; ?>
    </select>
    <input id="query" name="query" value="" />
    <select id="method" name="method">
        <? foreach( array( 'GET', 'POST', 'PUT', 'DELETE' ) as $method ): ?>
        <option><?= $method; ?></option>
        <? endforeach; ?>
    </select>
    <select id="content-type" name="content-type">
        <? foreach( array( 'application/json', 'application/xml', 'text/yaml', 'text/ini', 'text/html', 'text/plain' ) as $contentType ): ?>
        <option><?= $contentType; ?></option>
        <? endforeach; ?>
    </select>
    <input type="submit" value="Submit" />
</form>

<script type="text/javascript">

    function stringify(object, pad){
        var indent = '   '
        if (!pad) pad = ''
        var out = ''
        if (object instanceof Array){
            out += '[\n'
            for (var i=0; i<object.length; i++){
                out += pad + indent + stringify(object[i], pad + indent) + '\n'
            }
            out += pad + ']'
        }else if (object instanceof Object){
            out += '{\n'
            for (var i in object){
                out += pad + indent + i + ': ' + stringify(object[i], pad + indent) + '\n'
            }
            out += pad + '}'
        }else{
            out += object
        }
        return out
    }

    $(document).ready(function() {

        function getResponse( xhr )
        {
            $('#response-headers').html( 'HTTP/1.1 ' + xhr.status + ' ' + xhr.statusText + '\n' + xhr.getAllResponseHeaders() );

            var contentType = xhr.getResponseHeader( 'Content-Type' );
            if( typeof contentType == 'string' )
            {
                var sp = contentType.split( ';' );
                contentType = sp[ 0 ];
            }

            switch( typeof contentType == 'string' ? contentType : '' )
            {
                case 'application/json' :
                    $('#response').removeClass().addClass( 'prettyprint' ).addClass( 'lang-json' );
                    $('#response').text( stringify( $.parseJSON( xhr.responseText ) ) );
                    break;

                case 'application/xml' :
                    $('#response').removeClass().addClass( 'prettyprint' ).addClass( 'lang-xml' );
                    $('#response').text( xhr.responseText );
                    break;

                case 'application/x-yaml' :
                    $('#response').removeClass().addClass( 'prettyprint' ).addClass( 'lang-yaml' );
                    $('#response').text( xhr.responseText );
                    break;

                case 'text/ini' :
                    $('#response').removeClass().addClass( 'prettyprint' ).addClass( 'lang-ini' );
                    $('#response').text( xhr.responseText );
                    break;

                default :
                    $('#response').removeClass().addClass( 'prettyprint' ).addClass( 'lang-html' );
                    $('#response').text( xhr.responseText );
                    break;
            }
            window.prettyPrint();
        }

        $('#nav').submit(function()
        {
            $.ajax({
                type: $('#nav #method').val(),
                url:  $('#nav #path').val() + $('#nav #query').val(),
                //data: 'moo=cow&foo=bar',
                data: '<?= json_encode( array( 'name' => array( 'john' ), 'location' => 'London' ) ); ?>',
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'Accept', $('#nav #content-type').val() );
                    xhr.setRequestHeader( 'Content-Type', 'application/json' );
                    //xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
                    //xhr.setRequestHeader( 'Content-Type', 'multipart/form-data' );
                },
                success: function( data, textStatus, xhr ){ getResponse( xhr ); },
                error: function( xhr, textStatus, errorThrown ){ getResponse( xhr ); },
                processData: false
            });
           
            return false;
        });

        $('#nav').submit();

    });
    
</script>

<fieldset>
    <legend>Response Headers</legend>
    <pre id="response-headers"></pre>
</fieldset>

<fieldset>
    <legend>Response Body</legend>
    <pre id="response"></pre>
</fieldset>
