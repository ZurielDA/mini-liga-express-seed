# Web (Angular) — MiniLiga Express


## Instrucciones de ejecución de proyecto terminado

**Autor:** Zuriel Díaz Agustin  
**Descripción:** Aplicación frontend para gestionar una liga deportiva. Se conecta a la API desarrollada en Laravel.

## Tecnologías utilizadas
- **Node.js:** 22.12  
- **Gestor de paquetes:** npm  
- **Angular:** 20.3.0  
- **TypeScript:** 5.9.2  
- **Primeng:** 20.3.0",
- **TailwindCSS:** 4.1.16 

## Instalación y ejecución

## Instalación y ejecución
1. Instalar dependencias:
    ```bash
    npm install
    ```
2. Ejecutar proyecto:
    ```bash
    ng serve
    ```



## Objetivo
Dos pestañas:
1) **Equipos**: listado + alta.
2) **Clasificación**: tabla desde `GET /api/standings`.

## Instalación
```bash
bash ../scripts/init_web.sh
npm start
```

## API Service (ejemplo)
Crea `src/app/services/api.service.ts`:
```ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class ApiService {
  private base = environment.API_URL;
  constructor(private http: HttpClient) {}
  getTeams() { return this.http.get<any[]>(`${this.base}/api/teams`); }
  createTeam(payload: { name: string }) { return this.http.post(`${this.base}/api/teams`, payload); }
  getStandings() { return this.http.get<any[]>(`${this.base}/api/standings`); }
}
```

## UI mínima
- `TeamsComponent`: formulario reactivo `{ name }` y tabla.
- `StandingsComponent`: tabla con `team`, `played`, `goals_for`, `goals_against`, `goal_diff`, `points`.
