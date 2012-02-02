<?php $request = \Insomnia\Registry::get( 'request' ); ?>

<? $this->addScript( 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' ); ?>
<? $this->addScript( '/insomnia/js/stringify.js' ); ?>
<? $this->addScript( '/insomnia/prettify/prettify.js' ); ?>
<? $this->addStylesheet( '/insomnia/prettify/prettify.css' ); ?>

<?
    $requestFormats = array(
        'key/value'    => 'application/x-www-form-urlencoded',
        'json'          => 'application/json'
    );
?>

<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Client</h1>
            <h4>REST Client</h4>
        </div>
    </div>
    <div class="insomnia-documentation">
        <div>
            <form id="nav" action="" method="GET">
                <div>
                   <select id="method" name="method">
                        <? foreach( array( 'GET', 'POST', 'PUT', 'DELETE' ) as $method ): ?>
                        <option<? if( $request->getMethod() === $method ) echo ' selected="selected"' ;?>><?= $method; ?></option>
                        <? endforeach; ?>
                    </select>
                    <input id="request-uri" name="request-uri" value='<?= $request->getParam( 'path' ) === '/client' ? '/ping' : \str_replace( '/client', '', $request->getParam( 'path' ) ); ?>' />
                    <select id="content-type" name="content-type">
                        <? foreach( array( 'application/json', 'application/xml', 'text/yaml', 'text/ini', 'text/html', 'text/plain' ) as $contentType ): ?>
                        <option><?= $contentType; ?></option>
                        <? endforeach; ?>
                    </select>
                    <div style="height:10px;">&nbsp;</div>
                    <select id="request-content-type" name="request-content-type">
                        <? foreach( $requestFormats as $label => $contentType ): ?>
                        <option value="<?= $contentType; ?>"><?= $label; ?></option>
                        <? endforeach; ?>
                    </select>
                    <input id="request-body" name="request-body" value='name=John+Smith' />
                    <input type="submit" style="padding-left: 20px; padding-right:20px; margin-left:50px;" value="Submit" />
                </div>
            </form>
        </div>
        <script type="text/javascript">

            $(document).ready(function() {

                $('#nav #method').change( function(){ $('#nav').submit(); } );
                $('#nav #request-body').change( function(){ $('#nav').submit(); } );
                $('#nav #request-uri').change( function(){ $('#nav').submit(); } );
                $('#nav #content-type').change( function(){ $('#nav').submit(); } );
                $('#nav #request-content-type').change( function(){ $('#nav').submit(); } );

                function getResponse( xhr )
                {
                    $('#response-headers')
                        .html( '<strong>HTTP/1.1 ' + xhr.status + ' ' + xhr.statusText + '</strong>' + '\n' + xhr.getAllResponseHeaders().replace( /(.*:)/gi, '<span class="header-key">$1</span>' ) )
                        .fadeIn( 200 );

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
                        url:  $('#nav #request-uri').val(),
                        data: $('#nav #request-body').val(),
                        beforeSend: function(xhr){
                            $('#response-headers').empty();
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
        
        <br />
    
        <div class="posh">
            <pre id="response-headers" style="font-size:14px; float:left;"></pre>
            <hr />
            <pre id="response" style="font-size:14px;"></pre>
        </div>
    </div>
    <div class="footer">
        <a href="/client">Client</a>
        <a href="/doc">Documentation</a>
    </div>
</div>