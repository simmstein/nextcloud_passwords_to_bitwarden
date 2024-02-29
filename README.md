# Nextcloud Passwords to Bitwarden

This project allows you to convert Nextcloud Passwords CSV to a Bitwarden JSON file.

## Installation

```
git clone https://gitnet.fr/deblan/nextcloud_passwords_to_bitwarden
composer install
```

## How to

### On Nextcloud

* Go to "Personal settings"
* Set "English (US)" as language
* Go to "Passwords"
* Click on "More"
* Click on "Backup and restore"
* Choose "Backup or export"
* Choose "Predefined CSV"
* Check "Export Passwords" and "Export Folders"
* Click on "Export"
* Unzip the download file

### On the project

```
php index.php /path/to/Folders.csv /path/to/Passwords.csv > bitwarden_passwords.json
```

### On Bitwarden/Vaultwarden

* Go to tools
* Go to "Import data"
* Choose "Bitwarden (json)" as file format
* Choose the file "bitwarden_passwords.json"
* Click on "Import data"

### Clean up datas

* Remove the downloaded archive
* Remove extracted files
* Remove bitwarden_passwords.json
