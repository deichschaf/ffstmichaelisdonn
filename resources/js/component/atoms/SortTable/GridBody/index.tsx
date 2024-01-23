import React from 'react';
import { SortTableGridBody } from '../../../../props/props';
import GridBodySort from '../GridBodySort';
import SortTableHeader from '../Header';

const GridBody: React.FC<React.PropsWithChildren<SortTableGridBody>> = (
  props: SortTableGridBody,
): JSX.Element => (
  <div className="grid simple">
    <SortTableHeader lable={props.lable} />
    <GridBodySort sort={props.sort} />
  </div>
);

export default GridBody;
