$out   = Join-Path $env:TEMP 'estm_autostart_result.txt'
$exe   = 'C:\Program Files (x86)\mosquitto\mosquitto.exe'
$conf  = 'C:\Program Files (x86)\mosquitto\mosquitto.conf'
$start = Join-Path $PSScriptRoot 'start-parking.ps1'
Remove-Item $out -ErrorAction SilentlyContinue
function Log($m) { $m | Out-File $out -Append -Encoding utf8 }

try {
    # 1) Le service Windows Mosquitto démarre sans la bonne configuration : on le désactive
    Stop-Service mosquitto -Force -ErrorAction SilentlyContinue
    Set-Service mosquitto -StartupType Disabled
    Get-Process mosquitto -ErrorAction SilentlyContinue | Stop-Process -Force
    Start-Sleep 2
    Log 'service mosquitto: desactive'

    # 2) Tâche planifiée : Mosquitto avec la bonne configuration, au démarrage de Windows, sans fenêtre
    Unregister-ScheduledTask -TaskName 'ESTM Mosquitto' -Confirm:$false -ErrorAction SilentlyContinue
    $action    = New-ScheduledTaskAction -Execute $exe -Argument ('-c "' + $conf + '"')
    $trigger   = New-ScheduledTaskTrigger -AtStartup
    $principal = New-ScheduledTaskPrincipal -UserId 'SYSTEM' -LogonType ServiceAccount -RunLevel Highest
    $settings  = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries `
                   -ExecutionTimeLimit ([TimeSpan]::Zero) -RestartCount 5 -RestartInterval (New-TimeSpan -Minutes 1) -StartWhenAvailable
    Register-ScheduledTask -TaskName 'ESTM Mosquitto' -Action $action -Trigger $trigger `
        -Principal $principal -Settings $settings -Description 'Broker MQTT du parking ESTM (config complete, ecoute reseau, mot de passe obligatoire)' | Out-Null
    Log 'tache ESTM Mosquitto: creee'

    # 3) Tâche planifiée : site + écouteur MQTT à l'ouverture de session
    Unregister-ScheduledTask -TaskName 'ESTM Parking Web' -Confirm:$false -ErrorAction SilentlyContinue
    $user      = [System.Security.Principal.WindowsIdentity]::GetCurrent().Name
    $action2   = New-ScheduledTaskAction -Execute 'powershell.exe' `
                   -Argument ('-NoProfile -ExecutionPolicy Bypass -WindowStyle Hidden -File "' + $start + '"')
    $trigger2  = New-ScheduledTaskTrigger -AtLogOn -User $user
    $principal2 = New-ScheduledTaskPrincipal -UserId $user -LogonType Interactive -RunLevel Limited
    $settings2 = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -ExecutionTimeLimit ([TimeSpan]::Zero)
    Register-ScheduledTask -TaskName 'ESTM Parking Web' -Action $action2 -Trigger $trigger2 `
        -Principal $principal2 -Settings $settings2 -Description 'Site Laravel et ecouteur MQTT du parking ESTM' | Out-Null
    Log ('tache ESTM Parking Web: creee pour ' + $user)

    # 4) Démarrage immédiat de la tâche Mosquitto
    Start-ScheduledTask -TaskName 'ESTM Mosquitto'
    Start-Sleep 5
    $listen = (Get-NetTCPConnection -LocalPort 1883 -State Listen -ErrorAction SilentlyContinue | Select-Object -ExpandProperty LocalAddress) -join ','
    Log ('mosquitto ecoute sur: ' + $listen)
    Log ('etat tache: ' + (Get-ScheduledTask -TaskName 'ESTM Mosquitto').State)
} catch {
    Log ('ERREUR: ' + $_.Exception.Message)
}
Log 'FIN'
