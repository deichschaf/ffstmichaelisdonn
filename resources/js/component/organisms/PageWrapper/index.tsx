import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router';
import { PageWrapperProps } from '../../../props/props';
import LayoutContainer from '../../atoms/Layout/LayoutContainer';
import LayoutMainContent from '../../atoms/Layout/LayoutMainContent';
import SectionHeroImage from '../../atoms/Layout/SectionHeroImage';
import { getCookie, getCSRFToken, getWithExpiry, setWithExpiry } from '../../component_helper';
import Spacer from '../../molecules/Spacer';
import ErrorBoundary from '../errorboundary';
import Footer from '../Footer';
import Header from '../Header';

const PageWrapper: React.FC<React.PropsWithChildren<PageWrapperProps>> = (
  props: PageWrapperProps
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  const [getContent, setContent] = useState<any>(null);
  const checkAfterMicroseconds = 60000;
  const checkWarningsAfterMicroseconds = 180000;
  const location = useLocation();

  useEffect(() => {
    async function getApiWarnings() {
      const path = location;
      const token = getCSRFToken();
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
          let response = await fetch('/api/get/checkWarnings', {
            method: 'POST',
            headers,
            body: JSON.stringify({
              path: path.pathname,
              'csrf-token': token,
              _token: token,
            }),
          });
          response = await response.json();
          setCacheWarnings(response);
        } catch (error) {
          if (window.location.pathname !== '/login') {
            window.location.reload();
          }
        }
      } else {
        setCacheWarnings(false);
      }
    }

    function getCacheWarnings() {
      const warningsString = getWithExpiry('warnings') as string;
      if (warningsString === null) {
        getApiWarnings();
      } else {
        const warnings = JSON.parse(warningsString);
        setContent(warnings);
      }
    }

    function setCacheWarnings(content) {
      setWithExpiry('warnings', JSON.stringify(content), checkWarningsAfterMicroseconds);
      getCacheWarnings();
    }

    getCacheWarnings();
    const interval = setInterval(() => {
      getCacheWarnings();
    }, checkAfterMicroseconds);
    return () => clearInterval(interval);
  }, []);

  return (
    <ErrorBoundary>
      {typeof props.pagedata.header !== 'undefined' ? (
        <Header header={props.pagedata.header} data={props.pagedata} />
      ) : (
        <Header header={undefined} data={props.pagedata} />
      )}
      <main className="site-main page-main">
        <SectionHeroImage pagedata={props.pagedata} />
        <LayoutContainer>
          <Spacer />
          <LayoutMainContent widget={getContent} pagedata={props.pagedata}>
            {props.children}
          </LayoutMainContent>
        </LayoutContainer>
      </main>
      {typeof props.pagedata.footer !== 'undefined' ? (
        <Footer footer={props.pagedata.footer} data={props.pagedata} />
      ) : (
        <Footer footer={undefined} data={props.pagedata} />
      )}
      {/* <BackToTop /> */}
    </ErrorBoundary>
  );
};
export default PageWrapper;
