const puppeteer = require('puppeteer');
const path = require('path');

(async () => {
    const browser = await puppeteer.launch({
        headless: 'new',
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--font-render-hinting=none']
    });
    const page = await browser.newPage();

    // Set high-res viewport (2x scale for crisp output)
    await page.setViewport({ width: 2500, height: 2000, deviceScaleFactor: 2 });

    // Load the ERD HTML
    const htmlPath = path.resolve(__dirname, 'generate_erd.html');
    await page.goto(`file:///${htmlPath}`, { waitUntil: 'networkidle0', timeout: 30000 });

    // Wait for fonts to load
    await page.evaluateHandle('document.fonts.ready');
    await new Promise(r => setTimeout(r, 2000));

    // Get the exact element size
    const erdElement = await page.$('#erd');
    const box = await erdElement.boundingBox();

    // Screenshot the ERD container with padding
    await erdElement.screenshot({
        path: path.resolve(__dirname, 'ERD_Craftive.png'),
        type: 'png',
        omitBackground: false
    });

    console.log('✅ ERD exported to ERD_Craftive.png');
    console.log(`   Resolution: ${Math.round(box.width * 2)}x${Math.round(box.height * 2)} pixels (2x scale)`);

    await browser.close();
})();
