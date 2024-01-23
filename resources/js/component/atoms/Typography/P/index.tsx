import React from 'react';
import classNames from 'classnames';
import { PProps } from '../../../../props/props';

const P: React.FC<React.PropsWithChildren<PProps>> = (props: PProps) => (
  <p id={props.id} className={classNames('P', props.className)}>
    {props.label}
    {props.children}
  </p>
);
export default P;
