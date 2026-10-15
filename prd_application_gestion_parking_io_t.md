# PRD – Système intelligent de gestion de parking (IoT)

## Version
0.1 – 24/06/2025

## Auteur
Équipe projet ESTM (Licence RT)

## Parties prenantes
- **Équipe projet** (développeurs & concepteurs)
- **Direction de l’ESTM** (commanditaire)
- **Service Sécurité / Parking** (opérationnel)
- **Utilisateurs finaux** : personnel, enseignants, étudiants motorisés

## Contexte
Le parking de l’ESTM dispose d’un nombre limité de places et ne possède pas de système automatisé pour connaître le taux d’occupation ni réguler l’accès. Conséquences : perte de temps, embouteillages, frustration des usagers.

## Problème à résoudre
Comment offrir une visibilité _temps réel_ sur l’occupation des places et automatiser l’ouverture de la barrière, tout en restant simple à déployer et à maintenir par une petite équipe ?

## Objectifs produit
1. **Informer** en temps réel des places libres/occupées via une interface web responsive.
2. **Automatiser** l’accès : ouverture de la porte/barrière seulement s’il reste une place libre.
3. **Tracer** les états de chaque place pour un suivi historique.
4. **Minimiser** la charge de développement en restant 100 % Laravel (Livewire v3).

## Indicateurs de succès (KPIs)
| KPI | Cible |
|-----|-------|
| Temps moyen de recherche de place | ≤ 30 s |
| Taux de tentatives d’entrée sans place libre | < 5 % |
| Disponibilité de l’interface web | ≥ 99 % |
| Taux d’erreurs ESP32→API | < 1 % |

## Personas
- **Awa – Étudiante** : consulte le parking sur mobile avant d’arriver.
- **M. Faye – Enseignant** : a un badge d’accès automatique, veut gagner du temps.
- **Garde de sécurité** : supervise via un écran Livewire, force manuellement si besoin.

## Fonctionnalités clés
| ID | Fonctionnalité | Priorité |
|----|----------------|----------|
| F1 | Tableau de bord temps réel des places | Must |
| F2 | Authentification (login, mot de passe, photo) | Must |
| F3 | Notification WebSocket lorsqu’un slot change d’état | Should |
| F4 | Historique des changements d’état (slot_events) | Must |
| F5 | Interface admin CRUD pour les places | Should |
| F6 | Support mobile (PWA) | Could |
| F7 | Statistiques d’occupation hebdomadaire | Could |

## Hors‑périmètre (v1)
- Reconnaissance automatique de plaque
- Paiement / tarification
- Application native iOS/Android

## Architecture technique
- **Backend** : Laravel 11 (API REST + Livewire v3)
- **Base de données** : SQLite (fichier WAL) → migration MySQL possible
- **Temps réel** : Livewire Polling (5 s) → Reverb WebSockets si charge élevée
- **Hardware** : ESP32 + capteur ultrasons par slot, requêtes HTTP `POST /api/slots/{slot}`

## Modèle de données (v1)
- **users** (first_name, last_name, email, password, photo_path)
- **parking_slots** (slot_code, status, last_detection)
- **slot_events** (slot_id, status_before, status_after, detected_at, source)

## Flux utilisateur majeur
1. L’ESP32 détecte un changement, appelle `POST /api/slots/A-01`.
2. L’API met à jour `parking_slots.status`, crée un `slot_event`, déclenche l’événement `SlotUpdated`.
3. Livewire reçoit le broadcast; le tableau de bord se rafraîchit instantanément.
4. Si un utilisateur tente d’entrer et qu’`available_slots > 0`, la barrière s’ouvre.

## Contraintes & Risques
- **Verrous SQLite** sous forte écriture → activer WAL & `busy_timeout`.
- **Fiabilité réseau ESP32** : prévoir un watchdog et un timeout de détection.
- **Sécurité** : limiter l’API ESP32 par `throttle` & clé secrète.

## Dépendances
- Livraison maquette ESP32 + capteurs
- VPS ou serveur local avec PHP 8.3 & Node 20 pour Reverb (future)

## Roadmap (indicative)
| Sprint | Livrable | Durée |
|--------|----------|-------|
| S1 | Setup Laravel, migrations, seed 20 slots | 1 semaine |
| S2 | API ESP32 + tests Postman | 1 semaine |
| S3 | UI Livewire (tableau de bord + auth) | 2 semaines |
| S4 | Intégration ESP32 → démo temps réel | 1 semaine |
| S5 | Tests, tuning WAL, KPIs | 1 semaine |

## Questions ouvertes
- Nombre exact de slots à couvrir ?
- Fréquence de détection (ms) tolérable vs charge réseau ?
- Besoin réel de WebSockets dès le MVP ?

---
**Fin du PRD v0.1 — à discuter et itérer.**

