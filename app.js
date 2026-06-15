import { PDFDocument } from "pdf-lib";

const translations = {
  en: {
    eyebrow: "Smart PDF workspace",
    title: "PDF Manager",
    subtitle: "Upload, preview and edit the pages of your PDF in one clean workspace.",
    uploadTitle: "Open your file",
    uploadDesc: "Choose a PDF from your computer to start managing its pages.",
    selectPdf: "Select PDF",
    openPdf: "Open PDF",
    noPdf: "No PDF selected",
    managerLabel: "PDF manager",
    workspaceTitle: "Manage pages",
    deleteSelected: "Delete selected",
    chooseSource: "Add from another PDF",
    insertAfterLabel: "Insert after page",
    addSelected: "Add pages",
    previewPdf: "Preview PDF",
    downloadPdf: "Download PDF",
    previewLabel: "Final preview",
    previewTitle: "Review the edited PDF",
    previewDesc: "Scroll through the document page by page before saving it.",
    closePreview: "Close preview",
    currentPages: "PDF pages",
    sourcePages: "Pages to import",
    clearSelection: "Clear",
    sourceReady: "{file} loaded. Select the pages to add.",
    mainReady: "{file} contains {count} pages.",
    selectedMain: "{selected} of {count} pages selected.",
    selectedSource: "{selected} of {count} pages selected to import.",
    noMainSelection: "Select one or more pages to delete.",
    noSourceSelection: "Select one or more pages from the second PDF.",
    cannotDeleteAll: "Keep at least one page in the PDF.",
    deleted: "{count} pages deleted.",
    added: "{count} pages added.",
    addedAtStart: "{count} pages inserted at the beginning.",
    addedAfter: "{count} pages inserted after page {page}.",
    invalidInsertPage: "Type a page number from 0 to {count}. Use 0 to insert at the beginning.",
    page: "Page",
    importPage: "Import page",
    loading: "Loading PDF pages...",
    invalidPdf: "This file could not be opened as a PDF.",
    saveCanceled: "Save canceled.",
    savedName: "edited",
  },
  fr: {
    eyebrow: "Espace PDF intelligent",
    title: "PDF Manager",
    subtitle: "Importez, visualisez et modifiez les pages de votre PDF dans un espace clair.",
    uploadTitle: "Ouvrir votre fichier",
    uploadDesc: "Choisissez un PDF sur votre ordinateur pour gérer ses pages.",
    selectPdf: "Sélectionner PDF",
    openPdf: "Ouvrir PDF",
    noPdf: "Aucun PDF sélectionné",
    managerLabel: "Gestionnaire PDF",
    workspaceTitle: "Gérer les pages",
    deleteSelected: "Supprimer la sélection",
    chooseSource: "Ajouter depuis un PDF",
    insertAfterLabel: "Insérer après la page",
    addSelected: "Ajouter les pages",
    previewPdf: "Aperçu PDF",
    downloadPdf: "Télécharger PDF",
    previewLabel: "Aperçu final",
    previewTitle: "Vérifier le PDF modifié",
    previewDesc: "Parcourez le document page par page avant de l'enregistrer.",
    closePreview: "Fermer l'aperçu",
    currentPages: "Pages du PDF",
    sourcePages: "Pages à importer",
    clearSelection: "Effacer",
    sourceReady: "{file} chargé. Sélectionnez les pages à ajouter.",
    mainReady: "{file} contient {count} pages.",
    selectedMain: "{selected} sur {count} pages sélectionnées.",
    selectedSource: "{selected} sur {count} pages sélectionnées pour l'import.",
    noMainSelection: "Sélectionnez une ou plusieurs pages à supprimer.",
    noSourceSelection: "Sélectionnez une ou plusieurs pages du second PDF.",
    cannotDeleteAll: "Conservez au moins une page dans le PDF.",
    deleted: "{count} pages supprimées.",
    added: "{count} pages ajoutées.",
    addedAtStart: "{count} pages insérées au début.",
    addedAfter: "{count} pages insérées après la page {page}.",
    invalidInsertPage: "Saisissez un numéro de page entre 0 et {count}. Utilisez 0 pour insérer au début.",
    page: "Page",
    importPage: "Importer page",
    loading: "Chargement des pages PDF...",
    invalidPdf: "Ce fichier ne peut pas être ouvert comme PDF.",
    saveCanceled: "Enregistrement annulé.",
    savedName: "modifie",
  },
  it: {
    eyebrow: "Smart PDF workspace",
    title: "PDF Manager",
    subtitle: "Carica, visualizza e modifica le pagine del tuo PDF in un unico spazio di lavoro.",
    uploadTitle: "Apri il tuo file",
    uploadDesc: "Seleziona un PDF dal computer per iniziare a gestire le pagine.",
    selectPdf: "Seleziona PDF",
    openPdf: "Apri PDF",
    noPdf: "Nessun PDF selezionato",
    managerLabel: "PDF manager",
    workspaceTitle: "Gestisci le pagine",
    deleteSelected: "Elimina selezionate",
    chooseSource: "Aggiungi da altro PDF",
    insertAfterLabel: "Inserisci dopo pagina",
    addSelected: "Aggiungi pagine",
    previewPdf: "Anteprima PDF",
    downloadPdf: "Scarica PDF",
    previewLabel: "Anteprima finale",
    previewTitle: "Controlla il PDF modificato",
    previewDesc: "Scorri il documento pagina per pagina prima di salvarlo.",
    closePreview: "Chiudi anteprima",
    currentPages: "Pagine del PDF",
    sourcePages: "Pagine da importare",
    clearSelection: "Deseleziona",
    sourceReady: "{file} caricato. Seleziona le pagine da aggiungere.",
    mainReady: "{file} contiene {count} pagine.",
    selectedMain: "{selected} di {count} pagine selezionate.",
    selectedSource: "{selected} di {count} pagine selezionate da importare.",
    noMainSelection: "Seleziona una o piu pagine da eliminare.",
    noSourceSelection: "Seleziona una o piu pagine dal secondo PDF.",
    cannotDeleteAll: "Mantieni almeno una pagina nel PDF.",
    deleted: "{count} pagine eliminate.",
    added: "{count} pagine aggiunte.",
    addedAtStart: "{count} pagine inserite all'inizio.",
    addedAfter: "{count} pagine inserite dopo pagina {page}.",
    invalidInsertPage: "Digita un numero pagina da 0 a {count}. Usa 0 per inserire all'inizio.",
    page: "Pagina",
    importPage: "Importa pagina",
    loading: "Caricamento pagine PDF...",
    invalidPdf: "Questo file non puo essere aperto come PDF.",
    saveCanceled: "Salvataggio annullato.",
    savedName: "modificato",
  },
  es: {
    eyebrow: "Espacio PDF inteligente",
    title: "PDF Manager",
    subtitle: "Sube, visualiza y edita las páginas de tu PDF en un solo espacio de trabajo.",
    uploadTitle: "Abre tu archivo",
    uploadDesc: "Selecciona un PDF del ordenador para empezar a gestionar sus páginas.",
    selectPdf: "Seleccionar PDF",
    openPdf: "Abrir PDF",
    noPdf: "Ningún PDF seleccionado",
    managerLabel: "Gestor PDF",
    workspaceTitle: "Gestionar páginas",
    deleteSelected: "Eliminar selección",
    chooseSource: "Añadir desde otro PDF",
    insertAfterLabel: "Insertar después de página",
    addSelected: "Añadir páginas",
    previewPdf: "Vista previa PDF",
    downloadPdf: "Descargar PDF",
    previewLabel: "Vista previa final",
    previewTitle: "Revisar el PDF editado",
    previewDesc: "Desplázate por el documento página por página antes de guardarlo.",
    closePreview: "Cerrar vista previa",
    currentPages: "Páginas del PDF",
    sourcePages: "Páginas para importar",
    clearSelection: "Limpiar",
    sourceReady: "{file} cargado. Selecciona las páginas que quieres añadir.",
    mainReady: "{file} contiene {count} páginas.",
    selectedMain: "{selected} de {count} páginas seleccionadas.",
    selectedSource: "{selected} de {count} páginas seleccionadas para importar.",
    noMainSelection: "Selecciona una o más páginas para eliminar.",
    noSourceSelection: "Selecciona una o más páginas del segundo PDF.",
    cannotDeleteAll: "Mantén al menos una página en el PDF.",
    deleted: "{count} páginas eliminadas.",
    added: "{count} páginas añadidas.",
    addedAtStart: "{count} páginas insertadas al inicio.",
    addedAfter: "{count} páginas insertadas después de la página {page}.",
    invalidInsertPage: "Escribe un número de página de 0 a {count}. Usa 0 para insertar al inicio.",
    page: "Página",
    importPage: "Importar página",
    loading: "Cargando páginas PDF...",
    invalidPdf: "Este archivo no se pudo abrir como PDF.",
    saveCanceled: "Guardado cancelado.",
    savedName: "editado",
  },
  de: {
    eyebrow: "Smart PDF workspace",
    title: "PDF Manager",
    subtitle: "Laden, pruefen und bearbeiten Sie die Seiten Ihrer PDF in einem klaren Arbeitsbereich.",
    uploadTitle: "Datei oeffnen",
    uploadDesc: "Waehlen Sie eine PDF von Ihrem Computer, um die Seiten zu verwalten.",
    selectPdf: "PDF waehlen",
    openPdf: "PDF oeffnen",
    noPdf: "Keine PDF ausgewaehlt",
    managerLabel: "PDF manager",
    workspaceTitle: "Seiten verwalten",
    deleteSelected: "Auswahl loeschen",
    chooseSource: "Aus anderer PDF hinzufuegen",
    insertAfterLabel: "Einfuegen nach Seite",
    addSelected: "Seiten hinzufuegen",
    previewPdf: "PDF Vorschau",
    downloadPdf: "PDF herunterladen",
    previewLabel: "Finale Vorschau",
    previewTitle: "Bearbeitete PDF pruefen",
    previewDesc: "Blaettern Sie Seite fuer Seite durch das Dokument, bevor Sie es speichern.",
    closePreview: "Vorschau schliessen",
    currentPages: "PDF Seiten",
    sourcePages: "Seiten importieren",
    clearSelection: "Auswahl leeren",
    sourceReady: "{file} geladen. Waehlen Sie die Seiten zum Hinzufuegen.",
    mainReady: "{file} enthaelt {count} Seiten.",
    selectedMain: "{selected} von {count} Seiten ausgewaehlt.",
    selectedSource: "{selected} von {count} Seiten fuer den Import ausgewaehlt.",
    noMainSelection: "Waehlen Sie eine oder mehrere Seiten zum Loeschen.",
    noSourceSelection: "Waehlen Sie eine oder mehrere Seiten aus der zweiten PDF.",
    cannotDeleteAll: "Mindestens eine Seite muss in der PDF bleiben.",
    deleted: "{count} Seiten geloescht.",
    added: "{count} Seiten hinzugefuegt.",
    addedAtStart: "{count} Seiten am Anfang eingefuegt.",
    addedAfter: "{count} Seiten nach Seite {page} eingefuegt.",
    invalidInsertPage: "Geben Sie eine Seitennummer von 0 bis {count} ein. 0 fuegt am Anfang ein.",
    page: "Seite",
    importPage: "Seite importieren",
    loading: "PDF Seiten werden geladen...",
    invalidPdf: "Diese Datei konnte nicht als PDF geoeffnet werden.",
    saveCanceled: "Speichern abgebrochen.",
    savedName: "bearbeitet",
  },
  zh: {
    eyebrow: "Smart PDF workspace",
    title: "PDF Manager",
    subtitle: "Upload, preview and edit PDF pages in one clean workspace.",
    uploadTitle: "Open your file",
    uploadDesc: "Choose a PDF from your computer to start managing its pages.",
    selectPdf: "Select PDF",
    openPdf: "Open PDF",
    noPdf: "No PDF selected",
    managerLabel: "PDF manager",
    workspaceTitle: "Manage pages",
    deleteSelected: "Delete selected",
    chooseSource: "Add from another PDF",
    insertAfterLabel: "Insert after page",
    addSelected: "Add pages",
    previewPdf: "Preview PDF",
    downloadPdf: "Download PDF",
    previewLabel: "Final preview",
    previewTitle: "Review the edited PDF",
    previewDesc: "Scroll through the document page by page before saving it.",
    closePreview: "Close preview",
    currentPages: "PDF pages",
    sourcePages: "Pages to import",
    clearSelection: "Clear",
    sourceReady: "{file} loaded. Select the pages to add.",
    mainReady: "{file} contains {count} pages.",
    selectedMain: "{selected} of {count} pages selected.",
    selectedSource: "{selected} of {count} pages selected to import.",
    noMainSelection: "Select one or more pages to delete.",
    noSourceSelection: "Select one or more pages from the second PDF.",
    cannotDeleteAll: "Keep at least one page in the PDF.",
    deleted: "{count} pages deleted.",
    added: "{count} pages added.",
    addedAtStart: "{count} pages inserted at the beginning.",
    addedAfter: "{count} pages inserted after page {page}.",
    invalidInsertPage: "Type a page number from 0 to {count}. Use 0 to insert at the beginning.",
    page: "Page",
    importPage: "Import page",
    loading: "Loading PDF pages...",
    invalidPdf: "This file could not be opened as a PDF.",
    saveCanceled: "Save canceled.",
    savedName: "edited",
  },
};

