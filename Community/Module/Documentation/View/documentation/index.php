<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Documentation</h1>
            <h4>Documentation Index</h4>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php if( isset( $this[ 'directory' ][ 'routes' ] ) ): ?>
            <div class="posh" style="float:left; margin-right:20px;">
                <h4 style="text-align:center;"><a href="<?php echo $this[ 'directory' ][ 'routes' ]; ?>"><img src="/insomnia/icon/routes2.png" style="margin-bottom:20px;" /><br />Routes</a></h4>
           </div>
        <?php endif; ?>
        <?php if( isset( $this[ 'directory' ][ 'modules' ] ) ): ?>
            <div class="posh" style="float:left; margin-right:20px;">
                <h4 style="text-align:center;"><a href="<?php echo $this[ 'directory' ][ 'modules' ]; ?>"><img src="/insomnia/icon/modules2.png" style="margin-bottom:20px;" /><br />Modules</a></h4>
            </div>
        <?php endif; ?>
    </div>
</div>