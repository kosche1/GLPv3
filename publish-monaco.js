import fs from 'fs-extra';
import path from 'path';
import { fileURLToPath } from 'url';

// Get __dirname equivalent in ESM
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Source and destination paths
const monacoSrc = path.resolve(__dirname, 'node_modules', 'monaco-editor', 'min');
const monacoDest = path.resolve(__dirname, 'public', 'js', 'monaco-editor', 'min');

// Copy Monaco editor files
console.log('Copying Monaco editor files...');
fs.copySync(monacoSrc, monacoDest, { overwrite: true });
console.log('Monaco editor files copied successfully!');

// Create README file with instructions
const readmePath = path.resolve(__dirname, 'public', 'js', 'monaco-editor', 'README.md');
const readmeContent = `# Monaco Editor

These files are copied from the \`monaco-editor\` npm package.
Do not edit these files directly.

To update, run:
\`\`\`
bun install monaco-editor@latest
bun run publish-monaco
\`\`\`
`;

fs.writeFileSync(readmePath, readmeContent);
console.log('Created README file'); 