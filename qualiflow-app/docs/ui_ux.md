# Note UI/UX — Gestiva

## Principi

Gestiva è pensata per PMI dell'automotive, con utenti dall'età media medio-alta e poca dimestichezza con software complessi. Le scelte di interfaccia privilegiano **chiarezza e leggibilità** rispetto all'effetto:

- **Leggibilità prima di tutto**: testo ad alto contrasto, dimensioni generose, nessuna informazione affidata al solo colore.
- **Stato sempre triplo**: colore + testo + icona (es. badge "Scaduto" rosso con pallino), così l'informazione resta accessibile anche a chi distingue male i colori.
- **Movimento sobrio e mirato**: i numeri salgono, gli anelli e le barre si disegnano una sola volta al caricamento. Nessuna animazione in loop. Tutto rispetta `prefers-reduced-motion`.
- **Un flusso, non un labirinto**: ogni area ha una pagina elenco e, dove serve, una pagina di dettaglio con il ciclo di vita ben visibile (stepper).

## Sistema visivo

- **Palette "blueprint/precisione"**: sfondo chiaro `#f4f6fb`, superfici bianche, inchiostro `#10182a`, primario indaco `#3046c8`, accento teal. Scala stati: verde (ok), ambra (attenzione), rosso (critico), ardesia (neutro).
- **Sidebar** in grafite/navy ad alto contrasto, raggruppata per area (Qualità, Operations, Anagrafiche, Sistema).
- **Tipografia**: Inter per l'interfaccia, JetBrains Mono per codici e clausole.
- **Firma visiva**: il gauge radiale *Indice di prontezza audit* in cima al cruscotto, con formula trasparente.

## L'Indice di prontezza audit

È una stima sintetica (0–100) dello stato del sistema rispetto a un audit. Parte da 100 e sottrae penalità per:

- non conformità aperte (critica −8, alta −5, media −3, bassa −1);
- strumenti di misura (scaduto −4, in scadenza −2);
- attività in ritardo (−3 ciascuna);
- rilievi di audit aperti (NC maggiore −4, NC minore −2);
- documenti scaduti (−2 ciascuno).

Il valore è volutamente semplice e leggibile: non è un punteggio di certificazione, ma un indicatore gestionale per capire "dove intervenire prima".

## Accessibilità

- Contrasto conforme alle linee guida WCAG sui testi principali.
- Focus visibile sugli input; etichette esplicite su tutti i campi.
- Componenti utilizzabili da tastiera; menu mobili con chiusura via `Esc`.
- Nessun contenuto critico veicolato dal solo colore.
