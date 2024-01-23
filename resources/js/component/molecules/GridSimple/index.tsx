import React from 'react';
import classNames from 'classnames';
import { GridSimpleProps } from '../../../props/props';
import GridBody from './Body';
import GridHeader from './Header';

const GridSimple: React.FC<React.PropsWithChildren<GridSimpleProps>> = (
  props: GridSimpleProps,
): JSX.Element => {
  const defaultClass = 'grid simple';
  const { className } = props;
  const classes = [defaultClass];

  if (className) {
    classes.push(className);
  }

  return (
    <div className={classNames('', classes.join(' '))}>
      <GridHeader lable={props.lable} showTableButtons={false} />
      <GridBody>{props.children}</GridBody>
    </div>
  );
};
export default GridSimple;
