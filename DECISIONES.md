## Backend

### Trade-offs / Decisiones tomadas
1. Se utilizó el patrón **Repository** para separar la lógica de negocio dentro de cada uno de los **Services** y dejar la persistencia de datos en el **Repository**.
2. Únicamente se valida la existencia de datos y sus tipos en el **Controlador**; las validaciones de reglas de negocio se delegan a los **Services**.
3. Se creó una **Exception** particular para el caso en que no se pueda registrar información duplicada (Equipo y Partido).

### Próximos pasos / Mejoras pendientes
1. Normalizar, a través de un **helper**, las respuestas de la API.
2. Afinar la captura de **Exceptions** y crear excepciones para casos más específicos.
3. Centralizar la captura de las **Exceptions** mediante un **Middleware**.
4. Mejorar los mensajes de respuesta de los **endpoints**.
5. Revisar qué métodos necesitan comentarios y documentación.
