import React from 'react';
import classNames from 'classnames';
import { H3Props } from '../../../../props/props';

const H3: React.FC<React.PropsWithChildren<H3Props>> = (props: H3Props): JSX.Element => (
  <h3
    id={props.id}
    className={classNames(
      'H3',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h3>
);
export default H3;
