# Backend (Laravel) — MiniLiga Express

## Instrucciones de ejecución de proyecto terminado

**Autor:** Zuriel Díaz Agustin  
**Descripción:** API para gestionar una liga deportiva utilizando Laravel.  

## Tecnologías utilizadas
- **PHP:** 8.3.16  
- **Laravel:** 12.x  
- **Base de datos:** SQLite (entorno local y pruebas)  
- **Testing:** PHPUnit 11.5.3

## Instalación y ejecución
1. Instalar dependencias:
    ```bash
    composer install
    ```
2. Ejecutar migraciones:
    ```bash
    php artisan migrate
    ```
3. Poblar la base de datos con datos de ejemplo:
    ```bash
    php artisan db:seed --class=TeamsAndSportMatchesSeeder
    ```

## Ejecución de tests
Para correr los tests de la tabla de posiciones:
```bash
php artisan test --filter=StandingsTest
```

## Documentacion de Api
1.  La colección de Postman Mini Liga Express.postman_collection se encuentra en la carpeta docs/.
    Puedes importarla en Postman para probar todos los endpoints de la API.


## Instrucciones de ejecución de proyecto base

## Objetivo
Exponer endpoints:
- `GET /api/teams`
- `POST /api/teams` `{ name }`
- `POST /api/matches/{id}/result` `{ home_score, away_score }`
- `GET /api/standings`

## Instalación rápida (SQLite)
```bash
# Desde la raíz del repo
bash scripts/init_backend.sh

cd backend
php artisan migrate --seed
php artisan serve
```

## Migraciones sugeridas

### database/migrations/xxxx_create_teams_table.php
```php
public function up(): void {
    Schema::create('teams', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->integer('goals_for')->default(0);
        $table->integer('goals_against')->default(0);
        $table->timestamps();
    });
}
```

### database/migrations/xxxx_create_matches_table.php
```php
public function up(): void {
    Schema::create('matches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('home_team_id')->constrained('teams');
        $table->foreignId('away_team_id')->constrained('teams');
        $table->integer('home_score')->nullable();
        $table->integer('away_score')->nullable();
        $table->dateTime('played_at')->nullable();
        $table->timestamps();
    });
}
```

## Seed (ejemplo)
```php
public function run(): void {
    $teams = collect(['Dragons','Sharks','Tigers','Wolves'])
      ->map(fn($n)=>App\Models\Team::create(['name'=>$n]));

    // crea 2-3 partidos sin resultado
    App\Models\Match::create([
      'home_team_id'=>$teams[0]->id, 'away_team_id'=>$teams[1]->id
    ]);
    App\Models\Match::create([
      'home_team_id'=>$teams[2]->id, 'away_team_id'=>$teams[3]->id
    ]);
}
```

## Lógica standings (orientativa)
- `points`: W=3, D=1, L=0.
- `played`: partidos con `home_score` y `away_score` no nulos.
- Orden: `points DESC`, `goal_diff DESC`, `goals_for DESC`.

## Test mínimo (Pest o PHPUnit)
- Crea dos equipos, un partido y registra dos resultados (victoria y empate) asegurando que los puntos se calculan correctamente.
