import pandas as pd
import psycopg2
from psycopg2.extras import execute_values
import os

DB_HOST = 'localhost'
DB_NAME = 'renewable_energy_db'
DB_USER = 'postgres'
DB_PASSWORD = 'admin'

print("Wczytywanie przetworzonych danych...")
file_path = os.path.join('..', 'data', "C:/Users/dawid/renewable-energy-explorer/data/processed_data.csv")
df = pd.read_csv(file_path)

INDICATOR_MAP = {
    'solar_electricity_twh': ('Solar Electricity', 'TWh'),
    'solar_electricity_share_pct': ('Solar Electricity Share', '%'),
    'wind_electricity_twh': ('Wind Electricity', 'TWh'),
    'wind_electricity_share_pct': ('Wind Electricity Share', '%'),
    'hydro_electricity_twh': ('Hydro Electricity', 'TWh'),
    'hydro_electricity_share_pct': ('Hydro Electricity Share', '%'),
    'bioenergy_electricity_twh': ('Bioenergy Electricity', 'TWh'),
    'bioenergy_electricity_share_pct': ('Bioenergy Electricity Share', '%'),
    'renewables_electricity_twh': ('Renewables Electricity', 'TWh'),
    'renewables_electricity_share_pct': ('Renewables Electricity Share', '%'),
    'low_carbon_electricity_twh': ('Low Carbon Electricity', 'TWh'),
    'low_carbon_electricity_share_pct': ('Low Carbon Electricity Share', '%')
}

try:
    print("Laczenie z baza danych...")
    conn = psycopg2.connect(
        host=DB_HOST, database=DB_NAME, user=DB_USER, password=DB_PASSWORD
    )
    cur = conn.cursor()

    cur.execute("""
        INSERT INTO data_sources (data_name, url) 
        VALUES ('Our World in Data - Energy', 'https://ourworldindata.org/energy')
        ON CONFLICT DO NOTHING RETURNING data_sources_id;
    """)
    source_id = cur.fetchone()
    if not source_id:
        cur.execute("SELECT data_sources_id FROM data_sources WHERE data_name = 'Our World in Data - Energy';")
        source_id = cur.fetchone()[0]
    else:
        source_id = source_id[0]

    # 2. Import
    cur.execute("""
        INSERT INTO data_imports (source_id, file_name, row_count) 
        VALUES (%s, 'processed_data.csv', %s) RETURNING data_imports_id;
    """, (source_id, len(df)))
    import_id = cur.fetchone()[0]

    # 3. Kraje
    print("Dodawanie krajow...")
    countries_df = df[['country', 'iso_code']].drop_duplicates(subset=['country'])
    countries_data = []
    for _, row in countries_df.iterrows():
        iso = None if pd.isna(row['iso_code']) else row['iso_code']
        countries_data.append((row['country'], iso))
        
    execute_values(cur, """
        INSERT INTO countries (name, iso_code) VALUES %s
        ON CONFLICT (name) DO NOTHING;
    """, countries_data)

    cur.execute("SELECT name, country_id FROM countries;")
    country_map = {name: cid for name, cid in cur.fetchall()}

    # 4. Wskaźniki
    print("Dodawanie wskaźników...")
    indicators_data = []
    for code, (name, unit) in INDICATOR_MAP.items():
        indicators_data.append((code, name, unit))
        
    execute_values(cur, """
        INSERT INTO indicators (indicator_code, indicator_name, unit) VALUES %s
        ON CONFLICT (indicator_code) DO NOTHING;
    """, indicators_data)

    cur.execute("SELECT indicator_code, indicator_id FROM indicators;")
    indicator_map = {code: iid for code, iid in cur.fetchall()}

    # 5. Obserwacje
    print("Dodawanie obserwacji (to moze chwile potrwac)...")
    observations_data = []
    for _, row in df.iterrows():
        country_id = country_map.get(row['country'])
        indicator_id = indicator_map.get(row['indicator_code'])
        
        if country_id and indicator_id:
            observations_data.append((
                country_id, indicator_id, import_id, int(row['year']), float(row['value'])
            ))

    # Batch insert
    execute_values(cur, """
        INSERT INTO energy_observations (country_id, indicator_id, import_id, year, value) 
        VALUES %s
        ON CONFLICT (country_id, indicator_id, year) DO NOTHING;
    """, observations_data)

    conn.commit()
    print(f"Sukces! Wgrano {len(observations_data)} obserwacji do bazy.")

except Exception as e:
    print(f"Wystapil blad: {e}")
    if 'conn' in locals():
        conn.rollback()
finally:
    if 'cur' in locals():
        cur.close()
    if 'conn' in locals():
        conn.close()