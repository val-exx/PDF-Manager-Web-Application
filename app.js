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
    navAbout: "Studio",
    navSkills: "Perché noi",
    navProjects: "Soluzioni",
    navContact: "Contatti",
    menuQuality: "Gestione Qualità",
    menuDashboard: "Dashboard & KPI",
    menuProduction: "Gestione Produzione",
    menuGestiva: "gestiva_v1",
    menuShopSites: "Soluzioni su misura",
    portfolioEyebrow: "Soluzioni gestionali per aziende",
    portfolioSubtitle: "Creiamo gestionali e soluzioni software su misura per digitalizzare i processi aziendali: qualità, produzione, documenti, commesse e flussi operativi sempre sotto controllo.",
    portfolioOpenPdf: "Richiedi una demo",
    portfolioExploreServices: "Le soluzioni",
    metricTool: "Demo live online",
    metricAreas: "Aree gestionali",
    metricClientSide: "Su misura",
    badgeQuality: "procedure e controlli",
    badgeOps: "commesse e produzione",
    badgeDocs: "PDF e automazioni",
    aboutEyebrow: "Lo studio",
    aboutTitle: "Software gestionali su misura per processi aziendali reali.",
    aboutDesc: "ValexLab progetta e sviluppa gestionali e soluzioni software per le aziende: qualità, documentazione, produzione, dashboard operative e automazioni costruite per semplificare il lavoro di ogni giorno.",
    servicesEyebrow: "Soluzioni",
    servicesTitle: "Soluzioni gestionali per la tua azienda",
    serviceQualityTitle: "Qualità & documentazione",
    serviceQualityDesc: "Procedure, checklist, non conformità, audit interni e archivi documentali consultabili in modo ordinato.",
    serviceOpsTitle: "Produzione & commesse",
    serviceOpsDesc: "Dashboard per commesse, avanzamento lavorazioni, priorità, materiali e tracciamento delle attività chiave.",
    serviceDocsTitle: "Documenti & automazioni",
    serviceDocsDesc: "Strumenti per gestire PDF, moduli e allegati con automazioni che riducono il lavoro ripetitivo.",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "Gestionale modulare per attività, clienti, documenti e flussi operativi, pensato come base evolutiva per processi aziendali su misura.",
    servicePrototypeTitle: "Soluzioni su misura",
    servicePrototypeDesc: "Gestionali e web app costruiti sul tuo processo reale, semplici da usare e pronti a crescere con te.",
    skillsEyebrow: "Perché noi",
    skillsTitle: "Perché scegliere ValexLab",
    skillProcessTitle: "Analisi dei processi",
    skillProcessDesc: "Mappiamo ruoli, dati, documenti e punti critici prima di costruire la soluzione.",
    skillWebTitle: "Software su misura",
    skillWebDesc: "Gestionali leggeri, veloci e responsive, pensati per chi lavora ogni giorno.",
    skillDashboardTitle: "Dashboard & KPI",
    skillDashboardDesc: "Avanzamenti, priorità, controlli e indicatori utili alla gestione, sempre sott'occhio.",
    skillWorkflowTitle: "Assistenza continua",
    skillWorkflowDesc: "Un partner di riferimento per aggiornamenti, modifiche e supporto nel tempo.",
    projectsEyebrow: "Soluzioni",
    projectsTitle: "Soluzioni e demo",
    projectStatusLive: "Demo live",
    projectPdfDesc: "Web app che gestisce i PDF direttamente nel browser: elimina e riordina pagine, importa da altri documenti e scarica il file finale. Una demo delle nostre soluzioni su misura.",
    projectOpen: "Apri la demo",
    projectStatusRoadmap: "Gestionale",
    projectQualityTitle: "Gestione Qualità",
    projectQualityDesc: "Gestionale per procedure, controlli, non conformità, audit e documentazione qualità in azienda.",
    projectProductionTitle: "Gestione Produzione",
    projectProductionDesc: "Sistema operativo dedicato a commesse, avanzamento lavori, materiali e report essenziali.",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "Progetto gestionale dedicato a organizzare clienti, attività, documenti e avanzamenti in un unico spazio operativo personalizzabile.",
    projectStatusService: "Su misura",
    projectShopSitesTitle: "Gestionale su misura",
    projectShopSitesDesc: "Analizziamo come lavori e costruiamo la soluzione che ti serve: dati, documenti, flussi e automazioni su misura.",
    methodEyebrow: "Metodo",
    methodTitle: "Come lavoriamo",
    workflowMapTitle: "Analisi & preventivo",
    workflowMapDesc: "Capiamo chi usa il sistema, quali dati servono e dove si perde tempo, con un preventivo chiaro.",
    workflowUiTitle: "Sviluppo & test",
    workflowUiDesc: "Costruiamo la soluzione e la proviamo sul processo reale, raccogliendo il tuo feedback.",
    workflowReleaseTitle: "Rilascio & supporto",
    workflowReleaseDesc: "Mettiamo online lo strumento e restiamo al tuo fianco con aggiornamenti e assistenza.",
    contactEyebrow: "Contatti",
    contactTitle: "Hai un processo da digitalizzare?",
    contactDesc: "Raccontaci come lavori: ti proponiamo la soluzione gestionale più adatta, con una demo e un preventivo su misura.",
    contactButton: "Richiedi una demo",
    ctaEyebrow: "Iniziamo",
    ctaTitle: "La tua prossima soluzione gestionale inizia qui.",
    ctaDesc: "Dal primo tool a un gestionale completo, ValexLab digitalizza e semplifica i processi della tua azienda.",
    ctaButton: "Parliamo del tuo progetto",
  },
  en: {
    navHome: "Home",
    navAbout: "Studio",
    navSkills: "Why us",
    navProjects: "Solutions",
    navContact: "Contact",
    menuQuality: "Quality management",
    menuDashboard: "Dashboards & KPIs",
    menuProduction: "Production management",
    menuGestiva: "gestiva_v1",
    menuShopSites: "Custom solutions",
    portfolioEyebrow: "Business management solutions",
    portfolioSubtitle: "We build custom management software and solutions to digitize your business processes: quality, production, documents, jobs and operations always under control.",
    portfolioOpenPdf: "Request a demo",
    portfolioExploreServices: "Solutions",
    metricTool: "Live demo online",
    metricAreas: "Management areas",
    metricClientSide: "Fully custom",
    badgeQuality: "procedures & controls",
    badgeOps: "jobs & production",
    badgeDocs: "PDF & automation",
    aboutEyebrow: "The studio",
    aboutTitle: "Custom management software for real business processes.",
    aboutDesc: "ValexLab designs and builds management software and solutions for companies: quality, documentation, production, operational dashboards and automation built to simplify everyday work.",
    servicesEyebrow: "Solutions",
    servicesTitle: "Management solutions for your business",
    serviceQualityTitle: "Quality & documentation",
    serviceQualityDesc: "Procedures, checklists, non-conformities, internal audits and document archives that stay tidy and easy to consult.",
    serviceOpsTitle: "Production & jobs",
    serviceOpsDesc: "Dashboards for jobs, work progress, priorities, materials and tracking of the key activities.",
    serviceDocsTitle: "Documents & automation",
    serviceDocsDesc: "Tools to manage PDFs, forms and attachments with automation that cuts repetitive work.",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "A modular management tool for tasks, customers, documents and workflows, designed as an evolving base for custom business processes.",
    servicePrototypeTitle: "Custom solutions",
    servicePrototypeDesc: "Management tools and web apps built around your real process, easy to use and ready to grow with you.",
    skillsEyebrow: "Why us",
    skillsTitle: "Why choose ValexLab",
    skillProcessTitle: "Process analysis",
    skillProcessDesc: "We map roles, data, documents and pain points before building the solution.",
    skillWebTitle: "Custom software",
    skillWebDesc: "Lightweight, fast, responsive management tools made for people who work every day.",
    skillDashboardTitle: "Dashboards & KPIs",
    skillDashboardDesc: "Progress, priorities, controls and useful indicators, always at a glance.",
    skillWorkflowTitle: "Ongoing support",
    skillWorkflowDesc: "A reliable partner for updates, changes and support over time.",
    projectsEyebrow: "Solutions",
    projectsTitle: "Solutions & demos",
    projectStatusLive: "Live demo",
    projectPdfDesc: "A web app that manages PDFs right in the browser: delete and reorder pages, import from other documents and download the final file. A demo of our custom solutions.",
    projectOpen: "Open the demo",
    projectStatusRoadmap: "Software",
    projectQualityTitle: "Quality management",
    projectQualityDesc: "Software for procedures, controls, non-conformities, audits and quality documentation in the company.",
    projectProductionTitle: "Production management",
    projectProductionDesc: "A system dedicated to jobs, work progress, materials and essential reports.",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "A management project focused on organizing customers, tasks, documents and progress in one customizable operational workspace.",
    projectStatusService: "Tailored",
    projectShopSitesTitle: "Tailored management software",
    projectShopSitesDesc: "We analyze how you work and build the solution you need: data, documents, workflows and automation made to measure.",
    methodEyebrow: "Method",
    methodTitle: "How we work",
    workflowMapTitle: "Analysis & quote",
    workflowMapDesc: "We understand who uses the system, what data is needed and where time is lost, with a clear quote.",
    workflowUiTitle: "Build & test",
    workflowUiDesc: "We build the solution and test it on the real process, gathering your feedback.",
    workflowReleaseTitle: "Launch & support",
    workflowReleaseDesc: "We put the tool online and stay by your side with updates and assistance.",
    contactEyebrow: "Contact",
    contactTitle: "Got a process to digitize?",
    contactDesc: "Tell us how you work: we'll propose the right management solution, with a demo and a tailored quote.",
    contactButton: "Request a demo",
    ctaEyebrow: "Let's start",
    ctaTitle: "Your next management solution starts here.",
    ctaDesc: "From the first tool to a complete management system, ValexLab digitizes and simplifies your business processes.",
    ctaButton: "Let's talk about your project",
  },
  fr: {
    navHome: "Accueil",
    navAbout: "Studio",
    navSkills: "Pourquoi nous",
    navProjects: "Solutions",
    navContact: "Contact",
    menuQuality: "Gestion qualité",
    menuDashboard: "Tableaux de bord & KPI",
    menuProduction: "Gestion production",
    menuGestiva: "gestiva_v1",
    menuShopSites: "Solutions sur mesure",
    portfolioEyebrow: "Solutions de gestion pour les entreprises",
    portfolioSubtitle: "Nous créons des logiciels de gestion et des solutions sur mesure pour digitaliser vos processus : qualité, production, documents, affaires et opérations toujours sous contrôle.",
    portfolioOpenPdf: "Demander une démo",
    portfolioExploreServices: "Les solutions",
    metricTool: "Démo en ligne",
    metricAreas: "Domaines de gestion",
    metricClientSide: "Sur mesure",
    badgeQuality: "procédures & contrôles",
    badgeOps: "affaires & production",
    badgeDocs: "PDF & automatisation",
    aboutEyebrow: "Le studio",
    aboutTitle: "Des logiciels de gestion sur mesure pour des processus réels.",
    aboutDesc: "ValexLab conçoit et développe des logiciels de gestion et des solutions pour les entreprises : qualité, documentation, production, tableaux de bord et automatisations pensés pour simplifier le travail au quotidien.",
    servicesEyebrow: "Solutions",
    servicesTitle: "Des solutions de gestion pour votre entreprise",
    serviceQualityTitle: "Qualité & documentation",
    serviceQualityDesc: "Procédures, checklists, non-conformités, audits internes et archives documentaires claires et faciles à consulter.",
    serviceOpsTitle: "Production & affaires",
    serviceOpsDesc: "Tableaux de bord pour les affaires, l'avancement, les priorités, les matériaux et le suivi des activités clés.",
    serviceDocsTitle: "Documents & automatisation",
    serviceDocsDesc: "Des outils pour gérer PDF, formulaires et pièces jointes avec des automatisations qui réduisent les tâches répétitives.",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "Un logiciel de gestion modulaire pour activités, clients, documents et flux, conçu comme base évolutive pour des processus sur mesure.",
    servicePrototypeTitle: "Solutions sur mesure",
    servicePrototypeDesc: "Logiciels de gestion et web apps construits autour de votre processus réel, simples à utiliser et prêts à évoluer.",
    skillsEyebrow: "Pourquoi nous",
    skillsTitle: "Pourquoi choisir ValexLab",
    skillProcessTitle: "Analyse des processus",
    skillProcessDesc: "Nous cartographions rôles, données, documents et points critiques avant de construire la solution.",
    skillWebTitle: "Logiciel sur mesure",
    skillWebDesc: "Des outils de gestion légers, rapides et responsives, faits pour ceux qui travaillent chaque jour.",
    skillDashboardTitle: "Tableaux de bord & KPI",
    skillDashboardDesc: "Avancement, priorités, contrôles et indicateurs utiles, toujours en un coup d'œil.",
    skillWorkflowTitle: "Accompagnement continu",
    skillWorkflowDesc: "Un partenaire fiable pour les mises à jour, les modifications et le support dans la durée.",
    projectsEyebrow: "Solutions",
    projectsTitle: "Solutions & démos",
    projectStatusLive: "Démo en ligne",
    projectPdfDesc: "Une web app qui gère les PDF directement dans le navigateur : supprimez et réorganisez des pages, importez depuis d'autres documents et téléchargez le fichier final. Une démo de nos solutions sur mesure.",
    projectOpen: "Ouvrir la démo",
    projectStatusRoadmap: "Logiciel",
    projectQualityTitle: "Gestion qualité",
    projectQualityDesc: "Logiciel pour les procédures, contrôles, non-conformités, audits et documentation qualité en entreprise.",
    projectProductionTitle: "Gestion production",
    projectProductionDesc: "Un système dédié aux affaires, à l'avancement, aux matériaux et aux rapports essentiels.",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "Projet de gestion pour organiser clients, activités, documents et avancements dans un espace opérationnel personnalisable.",
    projectStatusService: "Sur mesure",
    projectShopSitesTitle: "Logiciel de gestion sur mesure",
    projectShopSitesDesc: "Nous analysons votre façon de travailler et construisons la solution qu'il vous faut : données, documents, flux et automatisations sur mesure.",
    methodEyebrow: "Méthode",
    methodTitle: "Notre façon de travailler",
    workflowMapTitle: "Analyse & devis",
    workflowMapDesc: "Nous comprenons qui utilise le système, quelles données sont nécessaires et où l'on perd du temps, avec un devis clair.",
    workflowUiTitle: "Développement & test",
    workflowUiDesc: "Nous construisons la solution et la testons sur le processus réel, en recueillant vos retours.",
    workflowReleaseTitle: "Lancement & support",
    workflowReleaseDesc: "Nous mettons l'outil en ligne et restons à vos côtés avec mises à jour et assistance.",
    contactEyebrow: "Contact",
    contactTitle: "Un processus à digitaliser ?",
    contactDesc: "Dites-nous comment vous travaillez : nous proposons la bonne solution de gestion, avec une démo et un devis sur mesure.",
    contactButton: "Demander une démo",
    ctaEyebrow: "Commençons",
    ctaTitle: "Votre prochaine solution de gestion commence ici.",
    ctaDesc: "Du premier outil à un logiciel complet, ValexLab digitalise et simplifie les processus de votre entreprise.",
    ctaButton: "Parlons de votre projet",
  },
  de: {
    navHome: "Start",
    navAbout: "Studio",
    navSkills: "Warum wir",
    navProjects: "Lösungen",
    navContact: "Kontakt",
    menuQuality: "Qualitätsmanagement",
    menuDashboard: "Dashboards & KPIs",
    menuProduction: "Produktionsmanagement",
    menuGestiva: "gestiva_v1",
    menuShopSites: "Individuelle Lösungen",
    portfolioEyebrow: "Management-Lösungen für Unternehmen",
    portfolioSubtitle: "Wir entwickeln individuelle Management-Software und Lösungen, um Ihre Geschäftsprozesse zu digitalisieren: Qualität, Produktion, Dokumente, Aufträge und Abläufe stets im Griff.",
    portfolioOpenPdf: "Demo anfragen",
    portfolioExploreServices: "Die Lösungen",
    metricTool: "Live-Demo online",
    metricAreas: "Management-Bereiche",
    metricClientSide: "Maßgeschneidert",
    badgeQuality: "Prozesse & Kontrollen",
    badgeOps: "Aufträge & Produktion",
    badgeDocs: "PDF & Automatisierung",
    aboutEyebrow: "Das Studio",
    aboutTitle: "Individuelle Management-Software für echte Geschäftsprozesse.",
    aboutDesc: "ValexLab gestaltet und entwickelt Management-Software und Lösungen für Unternehmen: Qualität, Dokumentation, Produktion, operative Dashboards und Automatisierungen, die den Arbeitsalltag vereinfachen.",
    servicesEyebrow: "Lösungen",
    servicesTitle: "Management-Lösungen für Ihr Unternehmen",
    serviceQualityTitle: "Qualität & Dokumentation",
    serviceQualityDesc: "Verfahren, Checklisten, Abweichungen, interne Audits und Dokumentenarchive – übersichtlich und leicht abrufbar.",
    serviceOpsTitle: "Produktion & Aufträge",
    serviceOpsDesc: "Dashboards für Aufträge, Arbeitsfortschritt, Prioritäten, Material und das Tracking der wichtigsten Aktivitäten.",
    serviceDocsTitle: "Dokumente & Automatisierung",
    serviceDocsDesc: "Werkzeuge für PDFs, Formulare und Anhänge mit Automatisierungen, die wiederkehrende Arbeit reduzieren.",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "Modulare Management-Software für Aufgaben, Kunden, Dokumente und Abläufe als ausbaufähige Basis für individuelle Geschäftsprozesse.",
    servicePrototypeTitle: "Individuelle Lösungen",
    servicePrototypeDesc: "Management-Tools und Web-Apps rund um Ihren echten Prozess, einfach zu bedienen und bereit mitzuwachsen.",
    skillsEyebrow: "Warum wir",
    skillsTitle: "Warum ValexLab",
    skillProcessTitle: "Prozessanalyse",
    skillProcessDesc: "Wir kartieren Rollen, Daten, Dokumente und Schwachstellen, bevor wir die Lösung bauen.",
    skillWebTitle: "Individuelle Software",
    skillWebDesc: "Leichte, schnelle, responsive Management-Tools für Menschen, die jeden Tag damit arbeiten.",
    skillDashboardTitle: "Dashboards & KPIs",
    skillDashboardDesc: "Fortschritt, Prioritäten, Kontrollen und nützliche Kennzahlen, immer im Blick.",
    skillWorkflowTitle: "Laufende Betreuung",
    skillWorkflowDesc: "Ein verlässlicher Partner für Updates, Änderungen und Support über die Zeit.",
    projectsEyebrow: "Lösungen",
    projectsTitle: "Lösungen & Demos",
    projectStatusLive: "Live-Demo",
    projectPdfDesc: "Eine Web-App, die PDFs direkt im Browser verwaltet: Seiten löschen und neu anordnen, aus anderen Dokumenten importieren und die fertige Datei herunterladen. Eine Demo unserer individuellen Lösungen.",
    projectOpen: "Demo öffnen",
    projectStatusRoadmap: "Software",
    projectQualityTitle: "Qualitätsmanagement",
    projectQualityDesc: "Software für Verfahren, Kontrollen, Abweichungen, Audits und Qualitätsdokumentation im Unternehmen.",
    projectProductionTitle: "Produktionsmanagement",
    projectProductionDesc: "Ein System für Aufträge, Arbeitsfortschritt, Material und wesentliche Reports.",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "Management-Projekt zur Organisation von Kunden, Aufgaben, Dokumenten und Fortschritten in einem anpassbaren Arbeitsbereich.",
    projectStatusService: "Maßgeschneidert",
    projectShopSitesTitle: "Individuelle Management-Software",
    projectShopSitesDesc: "Wir analysieren Ihre Arbeitsweise und bauen die passende Lösung: Daten, Dokumente, Abläufe und Automatisierungen nach Maß.",
    methodEyebrow: "Methode",
    methodTitle: "So arbeiten wir",
    workflowMapTitle: "Analyse & Angebot",
    workflowMapDesc: "Wir verstehen, wer das System nutzt, welche Daten nötig sind und wo Zeit verloren geht – mit klarem Angebot.",
    workflowUiTitle: "Entwicklung & Test",
    workflowUiDesc: "Wir bauen die Lösung und testen sie am realen Prozess, mit Ihrem Feedback.",
    workflowReleaseTitle: "Launch & Support",
    workflowReleaseDesc: "Wir bringen das Tool online und bleiben an Ihrer Seite – mit Updates und Hilfe.",
    contactEyebrow: "Kontakt",
    contactTitle: "Einen Prozess zu digitalisieren?",
    contactDesc: "Erzählen Sie uns, wie Sie arbeiten: Wir schlagen die passende Management-Lösung vor, mit Demo und individuellem Angebot.",
    contactButton: "Demo anfragen",
    ctaEyebrow: "Los geht's",
    ctaTitle: "Ihre nächste Management-Lösung beginnt hier.",
    ctaDesc: "Vom ersten Tool bis zur kompletten Software: ValexLab digitalisiert und vereinfacht Ihre Geschäftsprozesse.",
    ctaButton: "Über Ihr Projekt sprechen",
  },
  es: {
    navHome: "Inicio",
    navAbout: "Estudio",
    navSkills: "Por qué",
    navProjects: "Soluciones",
    navContact: "Contacto",
    menuQuality: "Gestión de calidad",
    menuDashboard: "Dashboards & KPIs",
    menuProduction: "Gestión de producción",
    menuGestiva: "gestiva_v1",
    menuShopSites: "Soluciones a medida",
    portfolioEyebrow: "Soluciones de gestión para empresas",
    portfolioSubtitle: "Creamos software de gestión y soluciones a medida para digitalizar tus procesos: calidad, producción, documentos, trabajos y operaciones siempre bajo control.",
    portfolioOpenPdf: "Solicitar una demo",
    portfolioExploreServices: "Las soluciones",
    metricTool: "Demo en vivo",
    metricAreas: "Áreas de gestión",
    metricClientSide: "A medida",
    badgeQuality: "procedimientos y controles",
    badgeOps: "trabajos y producción",
    badgeDocs: "PDF y automatización",
    aboutEyebrow: "El estudio",
    aboutTitle: "Software de gestión a medida para procesos reales.",
    aboutDesc: "ValexLab diseña y desarrolla software de gestión y soluciones para empresas: calidad, documentación, producción, paneles operativos y automatizaciones pensados para simplificar el trabajo diario.",
    servicesEyebrow: "Soluciones",
    servicesTitle: "Soluciones de gestión para tu empresa",
    serviceQualityTitle: "Calidad & documentación",
    serviceQualityDesc: "Procedimientos, checklists, no conformidades, auditorías internas y archivos documentales ordenados y fáciles de consultar.",
    serviceOpsTitle: "Producción & trabajos",
    serviceOpsDesc: "Paneles para trabajos, avance, prioridades, materiales y seguimiento de las actividades clave.",
    serviceDocsTitle: "Documentos & automatización",
    serviceDocsDesc: "Herramientas para gestionar PDF, formularios y adjuntos con automatizaciones que reducen el trabajo repetitivo.",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "Software modular para actividades, clientes, documentos y flujos operativos, pensado como base evolutiva para procesos a medida.",
    servicePrototypeTitle: "Soluciones a medida",
    servicePrototypeDesc: "Software de gestión y web apps construidos sobre tu proceso real, fáciles de usar y listos para crecer.",
    skillsEyebrow: "Por qué",
    skillsTitle: "Por qué elegir ValexLab",
    skillProcessTitle: "Análisis de procesos",
    skillProcessDesc: "Mapeamos roles, datos, documentos y puntos críticos antes de construir la solución.",
    skillWebTitle: "Software a medida",
    skillWebDesc: "Herramientas de gestión ligeras, rápidas y responsive, pensadas para quien trabaja cada día.",
    skillDashboardTitle: "Dashboards & KPIs",
    skillDashboardDesc: "Avances, prioridades, controles e indicadores útiles, siempre a la vista.",
    skillWorkflowTitle: "Soporte continuo",
    skillWorkflowDesc: "Un socio de confianza para actualizaciones, cambios y soporte a lo largo del tiempo.",
    projectsEyebrow: "Soluciones",
    projectsTitle: "Soluciones y demos",
    projectStatusLive: "Demo en vivo",
    projectPdfDesc: "Una web app que gestiona PDF directamente en el navegador: elimina y reordena páginas, importa de otros documentos y descarga el archivo final. Una demo de nuestras soluciones a medida.",
    projectOpen: "Abrir la demo",
    projectStatusRoadmap: "Software",
    projectQualityTitle: "Gestión de calidad",
    projectQualityDesc: "Software para procedimientos, controles, no conformidades, auditorías y documentación de calidad en la empresa.",
    projectProductionTitle: "Gestión de producción",
    projectProductionDesc: "Un sistema dedicado a trabajos, avance, materiales e informes esenciales.",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "Proyecto de gestión para organizar clientes, actividades, documentos y avances en un único espacio operativo personalizable.",
    projectStatusService: "A medida",
    projectShopSitesTitle: "Software de gestión a medida",
    projectShopSitesDesc: "Analizamos cómo trabajas y construimos la solución que necesitas: datos, documentos, flujos y automatizaciones a medida.",
    methodEyebrow: "Método",
    methodTitle: "Cómo trabajamos",
    workflowMapTitle: "Análisis & presupuesto",
    workflowMapDesc: "Entendemos quién usa el sistema, qué datos hacen falta y dónde se pierde tiempo, con un presupuesto claro.",
    workflowUiTitle: "Desarrollo & prueba",
    workflowUiDesc: "Construimos la solución y la probamos sobre el proceso real, recogiendo tu feedback.",
    workflowReleaseTitle: "Lanzamiento & soporte",
    workflowReleaseDesc: "Ponemos la herramienta online y seguimos a tu lado con actualizaciones y asistencia.",
    contactEyebrow: "Contacto",
    contactTitle: "¿Tienes un proceso que digitalizar?",
    contactDesc: "Cuéntanos cómo trabajas: te proponemos la solución de gestión adecuada, con una demo y un presupuesto a medida.",
    contactButton: "Solicitar una demo",
    ctaEyebrow: "Empecemos",
    ctaTitle: "Tu próxima solución de gestión empieza aquí.",
    ctaDesc: "Del primer tool a un software completo, ValexLab digitaliza y simplifica los procesos de tu empresa.",
    ctaButton: "Hablemos de tu proyecto",
  },
  zh: {
    navHome: "首页",
    navAbout: "工作室",
    navSkills: "为什么选我们",
    navProjects: "解决方案",
    navContact: "联系",
    menuQuality: "质量管理",
    menuDashboard: "仪表盘与 KPI",
    menuProduction: "生产管理",
    menuGestiva: "gestiva_v1",
    menuShopSites: "定制方案",
    portfolioEyebrow: "面向企业的管理解决方案",
    portfolioSubtitle: "我们打造定制的管理软件与解决方案，让企业流程数字化：质量、生产、文档、订单与运营，一切尽在掌握。",
    portfolioOpenPdf: "申请演示",
    portfolioExploreServices: "解决方案",
    metricTool: "在线演示",
    metricAreas: "管理领域",
    metricClientSide: "完全定制",
    badgeQuality: "流程与管控",
    badgeOps: "订单与生产",
    badgeDocs: "PDF 与自动化",
    aboutEyebrow: "工作室",
    aboutTitle: "为真实业务流程打造的定制管理软件。",
    aboutDesc: "ValexLab 为企业设计并开发管理软件与解决方案：质量、文档、生产、运营仪表盘与自动化，旨在简化日常工作。",
    servicesEyebrow: "解决方案",
    servicesTitle: "为您的企业提供管理解决方案",
    serviceQualityTitle: "质量与文档",
    serviceQualityDesc: "流程、检查表、不合格项、内部审核与文档档案，井然有序、易于查阅。",
    serviceOpsTitle: "生产与订单",
    serviceOpsDesc: "面向订单、进度、优先级、物料与关键活动跟踪的仪表盘。",
    serviceDocsTitle: "文档与自动化",
    serviceDocsDesc: "管理 PDF、表单与附件的工具，配合自动化减少重复工作。",
    serviceGestivaTitle: "gestiva_v1",
    serviceGestivaDesc: "面向任务、客户、文档与业务流程的模块化管理工具，可作为定制企业流程的可扩展基础。",
    servicePrototypeTitle: "定制方案",
    servicePrototypeDesc: "围绕您真实流程打造的管理工具与 Web 应用，易用且可随业务成长。",
    skillsEyebrow: "为什么选我们",
    skillsTitle: "为什么选择 ValexLab",
    skillProcessTitle: "流程分析",
    skillProcessDesc: "在动手开发前，我们先梳理角色、数据、文档与痛点。",
    skillWebTitle: "定制软件",
    skillWebDesc: "轻量、快速、响应式的管理工具，为每天使用的人而打造。",
    skillDashboardTitle: "仪表盘与 KPI",
    skillDashboardDesc: "进度、优先级、管控与实用指标，一目了然。",
    skillWorkflowTitle: "持续支持",
    skillWorkflowDesc: "长期可靠的合作伙伴，提供更新、修改与支持。",
    projectsEyebrow: "解决方案",
    projectsTitle: "方案与演示",
    projectStatusLive: "在线演示",
    projectPdfDesc: "一款在浏览器中直接管理 PDF 的 Web 应用：删除和重排页面、从其他文档导入并下载最终文件。这是我们定制方案的演示。",
    projectOpen: "打开演示",
    projectStatusRoadmap: "软件",
    projectQualityTitle: "质量管理",
    projectQualityDesc: "用于企业流程、管控、不合格项、审核与质量文档的软件。",
    projectProductionTitle: "生产管理",
    projectProductionDesc: "专注订单、进度、物料与关键报表的系统。",
    projectGestivaTitle: "gestiva_v1",
    projectGestivaDesc: "用于在一个可定制工作空间中管理客户、任务、文档与进度的管理系统项目。",
    projectStatusService: "定制",
    projectShopSitesTitle: "定制管理软件",
    projectShopSitesDesc: "我们分析您的工作方式并打造所需方案：数据、文档、流程与自动化，量身定制。",
    methodEyebrow: "方法",
    methodTitle: "我们的工作方式",
    workflowMapTitle: "分析与报价",
    workflowMapDesc: "我们了解谁使用系统、需要哪些数据、哪里浪费时间，并给出清晰报价。",
    workflowUiTitle: "开发与测试",
    workflowUiDesc: "我们开发方案并在真实流程上测试，收集您的反馈。",
    workflowReleaseTitle: "上线与支持",
    workflowReleaseDesc: "我们让工具上线，并持续提供更新与协助。",
    contactEyebrow: "联系",
    contactTitle: "有需要数字化的流程吗？",
    contactDesc: "告诉我们您的工作方式：我们会提出合适的管理方案，并提供演示与定制报价。",
    contactButton: "申请演示",
    ctaEyebrow: "开始吧",
    ctaTitle: "您的下一个管理方案从这里开始。",
    ctaDesc: "从第一个工具到完整的管理软件，ValexLab 让您的企业流程数字化、更简单。",
    ctaButton: "聊聊您的项目",
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

  for (let index = 0; index < 18; index += 1) {
    const particle = document.createElement("span");
    particle.className = "particle";
    const size = 5 + Math.random() * 9;
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;
    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;
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
    title: "ValexLab - Software gestionali e soluzioni su misura per aziende",
    description: "ValexLab crea gestionali e soluzioni software su misura per qualità, produzione, documenti, automazioni e processi aziendali, incluso gestiva_v1.",
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

const themeToggle = document.querySelector(".theme-toggle");
function applyTheme(theme) {
  document.documentElement.setAttribute("data-theme", theme);
  try { localStorage.setItem("valexlab-theme", theme); } catch (e) {}
  if (themeToggle) {
    themeToggle.setAttribute("aria-pressed", String(theme === "dark"));
  }
}
if (themeToggle) {
  themeToggle.addEventListener("click", () => {
    const current = document.documentElement.getAttribute("data-theme") === "dark" ? "dark" : "light";
    applyTheme(current === "dark" ? "light" : "dark");
  });
  themeToggle.setAttribute("aria-pressed", String(document.documentElement.getAttribute("data-theme") === "dark"));
}

applyLanguage(state.language);
renderRoute();
generatePortfolioParticles();
initPortfolioReveal();
