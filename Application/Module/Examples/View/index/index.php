<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error icon" style="background-image: url('/insomnia/icon/android/ic_menu_gallery.png');">Examples</h1>
            <h4>Examples Index</h4>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php foreach( $this[ 'examples' ] as $key => $value ): ?>

            <div class="posh" style="float:left; margin-right:20px; min-width:20%;">

                <h4 style="text-align:center; font-weight: normal; display:block; padding:0px;">

                    <?php if( isset( $value['url'] ) ): ?>
                        <a href="<?= $value[ 'url' ]; ?>">
                    <?php endif; ?>

                    <?php if( isset( $value['icon'] ) ): ?>
                        <img src="<?= $value[ 'icon' ]; ?>" style="float:left;" /><br />
                    <?php endif; ?>

                    <?php if( isset( $value['title'] ) ): ?>
                        <?= $value[ 'title' ]; ?>
                    <?php endif; ?>

                    <?php if( isset( $value['url'] ) ): ?>
                        </a>
                    <?php endif; ?>

                </h4>

                <?php if( isset( $value['help-text'] ) ): ?>
                    <br />
                    <?php if( isset( $value['help-uri'] ) ): ?>
                        <a href="<?= $value[ 'help-uri' ]; ?>" style="text-align:center; display: block;">
                    <?php endif; ?>
                            
                    <?= $value[ 'help-text' ]; ?>

                    <?php if( isset( $value['help-uri'] ) ): ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

           </div>

        <?php endforeach; ?>
    </div>
</div>