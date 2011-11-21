<style type="text/css">
       span.header-key
       {
           color:#008;
       }
</style>

<div style="margin:50px;">
    <hr />
    <pre><?php
            foreach( $this['meta'] as $key => $value )
            {
                echo '<span class="header-key">' . $key . '</span>: ' . $value . '<br />';
            }
    ?></pre>
    <hr />
    <pre><? print_r( $this['body'] ); ?></pre>
</div>