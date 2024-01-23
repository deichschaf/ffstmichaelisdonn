import React from 'react';
import { ContentChangerProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';
import ContentTextLeft from './ContentTextLeft';
import ContentTextRight from './ContentTextRight';

const ContentChanger: React.FC<React.PropsWithChildren<ContentChangerProps>> = (
  props: ContentChangerProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.idx % 2 === 0 ? (
      <ContentTextLeft boxleft={8} boxright={4} data={props.data} />
    ) : (
      <ContentTextRight boxleft={4} boxright={8} data={props.data} />
    )}
  </ErrorBoundary>
);
export default ContentChanger;
