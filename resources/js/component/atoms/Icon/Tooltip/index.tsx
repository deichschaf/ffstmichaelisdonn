import React, { FunctionComponent } from 'react';
import classNames from 'classnames';

export interface TooltipProps {
  id?: string | undefined;
  className?: string | undefined;
  children?: any | undefined;
}

const Tooltip: FunctionComponent<React.PropsWithChildren<TooltipProps>> = (props: TooltipProps) => (
  <div id={props.id} className={classNames('tooltip', props.className)} role="tooltip">
    {props.children}
  </div>
);

export default Tooltip;
