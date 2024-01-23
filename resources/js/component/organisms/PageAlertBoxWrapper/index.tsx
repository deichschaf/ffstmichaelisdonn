import React from 'react';
import { PageWrapperProps } from '../../../props/props';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';
import ErrorBoundary from '../errorboundary';
import Footer from '../Footer';
import Header from '../Header';

const PageAlertBoxWrapper: React.FC<React.PropsWithChildren<PageWrapperProps>> = (
  props: PageWrapperProps,
): JSX.Element => (
  <ErrorBoundary>
    <Header header={undefined} data={undefined} />
    <main className="site-main page-main">
      <div className="main-container">
        <div className="container">
          <LoadingAlertBox />
        </div>
      </div>
    </main>
    <Footer footer={undefined} data={undefined} />
  </ErrorBoundary>
);
export default PageAlertBoxWrapper;
