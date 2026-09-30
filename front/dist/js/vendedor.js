// front/dist/js/vendedor.js
// Pide a la API el vendedor con id 1 y muestra su nombre en el centro.

async function cargarVendedor() {
    const titulo = document.getElementById('vendedor');
    const res = await API.request('/vendedores/1');

    if (res.status !== 'ok') {
        titulo.textContent = 'No se encontro el vendedor';
        return;
    }

    // textContent ya escapa lo que viene de la base.
    titulo.textContent = res.data.Nombre_completo;
}

document.addEventListener('DOMContentLoaded', cargarVendedor);
