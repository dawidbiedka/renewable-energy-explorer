import pandas as pd

# Wczytaj dataset
df = pd.read_csv("../data/owid_energy.csv")

sources = ['solar', 'wind', 'hydro', 'bioenergy', 'renewables', 'low_carbon']

metrics = ['_twh', '_share_pct']

print("--- WYBRANE WSKAZNIKI DO APLIKACJI ---\n")

selected_columns = []
for col in df.columns:
    if any(source in col for source in sources) and any(col.endswith(metric) for metric in metrics):
        selected_columns.append(col)
        print(f"- {col}")

print(f"\nZnaleziono {len(selected_columns)} kluczowych kolumn z 130 dostepnych.")