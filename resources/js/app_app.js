import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import AnwesenheitOverview from './app/anwesenheit/Overview';
import EinsaetzeEditor from './app/einsaetze/editor';
import PageAppContainer from './component/organisms/PageAppContainer';
import MoveUp from './component/useHooks/MoveUp';
import ErrorBoundary from './component/organisms/errorboundary';
import AppTacticalMonitor from './app/tacticalmonitor';

export default function App() {
  const path = '/app';
  return (
    <ErrorBoundary>
      <BrowserRouter forceRefresh={true}>
        <MoveUp />
        <PageAppContainer>
          <ErrorBoundary>
            <Routes>
              <Route path={`${path}/einsaetze`} element={<EinsaetzeEditor />} />
              <Route path={`${path}/anwesenheit`} element={<AnwesenheitOverview />} />
              <Route path={`${path}/tacticalmonitor`} element={<AppTacticalMonitor />} />
            </Routes>
          </ErrorBoundary>
        </PageAppContainer>
      </BrowserRouter>
    </ErrorBoundary>
  );
}
