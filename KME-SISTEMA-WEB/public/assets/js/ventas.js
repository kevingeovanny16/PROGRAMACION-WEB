const PRODUCTOS_KEY = "kme_productos";
const VENTAS_KEY = "kme_ventas";

const formVenta = document.getElementById("formVenta");
const selectProducto = document.getElementById("productoVenta");
const inputCantidad = document.getElementById("cantidadVenta");
const tablaVentas = document.getElementById("tablaVentas");
const mensajeVenta = document.getElementById("mensajeVenta");

const precioUnitarioVista = document.getElementById("precioUnitarioVista");
const stockDisponibleVista = document.getElementById("stockDisponibleVista");
const totalEstimadoVista = document.getElementById("totalEstimadoVista");

function obtenerProductos() {
  return JSON.parse(localStorage.getItem(PRODUCTOS_KEY)) || [];
}

function guardarProductos(productos) {
  localStorage.setItem(PRODUCTOS_KEY, JSON.stringify(productos));
}

function obtenerVentas() {
  return JSON.parse(localStorage.getItem(VENTAS_KEY)) || [];
}

function guardarVentas(ventas) {
  localStorage.setItem(VENTAS_KEY, JSON.stringify(ventas));
}

function generarIdVenta() {
  return "VENTA-" + Date.now() + "-" + Math.floor(Math.random() * 1000);
}

function mostrarMensajeVenta(texto, tipo = "ok") {
  mensajeVenta.textContent = texto;
  mensajeVenta.style.color = tipo === "error" ? "#dc2626" : "#16a34a";
}

function formatearMoneda(valor) {
  return "$" + Number(valor).toFixed(2);
}

function cargarProductosEnSelect() {
  const productos = obtenerProductos();

  if (productos.length === 0) {
    selectProducto.innerHTML = `<option value="">No hay productos registrados</option>`;
    actualizarVistaProducto();
    return;
  }

  const productosDisponibles = productos.sort((a, b) =>
    a.nombre.localeCompare(b.nombre),
  );

  selectProducto.innerHTML =
    `<option value="">Seleccione un producto</option>` +
    productosDisponibles
      .map(
        (producto) => `
            <option value="${producto.id}">
                ${producto.nombre} | Stock: ${producto.stock}
            </option>
        `,
      )
      .join("");

  actualizarVistaProducto();
}

function obtenerProductoSeleccionado() {
  const productos = obtenerProductos();
  const idSeleccionado = selectProducto.value;
  return productos.find((producto) => producto.id === idSeleccionado);
}

function actualizarVistaProducto() {
  const producto = obtenerProductoSeleccionado();
  const cantidad = parseInt(inputCantidad.value) || 0;

  if (!producto) {
    precioUnitarioVista.textContent = "$0.00";
    stockDisponibleVista.textContent = "0";
    totalEstimadoVista.textContent = "$0.00";
    return;
  }

  precioUnitarioVista.textContent = formatearMoneda(producto.precio);
  stockDisponibleVista.textContent = producto.stock;
  totalEstimadoVista.textContent = formatearMoneda(producto.precio * cantidad);
}

function validarVenta(producto, cantidad) {
  if (!producto) {
    mostrarMensajeVenta("Debe seleccionar un producto válido.", "error");
    return false;
  }

  if (isNaN(cantidad) || cantidad <= 0) {
    mostrarMensajeVenta("La cantidad debe ser mayor a 0.", "error");
    return false;
  }

  if (cantidad > producto.stock) {
    mostrarMensajeVenta(
      "La cantidad solicitada supera el stock disponible.",
      "error",
    );
    return false;
  }

  return true;
}

function registrarVenta(producto, cantidad) {
  const ventas = obtenerVentas();
  const productos = obtenerProductos();

  const totalVenta = Number(producto.precio) * Number(cantidad);

  const nuevaVenta = {
    id: generarIdVenta(),
    productoId: producto.id,
    nombreProducto: producto.nombre,
    categoria: producto.categoria,
    cantidad: Number(cantidad),
    precioUnitario: Number(producto.precio),
    total: totalVenta,
    fecha: new Date().toLocaleString(),
  };

  ventas.push(nuevaVenta);

  const productosActualizados = productos.map((item) => {
    if (item.id === producto.id) {
      return {
        ...item,
        stock: Number(item.stock) - Number(cantidad),
      };
    }
    return item;
  });

  guardarVentas(ventas);
  guardarProductos(productosActualizados);

  formVenta.reset();
  mostrarMensajeVenta("Venta registrada correctamente.");
  cargarProductosEnSelect();
  renderizarVentas();
  actualizarVistaProducto();
}

function renderizarVentas() {
  const ventas = obtenerVentas();

  if (ventas.length === 0) {
    tablaVentas.innerHTML = `
            <tr>
                <td colspan="6">No hay ventas registradas.</td>
            </tr>
        `;
    return;
  }

  const ventasOrdenadas = [...ventas].reverse();

  tablaVentas.innerHTML = ventasOrdenadas
    .map(
      (venta) => `
        <tr>
            <td>${venta.nombreProducto}</td>
            <td>${venta.categoria}</td>
            <td>${venta.cantidad}</td>
            <td>${formatearMoneda(venta.precioUnitario)}</td>
            <td>${formatearMoneda(venta.total)}</td>
            <td>${venta.fecha}</td>
        </tr>
    `,
    )
    .join("");
}

formVenta.addEventListener("submit", function (e) {
  e.preventDefault();

  const producto = obtenerProductoSeleccionado();
  const cantidad = parseInt(inputCantidad.value);

  if (!validarVenta(producto, cantidad)) {
    return;
  }

  registrarVenta(producto, cantidad);
});

selectProducto.addEventListener("change", actualizarVistaProducto);
inputCantidad.addEventListener("input", actualizarVistaProducto);

cargarProductosEnSelect();
renderizarVentas();
