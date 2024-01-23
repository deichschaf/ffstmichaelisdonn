import React from 'react';
import { TermineProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const Termine: React.FC<React.PropsWithChildren<TermineProps>> = (
  props: TermineProps,
): JSX.Element => (
  <ErrorBoundary>
    <>{props.children}</>
  </ErrorBoundary>
);
export default Termine;
