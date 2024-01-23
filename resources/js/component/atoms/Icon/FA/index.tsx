import React from 'react';
import classNames from 'classnames';
import { FAProps } from '../../../../props/props';

const FA: React.FC<React.PropsWithChildren<FAProps>> = (props: FAProps) => (
  <i
    className={classNames('i', 'fa', `fa-${props.className}`)}
    title={props.title}
    aria-hidden="true"
  />
);
export default FA;
