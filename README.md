# ggTwenty
Semestrálna práca z predmetu VAII.

TODO: pridať návod na inštaláciu 


# Inštalačný návod

## Popis aplikácie

Aplikácia je webová aplikácia vyvíjaná v rámci semestrálneho projektu.
Zdrojový kód aplikácie je dostupný na platforme **GitHub**.

---

## Požiadavky

Pre správne spustenie aplikácie je potrebné mať nainštalované:

* **Git**
* **Docker**
* **Docker Compose**
* Webový prehliadač (Chrome, Firefox, Edge, ...)

---

## Inštalácia a spustenie aplikácie

### 1. Naklonovanie projektu

Najskôr je potrebné naklonovať projekt z GitHub repozitára:

```bash
git clone <URL_GITHUB_REPOZITÁRA>
```

Následne prejdite do priečinka projektu:

```bash
cd <nazov_projektu>
```

---

### 2. Spustenie aplikácie pomocou Docker Compose

V koreňovom adresári projektu sa nachádza súbor `docker-compose.yml`.

Spustite aplikáciu príkazom:

```bash
docker-compose up -d
```

Tento príkaz:

* spustí všetky potrebné kontajnery,
* automaticky vytvorí databázu a databázové tabuľky.

---

### 3. Otvorenie aplikácie

Po úspešnom spustení aplikácie otvorte webový prehliadač a prejdite na adresu:

```
http://localhost
```

Aplikácia by mala byť pripravená na používanie.

---

## Ukončenie aplikácie

Aplikáciu je možné zastaviť príkazom:

```bash
docker-compose down
```

---

## Poznámka

V prípade zmien v zdrojovom kóde je odporúčané aplikáciu znovu zostaviť pomocou:

```bash
docker-compose up -d --build
```
