import { exec } from 'child_process';
import path from 'path';

const rootDir = 'C:/xampp1/htdocs/craftive';
const htmlPath = path.join(rootDir, 'generate_erd.html');
const pngPath = path.join(rootDir, 'ERD_Craftive.png');

// Use Edge headless with larger window for high-res crisp output
const edgeCmd = `& "C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe" --headless --disable-gpu --screenshot="${pngPath}" --window-size=3000,2600 --force-device-scale-factor=1.5 "${htmlPath}"`;

console.log('Rendering ERD to high-res PNG via Edge headless...');
exec(edgeCmd, { shell: 'powershell.exe' }, (err, stdout, stderr) => {
    if (err) {
        console.error('Error:', err);
        return;
    }
    console.log('✅ ERD exported to:', pngPath);
    console.log('STDOUT:', stdout);
    console.log('STDERR:', stderr);
});
