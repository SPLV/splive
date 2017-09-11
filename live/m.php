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

    <style>
        .logo img {
            width : 100%;
        }
    </style>

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
                <div class="col-xs-6"><img class="img" src="san-logo.png"></div>
                <div class="col-xs-6">
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

</body>
</html>