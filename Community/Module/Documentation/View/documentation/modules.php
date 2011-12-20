<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">List of loaded modules</h1>
            <h4>Webservice documentation</h4>
            <p>Current: <?= date( 'r' ); ?></p>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php foreach( $this as $moduleName => $module ): ?>
            <?php if( true || is_array( $module ) && !empty( $module ) ): ?>
                <div class="insomnia-documentation-block posh">
                    <h4><?= $moduleName; ?></h4>
                    <ul style="padding-bottom:0;">
                        <?php foreach( $module as $pluginType => $plugin ): ?>
                            <li><?= $pluginType; ?><ul>
                            <?php foreach( $plugin as $pluginClass ): ?>
                                <li><?= $pluginClass; ?></li>
                            <?php endforeach; ?>
                            </ul></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
     </div>
</div>