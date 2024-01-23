import React from 'react';
import { LayoutContainerProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const LayoutContainer: React.FC<React.PropsWithChildren<LayoutContainerProps>> = (
  props: LayoutContainerProps,
): JSX.Element => {
  if (typeof props.children === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <div className="main-container">
        <div className="container">{props.children}</div>
      </div>
    </ErrorBoundary>
  );
};
export default LayoutContainer;
