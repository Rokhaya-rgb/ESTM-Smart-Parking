# À lancer UNE FOIS dans un PowerShell administrateur.
#   - désactive le service Windows "mosquitto" (il démarre sans la bonne configuration)
#   - supprime l'ancienne tâche "ESTM Mosquitto" (compte SYSTEM : ne peut pas lire le fichier des mots de passe)
#   - crée la tâche "ESTM Parking Web" : à l'ouverture de session, lance Mosquitto (avec sa configuration),
#     le site Laravel et l'écouteur MQTT, sans fenêtre (voir start-parking.ps1)

$out   = Join-Path $env:TEMP 'estm_autostart_result.txt'
$start = Join-Path $PSScriptRoot 'start-parking.ps1'
Remove-Item $out -ErrorAction SilentlyContinue
function Log($m) { $m | Out-File $out -Append -Encoding utf8 }

try {
    Stop-Service mosquitto -Force -ErrorAction SilentlyContinue
    Set-Service mosquitto -StartupType Disabled
    Log 'service mosquitto: desactive'

    Unregister-ScheduledTask -TaskName 'ESTM Mosquitto' -Confirm:$false -ErrorAction SilentlyContinue
    Log 'ancienne tache ESTM Mosquitto: supprimee'

    Unregister-ScheduledTask -TaskName 'ESTM Parking Web' -Confirm:$false -ErrorAction SilentlyContinue
    $user       = [System.Security.Principal.WindowsIdentity]::GetCurrent().Name
    $action     = New-ScheduledTaskAction -Execute 'powershell.exe' `
                    -Argument ('-NoProfile -ExecutionPolicy Bypass -WindowStyle Hidden -File "' + $start + '"')
    $trigger    = New-ScheduledTaskTrigger -AtLogOn -User $user
    $principal  = New-ScheduledTaskPrincipal -UserId $user -LogonType Interactive -RunLevel Limited
    $settings   = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -ExecutionTimeLimit ([TimeSpan]::Zero)
    Register-ScheduledTask -TaskName 'ESTM Parking Web' -Action $action -Trigger $trigger `
        -Principal $principal -Settings $settings `
        -Description 'Mosquitto, site Laravel et ecouteur MQTT du parking ESTM' | Out-Null
    Log ('tache ESTM Parking Web: creee pour ' + $user)
} catch {
    Log ('ERREUR: ' + $_.Exception.Message)
}
Log 'FIN'