const portfolioTranslations = {
  it: {
    navHome: "Home",
    navAbout: "Chi siamo",
    navSkills: "Competenze",
    navProjects: "Progetti",
    navContact: "Contatti",
    menuQuality: "Gestionale Qualita",
    menuDashboard: "Dashboard PMI",
    menuProduction: "Gestione Produzione",
    menuShopSites: "Siti web negozi",
    portfolioEyebrow: "Strumenti business per PMI",
    portfolioSubtitle: "Portfolio di applicazioni web e prototipi gestionali per piccole e medie imprese: strumenti chiari per qualita, produzione, documenti, commesse e flussi operativi.",
    portfolioOpenPdf: "Apri PDF Manager",
    portfolioExploreServices: "Esplora i servizi",
    metricTool: "Tool pubblicato",
    metricAreas: "Aree gestionali",
    metricClientSide: "PDF lato client",
    codeLine1: 'const pmi = "processi reali";',
    codeLine2: "map(flussi, dati, documenti);",
    codeLine3: 'build("prototipo operativo");',
    codeLine4: 'release("strumento semplice");',
    badgeQuality: "procedure e controlli",
    badgeOps: "commesse e produzione",
    badgeDocs: "PDF e automazioni",
    aboutEyebrow: "Chi siamo",
    aboutTitle: "Soluzioni digitali chiare per processi aziendali reali.",
    aboutDesc: "ValexLab e un portfolio dedicato a tool web e sistemi gestionali per PMI: qualita, documentazione, produzione, dashboard operative e piccoli automatismi costruiti per semplificare il lavoro quotidiano.",
    servicesEyebrow: "Servizi",
    servicesTitle: "Servizi digitali per gestionali PMI",
    serviceQualityTitle: "Qualita e documentazione",
    serviceQualityDesc: "Procedure, checklist, non conformita, audit interni e archivi documentali consultabili in modo ordinato.",
    serviceOpsTitle: "Produzione e operativita",
    serviceOpsDesc: "Dashboard per commesse, avanzamento lavorazioni, priorita, materiali e tracciamento delle attivita chiave.",
    serviceDocsTitle: "Documenti e automazioni",
    serviceDocsDesc: "Tool per gestire PDF, moduli, allegati e piccoli automatismi che riducono lavoro ripetitivo.",
    servicePrototypeTitle: "Prototipi su misura",
    servicePrototypeDesc: "Interfacce rapide da testare con utenti reali prima di investire in un gestionale completo.",
    skillsEyebrow: "Competenze",
    skillsTitle: "Competenze per gestionali moderni e facili da usare",
    skillProcessTitle: "Analisi processi",
    skillProcessDesc: "Mappatura di ruoli, dati, documenti e punti critici prima di progettare l'interfaccia.",
    skillWebTitle: "Web app operative",
    skillWebDesc: "Schermate responsive, leggere e orientate a chi deve lavorare in modo rapido.",
    skillDashboardTitle: "Dashboard e KPI",
    skillDashboardDesc: "Vista sintetica di avanzamenti, priorita, controlli e indicatori utili alla gestione.",
    skillWorkflowTitle: "Workflow documentali",
    skillWorkflowDesc: "Gestione di PDF, revisioni, allegati e procedure con passaggi semplici e tracciabili.",
    projectsEyebrow: "Progetti",
    projectsTitle: "Progetti in evidenza",
    projectStatusLive: "Tool online",
    projectPdfDesc: "Gestisci PDF direttamente nel browser: elimina pagine, importa pagine da altri documenti, scegli dove inserirle e scarica il file finale.",
    projectOpen: "Apri progetto",
    projectStatusRoadmap: "In roadmap",
    projectQualityTitle: "Gestione Qualita",
    projectQualityDesc: "Prototipo per procedure, controlli, non conformita, audit e documentazione qualita nelle PMI.",
    projectProductionTitle: "Gestione Produzione",
    projectProductionDesc: "Spazio per un sistema operativo dedicato a commesse, avanzamento lavori, materiali e report essenziali.",
    projectStatusService: "Servizio",
    projectShopSitesTitle: "Siti web per piccoli negozi",
    projectShopSitesDesc: "Supporto per creare e gestire siti web professionali: dominio, hosting, frontend, backend, contenuti e manutenzione del sito.",
    methodEyebrow: "Metodo",
    methodTitle: "Dal problema al prototipo",
    workflowMapTitle: "Mappatura del flusso",
    workflowMapDesc: "Capire chi usa il sistema, quali dati servono e dove si perdono tempo o informazioni.",
    workflowUiTitle: "Interfaccia operativa",
    workflowUiDesc: "Costruire schermate semplici, dense quanto basta e pronte per essere provate sul processo reale.",
    workflowReleaseTitle: "Iterazione e rilascio",
    workflowReleaseDesc: "Migliorare il prototipo con feedback pratici fino ad arrivare a uno strumento stabile.",
    contactEyebrow: "Contatti",
    contactTitle: "Hai un processo da trasformare in gestionale?",
    contactDesc: "Questa sezione e pronta per raccogliere richieste, demo e nuove idee di progetto per ValexLab.",
    contactButton: "Scrivi a ValexLab",
    ctaEyebrow: "Prossimo passo",
    ctaTitle: "Un portfolio che crescera progetto dopo progetto.",
    ctaDesc: "PDF Manager e il primo tassello. Le prossime aree saranno dedicate a qualita, produzione, magazzino e processi gestionali per PMI.",
    ctaButton: "Prova il primo tool",
  },
  en: {
    navHome: "Home",
    navAbout: "About",
    navSkills: "Skills",
    navProjects: "Projects",
    navContact: "Contact",
    menuQuality: "Quality Management",
    menuDashboard: "SME Dashboard",
    menuProduction: "Production Management",
    menuShopSites: "Shop websites",
    portfolioEyebrow: "Business tools for SMEs",
    portfolioSubtitle: "A portfolio of web applications and management prototypes for small and medium businesses: clear tools for quality, production, documents, orders and operational workflows.",
    portfolioOpenPdf: "Open PDF Manager",
    portfolioExploreServices: "Explore services",
    metricTool: "Published tool",
    metricAreas: "Management areas",
    metricClientSide: "Client-side PDF",
    codeLine1: 'const sme = "real processes";',
    codeLine2: "map(flows, data, documents);",
    codeLine3: 'build("operational prototype");',
    codeLine4: 'release("simple tool");',
    badgeQuality: "procedures and controls",
    badgeOps: "orders and production",
    badgeDocs: "PDFs and automations",
    aboutEyebrow: "About",
    aboutTitle: "Clear digital solutions for real business processes.",
    aboutDesc: "ValexLab is a portfolio dedicated to web tools and management systems for SMEs: quality, documentation, production, operational dashboards and small automations built to simplify everyday work.",
    servicesEyebrow: "Services",
    servicesTitle: "Digital services for SME management systems",
    serviceQualityTitle: "Quality and documentation",
    serviceQualityDesc: "Procedures, checklists, non-conformities, internal audits and document archives that are easy to consult.",
    serviceOpsTitle: "Production and operations",
    serviceOpsDesc: "Dashboards for orders, work progress, priorities, materials and tracking of key activities.",
    serviceDocsTitle: "Documents and automations",
    serviceDocsDesc: "Tools for managing PDFs, forms, attachments and small automations that reduce repetitive work.",
    servicePrototypeTitle: "Custom prototypes",
    servicePrototypeDesc: "Fast interfaces to test with real users before investing in a complete management system.",
    skillsEyebrow: "Skills",
    skillsTitle: "Skills for modern, easy-to-use management tools",
    skillProcessTitle: "Process analysis",
    skillProcessDesc: "Mapping roles, data, documents and critical points before designing the interface.",
    skillWebTitle: "Operational web apps",
    skillWebDesc: "Responsive, lightweight screens focused on people who need to work quickly.",
    skillDashboardTitle: "Dashboards and KPIs",
    skillDashboardDesc: "Summary views of progress, priorities, controls and indicators useful for management.",
    skillWorkflowTitle: "Document workflows",
    skillWorkflowDesc: "Managing PDFs, revisions, attachments and procedures with simple, traceable steps.",
    projectsEyebrow: "Projects",
    projectsTitle: "Featured projects",
    projectStatusLive: "Live tool",
    projectPdfDesc: "Manage PDFs directly in the browser: delete pages, import pages from other documents, choose where to insert them and download the final file.",
    projectOpen: "Open project",
    projectStatusRoadmap: "Roadmap",
    projectQualityTitle: "Quality Management",
    projectQualityDesc: "Prototype for procedures, controls, non-conformities, audits and quality documentation in SMEs.",
    projectProductionTitle: "Production Management",
    projectProductionDesc: "A space for an operational system dedicated to orders, work progress, materials and essential reports.",
    projectStatusService: "Service",
    projectShopSitesTitle: "Websites for small shops",
    projectShopSitesDesc: "Support to create and manage professional websites: domain, hosting, frontend, backend, content and site maintenance.",
    methodEyebrow: "Method",
    methodTitle: "From problem to prototype",
    workflowMapTitle: "Flow mapping",
    workflowMapDesc: "Understand who uses the system, which data is needed and where time or information is lost.",
    workflowUiTitle: "Operational interface",
    workflowUiDesc: "Build simple, dense-enough screens ready to be tested on the real process.",
    workflowReleaseTitle: "Iteration and release",
    workflowReleaseDesc: "Improve the prototype with practical feedback until it becomes a stable tool.",
    contactEyebrow: "Contact",
    contactTitle: "Do you have a process to turn into a management tool?",
    contactDesc: "This section is ready to collect requests, demos and new project ideas for ValexLab.",
    contactButton: "Write to ValexLab",
    ctaEyebrow: "Next",
    ctaTitle: "A portfolio that will grow project after project.",
    ctaDesc: "PDF Manager is the first building block. The next areas will focus on quality, production, inventory and management processes for SMEs.",
    ctaButton: "Try the first tool",
  },
  fr: {
    navHome: "Accueil",
    navAbout: "A propos",
    navSkills: "Competences",
    navProjects: "Projets",
    navContact: "Contact",
    menuQuality: "Gestion Qualite",
    menuDashboard: "Tableau de bord PME",
    menuProduction: "Gestion Production",
    menuShopSites: "Sites web boutiques",
    portfolioEyebrow: "Outils business pour PME",
    portfolioSubtitle: "Portfolio d'applications web et de prototypes de gestion pour petites et moyennes entreprises: des outils clairs pour la qualite, la production, les documents, les commandes et les flux operationnels.",
    portfolioOpenPdf: "Ouvrir PDF Manager",
    portfolioExploreServices: "Explorer les services",
    metricTool: "Outil publie",
    metricAreas: "Domaines de gestion",
    metricClientSide: "PDF cote client",
    codeLine1: 'const pme = "processus reels";',
    codeLine2: "map(flux, donnees, documents);",
    codeLine3: 'build("prototype operationnel");',
    codeLine4: 'release("outil simple");',
    badgeQuality: "procedures et controles",
    badgeOps: "commandes et production",
    badgeDocs: "PDF et automatisations",
    aboutEyebrow: "A propos",
    aboutTitle: "Solutions numeriques claires pour des processus d'entreprise reels.",
    aboutDesc: "ValexLab est un portfolio dedie aux outils web et aux systemes de gestion pour PME: qualite, documentation, production, tableaux de bord operationnels et petites automatisations pour simplifier le travail quotidien.",
    servicesEyebrow: "Services",
    servicesTitle: "Services numeriques pour systemes de gestion PME",
    serviceQualityTitle: "Qualite et documentation",
    serviceQualityDesc: "Procedures, checklists, non-conformites, audits internes et archives documentaires faciles a consulter.",
    serviceOpsTitle: "Production et operations",
    serviceOpsDesc: "Tableaux de bord pour commandes, avancement, priorites, materiaux et suivi des activites clés.",
    serviceDocsTitle: "Documents et automatisations",
    serviceDocsDesc: "Outils pour gerer PDF, formulaires, pieces jointes et petites automatisations qui reduisent le travail repetitif.",
    servicePrototypeTitle: "Prototypes sur mesure",
    servicePrototypeDesc: "Interfaces rapides a tester avec de vrais utilisateurs avant d'investir dans un systeme complet.",
    skillsEyebrow: "Competences",
    skillsTitle: "Competences pour des outils de gestion modernes et simples",
    skillProcessTitle: "Analyse des processus",
    skillProcessDesc: "Cartographie des roles, donnees, documents et points critiques avant de concevoir l'interface.",
    skillWebTitle: "Applications web operationnelles",
    skillWebDesc: "Ecrans responsives, legers et concus pour travailler rapidement.",
    skillDashboardTitle: "Tableaux de bord et KPI",
    skillDashboardDesc: "Vues synthetiques de l'avancement, des priorites, des controles et des indicateurs utiles.",
    skillWorkflowTitle: "Flux documentaires",
    skillWorkflowDesc: "Gestion de PDF, revisions, pieces jointes et procedures avec des etapes simples et tracables.",
    projectsEyebrow: "Projets",
    projectsTitle: "Projets en evidence",
    projectStatusLive: "Outil en ligne",
    projectPdfDesc: "Gerez les PDF directement dans le navigateur: supprimez des pages, importez des pages d'autres documents, choisissez ou les inserer et telechargez le fichier final.",
    projectOpen: "Ouvrir le projet",
    projectStatusRoadmap: "Feuille de route",
    projectQualityTitle: "Gestion Qualite",
    projectQualityDesc: "Prototype pour procedures, controles, non-conformites, audits et documentation qualite dans les PME.",
    projectProductionTitle: "Gestion Production",
    projectProductionDesc: "Espace pour un systeme operationnel dedie aux commandes, a l'avancement, aux materiaux et aux rapports essentiels.",
    projectStatusService: "Service",
    projectShopSitesTitle: "Sites web pour petites boutiques",
    projectShopSitesDesc: "Accompagnement pour creer et gerer des sites web professionnels: domaine, hebergement, frontend, backend, contenus et maintenance du site.",
    methodEyebrow: "Methode",
    methodTitle: "Du probleme au prototype",
    workflowMapTitle: "Cartographie du flux",
    workflowMapDesc: "Comprendre qui utilise le systeme, quelles donnees sont necessaires et ou le temps ou l'information se perd.",
    workflowUiTitle: "Interface operationnelle",
    workflowUiDesc: "Construire des ecrans simples, assez denses et prets a etre testes sur le processus reel.",
    workflowReleaseTitle: "Iteration et lancement",
    workflowReleaseDesc: "Ameliorer le prototype avec des retours pratiques jusqu'a obtenir un outil stable.",
    contactEyebrow: "Contact",
    contactTitle: "Avez-vous un processus a transformer en outil de gestion?",
    contactDesc: "Cette section est prete a collecter demandes, demos et nouvelles idees de projet pour ValexLab.",
    contactButton: "Ecrire a ValexLab",
    ctaEyebrow: "Prochaine etape",
    ctaTitle: "Un portfolio qui grandira projet apres projet.",
    ctaDesc: "PDF Manager est la premiere brique. Les prochaines zones seront dediees a la qualite, la production, le stock et les processus de gestion pour PME.",
    ctaButton: "Essayer le premier outil",
  },
  de: {
    navHome: "Start",
    navAbout: "Ueber uns",
    navSkills: "Kompetenzen",
    navProjects: "Projekte",
    navContact: "Kontakt",
    menuQuality: "Qualitaetsmanagement",
    menuDashboard: "KMU Dashboard",
    menuProduction: "Produktionsmanagement",
    menuShopSites: "Websites fuer Laeden",
    portfolioEyebrow: "Business Tools fuer KMU",
    portfolioSubtitle: "Portfolio von Webanwendungen und Management-Prototypen fuer kleine und mittlere Unternehmen: klare Tools fuer Qualitaet, Produktion, Dokumente, Auftraege und operative Ablaeufe.",
    portfolioOpenPdf: "PDF Manager oeffnen",
    portfolioExploreServices: "Services ansehen",
    metricTool: "Veroeffentlichtes Tool",
    metricAreas: "Managementbereiche",
    metricClientSide: "Client-side PDF",
    codeLine1: 'const kmu = "reale prozesse";',
    codeLine2: "map(ablaeufe, daten, dokumente);",
    codeLine3: 'build("operativer prototyp");',
    codeLine4: 'release("einfaches tool");',
    badgeQuality: "verfahren und kontrollen",
    badgeOps: "auftraege und produktion",
    badgeDocs: "PDFs und automatisierungen",
    aboutEyebrow: "Ueber uns",
    aboutTitle: "Klare digitale Loesungen fuer reale Geschaeftsprozesse.",
    aboutDesc: "ValexLab ist ein Portfolio fuer Web-Tools und Managementsysteme fuer KMU: Qualitaet, Dokumentation, Produktion, operative Dashboards und kleine Automatisierungen fuer den Arbeitsalltag.",
    servicesEyebrow: "Services",
    servicesTitle: "Digitale Services fuer KMU-Managementsysteme",
    serviceQualityTitle: "Qualitaet und Dokumentation",
    serviceQualityDesc: "Verfahren, Checklisten, Abweichungen, interne Audits und Dokumentenarchive, die einfach nutzbar sind.",
    serviceOpsTitle: "Produktion und Betrieb",
    serviceOpsDesc: "Dashboards fuer Auftraege, Fortschritt, Prioritaeten, Materialien und Nachverfolgung wichtiger Aktivitaeten.",
    serviceDocsTitle: "Dokumente und Automatisierungen",
    serviceDocsDesc: "Tools fuer PDFs, Formulare, Anhaenge und kleine Automatisierungen, die Wiederholungsarbeit reduzieren.",
    servicePrototypeTitle: "Individuelle Prototypen",
    servicePrototypeDesc: "Schnelle Oberflaechen zum Testen mit echten Nutzern, bevor in ein komplettes System investiert wird.",
    skillsEyebrow: "Kompetenzen",
    skillsTitle: "Kompetenzen fuer moderne und einfache Management-Tools",
    skillProcessTitle: "Prozessanalyse",
    skillProcessDesc: "Mapping von Rollen, Daten, Dokumenten und kritischen Punkten vor dem Interface-Design.",
    skillWebTitle: "Operative Web-Apps",
    skillWebDesc: "Responsive, leichte Ansichten fuer Menschen, die schnell arbeiten muessen.",
    skillDashboardTitle: "Dashboards und KPI",
    skillDashboardDesc: "Kompakte Ansichten von Fortschritt, Prioritaeten, Kontrollen und Kennzahlen.",
    skillWorkflowTitle: "Dokumenten-Workflows",
    skillWorkflowDesc: "Verwaltung von PDFs, Revisionen, Anhaengen und Verfahren mit einfachen, nachvollziehbaren Schritten.",
    projectsEyebrow: "Projekte",
    projectsTitle: "Ausgewaehlte Projekte",
    projectStatusLive: "Online-Tool",
    projectPdfDesc: "Verwalten Sie PDFs direkt im Browser: Seiten loeschen, Seiten aus anderen Dokumenten importieren, Einfuegeposition waehlen und die finale Datei herunterladen.",
    projectOpen: "Projekt oeffnen",
    projectStatusRoadmap: "Roadmap",
    projectQualityTitle: "Qualitaetsmanagement",
    projectQualityDesc: "Prototyp fuer Verfahren, Kontrollen, Abweichungen, Audits und Qualitaetsdokumentation in KMU.",
    projectProductionTitle: "Produktionsmanagement",
    projectProductionDesc: "Bereich fuer ein operatives System fuer Auftraege, Fortschritt, Materialien und wesentliche Berichte.",
    projectStatusService: "Service",
    projectShopSitesTitle: "Websites fuer kleine Laeden",
    projectShopSitesDesc: "Unterstuetzung beim Erstellen und Verwalten professioneller Websites: Domain, Hosting, Frontend, Backend, Inhalte und Wartung.",
    methodEyebrow: "Methode",
    methodTitle: "Vom Problem zum Prototyp",
    workflowMapTitle: "Ablauf abbilden",
    workflowMapDesc: "Verstehen, wer das System nutzt, welche Daten gebraucht werden und wo Zeit oder Informationen verloren gehen.",
    workflowUiTitle: "Operative Oberflaeche",
    workflowUiDesc: "Einfache, ausreichend dichte Ansichten bauen, die am realen Prozess getestet werden koennen.",
    workflowReleaseTitle: "Iteration und Release",
    workflowReleaseDesc: "Den Prototyp mit praktischem Feedback verbessern, bis ein stabiles Tool entsteht.",
    contactEyebrow: "Kontakt",
    contactTitle: "Haben Sie einen Prozess, der zu einem Management-Tool werden soll?",
    contactDesc: "Dieser Bereich ist bereit fuer Anfragen, Demos und neue Projektideen fuer ValexLab.",
    contactButton: "ValexLab schreiben",
    ctaEyebrow: "Naechster Schritt",
    ctaTitle: "Ein Portfolio, das mit jedem Projekt waechst.",
    ctaDesc: "PDF Manager ist der erste Baustein. Die naechsten Bereiche konzentrieren sich auf Qualitaet, Produktion, Lager und Managementprozesse fuer KMU.",
    ctaButton: "Erstes Tool testen",
  },
  es: {
    navHome: "Inicio",
    navAbout: "Sobre mi",
    navSkills: "Competencias",
    navProjects: "Proyectos",
    navContact: "Contacto",
    menuQuality: "Gestion de Calidad",
    menuDashboard: "Dashboard PYME",
    menuProduction: "Gestion de Produccion",
    menuShopSites: "Sitios web tiendas",
    portfolioEyebrow: "Herramientas business para PYMEs",
    portfolioSubtitle: "Portfolio de aplicaciones web y prototipos de gestion para pequenas y medianas empresas: herramientas claras para calidad, produccion, documentos, pedidos y flujos operativos.",
    portfolioOpenPdf: "Abrir PDF Manager",
    portfolioExploreServices: "Explorar servicios",
    metricTool: "Herramienta publicada",
    metricAreas: "Areas de gestion",
    metricClientSide: "PDF en cliente",
    codeLine1: 'const pyme = "procesos reales";',
    codeLine2: "map(flujos, datos, documentos);",
    codeLine3: 'build("prototipo operativo");',
    codeLine4: 'release("herramienta simple");',
    badgeQuality: "procedimientos y controles",
    badgeOps: "pedidos y produccion",
    badgeDocs: "PDF y automatizaciones",
    aboutEyebrow: "Sobre mi",
    aboutTitle: "Soluciones digitales claras para procesos empresariales reales.",
    aboutDesc: "ValexLab es un portfolio dedicado a herramientas web y sistemas de gestion para PYMEs: calidad, documentacion, produccion, dashboards operativos y pequenas automatizaciones para simplificar el trabajo diario.",
    servicesEyebrow: "Servicios",
    servicesTitle: "Servicios digitales para sistemas de gestion PYME",
    serviceQualityTitle: "Calidad y documentacion",
    serviceQualityDesc: "Procedimientos, checklists, no conformidades, auditorias internas y archivos documentales faciles de consultar.",
    serviceOpsTitle: "Produccion y operaciones",
    serviceOpsDesc: "Dashboards para pedidos, avance de trabajos, prioridades, materiales y seguimiento de actividades clave.",
    serviceDocsTitle: "Documentos y automatizaciones",
    serviceDocsDesc: "Herramientas para gestionar PDF, formularios, adjuntos y pequenas automatizaciones que reducen trabajo repetitivo.",
    servicePrototypeTitle: "Prototipos a medida",
    servicePrototypeDesc: "Interfaces rapidas para probar con usuarios reales antes de invertir en un sistema completo.",
    skillsEyebrow: "Competencias",
    skillsTitle: "Competencias para herramientas de gestion modernas y faciles",
    skillProcessTitle: "Analisis de procesos",
    skillProcessDesc: "Mapeo de roles, datos, documentos y puntos criticos antes de disenar la interfaz.",
    skillWebTitle: "Web apps operativas",
    skillWebDesc: "Pantallas responsive, ligeras y pensadas para trabajar rapidamente.",
    skillDashboardTitle: "Dashboards y KPI",
    skillDashboardDesc: "Vistas sinteticas de avances, prioridades, controles e indicadores utiles para la gestion.",
    skillWorkflowTitle: "Flujos documentales",
    skillWorkflowDesc: "Gestion de PDF, revisiones, adjuntos y procedimientos con pasos simples y trazables.",
    projectsEyebrow: "Proyectos",
    projectsTitle: "Proyectos destacados",
    projectStatusLive: "Herramienta online",
    projectPdfDesc: "Gestiona PDF directamente en el navegador: elimina paginas, importa paginas de otros documentos, elige donde insertarlas y descarga el archivo final.",
    projectOpen: "Abrir proyecto",
    projectStatusRoadmap: "Roadmap",
    projectQualityTitle: "Gestion de Calidad",
    projectQualityDesc: "Prototipo para procedimientos, controles, no conformidades, auditorias y documentacion de calidad en PYMEs.",
    projectProductionTitle: "Gestion de Produccion",
    projectProductionDesc: "Espacio para un sistema operativo dedicado a pedidos, avances, materiales e informes esenciales.",
    projectStatusService: "Servicio",
    projectShopSitesTitle: "Sitios web para pequenos negocios",
    projectShopSitesDesc: "Soporte para crear y gestionar sitios web profesionales: dominio, hosting, frontend, backend, contenidos y mantenimiento del sitio.",
    methodEyebrow: "Metodo",
    methodTitle: "Del problema al prototipo",
    workflowMapTitle: "Mapeo del flujo",
    workflowMapDesc: "Entender quien usa el sistema, que datos se necesitan y donde se pierden tiempo o informacion.",
    workflowUiTitle: "Interfaz operativa",
    workflowUiDesc: "Construir pantallas simples, densas lo justo y listas para probarse en el proceso real.",
    workflowReleaseTitle: "Iteracion y lanzamiento",
    workflowReleaseDesc: "Mejorar el prototipo con feedback practico hasta llegar a una herramienta estable.",
    contactEyebrow: "Contacto",
    contactTitle: "Tienes un proceso para convertir en herramienta de gestion?",
    contactDesc: "Esta seccion esta lista para recoger solicitudes, demos y nuevas ideas de proyecto para ValexLab.",
    contactButton: "Escribir a ValexLab",
    ctaEyebrow: "Siguiente paso",
    ctaTitle: "Un portfolio que crecera proyecto tras proyecto.",
    ctaDesc: "PDF Manager es el primer bloque. Las proximas areas estaran dedicadas a calidad, produccion, inventario y procesos de gestion para PYMEs.",
    ctaButton: "Probar la primera herramienta",
  },
  zh: {
    navHome: "首页",
    navAbout: "关于",
    navSkills: "技能",
    navProjects: "项目",
    navContact: "联系",
    menuQuality: "质量管理",
    menuDashboard: "中小企业仪表板",
    menuProduction: "生产管理",
    menuShopSites: "小店网站",
    portfolioEyebrow: "面向中小企业的业务工具",
    portfolioSubtitle: "ValexLab 展示面向中小企业的 Web 应用和管理系统原型，用清晰工具支持质量、生产、文档、订单和运营流程。",
    portfolioOpenPdf: "打开 PDF Manager",
    portfolioExploreServices: "查看服务",
    metricTool: "已发布工具",
    metricAreas: "管理领域",
    metricClientSide: "浏览器端 PDF",
    codeLine1: 'const sme = "真实流程";',
    codeLine2: "map(流程, 数据, 文档);",
    codeLine3: 'build("运营原型");',
    codeLine4: 'release("简单工具");',
    badgeQuality: "流程与控制",
    badgeOps: "订单与生产",
    badgeDocs: "PDF 与自动化",
    aboutEyebrow: "关于",
    aboutTitle: "为真实业务流程打造清晰的数字化方案。",
    aboutDesc: "ValexLab 是一个面向中小企业的工具作品集，涵盖质量、文档、生产、运营仪表板和小型自动化，帮助简化日常工作。",
    servicesEyebrow: "服务",
    servicesTitle: "面向中小企业管理系统的数字服务",
    serviceQualityTitle: "质量与文档",
    serviceQualityDesc: "流程、检查表、不符合项、内部审核和易于查询的文档档案。",
    serviceOpsTitle: "生产与运营",
    serviceOpsDesc: "用于订单、进度、优先级、物料和关键活动跟踪的仪表板。",
    serviceDocsTitle: "文档与自动化",
    serviceDocsDesc: "用于管理 PDF、表单、附件和小型自动化的工具，减少重复工作。",
    servicePrototypeTitle: "定制原型",
    servicePrototypeDesc: "在投入完整系统前，可与真实用户快速测试的界面原型。",
    skillsEyebrow: "技能",
    skillsTitle: "打造现代、易用管理工具的能力",
    skillProcessTitle: "流程分析",
    skillProcessDesc: "在设计界面前，梳理角色、数据、文档和关键问题。",
    skillWebTitle: "运营型 Web 应用",
    skillWebDesc: "响应式、轻量、面向快速工作的业务界面。",
    skillDashboardTitle: "仪表板与 KPI",
    skillDashboardDesc: "以摘要视图展示进度、优先级、控制点和管理指标。",
    skillWorkflowTitle: "文档工作流",
    skillWorkflowDesc: "用简单、可追踪的步骤管理 PDF、修订、附件和流程。",
    projectsEyebrow: "项目",
    projectsTitle: "精选项目",
    projectStatusLive: "在线工具",
    projectPdfDesc: "直接在浏览器中管理 PDF：删除页面、从其他文档导入页面、选择插入位置并下载最终文件。",
    projectOpen: "打开项目",
    projectStatusRoadmap: "规划中",
    projectQualityTitle: "质量管理",
    projectQualityDesc: "面向中小企业的流程、控制、不符合项、审核和质量文档原型。",
    projectProductionTitle: "生产管理",
    projectProductionDesc: "用于订单、生产进度、物料和核心报表的运营系统空间。",
    projectStatusService: "服务",
    projectShopSitesTitle: "面向小店的网站",
    projectShopSitesDesc: "支持创建和管理专业网站：域名、托管、前端、后端、内容和网站维护。",
    methodEyebrow: "方法",
    methodTitle: "从问题到原型",
    workflowMapTitle: "流程映射",
    workflowMapDesc: "理解谁使用系统、需要哪些数据，以及时间或信息在哪里流失。",
    workflowUiTitle: "运营界面",
    workflowUiDesc: "构建简单且信息密度适中的界面，并在真实流程中测试。",
    workflowReleaseTitle: "迭代与发布",
    workflowReleaseDesc: "通过实际反馈改进原型，直到形成稳定工具。",
    contactEyebrow: "联系",
    contactTitle: "你有想转化为管理工具的流程吗？",
    contactDesc: "此区域可用于收集 ValexLab 的需求、演示和新项目想法。",
    contactButton: "联系 ValexLab",
    ctaEyebrow: "下一步",
    ctaTitle: "一个会随着项目不断成长的作品集。",
    ctaDesc: "PDF Manager 是第一个模块。接下来将聚焦质量、生产、库存和中小企业管理流程。",
    ctaButton: "试用第一个工具",
  },
};

