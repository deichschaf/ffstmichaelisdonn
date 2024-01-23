import React from 'react';
import classNames from 'classnames';
import { DIVProps } from '../../../../props/props';

const DIV: React.FC<React.PropsWithChildren<DIVProps>> = (props: DIVProps): JSX.Element => (
  <div
    id={props.id}
    className={classNames('DIV', props.className)}
    aria-valuenow={props['aria-valuenow']}
    aria-valuemin={props['aria-valuemin']}
    aria-valuemax={props['aria-valuemax']}
    data-qa={props['data-qa']}
    data-dismiss={props['data-dismiss']}
  >
    {props.children}
  </div>
);
export default DIV;
