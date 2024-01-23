import React from 'react';
import { AdminNavigationProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import AdminNavigationList from './navigation';

const AdminNavigation: React.FC<React.PropsWithChildren<AdminNavigationProps>> = (
  props: AdminNavigationProps,
): JSX.Element => (
  <ul>
    <ErrorBoundary>
      <AdminNavigationList />
    </ErrorBoundary>
  </ul>
);
export default AdminNavigation;
