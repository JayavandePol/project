# AI Instructies & Code Requirements (gemini.md)

## 🎯 Projectdoel
Ontwikkel een webapplicatie op basis van een strikte MVC-architectuur. De applicatie moet volledige CRUD-functionaliteit (Create, Read, Update, Delete) bevatten, inclusief afhandeling voor zowel 'happy' (succesvolle) als 'unhappy' (foutieve) scenario's.

## ⚠️ Unhappy Scenario Definitie (Belangrijk!)
Een 'unhappy scenario' in dit project is **méér dan alleen formuliervalidatie** (zoals een leeg veld of foute syntax). Het gaat om fouten en conflicten op een hoger niveau (business logica). 
*Voorbeelden hiervan die de AI moet afvangen:*
* **Create:** Proberen een account aan te maken, maar het e-mailadres bestaat al in de database.
* **Update:** Proberen een record (bijv. een evenement of inschrijving) te wijzigen, maar de deadline of datum is al gepasseerd waardoor wijzigen niet meer is toegestaan.
* **Delete:** Proberen een record te verwijderen dat nog gekoppeld is aan andere actieve data (foreign-key restrictie) of waar de gebruiker geen rechten voor heeft.

## 🛠️ Tech Stack & Architectuur
* **Design Pattern:** Strict MVC (Model-View-Controller).
* **Backend:** PHP (Objectgeoriënteerd).
* **Frontend:** HTML5, CSS3 (Responsive), JavaScript.
* **Database:** Relationele database (SQL).

## 📂 Backend (PHP) Requirements
* **Structuur:** Duidelijke scheiding tussen Views, Controllers en Models.
* **Foutafhandeling:** Gebruik expliciet `Try-Catch` blokken voor error handling.
* **Codeconventies:** Volg de **PSR-12** standaard voor PHP code formattering.
* **Naamgeving:** Gebruik logische, beschrijvende en Engelse/Nederlandse (wees consistent) naamgeving voor klassen, functies en variabelen.
* **Documentatie:** Voorzie complexe logica van duidelijk en verklarend commentaar in de code.
* **Logging:** Implementeer een technisch log-systeem (bijv. fouten wegschrijven naar een logbestand of database tabel).

## 🗄️ Database (SQL) Requirements
* **Queries:** Maak effectief gebruik van `JOIN` operaties waar relaties nodig zijn.
* **Stored Procedures:** Gebruik `Stored Procedures` voor complexe of veelvoorkomende database handelingen.
* **Validatie:** Zorg dat de database op schema-niveau gevalideerd is (bijv. NOT NULL, UNIQUE constraints, correcte datatypes, foreign keys).
* **Ontwerp:** Zorg dat de code overeenkomt met het (door de student te maken) ERD en de specificatietabellen.

## 🛡️ Security & Validatie
* **Security:** Schrijf veilige code (bescherm tegen SQL Injection via Prepared Statements/PDO, XSS, CSRF).
* **Drie-laags Validatie vereist voor alle input:**
    1.  *Client-side validatie* (HTML5 attributes & JavaScript).
    2.  *Server-side validatie* (PHP filtering en validatie vóór database interactie).
    3.  *Database niveau validatie* (Constraints in de SQL tabellen).

## 🖥️ Frontend (HTML/CSS/JS) Requirements
* **Responsive Design:** De CSS moet de applicatie responsive maken voor in ieder geval Mobile en Desktop schermen (Media queries).
* **JavaScript:** JS functies moeten duidelijke namen hebben en functioneel bijdragen aan de UI/UX of client-side validatie.
* **Gebruikersfeedback (UX):** Zowel voor de 'happy' flows als de 'unhappy' flows *moeten* duidelijke en gebruiksvriendelijke meldingen aan de eindgebruiker getoond worden.

## 🔄 Functies: De CRUD Scenario's
Voor *elke* entiteit in dit project moet de volgende functionaliteit gebouwd worden, rekening houdend met BDD (Behavior-Driven Development) scenario's:

1.  **READ (Uitlezen)**
    * *Happy flow:* Data wordt correct opgehaald en getoond in de view.
    * *Unhappy flow:* Database is onbereikbaar, of de opgevraagde specifieke data bestaat niet (meer).
2.  **CREATE (Toevoegen)**
    * *Happy flow:* Gebruiker kan succesvol nieuwe data toevoegen. Succesmelding wordt getoond.
    * *Unhappy flow:* Business logica conflict (bijv. duplicate e-mailadres). Gebruiker krijgt een duidelijke foutmelding.
3.  **UPDATE (Wijzigen)**
    * *Happy flow:* Bestaande data wordt succesvol overschreven. Succesmelding.
    * *Unhappy flow:* Wijziging is niet toegestaan vanwege business regels (bijv. deadline is voorbij) of record is in de tussentijd door iemand anders verwijderd.
4.  **DELETE (Verwijderen)**
    * *Happy flow:* Record wordt veilig verwijderd. Succesmelding.
    * *Unhappy flow:* Verwijderen wordt geblokkeerd door actieve afhankelijkheden in de database.

## 🌿 Versiebeheer (Git) Instructies voor de AI
*Als je git-commando's of branch-strategieën suggereert, houd je dan aan de volgende flow:*
* Gebruik een `main` branch voor productie-ready code.
* Gebruik een `dev` branch voor actieve integratie.
* Gebruik `feature/...` branches voor het ontwikkelen van specifieke user stories.
* Commits moeten kleine, logische stappen zijn met duidelijke, beschrijvende commit messages.