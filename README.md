### Descripción del Proyecto

Bienvenido al repositorio de mi proyecto, una página web dedicada a un podólogo, desarrollada con WordPress y desplegada en un entorno de servidor gestionado mediante Docker Compose.

### Tecnologías Utilizadas

- **WordPress**: Plataforma de gestión de contenido (CMS) flexible y fácil de usar.
- **Docker Compose**: Herramienta para definir y gestionar aplicaciones Docker multi-contenedor.

### Configuración del Servidor

El servidor de esta aplicación está configurado utilizando el proyecto de Docker Compose proporcionado por [jersonmartinez/docker-lamp](https://github.com/jersonmartinez/docker-lamp). Este proyecto facilita la creación y gestión de un entorno LAMP (Linux, Apache, MySQL, PHP) mediante contenedores Docker.

### Instrucciones de Uso

1. Clona este repositorio a tu máquina local.
   ```bash
   git clone https://github.com/jlizancandela/David_wordpress.git
   ```

2. Accede al directorio del proyecto.
   ```bash
   cd David_wordpress
   ```

3. Inicia los contenedores con Docker Compose.
   ```bash
   docker-compose up -d
   ```
4. Carga la copia de seguridad de la base datos "wordpress (1).sql.gz" en phpmyadmin puerto (8000).

5. Visita tu aplicación en el navegador a través de la dirección local.

### Agradecimientos

Quisiera expresar mi agradecimiento a [jersonmartinez](https://github.com/jersonmartinez) por proporcionar la configuración de Docker Compose que ha facilitado la implementación y gestión del servidor para este proyecto.

¡Espero que encuentres útil y fácil de utilizar esta aplicación! Si tienes alguna pregunta o sugerencia, no dudes en abrir un problema o contribuir al proyecto.

¡Gracias por tu interés en este proyecto!
