var app = angular.module("myApp", ['ngStorage', '720kb.tooltips']);

var appURL = 'http://arbt.sanalpara.live/';

app.run(function ($rootScope) {

    $rootScope.sequenceArr = ['SANALPARA', "PARIBU", "KOINIM", "BTCTURK", "XBTCE", "BITSTAMP", "CEXIO", "BITFINEX", "POLONIEX"]

    $rootScope.addOrder = function (data) {
        angular.forEach(data, function (value, key) {
            value.vOrder = $rootScope.sequenceArr.indexOf(value.exchange)
        });

    }

});

app.controller('mainCtrl', function ($scope, $http, $interval) {

    $scope.allData = [];
    $scope.loader = false;

    $scope.loadData = function () {
        $scope.loader = true;
        $http.get(appURL + 'ajax.php').then(function (resp) {
            $scope.allData = resp.data;
            $scope.loader = false;
        }, function () {
            $scope.loader = false;
        })
    };

    $scope.loadData();

    $interval(function () {
        $scope.loadData();
    }, 10000);

})

app.controller('arbitrageCtrl', function ($rootScope, $scope, $http, $interval, $filter) {


    $scope.allData = [];
    $scope.loader = true;
    $scope.popup = false;
    $scope.currencySelected = 'USD';
    $scope.lastUpdatedAt = null;
    $scope.comArr = ["BTCTURK", "KOINIM", "PARIBU"]

    $scope.cc = function (x) {
        if (x == 'u') {
            $scope.currencySelected = 'USD';
        } else {
            $scope.currencySelected = 'TRY';
        }
    }
    $scope.closePopup = function () {
        $scope.popup = false
    }

    $scope.newData = []
    $scope.oldData = []
    $scope.profitPercentage = -1;

    $scope.getPriceDifference = function (a, b) {

        if (typeof a == 'string') {
            a = a.replace('.', '')
            a = a.replace(',', '.')
        }

        if (typeof b == 'string') {
            b = b.replace('.', '')
            b = b.replace(',', '.')
        }

        if ((a - b) == 0) {
            return '-'
        }

        return (a - b).toFixed(2)
    };
    $scope.getTdBgClass = function (x, y) {

        var a = x.pricesUsd
        var b = y.pricesUsd

        if (typeof a == 'string') {
            a = a.replace('.', '')
            a = a.replace(',', '.')
        }

        if (typeof b == 'string') {
            b = b.replace('.', '')
            b = b.replace(',', '.')
        }

        if ((a - b) == 0) {

            return 'blank'

        }
        else if (a - b > 0) {
            return 'success'
        }
        else {
            return 'danger'
        }


    };

    $scope.loadData = function () {
        $scope.loader = true;
        $http.get(appURL + 'ajax.php')
            .then(function (resp) {

                    $scope.oldData = angular.copy($scope.newData);
                    $scope.newData = resp.data;

                    var sanalParaData = $scope.algo.run();
                    $scope.newData.unshift(sanalParaData);

                    angular.forEach($scope.newData, function (value, key) {

                        var newPrice = $scope.clearPrice(value.priceTry);
                        var oldPrice = 0

                        angular.forEach($scope.oldData, function (val, key) {
                            if (val.exchange == value.exchange) {
                                // console.log(val.exchange)
                                oldPrice = $scope.clearPrice(val.priceTry)
                            }
                        });

                        if (newPrice - oldPrice > 0) {
                            value.class = 'green'
                        } else if (newPrice - oldPrice == 0) {
                            value.class = 'none'
                        } else {
                            value.class = 'red'
                        }

                    });

                    $rootScope.addOrder($scope.newData)
                    $scope.newData = $filter('orderBy')($scope.newData, 'vOrder')

                    $scope.loader = false;
                    $scope.lastUpdatedAt = new Date();
                },
                function () {
                    $scope.loader = false;
                })
    };

    $scope.loadData();

    $scope.algo = {
        seller: 'XBTCE',
        competition: 'KOINIM',
        differnce: 40,
        isProfit: false,
        allowMarin: false,
        profitPercentage: function () {

        },
        run: function () {

            if (this.seller == 'LOWEST') {
                var temp = _.sortBy(angular.copy($scope.newData), function (num) {
                    return $scope.clearPrice(num.priceTry)
                });

                $scope.aPrice = temp[0]

            }
            else {
                angular.forEach($scope.newData, function (value, key) {
                    if (value.exchange == this.seller) {
                        $scope.aPrice = value;

                    }
                }.bind(this));
            }

            if (this.competition == 'LOWEST') {
                var temp = _.sortBy(angular.copy($scope.newData), function (num) {
                    return $scope.clearPrice(num.priceTry)
                });

                $scope.bPrice = temp[0]

            }
            else if (this.competition == 'AVERAGE') {

                var t = {
                    exchange: 'AVERAGE',
                    pricesUsd: 0,
                    priceTry: 0
                }

                angular.forEach($scope.newData, function (value, key) {

                    if ($scope.comArr.indexOf(value.exchange) != -1) {
                        // console.log(value, $scope.clearPrice(value.pricesUsd), $scope.clearPrice(value.priceTry))
                        t.pricesUsd = t.pricesUsd + parseFloat($scope.clearPrice(value.pricesUsd))
                        t.priceTry = t.priceTry + parseFloat($scope.clearPrice(value.priceTry))
                    }
                })

                t.priceTry = t.priceTry / 3;
                t.pricesUsd = t.pricesUsd / 3;

                // console.log(t)

                $scope.bPrice = t

            }
            else if (this.competition == 'NONE') {

                this.isProfit = false

                return {
                    pricesUsd: $scope.clearPrice($scope.aPrice.pricesUsd) - this.differnce,
                    priceTry: $scope.clearPrice($scope.aPrice.priceTry) - this.differnce,
                    profit: -1,
                    exchange: 'SANALPARA'
                }

            }
            else {
                angular.forEach($scope.newData, function (value, key) {
                    if (value.exchange == this.competition) {
                        $scope.bPrice = value;
                    }
                }.bind(this));
            }

            var xx = {
                exchange: "KOINIM",
                priceTry: "9.451,05",
                pricesUsd: "2.664,35"
            };

            var seller = $scope.clearPrice($scope.aPrice.pricesUsd),
                competition = $scope.clearPrice($scope.bPrice.pricesUsd);

            var sellerTry = $scope.clearPrice($scope.aPrice.priceTry),
                competitionTry = $scope.clearPrice($scope.bPrice.priceTry);

            $scope.formula = {
                bestMargin: $scope.currencySelected == 'USD' ? competition - seller : competitionTry - sellerTry,
                comp: $scope.bPrice,
                seller: $scope.aPrice,
            }

            console.log(competition - seller, competition, seller)
            console.log(competitionTry - sellerTry, competitionTry, sellerTry)
            console.log($scope.formula.bestMargin * 0.3)


            if (competition - seller > 0) {

                // if (competition - seller >= $scope.algo.differnce) {
                //     // sanalpara price is competation - $scope.algo.differnce
                //
                //     var tryPrice = round(competitionTry - $scope.algo.differnce, 2)
                //     var usdPrice = round(competition - $scope.algo.differnce, 2)
                //
                //     this.isProfit = true
                //     return {
                //         pricesUsd: usdPrice,
                //         priceTry: tryPrice,
                //         profitUSD: ((usdPrice - seller ) / seller) * 100,
                //         profitTry: ((tryPrice - sellerTry ) / sellerTry) * 100,
                //         exchange: 'SANALPARA'
                //     }
                //
                // }
                // else {
                //     console.log('this is workign now ')
                //     this.isProfit = false
                //     return {
                //         pricesUsd: -1,
                //         priceTry: -1,
                //         profit: -1,
                //         exchange: 'SANALPARA'
                //     }
                // }


                $scope.formula.bestMargin = round($scope.formula.bestMargin * 0.3, 2)

                if (!this.allowMarin) {
                    $scope.algo.differnce = round($scope.formula.bestMargin, 2)
                }

                var tryPrice = round(competitionTry - $scope.algo.differnce, 2)
                var usdPrice = round(competition - $scope.algo.differnce, 2)

                this.isProfit = true
                return {
                    pricesUsd: usdPrice,
                    priceTry: tryPrice,
                    profitUSD: ((usdPrice - seller ) / seller) * 100,
                    profitTry: ((tryPrice - sellerTry ) / sellerTry) * 100,
                    exchange: 'SANALPARA'
                }

            }
            else {
                console.log('this case workied')
                /* this.isProfit = false
                 return {
                 pricesUsd: -1,
                 priceTry: -1,
                 profit: -1,
                 exchange: 'SANALPARA'
                 }*/

                $scope.formula.bestMargin = round($scope.formula.bestMargin * 0.3, 2)

                if (!this.allowMarin) {
                    $scope.algo.differnce = round($scope.formula.bestMargin, 2)
                }


                var tryPrice = round(sellerTry + $scope.algo.differnce, 2)
                var usdPrice = round(seller + $scope.algo.differnce, 2)

                this.isProfit = false
                return {
                    pricesUsd: usdPrice,
                    priceTry: tryPrice,
                    profitUSD: ((usdPrice - competition) / competition) * 100,
                    profitTry: ((tryPrice - competitionTry) / competitionTry) * 100,
                    exchange: 'SANALPARA'
                }


            }

        },
        changeSettings: function () {
            $scope.loadData()
        }
    }

    $scope.formula = {}

    $scope.marginChanged = function () {
        console.log('asdf')
        $scope.algo.allowMarin = true;
    }

    $interval(function () {
        $scope.loadData();
    }, 20 * 1000);

    $scope.clearPrice = function (x) {

        if (typeof x != 'string') return x

        x = x.replace('.', '')
        x = x.replace(',', '.')

        return round(parseFloat(x), 2)
    }

    $scope.dirtyPrice = function (x) {

        x = x.replace('.', '')
        x = x.replace(',', '.')

        return x
    }


})

app.directive('validNumber', function () {
    return {
        require: '?ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            if (!ngModelCtrl) {
                return;
            }

            ngModelCtrl.$parsers.push(function (val) {
                if (angular.isUndefined(val)) {
                    var val = '';
                }

                var clean = val.replace(/[^-0-9\.]/g, '');
                var negativeCheck = clean.split('-');
                var decimalCheck = clean.split('.');
                if (!angular.isUndefined(negativeCheck[1])) {
                    negativeCheck[1] = negativeCheck[1].slice(0, negativeCheck[1].length);
                    clean = negativeCheck[0] + '-' + negativeCheck[1];
                    if (negativeCheck[0].length > 0) {
                        clean = negativeCheck[0];
                    }

                }

                if (!angular.isUndefined(decimalCheck[1])) {
                    decimalCheck[1] = decimalCheck[1].slice(0, 2);
                    clean = decimalCheck[0] + '.' + decimalCheck[1];
                }

                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function (event) {
                if (event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
});

function round(value, exp) {
    if (typeof exp === 'undefined' || +exp === 0)
        return Math.round(value);

    value = +value;
    exp = +exp;

    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
        return NaN;

    // Shift
    value = value.toString().split('e');
    value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}
