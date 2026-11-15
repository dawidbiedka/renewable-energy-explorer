CREATE TABLE countries (
    country_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    iso_code VARCHAR(3) UNIQUE
);

CREATE TABLE indicators (
    indicator_id SERIAL PRIMARY KEY,
    indicator_code VARCHAR(100) NOT NULL UNIQUE,
    indicator_name VARCHAR(255) NOT NULL,
    unit VARCHAR(20) NOT NULL
);

CREATE TABLE data_sources (
    data_sources_id SERIAL PRIMARY KEY,
    data_name VARCHAR(255) NOT NULL,
    url VARCHAR(255),
    description TEXT
);

CREATE TABLE data_imports (
    data_imports_id SERIAL PRIMARY KEY,
    source_id INTEGER REFERENCES data_sources(data_sources_id),
    imported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_name VARCHAR(255),
    row_count INTEGER
);

CREATE TABLE energy_observations (
    energy_id SERIAL PRIMARY KEY,
    country_id INTEGER NOT NULL REFERENCES countries(country_id) ON DELETE CASCADE,
    indicator_id INTEGER NOT NULL REFERENCES indicators(indicator_id) ON DELETE CASCADE,
    import_id INTEGER REFERENCES data_imports(data_imports_id) ON DELETE SET NULL, -- Poprawione!
    year INTEGER NOT NULL,
    value NUMERIC(15, 4),
    UNIQUE(country_id, indicator_id, year) 
);

CREATE INDEX idx_obs_country ON energy_observations(country_id);
CREATE INDEX idx_obs_indicator ON energy_observations(indicator_id);
CREATE INDEX idx_obs_year ON energy_observations(year);