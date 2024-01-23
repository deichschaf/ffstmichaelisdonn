import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import ChangeLogAddEditComponent from './acp/changelog/ChangeLogAddEditComponent';
import ChangeLogOverviewComponent from './acp/changelog/ChangeLogOverviewComponent';
import Dashboard from './acp/dashboard/Dashboard';
import EmergencyAddEditComponent from './acp/emergency/actions/EmergencyAddEditComponent';
import EmergencyOverviewComponent from './acp/emergency/actions/EmergencyOverviewComponent';
import FacebookPostComponent from './acp/facebookpost/FacebookPostComponent';
import LinksAddEditComponent from './acp/links/LinksAddEditComponent';
import LinksOverviewComponent from './acp/links/LinksOverviewComponent';
import NewsAddEditComponent from './acp/news/NewsAddEditComponent';
import NewsOverviewComponent from './acp/news/NewsOverviewComponent';
import PageAddEditComponent from './acp/page/PageAddEditComponent';
import PageAddEditHeadlineComponent from './acp/page/PageAddEditHeadlineComponent';
import PageOverviewComponent from './acp/page/PageOverviewComponent';
import PlaceholderAddEditComponent from './acp/placeholder/PlaceholderAddEditComponent';
import PlaceholderOverviewComponent from './acp/placeholder/PlaceholderOverviewComponent';
import ShowLogsOverviewComponent from './acp/showlogs/ShowLogsOverviewComponent';
import TermineAddEditComponent from './acp/termine/TermineAddEditComponent';
import TermineOverviewComponent from './acp/termine/TermineOverviewComponent';
import ToDoAddEditComponent from './acp/todo/ToDoAddEditComponent';
import ToDoAreaAddEditComponent from './acp/todo/ToDoAreaAddEditComponent';
import ToDoAreaOverviewComponent from './acp/todo/ToDoAreaOverviewComponent';
import ToDoOverviewComponent from './acp/todo/ToDoOverviewComponent';
import ErrorBoundary from './component/organisms/errorboundary';
import PageAdminContainer from './component/organisms/PageAdminContainer';
import { useAuth } from './component/useHooks/useAuth';
import MoveUp from './component/useHooks/MoveUp';
import EmergencySetScenario from './acp/emergency/EmergencySetScenario';

export default function App() {
  const { user } = useAuth({
    middleware: 'auth',
  });
  if (!user) {
    // window.location = '/login';
    return false;
  }
  const path = '/admin';
  return (
    <ErrorBoundary>
      <BrowserRouter forceRefresh={true}>
        <ErrorBoundary>
          <MoveUp />
          <PageAdminContainer>
            <ErrorBoundary>
              <Routes>
                <Route path={`${path}/`} element={<Dashboard />} />

                <Route path={`${path}/facebookpost`} element={<FacebookPostComponent />} />
                <Route path={`${path}/page/overview`} element={<PageOverviewComponent />} />
                <Route path={`${path}/page/add`} element={<PageAddEditComponent />} />
                <Route path={`${path}/page/edit/:id`} element={<PageAddEditComponent />} />
                <Route
                  path={`${path}/page/edittitle/:id`}
                  element={<PageAddEditHeadlineComponent />}
                />

                <Route
                  path={`${path}/emergency/overview`}
                  element={<EmergencyOverviewComponent />}
                />
                <Route path={`${path}/emergency/add`} element={<EmergencyAddEditComponent />} />
                <Route
                  path={`${path}/emergency/edit/:id`}
                  element={<EmergencyAddEditComponent />}
                />
                <Route path={`${path}/emergency/scenario`} element={<EmergencySetScenario />} />

                <Route path={`${path}/news/overview`} element={<NewsOverviewComponent />} />
                <Route path={`${path}/news/add`} element={<NewsAddEditComponent />} />
                <Route path={`${path}/news/edit/:id`} element={<NewsAddEditComponent />} />

                <Route path={`${path}/termine/overview`} element={<TermineOverviewComponent />} />
                <Route path={`${path}/termine/add`} element={<TermineAddEditComponent />} />
                <Route path={`${path}/termine/edit/:id`} element={<TermineAddEditComponent />} />
                <Route path={`${path}/termine/copy/:id`} element={<TermineAddEditComponent />} />

                <Route
                  path={`${path}/placeholder/overview`}
                  element={<PlaceholderOverviewComponent />}
                />
                <Route path={`${path}/placeholder/add`} element={<PlaceholderAddEditComponent />} />
                <Route
                  path={`${path}/placeholder/edit/:id`}
                  element={<PlaceholderAddEditComponent />}
                />
                <Route path={`${path}/links/overview`} element={<LinksOverviewComponent />} />
                <Route path={`${path}/links/add`} element={<LinksAddEditComponent />} />
                <Route path={`${path}/links/edit/:id`} element={<LinksAddEditComponent />} />

                <Route path={`${path}/todo/overview`} element={<ToDoOverviewComponent />} />
                <Route path={`${path}/todo/add`} element={<ToDoAddEditComponent />} />
                <Route path={`${path}/todo/edit/:id`} element={<ToDoAddEditComponent />} />
                <Route
                  path={`${path}/todo/area/overview`}
                  element={<ToDoAreaOverviewComponent />}
                />
                <Route path={`${path}/todo/area/add`} element={<ToDoAreaAddEditComponent />} />
                <Route path={`${path}/todo/area/edit/:id`} element={<ToDoAreaAddEditComponent />} />

                <Route
                  path={`${path}/changelog/overview`}
                  element={<ChangeLogOverviewComponent />}
                />
                <Route path={`${path}/changelog/add`} element={<ChangeLogAddEditComponent />} />
                <Route
                  path={`${path}/changelog/edit/:id`}
                  element={<ChangeLogAddEditComponent />}
                />
                <Route path={`${path}/syslog/overview`} element={<ShowLogsOverviewComponent />} />
              </Routes>
            </ErrorBoundary>
          </PageAdminContainer>
        </ErrorBoundary>
      </BrowserRouter>
    </ErrorBoundary>
  );
}
