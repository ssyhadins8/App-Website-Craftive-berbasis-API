<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Craftive REST API',
    description: 'Dokumentasi interaktif REST API Craftive - Premium Handmade Goods Marketplace dengan integrasi Agentic AI Custom Planner. Dikembangkan sebagai Tugas Akhir Pemrograman API - UNESA 2026.',
    contact: new OA\Contact(email: 'dev@craftive.id')
)]
#[OA\Server(url: '/api', description: 'Server Lokal')]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Masukkan token JWT dari endpoint Login'
)]
#[OA\SecurityScheme(
    securityScheme: 'basicAuth',
    type: 'http',
    scheme: 'basic',
    description: 'HTTP Basic Auth (email & password)'
)]
abstract class Controller
{
    //
}
