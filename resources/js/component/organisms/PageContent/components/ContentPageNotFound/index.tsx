import React from 'react';
import NotFoundComponent from '../../../../../acp/notfound/NotFoundComponent';
import { ContentPageNotFoundProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';

const ContentPageNotFound: React.FC<React.PropsWithChildren<ContentPageNotFoundProps>> = (
  props: ContentPageNotFoundProps,
): JSX.Element => (
  <ErrorBoundary>
    <NotFoundComponent />
  </ErrorBoundary>
);
export default ContentPageNotFound;
