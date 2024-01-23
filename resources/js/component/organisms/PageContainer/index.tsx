import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router';
import { PageContainerProps } from '../../../props/props';
import { getCookie, getCSRFToken } from '../../component_helper';
import ErrorBoundary from '../errorboundary';
import PageAlertBoxWrapper from '../PageAlertBoxWrapper';
import PageWrapper from '../PageWrapper';

const PageContainer: React.FC<React.PropsWithChildren<PageContainerProps>> = (
  props: PageContainerProps
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  const location = useLocation();

  useEffect(() => {
    async function fetchMyApi() {
      const path = location;
      const token = getCSRFToken();
      // console.log(token);
      const csrfToken = getCookie('XSRF-TOKEN');
      let headers = new Headers({
        'Content-Type': 'application/json',
      });
      if (csrfToken !== null) {
        headers = new Headers({
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        });
      }
      if (window.location.pathname !== '/login') {
        try {
          let response = await fetch('/api/get/pagedata', {
            method: 'POST',
            headers,
            body: JSON.stringify({
              path: path.pathname,
              'csrf-token': token,
              _token: token,
            }),
          });
          response = await response.json();
          setAppState(response);
          setLoading(false);
        } catch (error) {
          console.log(window.location.pathname);
          if (window.location.pathname !== '/login') {
            window.location.reload();
          }
        }
      } else {
        setAppState(false);
        setLoading(false);
      }
    }

    fetchMyApi();
  }, [location]);
  if (loading || appState === null) {
    return <PageAlertBoxWrapper />;
  }
  return (
    <ErrorBoundary>
      <PageWrapper pagedata={appState}>{props.children}</PageWrapper>
    </ErrorBoundary>
  );
};
export default PageContainer;
