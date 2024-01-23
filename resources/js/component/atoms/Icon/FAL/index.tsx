import React from 'react';
import classNames from 'classnames';
import { FAProps } from '../../../../props/props';

const FAL: React.FC<React.PropsWithChildren<FAProps>> = (props: FAProps) => (
  <i
    className={classNames('i', 'fal', `fa-${props.className}`)}
    title={props.title}
    aria-hidden="true"
  />
);
export default FAL;
