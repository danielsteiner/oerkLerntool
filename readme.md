# Fragenkatalog

Fragenkatalog ist ein Projekt, das aus der Not heraus entstanden ist. Es ermöglicht Mitgliedern vom Österreichischen Roten Kreuz, sich auf den NFS Einstiegstest vorzubereiten. Dieser Test ist auch von angehenden Lehrsanitätern oder Praxisanleitern (PAL) zu absolvieren. Leider gibt es seit Q1/2019 keine offizielle Möglichkeit, diesen Fragenkatalog online zu lernen. 

## Installation

Dieses Projekt basiert auf [Laravel 6.0](https://laravel.com/docs/6.x/). Um eine eigene Instanz laufen zu lassen, müssen die Anforderungen von Laravel gegeben sein. Um die erforderlichen Abhängigkeiten zu installieren, gib in der Konsole deines Servers

```bash
composer install
```

ein. Composer installiert daraufhin alle erforderlichen Pakete. 

## First Use
zu allererst müssen die Fragen des Fragenkatalogs importiert werden. Dies geht mit dem artisan command 
```php
questions:parse {filename}
```
wobei hier der ganze Dateiname gegeben sein muss. Die Dateien werden im Ordner /storage/app/ erwartet. 

Anschließend sollte noch der Befehl 
```php
questions:fix
```
ausgeführt werden um die Fragen zu fixen (Umlaute, linebreaks, etc.)

## Contributing
Pull requests sind gerne gesehen. Für größere Änderungen, öffne bitte vorab ein Issue in dem über die Änderungen diskutiert werden kann. 
Bei kleineren Änderungen kannst du den Pull Request einfach erstellen & ich schau mir die Änderungen an. 

## License
[MIT](https://choosealicense.com/licenses/mit/)
