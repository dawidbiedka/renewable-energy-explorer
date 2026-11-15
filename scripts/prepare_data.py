import pandas as pd
import os

selected_indicators = [
    'solar_electricity_twh', 'solar_electricity_share_pct',
    'wind_electricity_twh', 'wind_electricity_share_pct',
    'hydro_electricity_twh', 'hydro_electricity_share_pct',
    'bioenergy_electricity_twh', 'bioenergy_electricity_share_pct',
    'renewables_electricity_twh', 'renewables_electricity_share_pct',
    'low_carbon_electricity_twh', 'low_carbon_electricity_share_pct'
]

file_path = os.path.join('..', 'data', 'owid_energy.csv')
print("Wczytywanie danych...")
df = pd.read_csv(file_path)

print("Filtrowanie lat...")
df = df[(df['year'] >= 2000) & (df['year'] <= 2024)]

columns_to_keep = ['country', 'iso_code', 'year'] + selected_indicators
df_filtered = df[columns_to_keep].copy()

print("Przekształcanie danych...")
df_melted = pd.melt(
    df_filtered, 
    id_vars=['country', 'iso_code', 'year'], 
    value_vars=selected_indicators,
    var_name='indicator_code', 
    value_name='value'
)

df_melted = df_melted.dropna(subset=['value'])

output_path = os.path.join('..', 'data', 'processed_data.csv')
df_melted.to_csv(output_path, index=False)

print(f"Sukces! Zapisano {len(df_melted)} wierszy.")