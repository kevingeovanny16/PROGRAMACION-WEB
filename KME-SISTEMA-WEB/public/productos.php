<?php
require_once "auth.php";
require_login();
?>
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
                    <button type="submit" class="btn btn-primary" id="btnGuardarProducto">Guardar producto</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>
                </div>
            </form>

            <p id="mensajeProducto" class="message"></p>
        </section>

        <section class="table-section">
            <div class="section-header">
                <h2>Listado de productos</h2>
            </div>

            <div class="filter-grid">
                <div class="form-group">
                    <label for="buscarProducto">Buscar por nombre</label>
                    <input type="text" id="buscarProducto" placeholder="Escriba el nombre del producto">
                </div>

                <div class="form-group">
                    <label for="filtroCategoria">Filtrar por categoría</label>
                    <select id="filtroCategoria">
                        <option value="">Todas las categorías</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="filtroEstado">Filtrar por estado</label>
                    <select id="filtroEstado">
                        <option value="todos">Todos</option>
                        <option value="stock-bajo">Stock bajo</option>
                        <option value="agotados">Agotados</option>
                    </select>
                </div>
            </div>

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