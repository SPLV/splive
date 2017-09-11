<html>
<head>
    <meta charset="utf-8">
    <title>Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
          crossorigin="anonymous">

    <link rel="stylesheet" href="style.css" crossorigin="anonymous">
    <link rel="stylesheet" href="media.css" crossorigin="anonymous">
    <link rel="stylesheet" href="colors.css" crossorigin="anonymous">



<script>
    <!-- Yandex.Metrika counter --><script type="text/javascript" >    (function (d, w, c) {        (w[c] = w[c] || []).push(function() {            try {                w.yaCounter45490791 = new Ya.Metrika({                    id:45490791,                    clickmap:true,                    trackLinks:true,                    accurateTrackBounce:true,                    webvisor:true,                    trackHash:true,                    ecommerce:"dataLayer"                });            } catch(e) { }        });        var n = d.getElementsByTagName("script")[0],            s = d.createElement("script"),            f = function () { n.parentNode.insertBefore(s, n); };        s.type = "text/javascript";        s.async = true;        s.src = "<a href="https://mc.yandex.ru/metrika/watch.js">https://mc.yandex.ru/metrika/watch.js</a>";        if (w.opera == "[object Opera]") {            d.addEventListener("DOMContentLoaded", f, false);        } else { f(); }    })(document, window, "yandex_metrika_callbacks");</script><!-- /Yandex.Metrika counter -->
</script>

</head>

<body ng-app="myApp" class="bgimg-1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="bower_components/angular/angular.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="app.js"></script>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12" ng-controller="mainCtrl">

            <div class="row logo">
                <div class="col-sm-4"><img class="img" src="san-logo.png"></div>
                <div class="col-sm-8">
                    <div class="text-right updatingText" ng-show="loader">
                        <span class="glyphicon glyphicon-refresh spin"></span>
                        Updating
                    </div>
                </div>
            </div>


            <div class="row hd">
                <div class="col-xs-3">
                    <button type="button" class="btn-dj tx-ft">BORSA</button>
                </div>
                <div class="col-xs-3">
                    <button type="button" class="btn-dj tx-ft">USD</button>
                </div>
                <div class="col-xs-3">
                    <button type="button" class="btn-dj tx-ft">TRY</button>
                </div>
                <div class="col-xs-3">
                    <button type="button" class="btn-dj tx-ft">VOLUME</button>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">

                    <div class="row bd cl-bk{{$index + 1}}" ng-repeat="a in allData | orderBy:'sortPrice' ">
                        <div class="col-xs-3">
                            <span class="lg-txt">{{a.exchange}}</span>
                        </div>
                        <div class="col-xs-3">
                            <span class="lg-txt">{{a.pricesUsd}}</span>
                        </div>
                        <div class="col-xs-3">
                            <span class="lg-txt">{{a.priceTry}}</span>
                        </div>
                        <div class="col-xs-3">
                            <span class="lg-txt">{{a.volumeTry}}</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104062051-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45490791 = new Ya.Metrika({ id:45490791, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <!-- /Yandex.Metrika counter -->

<script type="text/javascript">
    window._mfq = window._mfq || [];
    (function() {
        var mf = document.createElement("script");
        mf.type = "text/javascript"; mf.async = true;
        mf.src = "//cdn.mouseflow.com/projects/a8087bde-8799-4206-af97-f7d44948681d.js";
        document.getElementsByTagName("head")[0].appendChild(mf);
    })();
</script>
</body>
</html>