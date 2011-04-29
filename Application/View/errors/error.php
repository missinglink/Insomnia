<h1 class="error"><?= $this['data']['error']; ?></h1>
<h4><?= $this['data']['title']; ?></h4>
<h6><?= $this['data']['body']; ?></h6>

<pre>
<? print_r( $this->data ); ?>
</pre>