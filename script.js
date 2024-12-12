// Cargar usuarios registrados desde localStorage (si existen)
let usuariosRegistrados = JSON.parse(localStorage.getItem('usuariosRegistrados')) || [];

// Función para mostrar la página de Login o Principal
function mostrarPagina(pagina) {
    // Ocultar todas las páginas
    document.querySelectorAll('.page').forEach(function(page) {
        page.classList.add('hidden');
    });

    // Mostrar la página seleccionada
    document.getElementById(pagina).classList.remove('hidden');

    // Limpiar los formularios cuando se cambia de página
    if (pagina === 'login') {
        limpiarFormulario('login-form');
    } else if (pagina === 'registro') {
        limpiarFormulario('registro-form');
    } else if (pagina === 'principal') {
        limpiarFormulario('solicitud-form');
    }
}

// Al cargar la página, mostrar el Login por defecto
window.onload = function() {
    mostrarPagina('login'); // Asegura que solo se vea el Login al cargar la página
};

// Función para limpiar los formularios después de cada acción
function limpiarFormulario(formularioId) {
    const formulario = document.getElementById(formularioId);
    formulario.reset();
}

// Función para manejar el Login (verificación de usuario)
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    // Obtener los datos del formulario
    const username = document.getElementById('username').value.trim().toLowerCase(); // Convertir a minúsculas
    const password = document.getElementById('password').value;

    // Buscar el usuario en el array de usuarios registrados
    let usuarioEncontrado = usuariosRegistrados.find(usuario => usuario.username === username && usuario.password === password);

    if (usuarioEncontrado) {
        // Si las credenciales son correctas, mostrar la página principal
        alert("¡Bienvenido " + usuarioEncontrado.username + "!");
        mostrarPagina('principal');
    } else {
        // Si las credenciales son incorrectas, mostrar un mensaje de error
        alert('Usuario o contraseña incorrectos');
    }
});

// Función para manejar el Registro de un nuevo usuario
document.getElementById('registro-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    // Obtener los datos del formulario
    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const newPassword = document.getElementById('new-password').value.trim();

    // Crear un nombre de usuario (combinando primer nombre y primer apellido)
    const username = `${firstName.toLowerCase()}${lastName.toLowerCase()}`; // Convertir a minúsculas para evitar problemas

    // Verificar si el nombre de usuario ya está registrado
    let usuarioExistente = usuariosRegistrados.find(usuario => usuario.username === username);

    if (usuarioExistente) {
        alert('El nombre de usuario ya está registrado, elige otro.');
    } else {
        // Registrar el nuevo usuario
        usuariosRegistrados.push({
            username: username,
            password: newPassword
        });

        // Guardar usuarios en localStorage
        localStorage.setItem('usuariosRegistrados', JSON.stringify(usuariosRegistrados));

        alert('Usuario registrado correctamente. Ahora puedes iniciar sesión.');
        mostrarPagina('login'); // Regresar a la página de login
    }
});

// Función para manejar las solicitudes
document.getElementById('solicitud-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    // Obtener los datos de la solicitud
    const solicitud = document.getElementById('solicitud').value.trim();
    const urgencia = document.getElementById('urgencia').value;
    const respuestaPdf = document.getElementById('respuesta-pdf').files[0];

    // Verificar si el archivo es un PDF (si se adjunta uno)
    if (respuestaPdf && respuestaPdf.type !== 'application/pdf') {
        alert('El archivo debe ser un PDF.');
        return;
    }

    // Mostrar la información de la solicitud (para demostrar la acción)
    alert('Solicitud enviada\nNivel de urgencia: ' + urgencia + '\nDescripción: ' + solicitud +
        (respuestaPdf ? '\nArchivo adjunto: ' + respuestaPdf.name : ''));

    // Limpiar el formulario de solicitud
    limpiarFormulario('solicitud-form');
});

// Función para cargar solicitudes anteriores
function verSolicitudes() {
    fetch('obtener_solicitudes.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('solicitudes-container');
            container.innerHTML = ''; // Limpiar solicitudes anteriores

            if (data.length === 0) {
                container.innerHTML = '<p>No hay solicitudes anteriores.</p>';
            } else {
                const list = document.createElement('ul');
                data.forEach(solicitud => {
                    const item = document.createElement('li');
                    item.textContent = `Descripción: ${solicitud.descripcion}, Urgencia: ${solicitud.urgencia}` +
                        (solicitud.archivo ? `, Archivo adjunto: ${solicitud.archivo}` : '');
                    list.appendChild(item);
                });
                container.appendChild(list);
            }
        })
        .catch(error => {
            console.error('Error al cargar las solicitudes:', error);
            alert('Hubo un error al cargar las solicitudes.');
        });
}