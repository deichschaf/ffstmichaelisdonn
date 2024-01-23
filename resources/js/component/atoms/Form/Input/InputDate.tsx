import React from 'react';
import classNames from 'classnames';
import { InputProps } from '../../../../props/props';

const defaultClass = 'Input';

const InputDate: React.FC<React.PropsWithChildren<InputProps>> = (
  props: InputProps,
): JSX.Element => {
  const { className } = props;
  const classes = [defaultClass];

  if (className) {
    classes.push(className);
  }

  return <input type="date" {...props} className={classNames('', classes.join(' '))} />;
};

export default InputDate;
