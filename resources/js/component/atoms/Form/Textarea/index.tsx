import React from 'react';
import classNames from 'classnames';
import { TextareaProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const defaultClass = 'Textarea';

const Textarea: React.FC<React.PropsWithChildren<TextareaProps>> = (
  props: TextareaProps,
): JSX.Element => {
  const { className } = props;
  const classes = [defaultClass];

  if (className) {
    classes.push(className);
  }

  return (
    <ErrorBoundary>
      <textarea {...props} className={classNames('', classes.join(' '))} />
    </ErrorBoundary>
  );
};

export default Textarea;
