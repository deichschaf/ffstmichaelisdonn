import React from 'react';
import { SaveInfoErrorProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import AlertInfoErrorLine from '../AlertInfoLine/Error';
import AlertInfoInfoLine from '../AlertInfoLine/Info';

const SaveInfoError: React.FC<React.PropsWithChildren<SaveInfoErrorProps>> = (
  props: SaveInfoErrorProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.responseText !== null ? (
      <AlertInfoInfoLine text={props.responseText} showButton={false} />
    ) : (
      ''
    )}
    {props.errorText !== null ? (
      <AlertInfoErrorLine text={props.errorText} showButton={false} />
    ) : (
      ''
    )}
  </ErrorBoundary>
);
export default SaveInfoError;
