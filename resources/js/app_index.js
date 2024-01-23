import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './app_app';

require('./bootstrap');
const container = document.getElementById('root');
const root = createRoot(container);
root.render(<App />);
