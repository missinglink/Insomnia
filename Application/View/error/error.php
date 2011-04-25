<h1 class="error"><?= $this['title']; ?></h1>
<h4><?= $this['message']; ?></h4>
<h6><?= $this['class']; ?></h6>

<? if( isset( $this['trace'] ) ): ?>
<pre><?= print_r( $this['trace'], true ); ?></pre>
<? endif; ?>