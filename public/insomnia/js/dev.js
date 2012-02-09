$(document).ready(function()
{
    $("a#toggle").click(
        function ()
        {
          $.each(
            $('span.namespace'),
            function( key, value )
              {
                  if ( $(this).css( 'display' ) == 'none' )
                  {
                      $(this).val( 'Concise' );
                      $(this).css( 'display', 'inline' );
                  }

                  else
                  {
                      $(this).val( 'Verbose' );
                      $(this).css( 'display', 'none' );
                  }
              }
         )

          if ( $(this).html() == 'Concise' )
          {
              $(this).html( 'Verbose' );
          }

          else
          {
             $(this).html( 'Concise' );
          }

        return false;
       }
    );


    $("a.codetoggle").click(
        function ()
        {
          if ( $(this).html() == 'Hide' )
          {
              $(this).html( 'Source' );
              $('div#codeView').hide();
          }

          else
          {
             $(this).html( 'Hide' );
             $('div#codeView').show();
          }
        }
    );
});