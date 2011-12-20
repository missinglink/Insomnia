<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Ping</h1>
            <h4>&nbsp;</h4>
            <p>&nbsp;</p>
        </div>
    </div>
    <div class="insomnia-documentation">
        <pre><?php
                foreach( $this['meta'] as $key => $value )
                {
                    echo '<span class="header-key">' . $key . '</span>: ' . $value . '<br />';
                }
        ?></pre>
        <hr />
        <pre><? print_r( $this['body'] ); ?></pre>
    </div>
</div>