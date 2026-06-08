import fs from 'fs';
import path from 'path';
import { marked } from 'marked';
import { exec } from 'child_process';

const rootDir = 'C:/xampp1/htdocs/craftive';
const mdPath = path.join(rootDir, 'PANDUAN_DEMO_API.md');
const htmlPath = path.join(rootDir, 'PANDUAN_DEMO_API.html');
const pdfPath = path.join(rootDir, 'PANDUAN_DEMO_API.pdf');

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
    <title>Panduan Demo API Craftive</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e7e34;      /* Green for API Demo theme */
            --primary-dark: #155724;
            --primary-light: #d4edda;
            --secondary: #2C2C2C;    /* Charcoal */
            --bg-cream: #FAF4EA;
            --text-main: #333333;
            --border-color: #E2E8F0;
        }

        @page {
            size: A4;
            margin: 1.5cm;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: #FFFFFF;
            margin: 0;
            padding: 0;
            font-size: 10.5pt;
            line-height: 1.5;
        }

        h1, h2, h3, h4 {
            font-family: 'Outfit', sans-serif;
            color: var(--secondary);
            font-weight: 700;
            margin-top: 1.2em;
            margin-bottom: 0.4em;
            page-break-after: avoid;
        }

        h1 {
            font-size: 16pt;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 6px;
            margin-top: 0;
            text-transform: uppercase;
        }

        h2 {
            font-size: 13pt;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 4px;
            color: var(--secondary);
            margin-top: 1.5em;
        }

        h3 {
            font-size: 11pt;
            color: var(--primary-dark);
        }

        p, li {
            font-size: 10pt;
            color: var(--text-main);
        }

        ul, ol {
            padding-left: 20px;
        }

        li {
            margin-bottom: 6px;
        }

        strong {
            color: var(--secondary);
            font-weight: 600;
        }

        /* Tables styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
            font-size: 8.5pt;
            page-break-inside: avoid;
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
        }

        tr:nth-child(even) {
            background-color: #FAFAFA;
        }

        /* Code styling */
        code {
            font-family: 'Fira Code', monospace;
            font-size: 8.5pt;
            background-color: #F1F5F9;
            color: #E11D48;
            padding: 1px 4px;
            border-radius: 3px;
        }

        pre {
            background-color: #1E1E1E;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            margin: 1em 0;
            border-left: 4px solid var(--primary);
            page-break-inside: avoid;
        }

        pre code {
            background-color: transparent;
            color: #D4D4D4;
            font-size: 8pt;
            display: block;
        }

        blockquote {
            margin: 1em 0;
            padding: 10px 15px;
            background-color: #F8FAFC;
            border-left: 4px solid #94A3B8;
            font-style: italic;
        }
        
        blockquote p {
            margin: 0;
            font-size: 9.5pt;
        }
    </style>
</head>
<body>
    <div class="container">
        {{CONTENT}}
    </div>
</body>
</html>
`;

// Replace placeholder in template
const finalHtml = htmlTemplate.replace('{{CONTENT}}', contentHtml);

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
    // Cleanup HTML file
    try {
        fs.unlinkSync(htmlPath);
    } catch (e) {}
});
