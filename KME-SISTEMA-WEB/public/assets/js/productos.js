const PRODUCTOS_KEY = "kme_productos";

const formProducto = document.getElementById("formProducto");
const inputId = document.getElementById("productoId");
const inputNombre = document.getElementById("nombre");
const inputCategoria = document.getElementById("categoria");
const inputPrecio = document.getElementById("precio");
const inputStock = document.getElementById("stock");
const tablaProductos = document.getElementById("tablaProductos");
const mensajeProducto = document.getElementById("mensajeProducto");
const btnCancelar = document.getElementById("btnCancelar");
const btnGuardarProducto = document.getElementById("btnGuardarProducto");

const buscarProducto = document.getElementById("buscarProducto");
const filtroCategoria = document.getElementById("filtroCategoria");
const filtroEstado = document.getElementById("filtroEstado");

function obtenerProductos() {
  return JSON.parse(localStorage.getItem(PRODUCTOS_KEY)) || [];
}

function guardarProductos(productos) {
  localStorage.setItem(PRODUCTOS_KEY, JSON.stringify(productos));
}

function generarId() {
  return "PROD-" + Date.now() + "-" + Math.floor(Math.random() * 1000);
}

function mostrarMensaje(texto, tipo = "ok") {
  mensajeProducto.textContent = texto;
  mensajeProducto.style.color = tipo === "error" ? "#dc2626" : "#16a34a";
}

function limpiarFormulario() {
  inputId.value = "";
  inputNombre.value = "";
  inputCategoria.value = "";
  inputPrecio.value = "";
  inputStock.value = "";
  btnGuardarProducto.textContent = "Guardar producto";
  mostrarMensaje("");
}

function validarProducto(nombre, precio, stock) {
  if (nombre.trim() === "") {
    mostrarMensaje("El nombre del producto es obligatorio.", "error");
    return false;
  }

  if (isNaN(precio) || precio <= 0) {
    mostrarMensaje("El precio debe ser mayor a 0.", "error");
    return false;
  }

  if (isNaN(stock) || stock < 0) {
    mostrarMensaje("El stock debe ser mayor o igual a 0.", "error");
    return false;
  }

  return true;
}

function obtenerEstadoStockTexto(stock) {
  if (stock === 0) {
    return '<span class="stock-agotado">Agotado</span>';
  }

  if (stock <= 3) {
    return '<span class="stock-bajo">Stock bajo</span>';
  }

  return '<span class="stock-normal">Disponible</span>';
}

function formatearMoneda(valor) {
  return "$" + Number(valor).toFixed(2);
}

function cargarCategoriasEnFiltro() {
  const productos = obtenerProductos();
  const categorias = [
    ...new Set(productos.map((p) => (p.categoria || "General").trim())),
  ].sort();

  filtroCategoria.innerHTML =
    `<option value="">Todas las categorías</option>` +
    categorias
      .map((categoria) => `<option value="${categoria}">${categoria}</option>`)
      .join("");
}

function filtrarProductos(productos) {
  const textoBusqueda = buscarProducto.value.trim().toLowerCase();
  const categoriaSeleccionada = filtroCategoria.value;
  const estadoSeleccionado = filtroEstado.value;

  return productos.filter((producto) => {
    const nombreCoincide = producto.nombre
      .toLowerCase()
      .includes(textoBusqueda);
    const categoriaCoincide =
      categoriaSeleccionada === "" ||
      producto.categoria === categoriaSeleccionada;

    let estadoCoincide = true;

    if (estadoSeleccionado === "stock-bajo") {
      estadoCoincide =
        Number(producto.stock) > 0 && Number(producto.stock) <= 3;
    } else if (estadoSeleccionado === "agotados") {
      estadoCoincide = Number(producto.stock) === 0;
    }

    return nombreCoincide && categoriaCoincide && estadoCoincide;
  });
}