const pdfInput = document.getElementById("pdfInput");
const sourcePdfInput = document.getElementById("sourcePdfInput");
const chooseFileBtn = document.getElementById("chooseFileBtn");
const sourceFileBtn = document.getElementById("sourceFileBtn");
const fileName = document.getElementById("fileName");
const loadBtn = document.getElementById("loadBtn");
const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");
const addSelectedBtn = document.getElementById("addSelectedBtn");
const previewBtn = document.getElementById("previewBtn");
const downloadBtn = document.getElementById("downloadBtn");
const downloadFromPreviewBtn = document.getElementById("downloadFromPreviewBtn");
const insertAfterPageInput = document.getElementById("insertAfterPageInput");
const closePreviewBtn = document.getElementById("closePreviewBtn");
const clearMainSelectionBtn = document.getElementById("clearMainSelectionBtn");
const clearSourceSelectionBtn = document.getElementById("clearSourceSelectionBtn");
const pageInfo = document.getElementById("pageInfo");
const workspaceSummary = document.getElementById("workspaceSummary");
const selectionInfo = document.getElementById("selectionInfo");
const sourceInfo = document.getElementById("sourceInfo");
const fileStatus = document.querySelector(".file-status");
const managerSection = document.getElementById("managerSection");
const sourcePanel = document.getElementById("sourcePanel");
const previewSection = document.getElementById("previewSection");
const portfolioSection = document.getElementById("portfolioSection");
const pdfManagerApp = document.getElementById("pdfManagerApp");
const finalPreviewFrame = document.getElementById("finalPreviewFrame");
const pagesGrid = document.getElementById("pagesGrid");
const sourcePagesGrid = document.getElementById("sourcePagesGrid");
const languageButtons = document.querySelectorAll(".language-option");
const languageDropdown = document.querySelector(".language-dropdown");
const languageToggle = document.querySelector(".language-toggle");
const languageCurrent = document.querySelector(".language-current");
const languageToggleFlag = languageToggle?.querySelector(".flag");
const navDropdown = document.querySelector(".nav-dropdown");
const navDropdownToggle = document.querySelector(".nav-dropdown-toggle");
const routeLinks = document.querySelectorAll("[data-route]");
const navLinks = document.querySelectorAll(".site-nav a[data-route]");
const hashLinks = document.querySelectorAll('a[href^="#"]');
const metaDescription = document.querySelector("meta[name='description']");
const ogTitle = document.querySelector("meta[property='og:title']");
const ogDescription = document.querySelector("meta[property='og:description']");
const ogUrl = document.querySelector("meta[property='og:url']");
const canonicalLink = document.querySelector("link[rel='canonical']");
const savedLanguage = localStorage.getItem("pdf-manager-language");

