<?php $request = \Insomnia\Registry::get( 'request' ); ?>

<? $this->javascript( '/js/jquery-1.4.3.min.js' ); ?>
<? $this->javascript( '/prettify/prettify.js' ); ?>
<? $this->css( '/prettify/prettify.css' ); ?>

<?
    $requestFormats = array(
        'key/value'    => 'application/x-www-form-urlencoded',
        'json'          => 'application/json'
    );
?>

<form id="nav" action="" method="GET">
    <table>
        <tr>
            <td width="100">
                <label for="request-content-type">Request</label>
            </td>
            <td>
                <input id="request-body" name="request-body" value='name=John Smith' style="width: 300px;" />
                <select id="request-content-type" name="request-content-type">
                    <? foreach( $requestFormats as $label => $contentType ): ?>
                    <option value="<?= $contentType; ?>"><?= $label; ?></option>
                    <? endforeach; ?>
                </select>
                <select id="method" name="method">
                    <? foreach( array( 'GET', 'POST', 'PUT', 'DELETE' ) as $method ): ?>
                    <option<? if( $request->getMethod() === $method ) echo ' selected="selected"' ;?>><?= $method; ?></option>
                    <? endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="content-type">Response</label>
            </td>
            <td>
                <select id="content-type" name="content-type">
                    <? foreach( array( 'application/json', 'application/xml', 'text/yaml', 'text/ini', 'text/html', 'text/plain' ) as $contentType ): ?>
                    <option><?= $contentType; ?></option>
                    <? endforeach; ?>
                </select>
                <input type="submit" value="Submit" style="display:none;" />
            </td>
        </tr>
    </table>

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

        $('#nav #method').change( function(){ $('#nav').submit(); } );
        $('#nav #request-body').change( function(){ $('#nav').submit(); } );
        $('#nav #content-type').change( function(){ $('#nav').submit(); } );
        $('#nav #request-content-type').change( function(){ $('#nav').submit(); } );

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
                url:  '<?= $request->getParam( 'path' ) === '/client' ? '/ping' : \str_replace( '/client', '', $request->getParam( 'path' ) ); ?>',
                data: $('#nav #request-body').val(),
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'Accept', $('#nav #content-type').val() );
                    xhr.setRequestHeader( 'Content-Type', $('#nav #request-content-type').val() );
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
