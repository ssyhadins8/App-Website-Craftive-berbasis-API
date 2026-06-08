<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Craftive REST API Documentation (Swagger UI)</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin: 0;
            background: #fafafa;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Header Brand Style */
        .craftive-swagger-header {
            background-color: #2C2C2C;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #FAF4EA;
            border-bottom: 4px solid #C84B1E;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .craftive-swagger-header .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .craftive-swagger-header .brand h1 {
            margin: 0;
            font-size: 22px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #FAF4EA;
            text-transform: uppercase;
        }
        .craftive-swagger-header .brand h1 span {
            color: #C84B1E;
        }
        .craftive-swagger-header .back-btn {
            background-color: #C84B1E;
            color: #FAF4EA;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: 'Outfit', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .craftive-swagger-header .back-btn:hover {
            background-color: #FAF4EA;
            color: #2C2C2C;
            transform: translateY(-2px);
        }
        
        /* Swagger UI Internal Customization */
        .swagger-ui .topbar {
            display: none !important; /* Hide original Swagger header */
        }
        .swagger-ui .info {
            margin: 30px 0 20px 0 !important;
            padding: 0 30px !important;
        }
        .swagger-ui .info .title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 700 !important;
            color: #2C2C2C !important;
        }
        .swagger-ui .scheme-container {
            margin: 20px 30px !important;
            padding: 20px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
            border: 1px solid #E2E8F0 !important;
        }
        .swagger-ui .wrapper {
            max-width: 1200px !important;
            padding: 0 30px !important;
        }
        .swagger-ui .opblock-tag-section {
            background: #ffffff !important;
            border-radius: 8px !important;
            margin-bottom: 20px !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02) !important;
            border: 1px solid #E2E8F0 !important;
            overflow: hidden !important;
        }
        .swagger-ui .opblock-tag {
            font-family: 'Outfit', sans-serif !important;
            padding: 15px 20px !important;
            background: #FDF4F0 !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        .swagger-ui .opblock {
            border-radius: 6px !important;
            margin: 10px 20px !important;
        }
    </style>
</head>
<body>
    <div class="craftive-swagger-header">
        <div class="brand">
            <h1>CRAFTIVE<span>.API</span></h1>
        </div>
        <a href="<?php echo e(url('/')); ?>" class="back-btn">← Kembali ke Beranda</a>
    </div>

    <div id="swagger-ui"></div>

    <!-- Swagger UI JS bundles -->
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-bundle.js" charset="UTF-8"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-standalone-preset.js" charset="UTF-8"></script>
    <script>
        window.onload = () => {
            window.ui = SwaggerUIBundle({
                url: "<?php echo e(url('/docs/swagger.json')); ?>",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: "BaseLayout",
                persistAuthorization: true
            });
        };
    </script>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\craftive\resources\views/pages/docs.blade.php ENDPATH**/ ?>