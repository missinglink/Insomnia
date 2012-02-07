<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Ping</h1>
            <h4>Echo Request</h4>
        </div>
    </div>
    <div class="insomnia-documentation posh" style="margin-bottom:10px;">
        <pre style="margin:0;"><?php
                foreach( $this['meta'] as $key => $value )
                {
                    echo '<span class="header-key" style="font-size: 14px;">' . $key . '</span>: ' . $value . '<br />';
                }
        ?></pre>
        </div>
        <div class="insomnia-documentation posh">
        <pre style="margin:0;"><?= trim( print_r( $this['body'], true ) ); ?></pre>
    </div>
</div>