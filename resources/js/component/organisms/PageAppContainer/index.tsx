import React, { useState } from 'react';
import { useLocation } from 'react-router';
import { PageAppContainerProps } from '../../../props/props';
import ErrorBoundary from '../errorboundary';
import PageAdminWrapper from '../PageAdminWrapper';

const PageAppContainer: React.FC<React.PropsWithChildren<PageAppContainerProps>> = (
  props: PageAppContainerProps
): JSX.Element => {
  const [loading, setLoading] = useState(false);
  const [appState, setAppState] = useState<any>(null);
  const location = useLocation();

  return (
    <ErrorBoundary>
      <PageAdminWrapper location={location}>{props.children}</PageAdminWrapper>
    </ErrorBoundary>
  );
};
export default PageAppContainer;
