<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error icon" style="background-image: url('/insomnia/icon/android/ic_menu_manage.png');">Modules</h1>
            <h4>A list of modules loaded in the current request</h4>
            <p>Current: <?= date( 'r' ); ?></p>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php foreach( $this as $moduleName => $module ): ?>
            
            <div class="insomnia-documentation-block posh">
                <h4><?= $moduleName; ?></h4>
                <?php if( is_array( $module ) && !empty( $module ) ): ?>
                    <ul style="padding-bottom:0;">
                        <?php foreach( $module as $pluginType => $plugin ): ?>
                            <li><?= $pluginType; ?><ul>
                            <?php foreach( $plugin as $pluginClass ): ?>
                                <li><?= $pluginClass; ?></li>
                            <?php endforeach; ?>
                            </ul></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
        <?php endforeach; ?>
     </div>
</div>