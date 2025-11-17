import { spawn } from 'child_process';
import path from 'path';
import { fileURLToPath } from 'url';
import { URL } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default function handler(req, res) {
  return new Promise((resolve) => {
    // Get the public directory
    const publicDir = path.join(__dirname, '../public');
    const phpIndex = path.join(publicDir, 'index.php');

    // Parse request details
    const parsedUrl = new URL(req.url, `http://${req.headers.host || 'localhost'}`);
    const pathname = parsedUrl.pathname;
    const search = parsedUrl.search;

    // Set up environment for PHP
    const env = {
      ...process.env,
      REQUEST_METHOD: req.method,
      REQUEST_URI: `${pathname}${search}`,
      SCRIPT_FILENAME: phpIndex,
      SCRIPT_NAME: '/index.php',
      PHP_SELF: '/index.php',
      QUERY_STRING: search.substring(1),
      PATH_INFO: pathname,
      DOCUMENT_ROOT: publicDir,
      SERVER_NAME: req.headers.host?.split(':')[0] || 'localhost',
      SERVER_PORT: req.headers['x-forwarded-proto'] === 'https' ? '443' : '80',
      SERVER_PROTOCOL: 'HTTP/1.1',
      REMOTE_ADDR: req.headers['x-forwarded-for']?.split(',')[0] || '127.0.0.1',
      HTTP_HOST: req.headers.host,
    };

    // Spawn PHP process
    const php = spawn('php', ['-f', phpIndex], {
      cwd: path.join(__dirname, '..'),
      env,
      stdio: ['pipe', 'pipe', 'pipe'],
    });

    let output = '';
    let errorOutput = '';

    // Collect output
    php.stdout.on('data', (data) => {
      output += data.toString();
    });

    php.stderr.on('data', (data) => {
      errorOutput += data.toString();
    });

    // Handle process completion
    php.on('close', (code) => {
      if (code !== 0 && !output) {
        console.error('PHP Error:', errorOutput);
        res.status(500).send(`<h1>Server Error</h1><pre>${errorOutput}</pre>`);
      } else {
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.status(200).send(output);
      }
      resolve();
    });

    php.on('error', (err) => {
      console.error('Process Error:', err);
      res.status(500).send(`<h1>Error: ${err.message}</h1>`);
      resolve();
    });

    // Pass request body to PHP if POST
    if (req.method === 'POST' || req.method === 'PUT') {
      php.stdin.write(JSON.stringify(req.body || {}));
    }
    php.stdin.end();
  });
}
