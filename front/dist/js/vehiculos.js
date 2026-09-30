// front/dist/js/vehiculos.js
// Pide a la API todos los vehiculos y los dibuja en una tabla.

// Escapamos lo que viene de la base antes de meterlo en el HTML.
function esc(valor) {
    return String(valor).replace(/[&<>"']/g, (c) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
}

function precio(valor) {
    return 'US$ ' + Number(valor).toLocaleString('es-UY', { minimumFractionDigits: 2 });
}

async function cargarVehiculos() {
    const caja = document.getElementById('vehiculos');
    const res = await API.request('/vehiculos');

    if (res.status !== 'ok') {
        caja.innerHTML = '<p class="sin-datos">No se pudo conectar con la base de datos.</p>';
        return;
    }

    const filas = res.data.map((a) =>
        '<tr>' +
            '<td>' + (a.Nombre_completo ? esc(a.Nombre_completo) : '<i>Sin vender</i>') + '</td>' +
            '<td>' + esc(a.Marca) + '</td>' +
            '<td>' + esc(a.Modelo) + '</td>' +
            '<td class="numero">' + precio(a.Precio) + '</td>' +
        '</tr>'
    ).join('');

    caja.innerHTML =
        '<table>' +
            '<thead><tr><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th></tr></thead>' +
            '<tbody>' + filas + '</tbody>' +
        '</table>';
}

document.addEventListener('DOMContentLoaded', cargarVehiculos);
