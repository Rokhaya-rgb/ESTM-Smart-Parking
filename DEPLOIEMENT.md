# Déploiement d'ESTM Smart Parking

Deux hébergements, un seul sens de communication (VPS → site) :

```
 ESP32 ──MQTT :1883──▶ VPS  [Mosquitto] ─▶ [relais mqttlisten]
                                                  │  HTTPS POST /api/mqtt  (Bearer INGEST_API_KEY)
                                                  ▼
 Navigateurs ◀──HTTPS── Mutualisé  [site Laravel] ─▶ base MySQL
```

| Partie | Hébergement | Contenu |
|---|---|---|
| Site (tableau de bord, historique, connexion) | **Mutualisé** (PHP 8.2+, MySQL) | tout le dépôt, sans Docker |
| Temps réel | **VPS** (Docker) | `docker-compose.yml` : Mosquitto + relais |

Le VPS n'a **pas de base de données** : il ne fait que transmettre au site, seul à écrire en base. Cela évite
d'ouvrir MySQL à distance (presque toujours interdit sur un mutualisé).

## 1. Site sur le mutualisé

1. Créer une base MySQL et un utilisateur (depuis le panneau d'hébergement).
2. Envoyer le code (git, ou ZIP), puis en SSH, ou en local avant envoi si le SSH n'est pas disponible :
   `composer install --no-dev --optimize-autoloader`
   (les assets sont déjà compilés dans `public/build/`, Node n'est pas nécessaire).
3. Faire pointer le **dossier racine du domaine sur `public/`** (option « racine du document »).
   Si c'est impossible, ne jamais exposer le reste du dépôt (`.env`, `vendor`, …) : demander l'option à l'hébergeur.
4. Créer `.env` à partir de `.env.example` :
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://VOTRE-DOMAINE
   APP_KEY=            # php artisan key:generate --show
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   SESSION_DRIVER=file
   CACHE_STORE=file
   INGEST_API_KEY=     # php -r "echo bin2hex(random_bytes(32));"  (à recopier sur le VPS)
   ```
5. `php artisan migrate --force` puis `php artisan db:seed --force` (une seule fois), puis
   `php artisan config:cache && php artisan route:cache && php artisan view:cache`.
6. Vérifier : `https://VOTRE-DOMAINE/up` répond 200.

## 2. Temps réel sur le VPS

1. Installer Docker, cloner le dépôt.
2. `cp .env.vps.example .env`, puis renseigner `MQTT_PASSWORD`, `INGEST_API_KEY` (même valeur que le site),
   `MQTT_FORWARD_URL=https://VOTRE-DOMAINE/api/mqtt`, `APP_KEY`.
3. Créer le fichier de mots de passe du broker (commande en tête de `docker-compose.yml`).
4. `docker compose up -d --build`
5. Pare-feu : ouvrir **1883/TCP** uniquement.
6. Dans le programme de l'ESP32 : `mqtt_server` = IP ou nom du VPS, et connexion avec utilisateur et mot de passe MQTT.

## Vérifier la chaîne

```bash
docker compose logs -f relais            # « Connected to MQTT broker »
mosquitto_pub -h IP_VPS -u parking_estm -P '...' -t parking/total -m 3
```
Le compteur du tableau de bord passe à 3. Un message « HTTP 401 » dans les logs du relais signifie que
`INGEST_API_KEY` diffère entre le VPS et le site.

## Sécurité

- Le port 1883 n'est pas chiffré (limite de l'ESP32 simple) : utiliser un mot de passe long et propre à ce broker.
- Ne jamais committer `.env` ni `docker/mosquitto/passwd`.
- L'ancienne `APP_KEY` qui figurait dans `render.yaml` / `vercel.json` est publique : en générer une nouvelle.
- Les fichiers `render.yaml`, `fly.toml`, `railway.toml`, `vercel.json`, `Procfile` et `Dockerfile` servent à un
  déploiement tout-en-un du site seul ; ils ne sont pas utilisés dans cette architecture.
