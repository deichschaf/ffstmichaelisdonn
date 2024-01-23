import React from 'react';
import classNames from 'classnames';
import { H6Props } from '../../../../props/props';

const H6: React.FC<React.PropsWithChildren<H6Props>> = (props: H6Props) => (
  <h6
    id={props.id}
    className={classNames(
      'H6',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h6>
);
export default H6;
