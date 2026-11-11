# Lance le site Laravel et l'écouteur MQTT en arrière-plan (sans fenêtre),
# sans créer de doublon si l'un des deux tourne déjà.
# Utilisé au démarrage de la session Windows (tâche planifiée "ESTM Parking Web").

$root = Split-Path -Parent $PSScriptRoot
$php  = 'C:\php\php.exe'

function Test-PhpRunning([string]$pattern) {
    [bool](Get-CimInstance Win32_Process -Filter "name='php.exe'" |
        Where-Object { $_.CommandLine -match $pattern })
}

if (-not (Test-PhpRunning 'artisan serve|-S 127\.0\.0\.1:8000')) {
    Start-Process $php -ArgumentList 'artisan', 'serve', '--host=127.0.0.1', '--port=8000' `
        -WorkingDirectory $root -WindowStyle Hidden
}

if (-not (Test-PhpRunning 'mqttlisten')) {
    Start-Process $php -ArgumentList 'artisan', 'mqttlisten' `
        -WorkingDirectory $root -WindowStyle Hidden
}
