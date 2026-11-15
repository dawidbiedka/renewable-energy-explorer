# Wymagania funkcjonalne – Renewable Energy Explorer

## Cel projektu
Aplikacja webowa do przeglądania i analizy danych o energii odnawialnej na podstawie datasetu Our World in Data (OWID).

## Główne funkcjonalności
| Funkcja | Priorytet | Opis |
|---------|-----------|------|
| Dashboard ze statystykami | Wysoki | Podsumowanie: łączna produkcja OZE, udział OZE w miksie. |
| Lista krajów i regionów | Wysoki | Tabela z krajami/regionami, wyszukiwarka. |
| Szczegóły kraju | Wysoki | Wykresy liniowe produkcji (TWh) i udziału (%) w czasie. |
| Porównywanie | Wysoki | Możliwość zestawienia 2-3 krajów/regionów na jednym wykresie. |
| Analiza źródeł energii | Wysoki | Rozbicie na słońce, wiatr, wodę, biomasę. |
| Eksport danych do CSV | Średni | Możliwość pobrania wyfiltrowanych danych. |
| Logowanie administratora | Niski | Panel do ręcznego importu danych. |

## Ograniczenia pierwszej wersji (MVP)
- **Kraje/Regiony:** Wszystkie 247 krajów i agregatów regionalnych z datasetu OWID.
- **Lata:** 2000–2024.
- **Wskaźniki:** Produkcja energii elektrycznej (TWh) oraz udział procentowy (%).
- **Technologie:** PostgreSQL, PHP 8 + PDO, HTML, CSS, JS, Chart.js.
