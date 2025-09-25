<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripleJ - Gestión de Horas de Alfabetización</title>
    <link rel="stylesheet" href="css/landingpage.css">

    <style>
        .nav-links-f {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.5s ease;
            list-style: none;
        }
        
        .nav-links-f.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-links-f.hidden {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="container">
            <a href="/" class="logo">   TripleJ</a>
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#usuarios">Usuarios</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <li class="nav-links-f hidden"><a href="#ini" class="login-btn">Iniciar Sesión</a></li>
        </nav>
    </header>


    <!-- bnt log transition -->
    <div class="mpage" id="ini">
        <div class="cta-buttons-f">
            <div>
                <h2>Iniciar Sesión</h2>
                <div class="sinicio">
                    <a href="/teacher" class="btn-primary">Maestro</a> <br> <br>
                </div>
                <div class="sinicio">
                    <a href="/student" class="btn-primary">Estudiante</a> <br> <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <div class="container">
            <div class="hero-content fade-in">
                <h1>Gestión Inteligente de Horas de Alfabetización</h1>
            </div>
            <p>Plataforma segura y eficiente para el registro y seguimiento de horas de servicio social. Diseñada específicamente para instituciones educativas que valoran la precisión y la facilidad de uso.</p>
            
    </section>

    <!-- User Types Section -->
    <section class="user-types" id="usuarios">
        <div class="container">
            <h2 class="section-title">Diseñado para Cada Usuario</h2>
            <div class="user-grid">
                <div class="user-card fade-in">
                    <div class="user-icon">👨‍🎓</div>
                    <h3>Estudiantes</h3>
                    <p>Registra tus horas de servicio social de forma sencilla y visualiza tu progreso en tiempo real con estadísticas detalladas.</p>
                </div>
                <div class="user-card fade-in">
                    <div class="user-icon">👨‍💼</div>
                    <h3>Encargados</h3>
                    <p>Supervisa y gestiona todas las actividades de alfabetización con herramientas administrativas completas y reportes detallados.</p>
                </div>
                <div class="user-card fade-in">
                    <div class="user-icon">👩‍🏫</div>
                    <h3>Profesores</h3>
                    <p>Accede a información precisa sobre el desempeño de tus estudiantes y facilita el proceso de evaluación.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
        <div class="container">
            <div class="about-content">
                <div class="about-text fade-in">
                    <h2>Solución Personalizada para tu Institución</h2>
                    <p>Desarrollamos cada implementación de manera específica para las necesidades únicas de tu colegio, garantizando una integración perfecta con tus procesos existentes.</p>
                    <ul class="features-list">
                        <li>Sistema cerrado y seguro</li>
                        <li>Estadísticas precisas en tiempo real</li>
                        <li>Interfaz intuitiva y fácil de usar</li>
                        <li>Personalización completa</li>
                        <li>Soporte técnico dedicado</li>
                        <li>Reportes detallados</li>
                    </ul>
                </div>
                <div class="about-visual fade-in">
                    📊
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contacto">
        <div class="container">
            <div class="contact-content">
                <h2 class="section-title">¿Listo para Transformar tu Gestión?</h2>
                <p>Contáctanos para conocer cómo TripleJ puede adaptarse perfectamente a las necesidades de tu institución.</p>
                <form class="contact-form" onsubmit="submitForm(event)">
                    <div class="form-group">
                        <label for="institucion">Nombre de la Institución</label>
                        <input type="text" id="institucion" name="institucion" required>
                    </div>
                    <div class="form-group">
                        <label for="contacto">Persona de Contacto</label>
                        <input type="text" id="contacto" name="contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos sobre las necesidades específicas de tu institución..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>TripleJ</h3>
                    <p>Transformando la gestión educativa a través de la tecnología.</p>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p>triplej.info@gmail.com</p>
                    <p>+57 310 594-1006</p>
                    <p>Itagüí, Colombia</p>
                </div>
                <div class="footer-section">
                    <h3>Servicios</h3>
                    <a href="#">Implementación Personalizada</a>
                    <a href="#">Soporte Técnico</a>
                    <a href="#">Capacitación</a>
                </div>
            </div>
            <p>&copy; 2025 TripleJ. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="modal"></div>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = 'none';
            }
        });

        // Mostrar botón de login al hacer scroll
        document.addEventListener('DOMContentLoaded', () => {
            const mpageSection = document.querySelector('.mpage');
            const loginBtn = document.querySelector('.nav-links-f');

            function toggleLoginVisibility() {
                const mpageBottom = mpageSection.offsetTop + mpageSection.offsetHeight;
                const scrollY = window.scrollY;
                if (scrollY > mpageBottom) {
                    loginBtn.classList.remove('hidden');
                    loginBtn.classList.add('visible');
                } else {
                    loginBtn.classList.remove('visible');
                    loginBtn.classList.add('hidden');
                }
            }

            window.addEventListener('scroll', toggleLoginVisibility);
            toggleLoginVisibility();
        });

        // Form submission
        function submitForm(e) {
            e.preventDefault();
            alert('¡Gracias por tu interés! Nos pondremos en contacto contigo pronto.');
        }

        // Modal
        window.addEventListener('click', (e) => {
            const modal = document.getElementById('loginModal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>