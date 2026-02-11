var CACHE_NAME = "yt-cache-v3";
var ASSETS = [
	"./assets/css/style.css",
	"./assets/css/components.css",
	"./assets/css/pages.css",
	"./assets/js/main.js",
	"./assets/img/icon-192.png",
	"./assets/img/icon-512.png",
];

// Install — cache core assets
self.addEventListener("install", function (e) {
	e.waitUntil(
		caches.open(CACHE_NAME).then(function (cache) {
			return cache.addAll(ASSETS);
		}),
	);
	self.skipWaiting();
});

// Activate — clean ALL old caches
self.addEventListener("activate", function (e) {
	e.waitUntil(
		caches.keys().then(function (names) {
			return Promise.all(
				names
					.filter(function (n) {
						return n !== CACHE_NAME;
					})
					.map(function (n) {
						return caches.delete(n);
					}),
			);
		}),
	);
	self.clients.claim();
});

// Fetch — stale-while-revalidate for assets, network-first for pages
self.addEventListener("fetch", function (e) {
	var url = new URL(e.request.url);

	// Skip non-GET, chrome-extension, and admin requests
	if (e.request.method !== "GET") return;
	if (url.protocol === "chrome-extension:") return;
	if (url.pathname.indexOf("/admin") !== -1) return;

	// CSS/JS/fonts → Stale-While-Revalidate
	// (serve cached immediately, but always fetch fresh copy in background)
	if (url.pathname.match(/\.(css|js|woff2?)$/)) {
		e.respondWith(
			caches.open(CACHE_NAME).then(function (cache) {
				return cache.match(e.request).then(function (cached) {
					var fetchPromise = fetch(e.request)
						.then(function (networkResp) {
							if (networkResp && networkResp.ok) {
								cache.put(e.request, networkResp.clone());
							}
							return networkResp;
						})
						.catch(function () {
							return cached; // fallback to cached version if offline
						});
					// Return cached version immediately if available, otherwise wait for network
					return cached || fetchPromise;
				});
			}),
		);
		return;
	}

	// Images → Cache first (images rarely change)
	if (url.pathname.match(/\.(png|jpg|jpeg|webp|gif|ico|svg)$/)) {
		e.respondWith(
			caches.match(e.request).then(function (cached) {
				return (
					cached ||
					fetch(e.request).then(function (resp) {
						if (resp && resp.ok) {
							var clone = resp.clone();
							caches.open(CACHE_NAME).then(function (cache) {
								cache.put(e.request, clone);
							});
						}
						return resp;
					})
				);
			}),
		);
		return;
	}

	// HTML pages → Network only (never cache HTML, always get fresh from server)
	// This prevents stale page content from being served
});
