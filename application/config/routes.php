<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Public routes
$route['default_controller'] = 'home';
$route['rute'] = 'rute';
$route['rute/(:any)'] = 'rute/detail/$1';
$route['harga'] = 'harga';
$route['armada'] = 'armada';
$route['armada/(:any)'] = 'armada/detail/$1';
$route['galeri'] = 'galeri';
$route['galeri/(:any)'] = 'galeri/album/$1';
$route['berita'] = 'berita';
$route['berita/(:any)'] = 'berita/detail/$1';
$route['pesan-tiket'] = 'pesan';
$route['kirim-paket'] = 'paket';
$route['kontak'] = 'kontak';

// Admin routes
$route['admin'] = 'admin/dashboard';
$route['admin/login'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/(:any)'] = 'admin/$1';
$route['admin/(:any)/(:any)'] = 'admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3';

// API routes
$route['api/track-wa'] = 'api/track_wa';
$route['api/schedules-by-route'] = 'api/schedules_by_route';
$route['api/submit-review'] = 'api/submit_review';
$route['api/track-view'] = 'api/track_view';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
