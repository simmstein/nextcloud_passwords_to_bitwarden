# Nextcloud Passwords to Bitwarden/Vaultwarden

This project allows you to convert [Nextcloud Passwords](https://apps.nextcloud.com/apps/passwords) CSV to a [Bitwarden/Vaultwarden](https://github.com/dani-garcia/vaultwarden) JSON file.

## Installation

```sh
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
* Click on "Export" and download the archive
* Unzip the downloaded file

### On the project

```sh
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
