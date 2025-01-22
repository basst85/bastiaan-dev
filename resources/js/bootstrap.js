import hljs from 'highlightjs';
import 'highlightjs/styles/atom-one-dark-reasonable.css';
window.hljs = hljs;
hljs.initHighlightingOnLoad();

document.querySelectorAll('pre code').forEach((block) => {
    const button = document.createElement('button');
    button.className = 'copy-button';
    button.textContent = 'Copy';
    block.parentNode.insertBefore(button, block);
    button.addEventListener('click', () => {
        navigator.clipboard.writeText(block.textContent);
        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = 'Copy';
        }, 1000);
    });
});

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
