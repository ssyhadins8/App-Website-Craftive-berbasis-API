import fs from 'fs';
import path from 'path';
import { marked } from 'marked';
import { exec } from 'child_process';

// Get the root directory
const rootDir = 'C:/xampp1/htdocs/craftive';
const mdPath = path.join(rootDir, 'LAPORAN_UAS.md');
const htmlPath = path.join(rootDir, 'LAPORAN_UAS.html');
const pdfPath = path.join(rootDir, 'LAPORAN_UAS.pdf');

// Read markdown
let markdown = fs.readFileSync(mdPath, 'utf8');

// Parse markdown to HTML
let contentHtml = marked.parse(markdown);

// Premium CSS Styling for print-to-pdf
const htmlTemplate = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Proyek Akhir UAS - Pemrograman API</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #C84B1E;      /* Terracotta */
            --primary-dark: #A53612;
            --primary-light: #FDF4F0;
            --secondary: #2C2C2C;    /* Charcoal */
            --bg-cream: #FAF4EA;     /* Linen Cream */
            --bg-card: #FFFFFF;
            --text-main: #333333;
            --text-muted: #666666;
            --border-color: #E2E8F0;
        }

        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: var(--text-main);
            background-color: #FFFFFF;
            margin: 0;
            padding: 0;
            font-size: 12pt;
        }

        /* Page Containment */
        .page {
            position: relative;
            height: 25.4cm; /* Fits exactly on A4 page with 2cm margins and small safe area */
            page-break-after: always;
            box-sizing: border-box;
            padding-bottom: 1.5cm; /* Space for the manual page footer */
            overflow: hidden; /* Prevent content overflow into next page */
        }

        /* Cover Page Styling */
        .cover-page {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 25.4cm;
            page-break-after: always;
            box-sizing: border-box;
            padding: 0;
        }

        /* Spacing Rules */
        .spasi-double p, .spasi-double li {
            line-height: 2.0; /* Spasi 2 (double) for academic BAB 1-3 content */
            text-align: justify;
            margin-bottom: 10px;
        }

        .spasi-single p, .spasi-single li {
            line-height: 1.5; /* Spasi 1.5/single for abstractions and logs */
            text-align: justify;
            margin-bottom: 10px;
        }

        /* Typography & Layout */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            color: var(--secondary);
            font-weight: 700;
            margin-top: 1.2em;
            margin-bottom: 0.4em;
            page-break-after: avoid;
            line-height: 1.3;
        }

        h1 {
            font-size: 18pt;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 6px;
            color: var(--primary);
            margin-top: 1.5em;
        }

        h2 {
            font-size: 15pt;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 4px;
            color: var(--secondary);
            margin-top: 1.4em;
        }

        h3 {
            font-size: 12pt;
            color: var(--primary-dark);
        }

        p, li {
            font-size: 12pt;
            color: var(--text-main);
            text-align: justify;
        }

        ul, ol {
            padding-left: 20px;
            margin-bottom: 1em;
        }

        li {
            margin-bottom: 5px;
            text-align: left;
        }

        /* Strong & Emphasis */
        strong {
            color: var(--secondary);
            font-weight: 600;
        }

        /* Horizontal rule */
        hr {
            border: 0;
            height: 1px;
            background: var(--border-color);
            margin: 1.5em 0;
        }

        /* Tables styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
            font-size: 9pt;
            page-break-inside: avoid;
            line-height: 1.3 !important;
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
            font-family: 'Outfit', sans-serif;
        }

        tr:nth-child(even) {
            background-color: #FAFAFA;
        }

        /* Code & Preformatted */
        pre {
            background-color: #1E1E1E;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            margin: 1em 0;
            border-left: 4px solid var(--primary);
            page-break-inside: avoid;
            line-height: 1.35 !important;
        }

        code {
            font-family: 'Fira Code', 'Courier New', Courier, monospace;
            font-size: 9.5pt;
            background-color: #F1F5F9;
            color: #E11D48;
            padding: 1px 4px;
            border-radius: 3px;
        }

        pre code {
            background-color: transparent;
            color: #D4D4D4;
            padding: 0;
            border-radius: 0;
            font-size: 8.5pt;
            display: block;
            line-height: 1.35;
        }

        /* Images styling */
        .image-container {
            text-align: center;
            margin: 1em 0;
            page-break-inside: avoid;
        }

        img {
            max-width: 90%;
            max-height: 10.5cm;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            display: block;
            margin: 0 auto 5px auto;
        }

        .image-caption {
            font-size: 8.5pt;
            color: var(--text-muted);
            font-style: italic;
            margin-top: 4px;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Page Footer Styling */
        .page-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: var(--text-muted);
            border-top: 1px solid #FAF4EA;
            padding-top: 4px;
        }

        /* Utilities */
        .align-center {
            text-align: center;
        }

        /* Mermaid diagram wrapper */
        .mermaid {
            background-color: #F8FAFC;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-family: 'Fira Code', monospace;
            font-size: 8pt;
            margin: 1em 0;
            white-space: pre-wrap;
            page-break-inside: avoid;
        }

        /* Usability Testing Respondent Box */
        .respondent-box {
            border: 1px solid var(--border-color);
            padding: 12px;
            border-radius: 6px;
            background-color: var(--bg-cream);
            margin-bottom: 15px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4 !important;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Content will be parsed here -->
        {{CONTENT}}
    </div>
</body>
</html>
`;

// Helper: Custom Markdown to HTML enhancements
// 1. Wrap the cover page in proper structure
// Look for Cover page marker in HTML
let html = contentHtml;

// 2. Wrap images in styled container and add captions
const imgRegex = /<img src="([^"]+)" alt="([^"]+)"[^>]*>/g;
html = html.replace(imgRegex, (match, src, alt) => {
    // Skip if it's the logo on the cover page (it has cover-logo class already or handled)
    if (src.includes('logo.png')) return match;
    return `
    <div class="image-container">
        <img src="${src}" alt="${alt}">
        <div class="image-caption">Gambar: ${alt}</div>
    </div>
    `;
});

// 3. Format Mermaid codeblocks nicely
const mermaidRegex = /<pre><code class="language-mermaid">([\s\S]*?)<\/code><\/pre>/g;
html = html.replace(mermaidRegex, (match, code) => {
    return `<div class="mermaid">${code.trim()}</div>`;
});

// Replace placeholder in template
const finalHtml = htmlTemplate.replace('{{CONTENT}}', html);

// Save HTML file
fs.writeFileSync(htmlPath, finalHtml, 'utf8');
console.log('HTML compiled successfully to:', htmlPath);

// Execute Edge Headless PDF print
const edgeCmd = `& "C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe" --headless --disable-gpu --print-to-pdf-no-header --print-to-pdf="${pdfPath}" "${htmlPath}"`;

console.log('Executing Edge headless PDF export...');
exec(edgeCmd, { shell: 'powershell.exe' }, (err, stdout, stderr) => {
    if (err) {
        console.error('Error during PDF compilation:', err);
        return;
    }
    console.log('PDF printed successfully to:', pdfPath);
    console.log('STDOUT:', stdout);
    console.log('STDERR:', stderr);
});
