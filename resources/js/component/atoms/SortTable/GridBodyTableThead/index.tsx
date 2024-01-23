import React from 'react';
import { SortTableGridBodyTableThead } from '../../../../props/props';

function generateTH(props) {
  if (typeof props.ths === 'undefined') {
    return <></>;
  }
  const ths = [...props.ths];
  return ths.map((item, idx) => (
    <th key={idx} className="sorting" role="columnheader" aria-controls="example2">
      {item}
    </th>
  ));
}

const GridBodyTableThead: React.FC<React.PropsWithChildren<SortTableGridBodyTableThead>> = (
  props: SortTableGridBodyTableThead,
): JSX.Element => (
  <thead>
    <tr role="row">{generateTH(props)}</tr>
  </thead>
);

export default GridBodyTableThead;
