import React from 'react';
import classNames from 'classnames';
import { H2Props } from '../../../../props/props';

const H2: React.FC<React.PropsWithChildren<H2Props>> = (props: H2Props): JSX.Element => (
  <h2
    id={props.id}
    className={classNames(
      'H2',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h2>
);
export default H2;
