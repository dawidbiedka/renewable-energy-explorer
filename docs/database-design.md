# Projekt bazy danych – Renewable Energy Explorer

## Schemat relacyjny (5 tabel)

### 1. `countries` (Kraje)
Przechowuje listę krajów, dla których mamy dane.
- `id` (PK, serial)
- `name` (varchar, unikalna) – np. "Poland" (z kolumny `country`)
- `iso_code` (varchar(3), unikalny) – np. "POL" (z kolumny `iso_code`)

### 2. `indicators` (Wskaźniki)
Słownik wskaźników energetycznych (z kolumn datasetu).
- `id` (PK, serial)
- `code` (varchar, unikalny) – np. "solar_electricity_twh" (nazwa kolumny z OWID)
- `name` (varchar) – np. "Solar Electricity Generation"
- `unit` (varchar) – np. "TWh" lub "%"

### 3. `energy_observations` (Tabela faktów - najważniejsza)
Przechowuje konkretne wartości dla danego kraju, roku i wskaźnika.
- `id` (PK, serial)
- `country_id` (FK → `countries.id`)
- `indicator_id` (FK → `indicators.id`)
- `import_id` (FK → `data_imports.id`)
- `year` (integer) – np. 2022 (z kolumny `year`)
- `value` (numeric) – konkretna wartość liczbowa (np. 12.5)

### 4. `data_sources` (Źródła danych)
Informacje o tym, skąd pochodzą dane.
- `id` (PK, serial)
- `name` (varchar) – np. "Our World in Data - Energy Dataset"
- `url` (varchar) – link do źródła
- `description` (text)

### 5. `data_imports` (Historia importów)
Śledzenie, kiedy i z jakiego pliku zaimportowano dane.
- `id` (PK, serial)
- `source_id` (FK → `data_sources.id`)
- `imported_at` (timestamp)
- `file_name` (varchar)
- `row_count` (integer)

## Relacje
- `countries` (1) —— (N) `energy_observations`
- `indicators` (1) —— (N) `energy_observations`
- `data_imports` (1) —— (N) `energy_observations`
- `data_sources` (1) —— (N) `data_imports`
