import './bootstrap';

import quizSelector from './questions';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('quizSelector', quizSelector);

Alpine.start();
