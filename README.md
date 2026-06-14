# PDF Tool Web Application

A browser-based PDF manager built as a personal frontend project. The app lets users upload a PDF, preview its pages, delete selected pages, import pages from another PDF, preview the final document, and download the edited file.

The project was developed to practice client-side file handling, PDF manipulation, UI state management, and an AI-assisted development workflow.

## Features

- Upload and load a PDF directly in the browser
- Preview individual PDF pages
- Select and delete pages from the main document
- Import selected pages from a second PDF
- Choose where imported pages should be inserted
- Preview the edited PDF before saving
- Download the final PDF
- Multilingual interface: English, French, Italian, and Spanish

## Tech Stack

- HTML
- CSS
- JavaScript
- Vite
- pdf-lib

## Getting Started

Install dependencies:

```bash
npm install
```

Start the development server:

```bash
npm run dev
```

Create a production build:

```bash
npm run build
```

Preview the production build locally:

```bash
npm run preview
```

## Deploy Online

This is a static Vite app. Build it with:

```bash
npm run build
```

The production files are generated in:

```text
dist/
```

### Vercel

1. Push the project to a GitHub repository.
2. Create a new Vercel project.
3. Import the GitHub repository.
4. Use these settings:
   - Framework: Vite
   - Build command: `npm run build`
   - Output directory: `dist`
5. Deploy.

The repository includes `vercel.json` with the same build settings.

### Netlify

1. Push the project to a GitHub repository, or upload the `dist/` folder manually.
2. Create a new Netlify site.
3. Use these settings:
   - Build command: `npm run build`
   - Publish directory: `dist`
4. Deploy.

The repository includes `netlify.toml` with the same build settings.

### Search Engine Setup

After publishing:

1. Connect a custom domain.
2. Add the site to Google Search Console.
3. Request indexing for the homepage.
4. Add the final public URL to a sitemap if the site grows beyond one page.

Production domain:

```text
https://valexlab.eu/
```

Recommended canonical setup:

- `valexlab.eu` as the canonical domain
- `www.valexlab.eu` as an alias that redirects to `valexlab.eu`

## Project Structure

```text
.
|-- index.html
|-- style.css
|-- app.js
|-- package.json
|-- package-lock.json
|-- netlify.toml
|-- vercel.json
|-- public/
|   `-- robots.txt
`-- README.md
```

## AI-Assisted Development

This project was built independently with support from AI coding tools such as ChatGPT/Codex.

AI was used as a technical assistant for:

- planning features and interaction flows
- debugging JavaScript issues
- improving code structure
- reviewing implementation choices
- writing and refining documentation

All final implementation decisions, integration work, manual testing, and project direction were handled by me.

## What I Practiced

- Working with browser file inputs and client-side PDF processing
- Managing application state with plain JavaScript
- Creating dynamic page previews and selection controls
- Handling user feedback, validation, and download flows
- Building a small but complete frontend project from idea to working application

## Notes

PDF processing happens in the browser. The app does not upload user files to a server.
