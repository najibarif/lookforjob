import './bootstrap';
import { createIcons, icons } from 'lucide';

window.lucide = { createIcons, icons };

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
