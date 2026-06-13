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
const finalPreviewFrame = document.getElementById("finalPreviewFrame");
const pagesGrid = document.getElementById("pagesGrid");
const sourcePagesGrid = document.getElementById("sourcePagesGrid");
const languageButtons = document.querySelectorAll(".language-option");
const savedLanguage = localStorage.getItem("pdf-manager-language");

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

function translate(key, values = {}) {
  const dictionary = translations[state.language] || translations.it;
  const template = dictionary[key] || translations.en[key] || key;
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

languageButtons.forEach((button) => {
  button.addEventListener("click", () => applyLanguage(button.dataset.lang));
});

applyLanguage(state.language);
