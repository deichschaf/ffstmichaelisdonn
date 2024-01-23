import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import ErrorBoundary from './component/organisms/errorboundary';
import PageContainer from './component/organisms/PageContainer';
import LoginPage from './component/pages/Auth/LoginPage';
import Page from './component/pages/Page';
import Startpage from './component/pages/Startpage';
import MoveUp from './component/useHooks/MoveUp';

export default function App() {
  return (
    <ErrorBoundary>
      <BrowserRouter forceRefresh={true}>
        <ErrorBoundary>
          <MoveUp />
          <PageContainer>
            <ErrorBoundary>
              <Routes>
                <Route path="/login" element={<LoginPage />} />
                {/* <Route path="/register" element={<Register />} /> */}
                {/* <Route path="/forgot-password" element={<ForgotPassword />} /> */}
                {/* <Route path="/verify-email/:token" element={<VerifyEmail />} /> */}
                {/* <Route path="/password-reset/:token" element={<PasswordReset />} /> */}
                <Route
                  path="/:slug/:param1/:param2/:param3/:param4/:param5/:param6"
                  element={<Page />}
                />
                <Route path="/:slug/:param1/:param2/:param3/:param4/:param5" element={<Page />} />
                <Route path="/:slug/:param1/:param2/:param3/:param4" element={<Page />} />
                <Route path="/:slug/:param1/:param2/:param3" element={<Page />} />
                <Route path="/:slug/:param1/:param2" element={<Page />} />
                <Route path="/:slug/:param1" element={<Page />} />
                <Route path="/:slug" element={<Page />} />
                <Route path="/" element={<Startpage />} />
              </Routes>
            </ErrorBoundary>
          </PageContainer>
        </ErrorBoundary>
      </BrowserRouter>
    </ErrorBoundary>
  );
}
