import React from 'react';
import { ContentListProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';

const ContentList: React.FC<React.PropsWithChildren<ContentListProps>> = (
  props: ContentListProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.pagelist === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <ul>
        {props.data.pagelist.map((item, idx) => (
          <li key={idx}>{item}</li>
        ))}
      </ul>
    </ErrorBoundary>
  );
};
export default ContentList;
