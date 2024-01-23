import React from 'react';
import { ContentErrorPageProps } from '../../../../../props/props';
import ErrorPage from '../../../../atoms/Error/Error';
import ErrorBoundary from '../../../errorboundary';

const ContentErrorPage: React.FC<React.PropsWithChildren<ContentErrorPageProps>> = (
  props: ContentErrorPageProps,
): JSX.Element => (
  <ErrorBoundary>
    <ErrorPage text={props.data.message} headline={props.data.code} />
  </ErrorBoundary>
);
export default ContentErrorPage;
