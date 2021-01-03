# Nokes
> Die moderne Notizablage
## Installation
### MariaBD
Als Datenbank brauchen wir die MariaDB. Diese stellen wir über einen Docker Container bereit. Dieser wird folgendermassen installiert:
- In den `database` Ordner navigieren.
- Diese Befehle ausführen:
```
docker build -t nokesdb .
docker run -d --name nokesdb nokesdb
```
### PHP Web Hosting
Alle Dateien im `php` Ordner können in ein Hosting Ordner wie htdocs bei xampp (Apache) gepackt werden.

Die Index Page kann dann über `localhost/index.php` aufgerufen werden.