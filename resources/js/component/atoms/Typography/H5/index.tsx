import React from 'react';
import classNames from 'classnames';
import { H5Props } from '../../../../props/props';

const H5: React.FC<React.PropsWithChildren<H5Props>> = (props: H5Props) => (
  <h5
    id={props.id}
    className={classNames(
      'H5',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h5>
);
export default H5;
