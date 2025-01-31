function showAlert(message) {
    alert(message);
}

// Efecto de desplazamiento suave para los enlaces de navegación
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Manejo del formulario de contacto
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el envío del formulario

    // Validación simple
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();

    if (name === "" || email === "" || message === "") {
        showAlert("Por favor, completa todos los campos.");
        return;
    }

    // Simulación de envío exitoso
    const responseDiv = document.getElementById('formResponse');
    responseDiv.style.display = 'block';
    responseDiv.innerHTML = `<div class="alert alert-success">Gracias, ${name}. Tu mensaje ha sido enviado.</div>`;

    // Limpia el formulario
    document.getElementById('contactForm').reset();

    // Animación de entrada
    responseDiv.classList.add('fade-in');
});

// Animación de entrada para las secciones
const sections = document.querySelectorAll('.section');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

sections.forEach(section => {
    observer.observe(section);
});

// Función para animar el contador numérico de estadísticas
function animarContador(idElemento, finalNumero, duracion) {
    const elemento = document.querySelector(idElemento);
    let contador = 0;
    const incremento = Math.ceil(finalNumero / (duracion / 50));

    const intervalo = setInterval(() => {
        contador += incremento;
        if (contador >= finalNumero) {
            contador = finalNumero;
            clearInterval(intervalo);
        }
        elemento.textContent = `${contador}%`;
    }, 50);
}

// Inicia los contadores cuando la página se carga
window.addEventListener('load', () => {
    animarContador('.barra:first-of-type', 70, 2000); // 70% - Empleos tecnológicos
    animarContador('.barra:last-of-type', 22, 2000); // 22% - Crecimiento proyectado

    // Animación de barras de progreso
    const barras = document.querySelectorAll('.barra');
    barras.forEach(barra => {
        const ancho = barra.style.width; // Guardar el ancho inicial
        barra.style.width = '0'; // Inicializar la barra en 0
        setTimeout(() => {
            barra.style.transition = 'width 1.5s'; // Duración de la animación
            barra.style.width = ancho; // Volver al ancho original con la animación
        }, 300); // Retardo de inicio para la animación
    });
});

// Función para cambiar el estilo del encabezado al desplazarse
const header = document.querySelector('header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Hacer que las barras se muevan y cambien de color al hacer clic
document.querySelectorAll('.barra').forEach(barra => {
    barra.addEventListener('click', () => {
        barra.style.transition = 'all 0.5s';
        barra.style.transform = 'translateX(20px)'; // Mover la barra
        barra.style.background = 'linear-gradient(135deg, #ff7b7b, #ffce62)'; // Cambiar color
        setTimeout(() => {
            barra.style.transform = 'translateX(0)'; // Volver a la posición inicial
        }, 500);
    });
});