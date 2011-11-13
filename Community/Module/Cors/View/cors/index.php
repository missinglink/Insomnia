<?php $request = \Insomnia\Registry::get( 'request' ); ?>

<? $this->javascript( '/insomnia/js/jquery-1.4.3.min.js' ); ?>
<? $this->javascript( '/insomnia/js/stringify.js' ); ?>
<? $this->javascript( '/insomnia/js/jquery.cors.js' ); ?>

<script type="text/javascript">

    $(document).ready(function() {

        $.postCORS(
            '/ping',
            '{"test":"test"}',
            function( data, textStatus, xhr )
            {
                $('#test').text( xhr.responseText );
            },
            'json'
        );

        $.ajax({
            type: 'GET',
            url:  '/ping',
            //data: '{"test":"test"}',
            beforeSend: function(xhr){
                xhr.setRequestHeader( 'Accept', 'application/json' );
                //xhr.setRequestHeader( 'Content-Type', 'application/json' );
            },
            dataType: 'jsonp',
            jsonp: '_jsonp',
            success: function( data, textStatus, xhr ){ $('#test').text( stringify( data ) ); },
            error: function( xhr, textStatus, errorThrown ){ $('#test').text( xhr.responseText ); }
            //processData: false
        });

    });
    
</script>

<code id="test">
    Test
</code>
