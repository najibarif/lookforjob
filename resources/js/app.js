import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createIcons, icons } from 'lucide';
window.lucide = { createIcons, icons };

import './cv-builder';
