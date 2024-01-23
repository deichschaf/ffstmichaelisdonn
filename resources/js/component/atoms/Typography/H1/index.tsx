import React from 'react';
import classNames from 'classnames';
import { H1Props } from '../../../../props/props';

const H1: React.FC<React.PropsWithChildren<H1Props>> = (props: H1Props): JSX.Element => (
  <h1
    id={props.id}
    className={classNames(
      'H1',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h1>
);
export default H1;
