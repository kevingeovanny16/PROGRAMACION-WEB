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
            <p class="subtitle">Sistema web simple en PHP + JavaScript</p>
        </div>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="productos.php">Productos</a>
            <a href="ventas.php">Ventas</a>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Bienvenido al sistema</h2>
            <p>
                Este sistema permite gestionar productos y registrar ventas
                de forma simple, aplicando validaciones básicas, estructura ordenada
                y almacenamiento local.
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
        </section>

        <section class="info-box">
            <h3>Resumen</h3>
            <p>
                Desde el módulo de productos podrás crear, editar y eliminar registros.
                Desde el módulo de ventas podrás registrar ventas y descontar automáticamente
                el stock disponible.
            </p>
        </section>
    </main>

    <script>
        const productos = JSON.parse(localStorage.getItem("kme_productos")) || [];
        const ventas = JSON.parse(localStorage.getItem("kme_ventas")) || [];

        let stockTotal = 0;
        productos.forEach(producto => {
            stockTotal += Number(producto.stock);
        });

        document.getElementById("totalProductos").textContent = productos.length;
        document.getElementById("stockTotal").textContent = stockTotal;
        document.getElementById("totalVentas").textContent = ventas.length;
    </script>
</body>
</html>