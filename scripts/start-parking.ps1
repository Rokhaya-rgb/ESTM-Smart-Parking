# Lance Mosquitto, le site Laravel et l'écouteur MQTT en arrière-plan (sans fenêtre),
# sans créer de doublon si l'un d'eux tourne déjà.
# Utilisé à l'ouverture de session Windows (tâche planifiée "ESTM Parking Web").
# Mosquitto est lancé par l'utilisateur courant : lui seul peut lire le fichier des mots de passe.

$root = Split-Path -Parent $PSScriptRoot
$php  = 'C:\php\php.exe'
$mosq = 'C:\Program Files (x86)\mosquitto\mosquitto.exe'
$conf = 'C:\Program Files (x86)\mosquitto\mosquitto.conf'

function Test-PhpRunning([string]$pattern) {
    [bool](Get-CimInstance Win32_Process -Filter "name='php.exe'" |
        Where-Object { $_.CommandLine -match $pattern })
}

# 1) Broker MQTT (avec la configuration : écoute réseau + mot de passe obligatoire)
if (-not (Get-Process mosquitto -ErrorAction SilentlyContinue)) {
    Start-Process $mosq -ArgumentList '-c', ('"' + $conf + '"') -WindowStyle Hidden
    Start-Sleep -Seconds 3
}

# 2) Site web
if (-not (Test-PhpRunning 'artisan serve|-S 127\.0\.0\.1:8000')) {
    Start-Process $php -ArgumentList 'artisan', 'serve', '--host=127.0.0.1', '--port=8000' `
        -WorkingDirectory $root -WindowStyle Hidden
}

# 3) Écouteur MQTT -> base de données
if (-not (Test-PhpRunning 'mqttlisten')) {
    Start-Process $php -ArgumentList 'artisan', 'mqttlisten' `
        -WorkingDirectory $root -WindowStyle Hidden
}

# 4) Simulation des places sans capteur réel (tourne en continu, un passage toutes les 10 s)
if (-not (Test-PhpRunning 'parking:simulate')) {
    Start-Process $php -ArgumentList 'artisan', 'parking:simulate', '--loop' `
        -WorkingDirectory $root -WindowStyle Hidden
}