function generatePortfolioParticles() {
  const container = document.getElementById("portfolioParticles");
  if (!container || container.children.length) {
    return;
  }

  const symbols = ["{", "}", "[", "]", "<", "/>", "=", "+", "01", "QA", "OP", "PDF"];
  for (let index = 0; index < 24; index += 1) {
    const particle = document.createElement("span");
    particle.className = "particle";
    particle.textContent = symbols[Math.floor(Math.random() * symbols.length)];
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;
    particle.style.setProperty("--delay", `${Math.random() * -12}s`);
    particle.style.setProperty("--duration", `${12 + Math.random() * 10}s`);
    container.appendChild(particle);
  }
}

function initPortfolioReveal() {
  const items = document.querySelectorAll(".service-card, .skill-card, .project-card, .workflow-item");
  if (!items.length) {
    return;
  }

  if (!("IntersectionObserver" in window)) {
    items.forEach((item) => item.classList.add("is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.16 },
  );

  items.forEach((item, index) => {
    item.style.transitionDelay = `${Math.min(index * 70, 280)}ms`;
    observer.observe(item);
  });
}

const state = {
  language: translations[savedLanguage] ? savedLanguage : "it",
  mainDoc: null,
  sourceDoc: null,
  mainFileName: "",
  sourceFileName: "",
  selectedMainPages: new Set(),
  selectedSourcePages: new Set(),
  objectUrls: {
    main: [],
    source: [],
  },
  finalPreviewUrl: "",
};

const pages = {
  home: {
    path: "/",
    title: "ValexLab - Portfolio di applicazioni web",
    description: "ValexLab e un portfolio di applicazioni web, strumenti gestionali e prototipi digitali per piccole e medie imprese.",
    canonical: "https://valexlab.eu/",
  },
  pdfManager: {
    path: "/pdfmanager",
    title: "PDF Manager Online - ValexLab",
    description: "PDF Manager online per eliminare pagine, aggiungere pagine da altri PDF, visualizzare l'anteprima finale e salvare il documento modificato direttamente dal browser.",
    canonical: "https://valexlab.eu/pdfmanager",
  },
};

function normalizePath(pathname) {
  if (pathname === "/pdfmanager" || pathname === "/pdfmanager/") {
    return "/pdfmanager";
  }

  return "/";
}

function setPageMetadata(page) {
  document.title = page.title;
  metaDescription.content = page.description;
  ogTitle.content = page.title;
  ogDescription.content = page.description;
  ogUrl.content = page.canonical;
  canonicalLink.href = page.canonical;
}

function renderRoute(pathname = window.location.pathname) {
  const path = normalizePath(pathname);
  const isPdfManager = path === "/pdfmanager";
  const page = isPdfManager ? pages.pdfManager : pages.home;

  portfolioSection.hidden = isPdfManager;
  pdfManagerApp.hidden = !isPdfManager;
  setPageMetadata(page);

  navLinks.forEach((link) => {
    link.classList.toggle("is-active", normalizePath(new URL(link.href).pathname) === path);
  });
}

function closeDropdowns() {
  navDropdown?.classList.remove("is-open");
  languageDropdown?.classList.remove("is-open");
  navDropdownToggle?.setAttribute("aria-expanded", "false");
  languageToggle?.setAttribute("aria-expanded", "false");
}

routeLinks.forEach((link) => {
  link.addEventListener("click", (event) => {
    const url = new URL(link.href);
    const path = normalizePath(url.pathname);

    if (url.origin !== window.location.origin) {
      return;
    }

    event.preventDefault();
    closeDropdowns();
    window.history.pushState({}, "", path);
    renderRoute(path);
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});

hashLinks.forEach((link) => {
  link.addEventListener("click", (event) => {
    const targetId = link.getAttribute("href");
    if (!targetId || targetId === "#") {
      return;
    }

    event.preventDefault();
    closeDropdowns();

    if (normalizePath(window.location.pathname) !== "/") {
      window.history.pushState({}, "", "/");
      renderRoute("/");
    }

    requestAnimationFrame(() => {
      document.querySelector(targetId)?.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });
});

window.addEventListener("popstate", () => renderRoute());

function translate(key, values = {}) {
  const dictionary = {
    ...(portfolioTranslations[state.language] || portfolioTranslations.it),
    ...(translations[state.language] || translations.it),
  };
  const fallbackDictionary = {
    ...portfolioTranslations.en,
    ...translations.en,
  };
  const template = dictionary[key] || fallbackDictionary[key] || key;
  return Object.entries(values).reduce(
    (text, [name, value]) => text.replaceAll(`{${name}}`, value),
    template,
  );
}

function applyLanguage(language) {
  state.language = language;
  localStorage.setItem("pdf-manager-language", language);
  document.documentElement.lang = language;

  document.querySelectorAll("[data-i18n]").forEach((element) => {
    element.textContent = translate(element.dataset.i18n);
  });

  languageButtons.forEach((button) => {
    const isActive = button.dataset.lang === language;
    button.classList.toggle("is-active", isActive);
    button.setAttribute("aria-pressed", String(isActive));
  });

  const selectedLanguage = [...languageButtons].find((button) => button.dataset.lang === language);
  if (selectedLanguage && languageCurrent) {
    languageCurrent.textContent = selectedLanguage.dataset.label || language.toUpperCase();
  }

  if (selectedLanguage && languageToggleFlag) {
    languageToggleFlag.className = "";
    languageToggleFlag.classList.add("flag", `flag-${language}`);
  }

  if (!pdfInput.files[0] && !state.mainDoc) {
    fileName.textContent = translate("noPdf");
  }

  updateStatusText();
  updateSelectionText();
  updatePageLabels();
}

function updateStatusText(message = "") {
  if (!state.mainDoc) {
    pageInfo.textContent = message;
    workspaceSummary.textContent = "";
    return;
  }

  const count = state.mainDoc.getPageCount();
  const readyText = translate("mainReady", { file: state.mainFileName, count });
  pageInfo.textContent = message || readyText;
  workspaceSummary.textContent = readyText;
}

function updateSelectionText() {
  const mainCount = state.mainDoc ? state.mainDoc.getPageCount() : 0;
  const sourceCount = state.sourceDoc ? state.sourceDoc.getPageCount() : 0;

  selectionInfo.textContent = mainCount
    ? translate("selectedMain", { selected: state.selectedMainPages.size, count: mainCount })
    : "";

  sourceInfo.textContent = sourceCount
    ? translate("selectedSource", { selected: state.selectedSourcePages.size, count: sourceCount })
    : "";

  deleteSelectedBtn.disabled = state.selectedMainPages.size === 0;
  previewBtn.disabled = !state.mainDoc;
  downloadBtn.disabled = !state.mainDoc;
  downloadFromPreviewBtn.disabled = !state.mainDoc;
  addSelectedBtn.disabled = !state.mainDoc || state.selectedSourcePages.size === 0;
  updateInsertControl();
}

function updatePageLabels() {
  document.querySelectorAll("[data-page-label]").forEach((element) => {
    element.textContent = `${translate(element.dataset.labelKey)} ${Number(element.dataset.pageIndex) + 1}`;
  });
}

function updateInsertControl() {
  const pageCount = state.mainDoc ? state.mainDoc.getPageCount() : 0;
  insertAfterPageInput.disabled = !state.mainDoc;
  insertAfterPageInput.max = String(pageCount);

  if (!state.mainDoc) {
    insertAfterPageInput.value = "0";
    return;
  }

  const currentValue = Number(insertAfterPageInput.value);
  if (!Number.isInteger(currentValue) || currentValue < 0 || currentValue > pageCount) {
    insertAfterPageInput.value = String(pageCount);
  }
}

function setLoading(grid) {
  grid.innerHTML = `<div class="empty-state">${translate("loading")}</div>`;
}

function cleanupObjectUrls(type) {
  state.objectUrls[type].forEach((url) => URL.revokeObjectURL(url));
  state.objectUrls[type] = [];
}

function cleanupFinalPreviewUrl() {
  if (state.finalPreviewUrl) {
    URL.revokeObjectURL(state.finalPreviewUrl);
    state.finalPreviewUrl = "";
  }
}

function getSuggestedFileName() {
  const baseName = state.mainFileName.replace(/\.pdf$/i, "") || "pdf";
  return `${baseName}-${translate("savedName")}.pdf`;
}

async function getFinalPdfBytes() {
  return state.mainDoc.save();
}

async function showFinalPreview() {
  cleanupFinalPreviewUrl();
  const bytes = await getFinalPdfBytes();
  const blob = new Blob([bytes], { type: "application/pdf" });
  state.finalPreviewUrl = URL.createObjectURL(blob);
  finalPreviewFrame.src = `${state.finalPreviewUrl}#page=1&view=Fit`;
  previewSection.hidden = false;
  previewSection.scrollIntoView({ behavior: "smooth", block: "start" });
}

function closeFinalPreview() {
  previewSection.hidden = true;
  finalPreviewFrame.removeAttribute("src");
  cleanupFinalPreviewUrl();
}

function fallbackDownload(bytes) {
  const blob = new Blob([bytes], { type: "application/pdf" });
  const url = URL.createObjectURL(blob);
  const link = document.createElement("a");

  link.href = url;
  link.download = getSuggestedFileName();
  document.body.appendChild(link);
  link.click();
  link.remove();
  setTimeout(() => URL.revokeObjectURL(url), 1000);
}

async function saveFinalPdf() {
  if ("showSaveFilePicker" in window) {
    try {
      const handle = await window.showSaveFilePicker({
        suggestedName: getSuggestedFileName(),
        types: [
          {
            description: "PDF",
            accept: { "application/pdf": [".pdf"] },
          },
        ],
      });
      const bytes = await getFinalPdfBytes();
      const writable = await handle.createWritable();
      await writable.write(new Blob([bytes], { type: "application/pdf" }));
      await writable.close();
      return;
    } catch (error) {
      if (error.name === "AbortError") {
        updateStatusText(translate("saveCanceled"));
        return;
      }
      console.error(error);
    }
  }

  const bytes = await getFinalPdfBytes();
  fallbackDownload(bytes);
}

async function createSinglePageUrl(pdfDoc, pageIndex, type) {
  const previewDoc = await PDFDocument.create();
  const [page] = await previewDoc.copyPages(pdfDoc, [pageIndex]);
  previewDoc.addPage(page);
  const bytes = await previewDoc.save();
  const blob = new Blob([bytes], { type: "application/pdf" });
  const url = URL.createObjectURL(blob);
  state.objectUrls[type].push(url);
  return url;
}

function createPageCard({ url, index, type, selectedSet }) {
  const labelKey = type === "source" ? "importPage" : "page";
  const card = document.createElement("label");
  card.className = "page-card";

  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";
  checkbox.value = String(index);
  checkbox.checked = selectedSet.has(index);
  checkbox.setAttribute("aria-label", `${translate(labelKey)} ${index + 1}`);

  const preview = document.createElement("iframe");
  preview.className = "page-preview";
  preview.title = `${translate(labelKey)} ${index + 1}`;
  preview.src = `${url}#toolbar=0&navpanes=0&scrollbar=0&view=Fit`;
  preview.loading = "lazy";

  const meta = document.createElement("span");
  meta.className = "page-meta";
  meta.dataset.pageLabel = "";
  meta.dataset.labelKey = labelKey;
  meta.dataset.pageIndex = String(index);
  meta.textContent = `${translate(labelKey)} ${index + 1}`;

  checkbox.addEventListener("change", () => {
    if (checkbox.checked) {
      selectedSet.add(index);
      card.classList.add("is-selected");
    } else {
      selectedSet.delete(index);
      card.classList.remove("is-selected");
    }
    updateSelectionText();
  });

  card.classList.toggle("is-selected", checkbox.checked);
  card.append(checkbox, preview, meta);
  return card;
}

async function renderPageGrid(pdfDoc, grid, type, selectedSet) {
  cleanupObjectUrls(type);
  setLoading(grid);
  grid.innerHTML = "";

  const fragment = document.createDocumentFragment();
  for (let index = 0; index < pdfDoc.getPageCount(); index += 1) {
    const url = await createSinglePageUrl(pdfDoc, index, type);
    fragment.append(createPageCard({ url, index, type, selectedSet }));
  }

  grid.append(fragment);
  updateSelectionText();
}

async function loadMainPdf(file) {
  try {
    closeFinalPreview();
    state.selectedMainPages.clear();
    state.mainFileName = file.name;
    state.mainDoc = await PDFDocument.load(await file.arrayBuffer());
    managerSection.hidden = false;
    insertAfterPageInput.value = String(state.mainDoc.getPageCount());
    updateStatusText(translate("loading"));
    await renderPageGrid(state.mainDoc, pagesGrid, "main", state.selectedMainPages);
    updateStatusText();
  } catch (error) {
    console.error(error);
    alert(translate("invalidPdf"));
  }
}

async function loadSourcePdf(file) {
  try {
    state.selectedSourcePages.clear();
    state.sourceFileName = file.name;
    state.sourceDoc = await PDFDocument.load(await file.arrayBuffer());
    sourcePanel.hidden = false;
    sourceInfo.textContent = translate("loading");
    await renderPageGrid(state.sourceDoc, sourcePagesGrid, "source", state.selectedSourcePages);
    sourceInfo.textContent = translate("sourceReady", { file: state.sourceFileName });
    updateSelectionText();
  } catch (error) {
    console.error(error);
    alert(translate("invalidPdf"));
  }
}

async function refreshMainGrid(message = "") {
  state.selectedMainPages.clear();
  await renderPageGrid(state.mainDoc, pagesGrid, "main", state.selectedMainPages);
  updateStatusText(message);
}

function selectedIndexes(set) {
  return [...set].sort((first, second) => first - second);
}

chooseFileBtn.addEventListener("click", () => {
  pdfInput.click();
});

sourceFileBtn.addEventListener("click", () => {
  sourcePdfInput.click();
});

pdfInput.addEventListener("change", () => {
  const file = pdfInput.files[0];

  fileName.textContent = file ? file.name : translate("noPdf");
  fileStatus.classList.toggle("has-file", Boolean(file));
  loadBtn.disabled = !file;
  updateStatusText();
});

sourcePdfInput.addEventListener("change", async () => {
  const file = sourcePdfInput.files[0];
  if (file) {
    await loadSourcePdf(file);
  }
});

loadBtn.addEventListener("click", async () => {
  const file = pdfInput.files[0];
  if (!file) {
    alert(translate("noPdf"));
    return;
  }

  await loadMainPdf(file);
});

deleteSelectedBtn.addEventListener("click", async () => {
  if (!state.selectedMainPages.size) {
    alert(translate("noMainSelection"));
    return;
  }

  const indexes = selectedIndexes(state.selectedMainPages);
  if (indexes.length >= state.mainDoc.getPageCount()) {
    alert(translate("cannotDeleteAll"));
    return;
  }

  indexes.reverse().forEach((index) => state.mainDoc.removePage(index));
  closeFinalPreview();
  updateInsertControl();
  await refreshMainGrid(translate("deleted", { count: indexes.length }));
});

addSelectedBtn.addEventListener("click", async () => {
  if (!state.selectedSourcePages.size) {
    alert(translate("noSourceSelection"));
    return;
  }

  const insertAfterPage = Number(insertAfterPageInput.value);
  const mainPageCount = state.mainDoc.getPageCount();

  if (!Number.isInteger(insertAfterPage) || insertAfterPage < 0 || insertAfterPage > mainPageCount) {
    alert(translate("invalidInsertPage", { count: mainPageCount }));
    insertAfterPageInput.focus();
    return;
  }

  const indexes = selectedIndexes(state.selectedSourcePages);
  const copiedPages = await state.mainDoc.copyPages(state.sourceDoc, indexes);
  copiedPages.forEach((page, offset) => state.mainDoc.insertPage(insertAfterPage + offset, page));
  state.selectedSourcePages.clear();
  insertAfterPageInput.value = String(insertAfterPage + copiedPages.length);
  closeFinalPreview();

  await renderPageGrid(state.sourceDoc, sourcePagesGrid, "source", state.selectedSourcePages);
  await refreshMainGrid(
    insertAfterPage === 0
      ? translate("addedAtStart", { count: indexes.length })
      : translate("addedAfter", { count: indexes.length, page: insertAfterPage }),
  );
});

insertAfterPageInput.addEventListener("input", () => {
  updateSelectionText();
});

previewBtn.addEventListener("click", async () => {
  await showFinalPreview();
});

closePreviewBtn.addEventListener("click", () => {
  closeFinalPreview();
});

downloadBtn.addEventListener("click", async () => {
  await saveFinalPdf();
});

downloadFromPreviewBtn.addEventListener("click", async () => {
  await saveFinalPdf();
});

clearMainSelectionBtn.addEventListener("click", async () => {
  state.selectedMainPages.clear();
  document.querySelectorAll("#pagesGrid input").forEach((input) => {
    input.checked = false;
    input.closest(".page-card").classList.remove("is-selected");
  });
  updateSelectionText();
});

clearSourceSelectionBtn.addEventListener("click", () => {
  state.selectedSourcePages.clear();
  document.querySelectorAll("#sourcePagesGrid input").forEach((input) => {
    input.checked = false;
    input.closest(".page-card").classList.remove("is-selected");
  });
  updateSelectionText();
});

navDropdownToggle?.addEventListener("click", (event) => {
  event.stopPropagation();
  const willOpen = !navDropdown.classList.contains("is-open");
  closeDropdowns();
  navDropdown.classList.toggle("is-open", willOpen);
  navDropdownToggle.setAttribute("aria-expanded", String(willOpen));
});

languageToggle?.addEventListener("click", (event) => {
  event.stopPropagation();
  const willOpen = !languageDropdown.classList.contains("is-open");
  closeDropdowns();
  languageDropdown.classList.toggle("is-open", willOpen);
  languageToggle.setAttribute("aria-expanded", String(willOpen));
});

document.addEventListener("click", (event) => {
  if (!event.target.closest(".nav-dropdown") && !event.target.closest(".language-dropdown")) {
    closeDropdowns();
  }
});

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    closeDropdowns();
  }
});

languageButtons.forEach((button) => {
  button.addEventListener("click", () => {
    applyLanguage(button.dataset.lang);
    closeDropdowns();
  });
});

applyLanguage(state.language);
renderRoute();
generatePortfolioParticles();
initPortfolioReveal();
