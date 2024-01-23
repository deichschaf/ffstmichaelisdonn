import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router';
import { PageAdminContainerProps } from '../../../props/props';
import Loading from '../../atoms/Loading/Loading';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';
import ErrorBoundary from '../errorboundary';
import PageAdminWrapper from '../PageAdminWrapper';

const PageAdminContainer: React.FC<React.PropsWithChildren<PageAdminContainerProps>> = (
  props: PageAdminContainerProps,
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
export default PageAdminContainer;
