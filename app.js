document.addEventListener('DOMContentLoaded', () => {
    const carrito = document.getElementById('carrito');
    const listaCarrito = document.querySelector('#Lista-Carrito tbody');
    const vaciarCarritoBtn = document.getElementById('vaciar-carrito');
    const agregarCarritoBtns = document.querySelectorAll('.agregar-carrito.btn-3');
    const imgCarrito = document.getElementById('img-carrito');

    let articulosCarrito = [];

    // Añade el producto al carrito
    function agregarProducto(e) {
        e.preventDefault();
        const producto = e.target.parentElement.parentElement;
        leerDatosProducto(producto);
    }

    // Lee la información del producto
    function leerDatosProducto(producto) {
        const infoProducto = {
            imagen: producto.querySelector('img').src,
            nombre: producto.querySelector('h3').textContent,
            precio: producto.querySelector('.Precio').textContent,
            id: producto.querySelector('a').getAttribute('data-id'),
            cantidad: 1
        }

        // Verifica si el producto ya existe en el carrito
        const existe = articulosCarrito.some(producto => producto.id === infoProducto.id);
        if (existe) {
            const productos = articulosCarrito.map(producto => {
                if (producto.id === infoProducto.id) {
                    producto.cantidad++;
                    return producto;
                } else {
                    return producto;
                }
            });
            articulosCarrito = [...productos];
        } else {
            articulosCarrito = [...articulosCarrito, infoProducto];
        }

        carritoHTML();
    }

    // Muestra el carrito en el HTML
    function carritoHTML() {
        limpiarHTML();

        articulosCarrito.forEach(producto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <img src="${producto.imagen}" width="100">
                </td>
                <td>${producto.nombre}</td>
                <td>${producto.precio}</td>
                <td>${producto.cantidad}</td>
                <td>
                    <a href="#" class="borrar-producto" data-id="${producto.id}">X</a>
                </td>
            `;

            listaCarrito.appendChild(row);
        });
    }

    // Elimina los productos del tbody
    function limpiarHTML() {
        while (listaCarrito.firstChild) {
            listaCarrito.removeChild(listaCarrito.firstChild);
        }
    }

    // Vacía el carrito
    function vaciarCarrito() {
        articulosCarrito = [];
        limpiarHTML();
    }

    // Alterna la visibilidad del carrito
    function toggleCarrito() {
        carrito.classList.toggle('show');
    }

    // Listeners
    agregarCarritoBtns.forEach(btn => btn.addEventListener('click', agregarProducto));
    vaciarCarritoBtn.addEventListener('click', vaciarCarrito);
    carrito.addEventListener('click', e => {
        if (e.target.classList.contains('borrar-producto')) {
            const productoId = e.target.getAttribute('data-id');
            articulosCarrito = articulosCarrito.filter(producto => producto.id !== productoId);
            carritoHTML();
        }
    });
    imgCarrito.addEventListener('click', toggleCarrito);

    // Debugging
    console.log('Carrito cargado');
    console.log('Botones de agregar al carrito:', agregarCarritoBtns);
    agregarCarritoBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            console.log('Botón agregar al carrito clickeado:', e.target);
            agregarProducto(e);
        });
    });
});
