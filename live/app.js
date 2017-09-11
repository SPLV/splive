var app = angular.module("myApp", []);

var appURL = 'http://arbt.sanalpara.live/'
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