import React from 'react';
import classNames from 'classnames';
import { FAProps } from '../../../../props/props';

const FAD: React.FC<React.PropsWithChildren<FAProps>> = (props: FAProps) => (
  <i
    className={classNames('i', 'fad', `fa-${props.className}`)}
    title={props.title}
    aria-hidden="true"
  />
);
export default FAD;
