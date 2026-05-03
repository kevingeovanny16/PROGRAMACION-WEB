<?php
require_once "auth.php";
require_login();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KME Inventario y Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <h1>KME Inventario y Ventas</h1>
            <p class="subtitle">Panel principal del sistema</p>
        </div>
        <nav class="nav-right">
    <a href="index.php">Inicio</a>
    <a href="productos.php">Productos</a>
    <a href="ventas.php">Ventas</a>
    <span class="user-badge">
        Usuario: <?php echo htmlspecialchars($_SESSION["nombre_usuario"] ?? "admin"); ?>
    </span>
    <a href="logout.php" class="logout-link">Salir</a>
</nav>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Bienvenido al sistema</h2>
            <p>
                Este sistema permite gestionar productos, registrar ventas y visualizar
                información resumida del inventario de forma rápida y ordenada.
            </p>
        </section>

        <section class="cards">
            <article class="card">
                <h3>Total de productos</h3>
                <p id="totalProductos">0</p>
            </article>

            <article class="card">
                <h3>Stock total</h3>
                <p id="stockTotal">0</p>
            </article>

            <article class="card">
                <h3>Total de ventas</h3>
                <p id="totalVentas">0</p>
            </article>

            <article class="card">
                <h3>Valor del inventario</h3>
                <p id="valorInventario">$0.00</p>
            </article>
        </section>

        <section class="alert-grid">
            <article class="alert-card alert-warning">
                <h3>Productos con stock bajo</h3>
                <p id="productosStockBajo">0</p>
                <small>Productos con stock menor o igual a 3 unidades</small>
            </article>

            <article class="alert-card alert-danger">
                <h3>Productos agotados</h3>
                <p id="productosAgotados">0</p>
                <small>Productos con stock igual a 0</small>
            </article>
        </section>

        <section class="info-box">
            <h3>Resumen de alertas</h3>
            <ul id="listaAlertasInicio" class="summary-list"></ul>
        </section>

        <section class="table-section">
            <h2>Últimas ventas registradas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="tablaUltimasVentas"></tbody>
            </table>
        </section>
    </main>

    <script>
        const PRODUCTOS_KEY = "kme_productos";
        const VENTAS_KEY = "kme_ventas";

        function obtenerProductos() {
            return JSON.parse(localStorage.getItem(PRODUCTOS_KEY)) || [];
        }

        function obtenerVentas() {
            return JSON.parse(localStorage.getItem(VENTAS_KEY)) || [];
        }

        function formatearMoneda(valor) {
            return "$" + Number(valor).toFixed(2);
        }

        function cargarResumen() {
            const productos = obtenerProductos();
            const ventas = obtenerVentas();

            let stockTotal = 0;
            let valorInventario = 0;
            let stockBajo = 0;
            let agotados = 0;

            productos.forEach(producto => {
                const stock = Number(producto.stock);
                const precio = Number(producto.precio);

                stockTotal += stock;
                valorInventario += stock * precio;

                if (stock <= 3 && stock > 0) {
                    stockBajo++;
                }

                if (stock === 0) {
                    agotados++;
                }
            });

            document.getElementById("totalProductos").textContent = productos.length;
            document.getElementById("stockTotal").textContent = stockTotal;
            document.getElementById("totalVentas").textContent = ventas.length;
            document.getElementById("valorInventario").textContent = formatearMoneda(valorInventario);
            document.getElementById("productosStockBajo").textContent = stockBajo;
            document.getElementById("productosAgotados").textContent = agotados;
        }

        function renderizarAlertas() {
            const productos = obtenerProductos();
            const listaAlertas = document.getElementById("listaAlertasInicio");

            const productosConAlerta = productos.filter(producto => Number(producto.stock) <= 3);

            if (productosConAlerta.length === 0) {
                listaAlertas.innerHTML = "<li>No existen alertas de stock en este momento.</li>";
                return;
            }

            listaAlertas.innerHTML = productosConAlerta.map(producto => {
                const stock = Number(producto.stock);

                if (stock === 0) {
                    return `<li><strong>${producto.nombre}</strong> se encuentra agotado.</li>`;
                }

                return `<li><strong>${producto.nombre}</strong> tiene stock bajo (${stock} unidades).</li>`;
            }).join("");
        }

        function renderizarUltimasVentas() {
            const ventas = obtenerVentas();
            const tablaUltimasVentas = document.getElementById("tablaUltimasVentas");

            if (ventas.length === 0) {
                tablaUltimasVentas.innerHTML = `
                    <tr>
                        <td colspan="5">No hay ventas registradas todavía.</td>
                    </tr>
                `;
                return;
            }

            const ultimasVentas = [...ventas].reverse().slice(0, 5);

            tablaUltimasVentas.innerHTML = ultimasVentas.map(venta => `
                <tr>
                    <td>${venta.nombreProducto}</td>
                    <td>${venta.categoria}</td>
                    <td>${venta.cantidad}</td>
                    <td>${formatearMoneda(venta.total)}</td>
                    <td>${venta.fecha}</td>
                </tr>
            `).join("");
        }

        cargarResumen();
        renderizarAlertas();
        renderizarUltimasVentas();
    </script>
</body>
</html>