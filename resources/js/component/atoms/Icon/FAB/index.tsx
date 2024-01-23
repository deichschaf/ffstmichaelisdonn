import React from 'react';
import classNames from 'classnames';
import { FAProps } from '../../../../props/props';

const FAB: React.FC<React.PropsWithChildren<FAProps>> = (props: FAProps) => (
  <i
    className={classNames('i', 'fab', `fa-${props.className}`)}
    title={props.title}
    aria-hidden="true"
  />
);
export default FAB;
