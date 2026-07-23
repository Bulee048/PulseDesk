const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        file = dir + '/' + file;
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) {
            results = results.concat(walk(file));
        } else {
            if(file.endsWith('.blade.php') || file.endsWith('.php')) results.push(file);
        }
    });
    return results;
}

const files = walk('resources/views');

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    
    // Headers -> ink, font-heading
    content = content.replace(/text-gray-900/g, 'text-ink');
    content = content.replace(/<h([1-6])([^>]*)class="([^"]*)"/g, '<h$1$2class="$3 font-heading"');
    content = content.replace(/<h([1-6])(.*?)>/g, (match, p1, p2) => {
        if (!p2.includes('class=')) {
            return `<h${p1}${p2} class="font-heading">`;
        }
        return match;
    });
    
    // Replace gray text/border/bg
    content = content.replace(/text-gray-[1-4]00/g, 'text-slate/70');
    content = content.replace(/text-gray-[5-9]00/g, 'text-slate');
    content = content.replace(/bg-gray-100/g, 'bg-cloud');
    content = content.replace(/bg-gray-50/g, 'bg-cloud');
    content = content.replace(/bg-gray-[2-8]00/g, 'bg-slate/10');
    content = content.replace(/border-gray-[1-3]00/g, 'border-line');
    content = content.replace(/border-gray-[4-9]00/g, 'border-slate');
    
    // Primary brand colors (indigo/blue -> signal)
    content = content.replace(/text-indigo-[1-9]00/g, 'text-signal');
    content = content.replace(/bg-indigo-[1-9]00/g, 'bg-signal');
    content = content.replace(/border-indigo-[1-9]00/g, 'border-signal');
    content = content.replace(/focus:border-indigo-[1-9]00/g, 'focus:border-signal');
    content = content.replace(/focus:ring-indigo-[1-9]00/g, 'focus:ring-signal');
    
    content = content.replace(/text-blue-[1-9]00/g, 'text-signal');
    content = content.replace(/bg-blue-[1-9]00/g, 'bg-signal');
    content = content.replace(/border-blue-[1-9]00/g, 'border-signal');

    // Destructive colors (red -> ember)
    content = content.replace(/text-red-[1-9]00/g, 'text-ember');
    content = content.replace(/bg-red-[1-9]00/g, 'bg-ember');
    content = content.replace(/border-red-[1-9]00/g, 'border-ember');
    
    // IDs, Timestamps, etc. to mono
    content = content.replace(/text-xs/g, 'text-xs font-mono');

    fs.writeFileSync(file, content);
});
console.log('Replaced tokens in ' + files.length + ' files');
