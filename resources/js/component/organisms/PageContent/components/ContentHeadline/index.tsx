import React from 'react';
import { ContentHeadlineProps } from '../../../../../props/props';
import H1 from '../../../../atoms/Typography/H1';
import ErrorBoundary from '../../../errorboundary';
import ContentRow from '../ContentRow';

const ContentHeadline: React.FC<React.PropsWithChildren<ContentHeadlineProps>> = (
  props: ContentHeadlineProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.title === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <ContentRow>
        <H1 label={props.data.title} />
      </ContentRow>
    </ErrorBoundary>
  );
};
export default ContentHeadline;
