import React from 'react';
import classNames from 'classnames';
import { LabelProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const defaultClass = 'Label';

const Label: React.FC<React.PropsWithChildren<LabelProps>> = (props: LabelProps): JSX.Element => {
  const { className } = props;
  const classes = [defaultClass];

  if (className) {
    classes.push(className);
  }

  return (
    <ErrorBoundary>
      <label htmlFor={props.htmlFor} {...props} className={classNames('', classes.join(' '))}>
        {props.label}
      </label>
    </ErrorBoundary>
  );
};

export default Label;
