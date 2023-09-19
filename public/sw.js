const preLoad = function () {
    return caches.open('offline').then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
};

self.addEventListener('install', function (event) {
    event.waitUntil(preLoad());
});

const filesToCache = [
    '../public/css/app.css',
    '../public/css/vendor.css',
    '../public/js/app.js',
    '../public/js/vendor.js',
    '../public/js/common.js',
    '../public/js/documents_and_note.js',
    '../public/js/feather.min.js',
    '../public/js/functions.js',
    '../public/js/help-tour.js',
    '../public/js/home.js',
    '../public/js/init.js',
    '../public/js/labels.js',
    '../public/js/login.js',
    '../public/js/main.js',
    '../public/js/opening_stock.js',
    '../public/js/payment.js',
    '../public/js/pos.js',
    '../public/js/printer.js',
    '../public/js/product.js',
    '../public/js/purchase_return.js',
    '../public/js/purchase.js',
    '../public/js/report.js',
    '../public/js/restaurant.js',
    '../public/js/sell_return.js',
    '../public/js/stock_adjustment.js',
    '../public/js/stock_transfer.js',
    '../public/js/wizardscript.js',
    '../public/offline.html',
];

const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

const addToCache = function (request) {
  
    return caches.open('offline').then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.add(request, response);
        });
    });
};

const returnFromCache = function (request) {
    return caches.open('offline').then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match('offline.html');
            } else {
                return matching;
            }
        });
    });
};

self.addEventListener('fetch', function (event) {
    event.respondWith(
        checkResponse(event.request).catch(function () {
            return returnFromCache(event.request);
        })
    );
    if (!event.request.url.startsWith('http')) {
        event.waitUntil(addToCache(event.request));
    }
});
