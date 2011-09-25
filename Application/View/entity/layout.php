<?php $this->addStylesheet( '/css/styles.css' ); ?>
<html>
    <head>
        <title><?= $this->getTitle(); ?></title><?php
            $this->printStylesheetsAsHtml();
            $this->printScriptsAsHtml();
        ?><style type="text/css">body{background-color:none;background-image:url(http://peter.john.so/n/bg.jpg);background-repeat:repeat-x;}@font-face{font-family:Delius;font-style:normal;font-weight:400;src:local(Delius-Regular), url(http://themes.googleusercontent.com/static/fonts/delius/v1/7WQiMJKp1Jo3CiUw302zGA.woff) format(woff);}@font-face{font-family:Montez;font-style:normal;font-weight:400;src:local(Montez), local(Montez-Regular), url(http://themes.googleusercontent.com/static/fonts/montez/v1/Zfcl-OLECD6-4EcdWMp-Tw.woff) format(woff);}@font-face{font-family:'Yanone Kaffeesatz';font-style:normal;font-weight:400;src:local('Yanone Kaffeesatz Regular'), local(YanoneKaffeesatz-Regular), url(http://themes.googleusercontent.com/static/fonts/yanonekaffeesatz/v1/YDAoLskQQ5MOAgvHUQCcLRTHiN2BPBirwIkMLKUspj4.woff) format(woff);}@font-face{font-family:Nobile;font-style:normal;font-weight:400;src:local(Nobile), url(http://themes.googleusercontent.com/static/fonts/nobile/v1/LJdSuYk02E6wtyvk5bnaeA.woff) format(woff);}@font-face{font-family:Molengo;font-style:normal;font-weight:400;src:local(Molengo), url(http://themes.googleusercontent.com/static/fonts/molengo/v1/z1JWuCBrQt_Ta83eqIo6Dg.woff) format(woff);}@font-face{font-family:'Josefin Sans';font-style:normal;font-weight:400;src:local('Josefin Sans'), local(JosefinSans), url(http://themes.googleusercontent.com/static/fonts/josefinsans/v1/xgzbb53t8j-Mo-vYa23n5nhCUOGz7vYGh680lGh-uXM.woff) format(woff);}</style>
    </head>
    <body>
        <?php echo $this->getView()->getOutput(); ?>
        <script type="text/javascript">var _gaq=_gaq||[];_gaq.push(["_setAccount","UA-21161437-2"]);_gaq.push(["_setDomainName",".htmlentities.org"]);_gaq.push(["_trackPageview"]);(function(){var a=document.createElement("script");a.type="text/javascript";a.async=true;a.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})()</script>
    </body>
</html>