function renderizarProductos() {
  const productos = obtenerProductos();
  const productosFiltrados = filtrarProductos(productos);

  if (productosFiltrados.length === 0) {
    tablaProductos.innerHTML = `
            <tr>
                <td colspan="6">No se encontraron productos con los filtros seleccionados.</td>
            </tr>
        `;
    return;
  }

  const productosOrdenados = [...productosFiltrados].sort((a, b) =>
    a.nombre.localeCompare(b.nombre),
  );

  tablaProductos.innerHTML = productosOrdenados
    .map(
      (producto) => `
        <tr>
            <td>${producto.nombre}</td>
            <td>${producto.categoria}</td>
            <td>${formatearMoneda(producto.precio)}</td>
            <td>${producto.stock}</td>
            <td>${obtenerEstadoStockTexto(Number(producto.stock))}</td>
            <td>
                <button class="btn-edit" onclick="editarProducto('${producto.id}')">Editar</button>
                <button class="btn-delete" onclick="eliminarProducto('${producto.id}')">Eliminar</button>
            </td>
        </tr>
    `,
    )
    .join("");
}

function crearProducto(nombre, categoria, precio, stock) {
  const productos = obtenerProductos();

  const nuevoProducto = {
    id: generarId(),
    nombre: nombre.trim(),
    categoria: categoria.trim() === "" ? "General" : categoria.trim(),
    precio: Number(precio),
    stock: Number(stock),
    fechaCreacion: new Date().toLocaleString(),
  };

  productos.push(nuevoProducto);
  guardarProductos(productos);
  cargarCategoriasEnFiltro();
  renderizarProductos();
  limpiarFormulario();
  mostrarMensaje("Producto registrado correctamente.");
}

function actualizarProducto(id, nombre, categoria, precio, stock) {
  const productos = obtenerProductos();

  const productosActualizados = productos.map((producto) => {
    if (producto.id === id) {
      return {
        ...producto,
        nombre: nombre.trim(),
        categoria: categoria.trim() === "" ? "General" : categoria.trim(),
        precio: Number(precio),
        stock: Number(stock),
      };
    }
    return producto;
  });

  guardarProductos(productosActualizados);
  cargarCategoriasEnFiltro();
  renderizarProductos();
  limpiarFormulario();
  mostrarMensaje("Producto actualizado correctamente.");
}

function editarProducto(id) {
  const productos = obtenerProductos();
  const producto = productos.find((p) => p.id === id);

  if (!producto) {
    mostrarMensaje("No se encontró el producto seleccionado.", "error");
    return;
  }

  inputId.value = producto.id;
  inputNombre.value = producto.nombre;
  inputCategoria.value = producto.categoria;
  inputPrecio.value = producto.precio;
  inputStock.value = producto.stock;
  btnGuardarProducto.textContent = "Actualizar producto";

  mostrarMensaje("Modo edición activado.");
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function eliminarProducto(id) {
  const productos = obtenerProductos();
  const producto = productos.find((p) => p.id === id);

  if (!producto) {
    mostrarMensaje("No se encontró el producto a eliminar.", "error");
    return;
  }

  const confirmar = confirm(
    `¿Deseas eliminar el producto "${producto.nombre}"?`,
  );

  if (!confirmar) {
    return;
  }

  const productosFiltrados = productos.filter((p) => p.id !== id);
  guardarProductos(productosFiltrados);
  cargarCategoriasEnFiltro();
  renderizarProductos();
  limpiarFormulario();
  mostrarMensaje("Producto eliminado correctamente.");
}

formProducto.addEventListener("submit", function (e) {
  e.preventDefault();

  const id = inputId.value;
  const nombre = inputNombre.value;
  const categoria = inputCategoria.value;
  const precio = parseFloat(inputPrecio.value);
  const stock = parseInt(inputStock.value);

  if (!validarProducto(nombre, precio, stock)) {
    return;
  }

  if (id) {
    actualizarProducto(id, nombre, categoria, precio, stock);
  } else {
    crearProducto(nombre, categoria, precio, stock);
  }
});

btnCancelar.addEventListener("click", function () {
  limpiarFormulario();
});

buscarProducto.addEventListener("input", renderizarProductos);
filtroCategoria.addEventListener("change", renderizarProductos);
filtroEstado.addEventListener("change", renderizarProductos);

cargarCategoriasEnFiltro();
renderizarProductos();

window.editarProducto = editarProducto;
window.eliminarProducto = eliminarProducto;
