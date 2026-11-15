# Wymagania funkcjonalne – Renewable Energy Explorer

## Cel projektu
Aplikacja webowa do przeglądania, porównywania i analizy danych o energii odnawialnej dla wybranych krajów europejskich na podstawie datasetu Our World in Data (OWID).

## Funkcjonalności

| Funkcja | Priorytet | Opis |
|---------|-----------|------|
| Dashboard ze statystykami | Wysoki | Główne podsumowanie: łączna produkcja OZE, udział OZE w miksie, itp. |
| Lista krajów i wyszukiwarka | Wysoki | Tabela z krajami, filtrowanie po nazwie/kodzie ISO. |
| Szczegóły kraju | Wysoki | Wykresy liniowe produkcji (TWh) i udziału (%) w czasie dla danego kraju. |
| Porównywanie krajów | Wysoki | Możliwość zestawienia 2-3 krajów na jednym wykresie. |
| Analiza źródeł energii | Wysoki | Rozbicie na słońce, wiatr, wodę, biomasę. |
| Eksport danych do CSV | Średni | Możliwość pobrania wyfiltrowanych danych. |
| Logowanie administratora | Niski | Panel do ręcznego dodawania/importu nowych danych. |

## Ograniczenia pierwszej wersji (MVP)
- **Kraje:** ok. 20–30 państw europejskich (np. Polska, Niemcy, Francja, Hiszpania, Włochy, Szwecja, Norwegia, Dania, Czechy, Słowacja, Litwa, Łotwa, Estonia, itd.).
- **Lata:** 2000–2024 (mimo że dane w OWID sięgają 1700 roku, skupiamy się na współczesności).
- **Wskaźniki:** Skupiamy się na produkcji energii elektrycznej (TWh) oraz udziale procentowym (%).
- **Baza danych:** PostgreSQL.
- **Backend:** PHP 8 + PDO (bez frameworka).
- **Frontend:** HTML, CSS, JavaScript, Chart.js.
