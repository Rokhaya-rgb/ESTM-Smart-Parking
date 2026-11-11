# Démarrer ESTM Smart Parking

Chaîne complète : **ESP32 → Wi-Fi → Mosquitto (MQTT) → écouteur Laravel → base de données → tableau de bord**.

## Ce qui doit tourner sur le PC

| Élément | Rôle | Comment le lancer |
|---|---|---|
| Mosquitto | broker MQTT (port 1883, mot de passe obligatoire) | voir ci-dessous, ou `scripts\start-parking.ps1` |
| `php artisan serve` | site web (`http://127.0.0.1:8000`) | `scripts\start-parking.ps1` |
| `php artisan mqttlisten` | reçoit les messages de l'ESP32 et met la base à jour | `scripts\start-parking.ps1` |

### Mosquitto

Lancer **avec la configuration** (sinon il n'écoute que sur le PC lui-même et l'ESP32 ne peut pas se connecter) :

```powershell
& "C:\Program Files (x86)\mosquitto\mosquitto.exe" -c "C:\Program Files (x86)\mosquitto\mosquitto.conf"
```

À éviter :
- l'option `-v` dans une fenêtre console : un clic dans la fenêtre (mode « Sélection ») fige le broker ;
- le service Windows `mosquitto` : il démarre sans cette configuration.

### Site et écouteur

```powershell
powershell -ExecutionPolicy Bypass -File scripts\start-parking.ps1
```

Les lance sans fenêtre et sans doublon.

### Démarrage automatique (optionnel, une seule fois, PowerShell administrateur)

```powershell
powershell -ExecutionPolicy Bypass -File scripts\install-autostart.ps1
```

Désactive le service Windows Mosquitto (il démarre sans la bonne configuration) et crée la tâche
« ESTM Parking Web » : à l'ouverture de session Windows, elle lance Mosquitto (avec sa configuration),
le site et l'écouteur MQTT, sans fenêtre. Mosquitto est lancé par ton compte et non par `SYSTEM`, car seul
ton compte peut lire le fichier des mots de passe.

## Côté maquette

- Le PC et l'ESP32 doivent être sur le **même Wi-Fi** (point d'accès « Kya »).
- L'adresse du PC sur ce réseau doit être celle de `mqtt_server` dans le programme de l'ESP32 (`172.20.10.10`).
- Le programme de l'ESP32 doit se connecter avec l'utilisateur et le mot de passe MQTT :
  `client.connect(mqtt_client_id, mqtt_user, mqtt_password)`.
  Un `client.connect(mqtt_client_id)` sans identifiants est refusé par le broker.

## Diagnostic rapide

| Symptôme | Cause probable |
|---|---|
| Pastille « Maquette hors ligne » | l'ESP32 n'envoie rien (éteint, mauvais Wi-Fi, ou refusé par le broker) |
| ESP32 : `rc=-2` | connexion réseau impossible : broker lancé sans configuration, pare-feu, mauvaise adresse IP |
| ESP32 : `rc=5` | identifiants MQTT refusés |
| Laravel : « unauthorized » | identifiants du `.env` (`MQTT_USERNAME`, `MQTT_PASSWORD`) différents de ceux du broker |
| Plus de photo de fond | un serveur `npm run dev` oublié (fichier `public/hot`) : l'arrêter et supprimer `public/hot`, ou lancer `npm run build` |
