import React from 'react';
import classNames from 'classnames';
import { H4Props } from '../../../../props/props';

const H4: React.FC<React.PropsWithChildren<H4Props>> = (props: H4Props): JSX.Element => (
  <h4
    id={props.id}
    className={classNames(
      'H4',
      typeof props.label !== 'undefined' && props.label !== '' ? 'underline' : '',
      props.className,
    )}
  >
    {props.label}
    {props.children}
  </h4>
);
export default H4;
