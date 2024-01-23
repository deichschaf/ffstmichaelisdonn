import React from 'react';
import classNames from 'classnames';
import { InputProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const defaultClass = 'Input';

const Input: React.FC<React.PropsWithChildren<InputProps>> = (props: InputProps): JSX.Element => {
  const { className } = props;
  const classes = [defaultClass];

  if (className) {
    classes.push(className);
  }

  return (
    <ErrorBoundary>
      <input {...props} className={classNames('', classes.join(' '))} />
    </ErrorBoundary>
  );
};

export default Input;
