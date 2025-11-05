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



## FrontEnd

### Trade-offs / Decisiones tomadas
1. Se utilizó el Angular más reciente (Angular 20) dado que lo realizado no requiere características demasiado avanzadas del framework. En otro caso, se podría haber usado una versión más antigua (16 o incluso 12, con las que he trabajado anteriormente).
2. Se consideraba usar **Angular Material** por ser un proyecto pequeño y por su buena integración, pero por preferencias visuales y la cantidad de componentes que ofrece **PrimeNG**, se optó por esta última. Además, su nueva integración con **TailwindCSS** representa un gran plus para personalizar componentes, algo más complicado con Angular Material. También se valoró el amplio soporte y comunidad que tiene PrimeNG.
3. Se decidió crear una carpeta que contiene las interfaces y las peticiones al backend, las cuales pueden ser utilizadas tanto en el proyecto web como en el móvil. Esto permite mantener todo centralizado. El punto más crítico se encuentra en la carpeta **shared/api/ApiServices.ts**, donde se optó por usar la función nativa de JavaScript **Fetch** para no depender de librerías externas y no estar atentos a nuevas versiones. Inicialmente se pensó en crear un mini proyecto Angular que contuviera las mismas peticiones usando **HttpClient** y estar alineado con las tecnologías del proyecto, pero dada la cantidad de APIs utilizadas, no se consideró necesario.

### Próximos pasos / Mejoras pendientes
1. Se pueden establecer **Interfaces base** de las cuales otras interfaces puedan extender, especialmente para propiedades como **id, created_at y updated_at**.
2. El punto más crítico que podría modificarse para lograr mejoras es **ApiServices**, ubicado en **shared/api/ApiServices**. Este punto es delicado ya que se consume en ambos proyectos y requiere cuidado para no romper funcionalidades existentes. Para ello, se debera agregar validaciones mas especificacas sobre los **Estatus Http** y asegurar que tanto la versión web como la móvil interpreten de forma correcta. También se deberan crear funciones propias para **Simular interceptores** que Angular proporciona por defecto. En caso necesario, podría desarrollarse un mini proyecto Angular que contenga únicamente un service encargado de las solicitudes al backend, permitiendo un manejo centralizado y consistente en todo el frontend.



## Mobile

### Trade-offs / Decisiones tomadas
1. Dado que nunca se había utilizado **Ionic**, se decidió apegarse a lo que indica la documentación. En este caso no se agregó ninguna librería externa para no complicar el pequeño desarrollo.
2. La obtención de los partidos y la actualización de los mismos se realiza dentro de un mismo componente por mayor practicidad. A cambio, se utilizó el componente **ReportResult** para mostrar las clasificaciones de los equipos.

### Próximos pasos / Mejoras pendientes
1. Dado que Ionic trabaja sobre Angular y ya contamos con un proyecto web en Angular, lo ideal sería lograr que ambos proyectos compartieran la mayor cantidad de tecnologías posible, para mantener una misma línea de trabajo y poder trasladar elementos del **Web** al **Mobile** y viceversa.
2. Revisar más a detalle el código y agregar **validaciones** y bloques **try-catch** donde sea necesario, para prevenir que el usuario realice acciones no deseadas o, en caso de un error, evitar que la aplicación se rompa.
