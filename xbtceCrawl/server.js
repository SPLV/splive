var Nightmare = require('nightmare');
var jsonfile = require('jsonfile')
var async = require('async')
var request = require('request')
var cheerio = require('cheerio')
var isWorking_XBTCE = false;
var express = require('express')
var app = express()

var XBTCE_Price = function () {

    isWorking_XBTCE = true;

    var price = 0
    var volumne = 0

    async.parallel([
        function (cb) {
            var nightmare = Nightmare({show: false});

            nightmare
                .goto('https://www.xbtce.com/en/?type=exchange')
                .wait('#btn-Bids .bvm-corner')
                .wait(10000)
                .evaluate(function () {
                    var up = document.querySelector('#btn-Bids .bvm-value').textContent;
                    var price = document.querySelector('#btn-Bids .bvm-price').textContent;
                    return {
                        up: up,
                        price: price,
                        all: up + price
                    };
                })
                .end()
                .then(function (result) {
                    console.log(result)
                    if (result.all) {
                        price = parseFloat(result.all)
                    }
                    cb()

                })
                .catch(function (error) {
                    isWorking_XBTCE = false;
                    console.error('Search failed:', error);
                });
        },
        function (cb) {

            var options = {
                url: 'https://coinmarketcap.com/exchanges/xbtce/',
                headers: {
                    'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'
                }
            };

            request(options, function (error, response, body) {
                    if (!error && response.statusCode == 200) {
                        var selector = 'body > div.container > div > div.col-xs-12.col-sm-12.col-md-12.col-lg-10 > div:nth-child(5) > div.col-xs-8 > div > span'

                        var $ = cheerio.load(body);
                        var text = $(selector).text();
                        text = text.replace('$', '')
                        text = text.replace(/,/ig, '')
                        volumne = text
                    }


                    cb()
                }
            );

        }
    ], function () {

        console.log(price, volumne)

        var file = './xbtce.json';
        jsonfile.readFile(file, function (err, obj) {

            if (!obj) obj = {}

            if (price) obj.price = parseFloat(price)
            if (volumne) obj.volume = parseFloat(volumne)

            jsonfile.writeFile(file, obj, function (err) {
                console.error(err)
                isWorking_XBTCE = false;

            })

        })

    })


};

XBTCE_Price()

setInterval(function () {
    if (!isWorking_XBTCE) {
        XBTCE_Price()
    }
}, 10 * 1000)


app.get('/xbtce', function (req, res) {
    var file = './xbtce.json';
    jsonfile.readFile(file, function (err, obj) {
        res.send(obj)
    })
})

app.listen(80, function () {
    console.log('Example app listening on port 8080!')
})
