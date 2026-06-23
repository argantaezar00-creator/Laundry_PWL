<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');

$routes->group('layanan', function($routes) {
    $routes->get('/', 'Layanan::index');
    $routes->get('create', 'Layanan::create');
    $routes->post('store', 'Layanan::store');
    $routes->get('edit/(:num)', 'Layanan::edit/$1');
    $routes->post('update/(:num)', 'Layanan::update/$1');
    $routes->post('delete/(:num)', 'Layanan::delete/$1');
});

$routes->group('pelanggan', function($routes) {
    $routes->get('/', 'Pelanggan::index');
    $routes->get('create', 'Pelanggan::create');
    $routes->post('store', 'Pelanggan::store');
    $routes->get('edit/(:num)', 'Pelanggan::edit/$1');
    $routes->post('update/(:num)', 'Pelanggan::update/$1');
    $routes->post('delete/(:num)', 'Pelanggan::delete/$1');
});

$routes->group('pesanan', function($routes) {
    $routes->get('/', 'Pesanan::index');
    $routes->get('create', 'Pesanan::create');
    $routes->post('store', 'Pesanan::store');
    $routes->get('detail/(:num)', 'Pesanan::detail/$1');
    $routes->get('edit/(:num)', 'Pesanan::edit/$1');
    $routes->post('update/(:num)', 'Pesanan::update/$1');
    $routes->post('update-status/(:num)', 'Pesanan::updateStatus/$1');
    $routes->post('update-pembayaran/(:num)', 'Pesanan::updatePembayaran/$1');
    $routes->get('struk/(:num)', 'Pesanan::struk/$1');
    $routes->post('delete/(:num)', 'Pesanan::delete/$1');
});

$routes->get('laporan', 'Laporan::index');
