<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <!--    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->


    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <?php
    include 'inc/css.php';
    ?>


</head>
<body ng-app="myApp" class="arbitrage">


<?php
include 'inc/js.php';
?>

<div class="container-fluid" ng-controller="arbitrageCtrl">


    <div class="row setings">
        <div class="col-xs-1">
            <div id="loader" ng-show="loader" class="glowtext">
                <span>Loading ...</span>
            </div>
        </div>
        <div class="col-xs-7">

            <div ng-show="algo.isProfit" style="display: inline-block">

                <p style="display: inline-block; font-size: 16px" ng-show="currencySelected == 'USD'">
                    (<span tooltips tooltip-side="bottom" tooltip-template="{{formula.comp.exchange}}"> {{formula.comp.pricesUsd}} </span>
                    -
                    <span tooltips tooltip-side="bottom" tooltip-template="{{formula.seller.exchange}}"> {{formula.seller.pricesUsd}}</span>
                    -
                    <span tooltips tooltip-side="bottom" tooltip-template="Margin"> {{algo.differnce}} </span>) /
                    <span tooltips tooltip-side="bottom" tooltip-template="{{formula.seller.exchange}}"> {{formula.seller.pricesUsd}} </span>
                    *
                    100
                </p>

                <p style="display: inline-block; font-size: 16px" ng-show="currencySelected != 'USD'">
                    (<span tooltips tooltip-side="bottom" tooltip-template="{{formula.comp.exchange}}"> {{formula.comp.priceTry}} </span>
                    -
                    <span tooltips tooltip-side="bottom" tooltip-template="{{formula.seller.exchange}}"> {{formula.seller.priceTry}}</span>
                    -
                    <span tooltips tooltip-side="bottom" tooltip-template="Margin"> {{algo.differnce}} </span>) /
                    <span tooltips tooltip-side="bottom" tooltip-template="{{formula.seller.exchange}}"> {{formula.seller.priceTry}} </span>
                    *
                    100
                </p>

            </div>

            <p style="float: right; display: inline-block" ng-hide="algo.competition == 'NONE'">
                Max Margin : {{formula.bestMargin | number:2}}
            </p>


        </div>
        <div class=" col-xs-4 text-right myinput">

            <form class="form-inline">
                <div class="form-group">
                    <label for="margin">Margin</label>
                    <input type="text" style="width: 40px"
                           ng-model="algo.differnce"
                           class="" valid-number="true" name="margin">
                </div>
                <div class="form-group">
                    <label for="pwd">Seller</label>
                    <select ng-model="algo.seller">
                        <option value="LOWEST">LOWEST</option>
                        <option value="BTCE">BTCE</option>
                        <option value="POLONIEX">POLONIEX</option>
                        <option value="BITSTAMP">BITSTAMP</option>
                        <option value="BITFINEX">BITFINEX</option>
                        <option value="CEXIO">CEXIO</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pwd">Competition</label>
                    <select ng-model="algo.competition">
                        <option value="LOWEST">LOWEST</option>
                        <option value="BTCTURK">BTCTURK</option>
                        <option value="KOINIM">KOINIM</option>
                        <option value="PARIBU">PARIBU</option>
                        <option value="AVERAGE">AVERAGE</option>
                        <option value="NONE">NONE</option>
                    </select>
                </div>


                <button type="submit" ng-click="algo.changeSettings()" class="btn btn-success btn-xs">
                    <span class="glyphicon glyphicon-ok"></span>
                </button>
            </form>

        </div>
    </div>

    <table class="table main">

        <tbody>

        <tr>
            <td rowspan="2" colspan="2" class="logoCont">

                <img class="img" src="san-logo.png">

                <span class="last_update_time" ng-if="lastUpdatedAt">
                    Last update:  <b>{{lastUpdatedAt | date:'hh:mm:ss a'}}</b>
                </span>

                <div class="currChanger">
                    <a href="" class="curr" ng-click="cc('t')" ng-class="{'active' : currencySelected == 'TRY'}">TRY</a>
                    <a href="" class="curr" ng-click="cc('u')" ng-class="{'active' : currencySelected == 'USD'}">USD</a>
                </div>


            </td>
            <th class="vname e1" ng-repeat="a in newData">{{a.exchange}}</th>
        </tr>

        <tr>
            <th class="header e1 vprice selected" ng-repeat="a in newData">
                <span class="price label label-warning" ng-class="a.class">
                    <span ng-hide="currencySelected == 'USD'">{{a.priceTry}}</span>
                    <span ng-show="currencySelected == 'USD'">{{a.pricesUsd}}</span>
                    <span ng-show="a.pricesUsd == -1">
                        N/A
                    </span>
                </span>


                <p ng-show="a.exchange == 'SANALPARA'" style="position: absolute;
                    right: 0px;
                    top: 0px;
                    font-size: 10px;
                    background-color: #4CAF50;
                    padding: 1px 4px 6px 4px;
                ">
                    <span ng-show="currencySelected == 'USD'">{{a.profitUSD | number:2}} </span>
                    <span ng-hide="currencySelected == 'USD'">{{a.profitTry| number:2}} </span>

                </p>

            </th>

        </tr>

        <tr ng-repeat="a in newData">

            <th class="hname e2" exchange="bit-x">{{a.exchange}}</th>

            <th class="header e2 hprice" exchange="bit-x">
                <span class="price label label-warning" ng-class="a.class">
                    <span ng-hide="currencySelected == 'USD'">{{a.priceTry}}</span>
                    <span ng-show="currencySelected == 'USD'">{{a.pricesUsd}}</span>
                     <span ng-show="a.pricesUsd == -1">
                        N/A
                    </span>

                </span>

                <p ng-show="a.exchange == 'SANALPARA'" style="position: absolute;
                    right: 0px;
                    top: 0px;
                    font-size: 10px;
                    background-color: #4CAF50;
                    padding: 1px 4px 6px 4px;">
                    <span ng-show="currencySelected == 'USD'"">{{a.profitUSD | number:2}} </span>
                    <span ng-hide="currencySelected == 'USD'">{{a.profitTry| number:2}} </span>

                </p>

            </th>

            <td class="arb bit-x_bitbay" ng-repeat="b in newData" ng-class="getTdBgClass(b, a)">
                <span ng-show="currencySelected == 'USD'">{{getPriceDifference(b.pricesUsd , a.pricesUsd)}}</span>
                <span ng-hide="currencySelected == 'USD'">{{getPriceDifference(b.priceTry , a.priceTry)}}</span>
            </td>

        </tr>

        </tbody>

    </table>

    <div class="settingPopup" ng-show="popup">

        <div class="box">
            <div class="closeBtn" ng-click="closePopup()">
                x
            </div>
        </div>

    </div>


</div>

</body>
</html>