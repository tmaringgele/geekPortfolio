<?php /* index.php – geeky terminal-style portfolio */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tobias Maringgele | Portfolio</title>
  <link rel="icon" href="favicon.png" type="image/png">


  <style>
    /* --- Terminal Aesthetic --- */
    @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap');
    :root {
      --bg: #0d0d0d;
      --text: #33ff99;
      --accent: #25c46f;
      --cursor: #33ff99;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Fira Code', monospace;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 2rem;
    }

    .terminal {
      width: 100%;
      max-width: 880px;
      background: #111;
      border: 2px solid var(--accent);
      border-radius: 8px;
      padding: 1.5rem;
      overflow: auto;
      box-shadow: 0 0 16px #021;
    }

    .title-bar {
      display: flex;
      gap: 8px;
      margin-bottom: 1rem;
    }
    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: var(--accent);
    }

    a { color: var(--text); text-decoration: none; }
    a:hover { color: var(--accent); }

    #cursor {
      display: inline-block;
      width: 10px;
      background: var(--cursor);
      animation: blink 1s steps(2, start) infinite;
    }

    @keyframes blink {
      to { background: transparent; }
    }
    ul.pdf-list { list-style: square inside; margin-top: .5rem; }
    ul.pdf-list li { margin-left: 1rem; margin-bottom: .25rem; }

    a {
        color: var(--text);
        text-decoration: underline;
        }
        a:hover {
        color: var(--accent);
        }

    /* --- Mobile Optimization --- */
    @media (max-width: 600px) {
      body {
        padding: 0.5rem;
        font-size: 0.95rem;
        align-items: flex-start;
        height: auto;
      }
      .terminal {
        max-width: 100vw;
        width: 100vw;
        min-width: 0;
        padding: 0.5rem;
        font-size: 0.95rem;
        border-radius: 0;
        box-shadow: none;
        overflow-x: auto;
      }
      .title-bar {
        gap: 4px;
        margin-bottom: 0.5rem;
      }
      .dot {
        width: 8px;
        height: 8px;
      }
      pre {
        font-size: 0.95rem;
        white-space: pre-wrap;
        word-break: break-word;
      }
    }
  </style>
</head>
<body>
  <div class="terminal">
    <div class="title-bar">
      <span class="dot"></span><span class="dot"></span><span class="dot"></span>
    </div>
    <pre><div id="terminal-output"></div><span id="cursor"></span></pre>

  </div>

<script>
const lines = [
  'tobias@portfolio:~$ whoami',
  'Tobias Anton Maringgele – Software Engineer / Data Enthusiast',
  '',
  'tobias@portfolio:~$ links',
  'LinkedIn  →  <a href="https://www.linkedin.com/in/tobias-maringgele-0a0602220" target="_blank">LinkedIn</a>',
  'GitHub    →  <a href="https://github.com/tmaringgele" target="_blank">GitHub</a>',
  'Company   →  <a href="https://reprasent.at" target="_blank">reprasent.at</a>',
  '',
  'tobias@portfolio:~$ downloads'
];

const term = document.getElementById('terminal-output');
let line = 0, idx = 0;
let currentLine = '';
let span = null;

function type() {
  if (line >= lines.length) {
    // Load downloads
    fetch('pdf-list.php')
      .then(r => r.text())
      .then(html => {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        term.appendChild(tempDiv);
      });
    return;
  }

  const text = lines[line];

  if (idx === 0) {
    span = document.createElement('div');
    span.className = 'line';
    term.appendChild(span);
  }

  if (idx < text.length) {
    span.innerHTML += text.charAt(idx);
    currentLine += text.charAt(idx);
    idx++;
    setTimeout(type, 35);
  } else {
    span.innerHTML = lines[line] === '' ? '&nbsp;' : lines[line]; //Make sure empty lines are visible
    line++;
    idx = 0;
    currentLine = '';
    setTimeout(type, 200);
  }
}

window.onload = type;
</script>




<?php /* --- Dynamic PDF list injected via JS --- */ ?>

</body>
</html>
