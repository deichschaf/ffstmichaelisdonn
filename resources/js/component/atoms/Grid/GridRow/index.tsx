import React from 'react';
import { GridRowProps } from '../../../../props/props';

const GridRow: React.FC<React.PropsWithChildren<GridRowProps>> = (
  props: GridRowProps,
): JSX.Element => (
  <div id={props.id} key={props.key} className={`${props.className} row`}>
    {props.children}
  </div>
);
export default GridRow;
