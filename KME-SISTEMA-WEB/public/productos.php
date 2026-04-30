<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | KME Inventario y Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <h1>KME Inventario y Ventas</h1>
            <p class="subtitle">Módulo de productos</p>
        </div>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="productos.php">Productos</a>
            <a href="ventas.php">Ventas</a>
        </nav>
    </header>

    <main class="container">
        <section class="form-section">
            <h2>Registrar producto</h2>

            <form id="formProducto">
                <input type="hidden" id="productoId">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" placeholder="Ej: Mouse inalámbrico">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <input type="text" id="categoria" placeholder="Ej: Accesorios">
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" step="0.01" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" placeholder="0">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar producto</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>
                </div>
            </form>

            <p id="mensajeProducto" class="message"></p>
        </section>

        <section class="table-section">
            <h2>Listado de productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaProductos"></tbody>
            </table>
        </section>
    </main>

    <script src="assets/js/productos.js"></script>
</body>
</html>