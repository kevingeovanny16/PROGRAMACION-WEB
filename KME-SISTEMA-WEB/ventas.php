<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas | KME Inventario y Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <h1>KME Inventario y Ventas</h1>
            <p class="subtitle">Módulo de ventas</p>
        </div>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="productos.php">Productos</a>
            <a href="ventas.php">Ventas</a>
        </nav>
    </header>

    <main class="container">
        <section class="form-section">
            <h2>Registrar venta</h2>

            <form id="formVenta">
                <div class="form-group">
                    <label for="productoVenta">Producto</label>
                    <select id="productoVenta"></select>
                </div>

                <div class="sale-preview">
                    <div class="preview-box">
                        <span>Precio unitario</span>
                        <strong id="precioUnitarioVista">$0.00</strong>
                    </div>
                    <div class="preview-box">
                        <span>Stock disponible</span>
                        <strong id="stockDisponibleVista">0</strong>
                    </div>
                    <div class="preview-box">
                        <span>Total estimado</span>
                        <strong id="totalEstimadoVista">$0.00</strong>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cantidadVenta">Cantidad</label>
                    <input type="number" id="cantidadVenta" placeholder="0" min="1">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Registrar venta</button>
                </div>
            </form>

            <p id="mensajeVenta" class="message"></p>
        </section>

        <section class="table-section">
            <h2>Historial de ventas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="tablaVentas"></tbody>
            </table>
        </section>
    </main>

    <script src="assets/js/ventas.js"></script>
</body>
</html>