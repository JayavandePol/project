# Unhappy Scenarios - Project JayavandePol

Dit document beschrijft de "unhappy" scenario's die zijn geïdentificeerd en afgehandeld in de applicatie om robuustheid en een goede gebruikerservaring te garanderen.

## Algemene Validatie (Alle Formulieren)

### 1. Ontbrekende Verplichte Velden
- **Scenario**: Gebruiker probeert een formulier te verzenden zonder verplichte velden in te vullen.
- **Afhandeling**: 
  - **Client-side**: HTML5 `required` attributen en JavaScript validatie voorkomen verzending en geven een waarschuwing.
  - **Server-side**: `FormRequest` klassen valideren de aanwezigheid. Gebruiker wordt teruggestuurd met foutmeldingen per veld.

### 2. Ongeldige Data Formaten
- **Scenario**: Gebruiker voert tekst in waar een getal wordt verwacht, of een ongeldig e-mailadres.
- **Afhandeling**: `FormRequest` validatie regels (`email`, `numeric`, `integer`) vangen dit af met specifieke Nederlandse foutmeldingen.

---

## Klanten (Customers)

### 1. Dubbel E-mailadres
- **Scenario**: Gebruiker probeert een nieuwe klant aan te maken met een e-mailadres dat al bestaat, of wijzigt een bestaande naar een bezet adres.
- **Afhandeling**: `unique:klanten,email` regel in `StoreKlantRequest` en `UpdateKlantRequest`. Bij updates wordt de huidige ID genegeerd.

### 2. Ongeldige Postcode
- **Scenario**: Gebruiker voert een postcode in die niet voldoet aan het Nederlandse formaat (1234 AB).
- **Afhandeling**: Regex validatie (`/^[0-9]{4}\s?[A-Z]{2}$/i`) in zowel JavaScript als `FormRequest`.

---

## Reizen (Trips)

### 1. Einddatum vóór Begindatum
- **Scenario**: Gebruiker voert een einddatum in die chronologisch voor de begindatum ligt.
- **Afhandeling**: 
  - **Client-side**: JavaScript vergelijkt de datums voor verzending.
  - **Server-side**: `after_or_equal:start_date` regel in de Request klassen.

### 2. Negatieve Prijs of Deelnemers
- **Scenario**: Gebruiker voert een negatief getal in voor prijs of maximaal aantal deelnemers.
- **Afhandeling**: `min:0` (prijs) en `min:1` (deelnemers) validatie regels.

---

## Accommodaties

### 1. Rating Buiten Bereik
- **Scenario**: Gebruiker probeert handmatig een rating buiten 1-5 door te geven via de browser console of een tool.
- **Afhandeling**: `between:1,5` regel in de Request klassen en een gecontroleerd select-veld in de UI.

---

## Boekingen (Bookings)

### 1. Ongeldig Aantal Personen
- **Scenario**: Gebruiker voert 0 of minder personen in voor een boeking.
- **Afhandeling**: `min:1` validatie in zowel JavaScript als `FormRequest`.

### 2. Conflict met Verwijderde Entiteiten (Database Integriteit)
- **Scenario**: Gebruiker probeert een boeking te maken voor een klant, reis of accommodatie die net is verwijderd door een andere beheerder.
- **Afhandeling**: Foreign Key constraints in de database en `exists:table,id` validatie regels in de Request klassen vangen dit af. Stored Procedures genereren een fout die door de Controller in een `try-catch` blok wordt opgevangen.

---

## Database & Stored Procedures

### 1. Stored Procedure Runtime Fout
- **Scenario**: Er treedt een onverwachte databasefout op tijdens de uitvoering van een Stored Procedure (bijv. deadlock of verbindingsverlies).
- **Afhandeling**: Alle controller acties zijn ingepakt in `try-catch` blokken. Fouten worden gelogd via `Log::error()` en de gebruiker krijgt een generieke, gebruiksvriendelijke foutmelding te zien via een `session()->with('error', ...)`.
